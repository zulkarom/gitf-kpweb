<?php

namespace backend\modules\grant\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use common\models\User;
use backend\modules\postgrad\models\Supervisor;

class BackfillController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionHeadResearcher($limit = 100, $dryRun = false)
    {
        $limit = (int) $limit;
        if ($limit <= 0) {
            $limit = 100;
        }

        

        $db = Yii::$app->db;

        $grants = $db->createCommand(
            'SELECT `id`, `head_researcher_name` FROM `grn_grant` WHERE `head_researcher_id` IS NULL AND `head_researcher_name` IS NOT NULL AND `head_researcher_name` <> "" LIMIT ' . $limit
        )->queryAll();

        $checked = 0;
        $matched = 0;
        $updated = 0;
        $notFound = 0;

        foreach ($grants as $g) {
            $checked++;
            $id = (int) $g['id'];
            $name = (string) $g['head_researcher_name'];

            $svId = $this->findSupervisorIdByName($name);

            if (!$svId) {
                $notFound++;
                echo "NOT FOUND | grn_grant.id={$id} | {$name}\n";
                continue;
            }

            $matched++;

            if (!$dryRun) {
                $affected = $db->createCommand(
                    'UPDATE `grn_grant` SET `head_researcher_id` = :sv WHERE `id` = :id AND `head_researcher_id` IS NULL',
                    [':sv' => (int) $svId, ':id' => $id]
                )->execute();

                if ($affected) {
                    $updated++;
                }
            }

            echo "MATCHED | grn_grant.id={$id} | sv_id={$svId} | {$name}\n";
        }

        echo "\nSUMMARY\n";
        echo "checked={$checked}\n";
        echo "matched={$matched}\n";
        echo "updated={$updated}\n";
        echo "not_found={$notFound}\n";
        echo "dry_run=" . ($dryRun ? '1' : '0') . "\n";

        exit;
    }

    private function findSupervisorIdByName($name)
    {
        $name = trim((string) $name);
        if ($name === '') {
            return null;
        }

        $candidates = preg_split("/\r\n|\r|\n/", $name);
        if (!$candidates) {
            $candidates = [$name];
        }

        foreach ($candidates as $candidate) {
            $candidate = trim((string) $candidate);
            if ($candidate === '') {
                continue;
            }

            $strip = $this->normalizeName($candidate);
            if (!$strip) {
                continue;
            }

            $user = User::find()->alias('a')
                ->select('s.id as staff_id, a.id')
                ->joinWith(['staff s'])
                ->where(['like', 'fullname', $strip])
                ->one();

            if (!$user || empty($user->staff_id)) {
                continue;
            }

            $supervisor = Supervisor::find()->where(['staff_id' => (int) $user->staff_id])->one();
            if ($supervisor) {
                return (int) $supervisor->id;
            }

            $supervisor = new Supervisor();
            $supervisor->staff_id = (int) $user->staff_id;
            $supervisor->is_internal = 1;
            if ($supervisor->save(false)) {
                return (int) $supervisor->id;
            }
        }

        return null;
    }

    private function normalizeName($nama_input)
    {
        $titles = [
            'Professor', 'Proffesor', 'Prof.', 'Prof', 'Porf', 'Madya', 'Ts.', 'Ts', 'Dr.', 'Dr', 'Encik',
            'En.', 'En', 'Puan', 'Madam', "Dato'", 'Assoc.', 'Associate', '1)', '2)', '3)', '1.', '2.', '3.', '1', '2', '3',
        ];

        $nama = str_ireplace($titles, '', (string) $nama_input);

        $splitters = array_map('strtolower', [' Bin ', ' Binti ', ' Bt. ', ' Bt ', ' bte ', ' a/l ', ' a/p ']);

        $nama = str_ireplace($splitters, '|', strtolower($nama));

        $parts = explode('|', $nama);
        $firstPart = trim((string) ($parts[0] ?? ''));

        $firstPart = preg_replace('/\s+/', ' ', $firstPart);

        $words = explode(' ', $firstPart);

        $limited = array_slice($words, 0, 2);

        $out = trim(implode(' ', $limited));

        return $out !== '' ? $out : null;
    }
}
