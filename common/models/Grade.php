<?php

namespace common\models;

use Yii;

class Grade
{
    public static function showGrade($mark){
        $grades = self::gradeArray();
        foreach($grades as $k => $m){
            if($mark >= $k){
                return $m[0];
            }
        }
        return 'F';
    }

    public static function analyse($marks){
        $g = self:: gradeArray();
        $sum = array();
        
        if($marks){
            foreach($marks as $m){
                foreach($g as $min=>$v){
                    $max = $v[1];
                    if($m >= $min && $m <= $max){
                        if(!array_key_exists($min,$sum)){
                            $sum[$min] = 0; 
                        }
                        $cur = $sum[$min];
                        $sum[$min] = $cur + 1;
                        break;
                    }
                }
                
            }
        }

        if($sum){
            foreach($sum as $n=>$s){
                $g[$n][2] = $s;
            }
        }

        return $g;
    }

    private static function gradeArray(){
        return [
            90 => ['A+', 100, 0],
            80 => ['A', 89, 0],
            75 => ['A-', 79, 0],
            70 => ['B+', 74, 0],
            65 => ['B', 69, 0],
            60 => ['B-', 64, 0],
            55 => ['C+', 59, 0],
            50 => ['C', 54, 0],
            45 => ['C-', 49, 0],
            40 => ['D', 44, 0],
            0 => ['F', 39, 0],

        ];
    }
    
}