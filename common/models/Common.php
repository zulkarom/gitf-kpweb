<?php

namespace common\models;

use Yii;

class Common {

    public static function bulan()
    {
        return [
			1 => 'Januari',
			2 => 'Februari',
			3 => 'Mac',
			4 => 'April',
			5 => 'Mei',
			6 => 'Jun',
			7 => 'Julai',
			8 => 'Ogos',
			9 => 'September',
			10 => 'Oktober',
			11 => 'November',
			12 => 'Disember',
		];
    }
	
	public static function months()
    {
        return [
			1 => 'January',
			2 => 'February',
			3 => 'March',
			4 => 'April',
			5 => 'May',
			6 => 'June',
			7 => 'July',
			8 => 'August',
			9 => 'September',
			10 => 'October',
			11 => 'November',
			12 => 'December',
		];
    }
	
	public static function dateth(){
		$days = [];
		for($i=1;$i<=31;$i++){
			$days[$i] = $i;
		}
		return $days;
	}
	
	public static function months_short()
    {
        return [
			1 => 'Jan',
			2 => 'Feb',
			3 => 'Mac',
			4 => 'Apr',
			5 => 'Mei',
			6 => 'Jun',
			7 => 'Jul',
			8 => 'Ogos',
			9 => 'Sep',
			10 => 'Okt',
			11 => 'Nov',
			12 => 'Dis',
		];
    }
	
	public static function getMonth($str){
		$list = self::months_short();
		foreach($list as $key=>$val){
			$m = strtolower($val);
			$str = strtolower($str);
			if($m == $str){
				return $key;
			}
		}
		return 0;
	}
	
	public static function date_malay($str){
		$day = date('d', strtotime($str));
		$month = date('m', strtotime($str)) + 0;
		$month_malay = self::bulan()[$month];
		$year = date('Y', strtotime($str));
		return $day . ' ' . $month_malay . ' ' . $year;
	}
	
	public static function date_malay_short($str){
		$day = date('d', strtotime($str));
		$month = date('m', strtotime($str)) + 0;
		$month_malay = self::months_short()[$month];
		$year = date('Y', strtotime($str));
		return $day . ' ' . $month_malay . ' ' . $year;
	}
	
	
	public static function days(){
		return [1 => "Ahad", 2 => "Isnin", 3 => "Selasa", 4 => "Rabu", 5 =>"Khamis", 6 => "Jumaat", 7 => "Sabtu"];
	}
	
	public static function years()
    {
		$curr = date('Y') + 0;
		$last = $curr - 1;
        return [
			$curr => $curr,
			$last => $last,
		];
    }
	
	public static function gender(){
		return [1 => 'Lelaki', 0 => 'Perempuan'];
	}
	
	public static function marital(){
		return [1 => 'Berkahwin', 2 => 'Tidak Berkahwin'];
	}
	
	public static function marital2(){
	    return [1 => 'Berkahwin', 2 => 'Bujang'];
	}
	
	public static function citizen(){
		return ['Malaysia' => 'Malaysia', 'Bukan Malaysia' => 'Bukan Malaysia'];
	}

	public static function citizenship(){
		return ['1' => 'Tempatan', '2' => 'Antarabangsa'];
	}
	
	public static function yesNo(){
		return [1 => 'Ya', 0 => 'Tidak'];
	}
	
	public static function studyMode(){
		return [1 => 'Sepenuh Masa', 2 => 'Separuh Masa'];
	}

	
	public static function race(){
		return [1 => 'Malay', 2 => 'Chinese', 3 => 'Indian' , 4 => 'Others'];
	}

	public static function religion(){
		return [1 => 'Islam', 2 => 'Buddhist', 3 => 'Cristian' , 4 => 'Hindu', 5 => 'Others'];
	}

	public static function studentStatus(){
		return [1 => 'Active', 0 => 'Not Active'];
	}

	

	public static function statusKursus(){
	    return [10 => 'Submit', 20 => 'Paid', 30 => 'Complete', 40 => 'Reject'];
	}


}
