<?php

namespace backend\modules\postgrad\models;

use Yii;

class PgSetting extends \yii\db\ActiveRecord
{
    private static $rangeCache = [];

    public static function tableName()
    {
        return 'pg_setting';
    }

    public static function trafficLightDefaults($module)
    {
        return [
            'green' => ['min' => 0, 'max' => 3],
            'yellow' => ['min' => 4, 'max' => 7],
            'red' => ['min' => 8, 'max' => null],
        ];
    }

    public static function trafficLightRanges($module)
    {
        $module = (string)$module;
        if (isset(self::$rangeCache[$module])) {
            return self::$rangeCache[$module];
        }

        $ranges = self::trafficLightDefaults($module);

        $rows = self::find()
            ->where(['module' => $module])
            ->indexBy('color')
            ->all();

        if ($rows) {
            foreach ($rows as $color => $row) {
                if (!isset($ranges[$color])) {
                    continue;
                }
                $ranges[$color] = [
                    'min' => (int)$row->min_value,
                    'max' => $row->max_value === null ? null : (int)$row->max_value,
                ];
            }
        }

        self::$rangeCache[$module] = $ranges;
        return $ranges;
    }

    public static function trafficLightLabel($module, $color)
    {
        $ranges = self::trafficLightRanges($module);
        $color = (string)$color;
        $r = $ranges[$color] ?? null;
        if (!$r) {
            return '';
        }

        $min = (int)($r['min'] ?? 0);
        $max = $r['max'] ?? null;

        $labelColor = ucfirst($color);
        if ($max === null) {
            return $labelColor . ' (' . $min . '+)';
        }
        return $labelColor . ' (' . $min . '–' . (int)$max . ')';
    }

    public static function classifyTrafficLight($module, $value)
    {
        $value = (int)$value;
        $ranges = self::trafficLightRanges($module);

        foreach (['green', 'yellow', 'red'] as $color) {
            if (!isset($ranges[$color])) {
                continue;
            }
            $min = (int)($ranges[$color]['min'] ?? 0);
            $max = $ranges[$color]['max'] ?? null;
            if ($value < $min) {
                continue;
            }
            if ($max === null || $value <= (int)$max) {
                return $color;
            }
        }

        return 'red';
    }

    public function rules()
    {
        return [
            [['module', 'color', 'min_value'], 'required'],
            [['min_value', 'max_value', 'updated_at', 'updated_by'], 'integer'],
            [['module'], 'string', 'max' => 32],
            [['color'], 'string', 'max' => 10],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'module' => 'Module',
            'color' => 'Color',
            'min_value' => 'From',
            'max_value' => 'To',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }
}
