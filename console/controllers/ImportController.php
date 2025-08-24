<?php

namespace console\controllers;

use yii\console\Controller;
use yii\console\ExitCode;

/**
 * Import and data utilities
 */
class ImportController extends Controller
{
    private function normalizeHeader(string $h): string
    {
        // Remove BOM if present
        $h = preg_replace('/^\xEF\xBB\xBF/', '', $h);
        $h = trim($h);
        // Collapse whitespace and unify spacing
        $h = preg_replace('/\s+/', ' ', $h);
        // Remove stray quotes
        $h = trim($h, "\"' ");

        // Handle known multi-line header variants
        $h = str_replace(["TARIKH KEMASUKAN\nSEMESTER 1", "TARIKH KEMASUKAN\n SEMESTER 1", "TARIKH KEMASUKAN\r\nSEMESTER 1"], "TARIKH KEMASUKAN", $h);

        // Canonical mapping for common variants
        $map = [
            'NO. MATRIK' => 'NO_MATRIK',
            'NO.MATRIK' => 'NO_MATRIK',
            'NO MATRIK' => 'NO_MATRIK',
            'NO. IC / PASSPORT' => 'NO_IC',
            'NO. IC/ PASSPORT' => 'NO_IC',
            'NO IC' => 'NO_IC',
            'NO. TELEFON' => 'NO_TELEFON',
            'KOD PROGRAM' => 'KOD_PROGRAM',
            'PROGRAM' => 'PROGRAM',
            'PROGRAM ' => 'PROGRAM',
            'STATUS PELAJAR' => 'STATUS',
            'STATUS PENDAFTARAN' => 'STATUS_PENDAFTARAN',
            'AGAMA & KETURUNAN' => 'AGAMA',
            'SESI MASUK' => 'SESI MASUK',
            'SEMESTER SEMASA PELAJAR' => 'SEMESTER',
        ];
        if (isset($map[$h])) {
            return $map[$h];
        }
        return $h;
    }
    /**
     * Merge two postgraduate CSV files into one standardized CSV with an extra column `mod`.
     *
     * Example:
     * yii import/merge-pg-csv \
     *   --ker=@app/../db/modker.csv \
     *   --pen=@app/../db/modpen.csv \
     *   --out=@app/../db/postgrad_merged.csv
     *
     * @param string $ker Path to modker.csv
     * @param string $pen Path to modpen.csv
     * @param string $out Output CSV path
     * @return int
     */
    // Console options (e.g., --ker=..., --pen=..., --out=...)
    public $ker;
    public $pen;
    public $out;

    public function options($actionID)
    {
        return array_merge(parent::options($actionID), ['ker', 'pen', 'out']);
    }

