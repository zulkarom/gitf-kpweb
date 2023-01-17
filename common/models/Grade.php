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
    public static function showPoint($mark){
        $grades = self::gradeArray();
        foreach($grades as $k => $m){
            if($mark >= $k){
                return $m[3];
            }
        }
        return 0;
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
            90 => ['A+', 100, 0, 4],
            80 => ['A', 89, 0, 4],
            75 => ['A-', 79, 0, 3.7],
            70 => ['B+', 74, 0, 3.3],
            65 => ['B', 69, 0, 3],
            60 => ['B-', 64, 0, 2.7],
            55 => ['C+', 59, 0, 2.3],
            50 => ['C', 54, 0, 2],
            45 => ['C-', 49, 0, 1.7],
            40 => ['D', 44, 0, 1],
            0 => ['F', 39, 0, 0],

        ];
    }

    public static function average(array $array, bool $includeEmpties = true): float
    {
        $array = array_filter($array, fn($v) => (
            $includeEmpties ? is_numeric($v) : is_numeric($v) && ($v > 0)
        ));

        return array_sum($array) / count($array);
    }

    public static function stdev($arr)
    {
        $num_of_elements = count($arr);
          
        $variance = 0.0;
          
                // calculating mean using array_sum() method
        $average = array_sum($arr)/$num_of_elements;
          
        foreach($arr as $i)
        {
            // sum of squares of differences between 
                        // all numbers and means.
            $variance += pow(($i - $average), 2);
        }
          
        return (float)sqrt($variance/$num_of_elements);
    }

    
}