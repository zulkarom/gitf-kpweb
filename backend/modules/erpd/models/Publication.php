<?php

namespace backend\modules\erpd\models;

use Yii;
use yii\helpers\ArrayHelper;


/**
 * This is the model class for table "publication".
 *
 * @property int $id
 * @property int $staff_id
 * @property int $pub_type
 * @property int $pub_year
 * @property string $pub_title
 * @property string $pub_journal
 * @property string $pub_volume
 * @property string $pub_issue
 * @property string $pub_page
 * @property string $pub_city
 * @property string $pub_state
 * @property string $pub_publisher
 * @property string $pub_isbn
 * @property string $pub_organizer
 * @property string $pub_inbook
 * @property string $pub_month
 * @property string $pub_day
 * @property string $pub_date
 * @property string $pub_index
 * @property int $has_file
 * @property string $modified_at
 * @property string $created_at
 */
class Publication extends \yii\db\ActiveRecord
{
	public $staff_name;
	
	public $pubupload_instance;
	public $file_controller;
	
	public $pub_label;
	public $pub_data;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rp_publication';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['staff_id','pub_type'], 'required'],
			
			[['pubupload_file'], 'required', 'on' => 'submit'],
			
			
            [['staff_id', 'pub_type', 'pub_year', 'has_file', 'reviewed_by'], 'integer'],
			
            [['modified_at', 'created_at', 'reviewed_at'], 'safe'],
			
            [['pub_title', 'pub_journal', 'pub_page', 'pub_city', 'pub_state', 'pub_publisher', 'pub_inbook', 'pub_month'], 'string', 'max' => 500],
			
            [['pub_volume', 'pub_issue', 'pub_day', 'pub_date'], 'string', 'max' => 100],
			
            [['pub_isbn', 'pub_organizer', 'pub_index'], 'string', 'max' => 200],
			