    public function actionMergePgCsv(string $ker = null, string $pen = null, string $out = null)
    {
        // Allow both positional params and --option style
        $ker = $ker ?: $this->ker;
        $pen = $pen ?: $this->pen;
        $out = $out ?: $this->out;

        if (!$ker || !$pen || !$out) {
            $this->stderr("Usage: yii import/merge-pg-csv --ker=/path/modker.csv --pen=/path/modpen.csv --out=/path/merged.csv\n");
            $this->stderr("Or positional: yii import/merge-pg-csv /path/modker.csv /path/modpen.csv /path/merged.csv\n");
            return ExitCode::USAGE;
        }

        $sources = [
            ['path' => $ker, 'mod' => 'modker'],
            ['path' => $pen, 'mod' => 'modpen'],
        ];

        $rows = [];
        $allHeaders = [];

        foreach ($sources as $src) {
            $path = \Yii::getAlias($src['path']);
            if (!is_file($path)) {
                $this->stderr("File not found: {$path}\n");
                return ExitCode::DATAERR;
            }

            $handle = fopen($path, 'r');
            if (!$handle) {
                $this->stderr("Cannot open: {$path}\n");
                return ExitCode::CANTCREAT;
            }

            // Read header line using fgetcsv; handles quoted fields
            $header = fgetcsv($handle, 0, ',', '"', "\0");
            if ($header === false) {
                fclose($handle);
                $this->stderr("Empty or invalid CSV: {$path}\n");
                return ExitCode::DATAERR;
            }

            // Normalize headers: trim, collapse spaces, canonicalize names
            $normHeader = [];
            foreach ($header as $h) {
                $normHeader[] = $this->normalizeHeader($h);
            }

            // Keep union of headers
            foreach ($normHeader as $h) {
                $allHeaders[$h] = true;
            }

            // Read data rows
            while (($data = fgetcsv($handle, 0, ',', '"', "\0")) !== false) {
                // Skip entirely empty rows
                if (count($data) === 1 && trim((string)$data[0]) === '') {
                    continue;
                }
                $row = [];
                foreach ($normHeader as $i => $h) {
                    $val = isset($data[$i]) ? $data[$i] : '';
                    // Normalize line breaks to \n, trim trailing spaces
                    $val = str_replace(["\r\n", "\r"], "\n", $val);
                    $row[$h] = $val;
                }
                $row['mod'] = $src['mod'];
                $rows[] = $row;
            }
            fclose($handle);
        }

        // Final header order: sorted, but prioritize common/important columns if present
        $headers = array_keys($allHeaders);
        // Move known keys to front if exist
        $priority = [
            'NO. MATRIK', 'NO_MATRIK', 'NAMA PELAJAR', 'NO. IC / PASSPORT', 'NO_IC',
            'TARIKH LAHIR', 'JANTINA', 'TARAF PERKAHWINAN', 'NEGARA ASAL', 'KEWARGANEGARAAN',
            'PROGRAM', 'PROGRAM PENGAJIAN', 'KOD PROGRAM', 'KOD_PROGRAM', 'TARAF PENGAJIAN', 'MOD PENGAJIAN',
            'FAKULTI', 'BIDANG PENGAJIAN', 'ALAMAT', 'DAERAH', 'NO. TELEFON', 'NO_TELEFON',
            'EMEL PERSONAL', 'EMEL_PELAJAR', 'SESI MASUK', 'TAHUN KEMASUKAN', 'TARIKH KEMASUKAN',
            'SEMESTER', 'SEMESTER SEMASA PELAJAR', 'KAMPUS', 'STATUS', 'STATUS PELAJAR'
        ];
        $ordered = [];
        foreach ($priority as $p) {
            if (isset($allHeaders[$p])) {
                $ordered[$p] = true;
            }
        }
        foreach ($headers as $h) {
            if (!isset($ordered[$h])) {
                $ordered[$h] = true;
            }
        }
        $headers = array_keys($ordered);
        // Append the new 'mod' column at the end
        $headers[] = 'mod';

        // Write output CSV
        $outPath = \Yii::getAlias($out);
        $outDir = dirname($outPath);
        if (!is_dir($outDir)) {
            if (!mkdir($outDir, 0775, true) && !is_dir($outDir)) {
                $this->stderr("Cannot create directory: {$outDir}\n");
                return ExitCode::CANTCREAT;
            }
        }
        $outHandle = fopen($outPath, 'w');
        if (!$outHandle) {
            $this->stderr("Cannot write to: {$outPath}\n");
            return ExitCode::CANTCREAT;
        }
        // Force UTF-8 without BOM by writing normally
        fputcsv($outHandle, $headers);
        foreach ($rows as $row) {
            $line = [];
            foreach ($headers as $h) {
                $line[] = $row[$h] ?? '';
            }
            fputcsv($outHandle, $line);
        }
        fclose($outHandle);

        $this->stdout("Merged CSV written to: {$outPath}\n");
        $this->stdout("Rows: " . count($rows) . ", Columns: " . count($headers) . "\n");
        return ExitCode::OK;
    }
}