			[['pubupload_file'], 'required', 'on' => 'pubupload_upload'],
            [['pubupload_instance'], 'file', 'skipOnEmpty' => true, 'extensions' => 'pdf', 'maxSize' => 5000000],
            [['modified_at'], 'required', 'on' => 'pubupload_delete'],



        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Pub ID',
            'staff_id' => 'Staff ID',
            'pub_type' => 'Type of Publication',
            'pub_year' => 'Year',
            'pub_title' => 'Title',
            'pub_journal' => 'Journal',
            'pub_volume' => 'Volume',
            'pub_issue' => 'Issue',
            'pub_page' => 'Page(s)',
			'pub_index' => 'Index',
			'pub_inbook' => 'Proceedings/Book/Newspaper/Magazine',
			'pub_isbn' => 'ISSN/ISBN',
			'pub_publisher' => 'Publisher',
            'pub_city' => 'City',
            'pub_state' => 'State',
            'pub_organizer' => 'Organizer',      
            'pub_month' => 'Month',
            'pub_day' => 'Day',
            'pub_date' => 'Date',
            'has_file' => 'Has File',
            'pubupload_file' => 'Publication PDF File',
            'modified_at' => 'Modified At',
            'created_at' => 'Created At',
        ];
    }
	
	public function fieldTempate($col2 = 8, $help = ''){
		return '<div class="row"><div class="col-md-3" align="right">{label}:</div><div class="col-md-'.$col2.'">{input}<i style="font-size:9pt">'.$help.'</i>{error}</div></div>';
	}
	
	public function flashError(){
        if($this->getErrors()){
            foreach($this->getErrors() as $error){
                if($error){
                    foreach($error as $e){
                        Yii::$app->session->addFlash('error', $e);
                    }
                }
            }
        }

    }
	
	public function years(){
		$years = [];
		$curr = date('Y');
		$last = $curr - 30;
		for($y=$curr;$y>=$last;$y--){
			$years[$y] = $y;
		}
		
		return $years;
		
	}
	
	public function getPubType(){
        return $this->hasOne(PubType::className(), ['id' => 'pub_type']);
    }
	
	public function getStatusInfo(){
        return $this->hasOne(Status::className(), ['status_code' => 'status']);
    }
	
	public function getAuthors()
    {
        return $this->hasMany(Author::className(), ['pub_id' => 'id']);
    }
	
	public function getEditors()
    {
        return $this->hasMany(Editor::className(), ['pub_id' => 'id']);
    }
	
	public function getPubTags()
    {
        return $this->hasMany(PubTag::className(), ['pub_id' => 'id']);
    }
	
	public function getTagStaffNames($break = "<br />"){
		$tags = $this->pubTags;
		$str = '';
		if($tags){
			$i = 0;
			foreach($tags as $tag){
				$br = $i == 0 ? "" : $break;
				$str .= $br.$tag->staff->user->fullname;
			$i++;
			}
		}
		return $str;
	}
	
	public function getMyPubTags()
    {
        return $this->hasMany(PubTag::className(), ['pub_id' => 'id'])->where(['rp_pub_tag.staff_id' => Yii::$app->user->identity->staff->id]);
    }
	
	public function getPubTagsNotMe()
    {
        return $this->hasMany(PubTag::className(), ['pub_id' => 'id'])->where(['<>', 'staff_id',Yii::$app->user->identity->staff->id]);
    }
	
	public function tagStaffArray()
    {
        $list = self::find()
		->select('staff.id, user.fullname as staff_name, user.id as user_id')
		->innerJoin('rp_pub_tag', 'rp_pub_tag.pub_id = rp_publication.id')
		->innerJoin('staff', 'rp_pub_tag.staff_id = staff.id')
		->innerJoin('user', 'user.id = staff.user_id')
		->where(['rp_pub_tag.pub_id' => $this->id])
		->all();
		
		return ArrayHelper::map($list,'id', 'id');
    }
	
	public function showApaStyle(){
		$authors = $this->stringAuthors();
		if($this->pub_year){
			$year =" (".$this->pub_year."). ";
		}else{
			$year="";
		}
		if($this->pub_volume ==""){
			$volume="";	
		}else if($this->pub_issue==""){
			$volume= $this->pub_volume . ", ";
		}else{
			$volume=$this->pub_volume;
		}
		if($this->pub_issue){
			$issue ="(".$this->pub_issue .")";
			if($this->pub_page  == ""){
				$issue .= ".";
			}else{
				$issue .= ", ";
			}
		}else{
			$issue="";
		}
		
		if($this->pub_journal){
			$journal ="<em>".$this->pub_journal ."</em>";
			if($this->pub_volume =="" and $this->pub_issue=="" and $this->pub_page  == ""){
				$journal .=".";
			}else{
				$journal .=", ";
			}
		}else{
			$journal="";
		}
		if($this->pub_city){
			$city =$this->pub_city .", ";
		}else{
			$city="";
		}
		if($this->pub_state){
			$state =$this->pub_state .": ";
		}else{
			$state="";
		}
		if($this->pub_publisher){
			$publisher =$this->pub_publisher .".";
		}else{
			$publisher ="";
		}
		if($this->pub_page){
			$page =$this->pub_page .".";
		}else{
			$page ="";
		}
		
		if($this->pub_type ==1){ //journal article
			if($this->pub_title){
			$title =$this->pub_title .". ";
		}else{
			$title="";
		}
			$list = $authors.$year.$title.$journal.$volume.$issue.$page;
		}

		if($this->pub_type ==2){ // inbook
			if($this->pub_title  != ""){
				$title ="<em>".$this->pub_title ."</em>. ";
			}else{
				$title="";
			}
		$list = $authors.$year.$title.$city.$state.$publisher;
		
		
	}

	
	$editor = $this->stringEditors();
		if($this->pub_title){
			$title =$this->pub_title .". ";
		}else{
			$title="";
		}
		if($this->pub_inbook){
			$inbook ="In ".$editor."<em>".$this->pub_inbook ."</em>. ";
		}else{
			$inbook="";
		}
		if($this->pub_page){
			$page =" (pp. " .$this->pub_page ."). ";
		}else{
			$page="";
		}
	if($this->pub_type ==3){ //conference
		
	$list = $authors.$year.$title.$inbook.$page.$city.$state.$publisher;
	}
	if($this->pub_city){
		$city =$this->pub_city .": ";
	}else{
		$city="";
	}
	if($this->pub_type ==4){
		
	$list = $authors.$year.$title.$inbook.$page.$city.$publisher;
	}
	
	if($this->pub_year){
		$year =$this->pub_year;
	}else{
		$year="";
	}
	if($this->pub_inbook){
		$inbook ="<em>".$this->pub_inbook ."</em>. ";
	}else{
		$inbook="";
	}
	if($this->pub_month){
		$month =$this->pub_month ;
	}else{
		$month="";
	}
	
	$yearmonth = " (".$year.", ".$month.") ";
	
	if($this->pub_type ==5){
		
	$list = $authors.$yearmonth.$title.$inbook.$page;
	}
	if($this->pub_day){
		$day =" ".$this->pub_day ;
	}else{
		$day="";
	}
	$yearmonth = " (".$year.", ".$month.$day.") ";
	if($this->pub_type ==6){
		
	$list = $authors.$yearmonth.$title.$inbook.$page;
	}
	
	return str_replace("`","'",$list);
	}
	
	public function stringAuthorsPlain($break = "<br />"){
		$string_au ="";
		$authors = $this->authors;
		if($authors){
		$result_au = ArrayHelper::map($authors, 'id', 'au_name');
			$i = 0;
			foreach($result_au as $row_au){
				$br = $i == 0 ? "" : $break;
				$string_au .= $br.$row_au ;
			$i++;
			}
		}
		return $string_au;
	}
	
	public function stringEditorsPlain($break = "<br />"){
		$string_au ="";
		$authors = $this->editors;
		if($authors){
		$result_au = ArrayHelper::map($authors, 'id', 'edit_name');
			$i = 0;
			foreach($result_au as $row_au){
				$br = $i == 0 ? "" : $break;
				$string_au .= $br.$row_au ;
			$i++;
			}
		}
		return $string_au;
	}
	
	public function stringAuthors(){
		$authors = $this->authors;
		$string_au ="";
		if($authors){
		$result_au = ArrayHelper::map($authors, 'id', 'au_name');
		$num_au = count($result_au);
		
		$i=1;
		foreach($result_au as $row_au){
			$author = $row_au;
			if($i==1){$coma="";
			}else{
				if($i==$num_au){ // last sekali
				$coma=", & ";
				}else{
				$coma=", ";
				}
			}
			$stringau = $this->stringSingleAuthor($author);
			$lastname = trim(ucfirst($stringau[0]));
			//echo "##".$lastname."##";
			$stringnotlast = trim(ucfirst($stringau[1]));
			if($stringnotlast==""){
				$string_au .= $coma.$lastname.".";
				
			}else{
				$string_au .= $coma.$lastname.", ".$stringnotlast;
			}
			
		$i++;
		}
		}
	return $string_au;
	}
	
	public function stringSingleAuthor($input){
		//cari ada comma tak
		$lastname = '';
		$stringnotlast = '';
		$splitcomma = explode(",", $input);
		$kira = count($splitcomma);
		if($kira==2){
			$lastname = trim($splitcomma[0]);
			//echo $splitcomma[1];
			$split = explode(" ", trim($splitcomma[1]));
			$total2 = count($split);
			//echo $total2;
			$stringnotlast="";
			for($x=1;$x<=$total2;$x++){
				//echo $input.">>".$x."---";
				$notlast = $split[$x-1];
				if($notlast){
					$stringnotlast .= substr($notlast, 0, 1).". ";
				}else{
					$stringnotlast .="";
				}
				
			}
		}else if ($kira==1){
			$split = explode(" ", $input);//by space
			$total = count($split);
			//echo $total;
			if($total ==1){
				$lastname = $input;
				$stringnotlast = "";
			}else{
				$lastcount = $total -1;
				$stringnotlast="";
				for($x=1;$x<=$lastcount;$x++){
					if($x==$lastcount){$t=".";}else{$t=". ";}
					$notlast = $split[$x-1];
					$stringnotlast .= ucfirst(substr($notlast, 0, 1)).$t;
				}
				$lastname = $split[$lastcount];
			}
			
		}
		
		
	
			
		return array($lastname,$stringnotlast);
	}
	
	public function stringEditors(){
	$editors = $this->editors;
	
	$result_au = ArrayHelper::map($editors, 'id', 'edit_name');
	$num_au = count($result_au);

		if($num_au==1){
			$bb = " (Ed.) ";
		}else if($num_au > 1){
			$bb = " (Eds.) ";
		} else{
			$bb = "";
		}

	
	$string_au ="";
	$i=1;
		foreach($result_au as $row_au){
			$editor = $row_au;
			if($i==1){$coma="";
			}else{
				if($i==$num_au){
				$coma=" & ";
				}else{
				$coma=", ";
				}
			}
			
			$stringau = $this->stringSingleAuthor($editor);
			$lastname = $stringau[0];
			$stringnotlast = $stringau[1];
			$string_au .= $coma.$stringnotlast.$lastname;
		$i++;
		}
	return $string_au.$bb;
	}
	
	public function statusList(){
		$list = Status::find()->where(['user_show' => 1])->all();
		return ArrayHelper::map($list, 'status_code', 'status_name');
	}
	public function showStatus(){
		$status = $this->statusInfo;
		return '<span class="label label-'.$status->status_color .'">'.$status->status_name .'</span>';
	}
	
	public function myUniqueYear(){
		$years = self::find()
		->select('DISTINCT(pub_year)')
		->innerJoin('rp_pub_tag','rp_publication.id = rp_pub_tag.pub_id')
		->where(['rp_pub_tag.staff_id' => Yii::$app->user->identity->staff->id])
		->all();
		if($years){
			return ArrayHelper::map($years, 'pub_year', 'pub_year');
		}else{
			return [];
		}
	}


}
