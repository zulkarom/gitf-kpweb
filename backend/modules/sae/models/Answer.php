<?php

namespace backend\modules\sae\models;

use Yii;
use backend\modules\sae\models\Common;
/**
 * This is the model class for table "psy_answers".
 *
 * @property int $id
 * @property int $can_id user_id
 * @property int $bat_id
 * @property string $column1
 * @property string $column2
 * @property string $column3
 * @property int $status
 * @property int|null $finished_at
 * @property int $answer_status
 * @property int $answer_status2
 * @property int $overall_status
 * @property string $answer_last_saved
 * @property int $question_last_saved
 * @property string|null $answer_last_saved2
 * @property int $created_at
 * @property int $updated_at
 * @property int $q1
 * @property int $q2
 * @property int $q3
 * @property int $q4
 * @property int $q5
 * @property int $q6
 * @property int $q7
 * @property int $q8
 * @property int $q9
 * @property int $q10
 * @property int $q11
 * @property int $q12
 * @property int $q13
 * @property int $q14
 * @property int $q15
 * @property int $q16
 * @property int $q17
 * @property int $q18
 * @property int $q19
 * @property int $q20
 * @property int $q21
 * @property int $q22
 * @property int $q23
 * @property int $q24
 * @property int $q25
 * @property int $q26
 * @property int $q27
 * @property int $q28
 * @property int $q29
 * @property int $q30
 * @property int $q31
 * @property int $q32
 * @property int $q33
 * @property int $q34
 * @property int $q35
 * @property int $q36
 * @property int $q37
 * @property int $q38
 * @property int $q39
 * @property int $q40
 * @property int $q41
 * @property int $q42
 * @property int $q43
 * @property int $q44
 * @property int $q45
 * @property int $q46
 * @property int $q47
 * @property int $q48
 * @property int $q49
 * @property int $q50
 * @property int $q51
 * @property int $q52
 * @property int $q53
 * @property int $q54
 * @property int $q55
 * @property int $q56
 * @property int $q57
 * @property int $q58
 * @property int $q59
 * @property int $q60
 * @property int $q61
 * @property int $q62
 * @property int $q63
 * @property int $q64
 * @property int $q65
 * @property int $q66
 * @property int $q67
 * @property int $q68
 * @property int $q69
 * @property int $q70
 * @property int $q71
 * @property int $q72
 * @property int $q73
 * @property int $q74
 * @property int $q75
 * @property int $q76
 * @property int $q77
 * @property int $q78
 * @property int $q79
 * @property int $q80
 * @property int $q81
 * @property int $q82
 * @property int $q83
 * @property int $q84
 * @property int $q85
 * @property int $q86
 * @property int $q87
 * @property int $q88
 * @property int $q89
 * @property int $q90
 * @property int $q91
 * @property int $q92
 * @property int $q93
 * @property int $q94
 * @property int $q95
 * @property int $q96
 * @property int $q97
 * @property int $q98
 * @property int $q99
 * @property int $q100
 * @property int $q101
 * @property int $q102
 * @property int $q103
 * @property int $q104
 * @property int $q105
 * @property int $q106
 * @property int $q107
 * @property int $q108
 * @property int $q109
 * @property int $q110
 * @property int $q111
 * @property int $q112
 * @property int $q113
 * @property int $q114
 * @property int $q115
 * @property int $q116
 * @property int $q117
 * @property int $q118
 * @property int $q119
 * @property int $q120
 * @property string|null $biz_idea
 */
class Answer extends \yii\db\ActiveRecord
{

    public $c1;
    public $c2;
    public $c3;
    public $c4;
    public $c5;
    public $c6;
    public $can_name;
    public $username;
    public $bat_text;
	public $total;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'psy_answers';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['can_id'], 'required'],
            [['can_id', 'bat_id', 'status', 'finished_at', 'answer_status', 'answer_status2', 'overall_status', 'question_last_saved', 'created_at', 'updated_at', 'q1', 'q2', 'q3', 'q4', 'q5', 'q6', 'q7', 'q8', 'q9', 'q10', 'q11', 'q12', 'q13', 'q14', 'q15', 'q16', 'q17', 'q18', 'q19', 'q20', 'q21', 'q22', 'q23', 'q24', 'q25', 'q26', 'q27', 'q28', 'q29', 'q30', 'q31', 'q32', 'q33', 'q34', 'q35', 'q36', 'q37', 'q38', 'q39', 'q40', 'q41', 'q42', 'q43', 'q44', 'q45', 'q46', 'q47', 'q48', 'q49', 'q50', 'q51', 'q52', 'q53', 'q54', 'q55', 'q56', 'q57', 'q58', 'q59', 'q60', 'q61', 'q62', 'q63', 'q64', 'q65', 'q66', 'q67', 'q68', 'q69', 'q70', 'q71', 'q72', 'q73', 'q74', 'q75', 'q76', 'q77', 'q78', 'q79', 'q80', 'q81', 'q82', 'q83', 'q84', 'q85', 'q86', 'q87', 'q88', 'q89', 'q90', 'q91', 'q92', 'q93', 'q94', 'q95', 'q96', 'q97', 'q98', 'q99', 'q100', 'q101', 'q102', 'q103', 'q104', 'q105', 'q106', 'q107', 'q108', 'q109', 'q110', 'q111', 'q112', 'q113', 'q114', 'q115', 'q116', 'q117', 'q118', 'q119', 'q120'], 'integer'],
            [['biz_idea'], 'string'],
            [['column1', 'column2', 'column3', 'column4'], 'string', 'max' => 225,  'strict' => false],
            [['answer_last_saved', 'answer_last_saved2'], 'string', 'max' => 8],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'can_id' => 'Can ID',
            'bat_id' => 'Bat ID',
            'column1' => 'Column1',
            'column2' => 'Column2',
            'column3' => 'Column3',
            'column4' => 'Column4',
            'status' => 'Status',
            'finished_at' => 'Finished At',
            'answer_status' => 'Answer Status',
            'answer_status2' => 'Answer Status2',
            'overall_status' => 'Overall Status',
            'answer_last_saved' => 'Answer Last Saved',
            'question_last_saved' => 'Question Last Saved',
            'answer_last_saved2' => 'Answer Last Saved2',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'q1' => 'Q1',
            'q2' => 'Q2',
            'q3' => 'Q3',
            'q4' => 'Q4',
            'q5' => 'Q5',
            'q6' => 'Q6',
            'q7' => 'Q7',
            'q8' => 'Q8',
            'q9' => 'Q9',
            'q10' => 'q10',
            'q11' => 'Q11',
            'q12' => 'Q12',
            'q13' => 'Q13',
            'q14' => 'Q14',
            'q15' => 'Q15',
            'q16' => 'Q16',
            'q17' => 'Q17',
            'q18' => 'Q18',
            'q19' => 'Q19',
            'q20' => 'q20',
            'q21' => 'Q21',
            'q22' => 'Q22',
            'q23' => 'Q23',
            'q24' => 'Q24',
            'q25' => 'Q25',
            'q26' => 'Q26',
            'q27' => 'Q27',
            'q28' => 'Q28',
            'q29' => 'Q29',
            'q30' => 'q30',
            'q31' => 'Q31',
            'q32' => 'Q32',
            'q33' => 'Q33',
            'q34' => 'Q34',
            'q35' => 'Q35',
            'q36' => 'Q36',
            'q37' => 'Q37',
            'q38' => 'Q38',
            'q39' => 'Q39',
            'q40' => 'q40',
            'q41' => 'Q41',
            'q42' => 'Q42',
            'q43' => 'Q43',
            'q44' => 'Q44',
            'q45' => 'Q45',
            'q46' => 'Q46',
            'q47' => 'Q47',
            'q48' => 'Q48',
            'q49' => 'Q49',
            'q50' => 'q50',
            'q51' => 'Q51',
            'q52' => 'Q52',
            'q53' => 'Q53',
            'q54' => 'Q54',
            'q55' => 'Q55',
            'q56' => 'Q56',
            'q57' => 'Q57',
            'q58' => 'Q58',
            'q59' => 'Q59',
            'q60' => 'q60',
            'q61' => 'Q61',
            'q62' => 'Q62',
            'q63' => 'Q63',
            'q64' => 'Q64',
            'q65' => 'Q65',
            'q66' => 'Q66',
            'q67' => 'Q67',
            'q68' => 'Q68',
            'q69' => 'Q69',
            'q70' => 'q70',
            'q71' => 'Q71',
            'q72' => 'Q72',
            'q73' => 'Q73',
            'q74' => 'Q74',
            'q75' => 'Q75',
            'q76' => 'Q76',
            'q77' => 'Q77',
            'q78' => 'Q78',
            'q79' => 'Q79',
            'q80' => 'q80',
            'q81' => 'Q81',
            'q82' => 'Q82',
            'q83' => 'Q83',
            'q84' => 'Q84',
            'q85' => 'Q85',
            'q86' => 'Q86',
            'q87' => 'Q87',
            'q88' => 'Q88',
            'q89' => 'Q89',
            'q90' => 'q90',
            'q91' => 'Q91',
            'q92' => 'Q92',
            'q93' => 'Q93',
            'q94' => 'Q94',
            'q95' => 'Q95',
            'q96' => 'Q96',
            'q97' => 'Q97',
            'q98' => 'Q98',
            'q99' => 'Q99',
            'q100' => 'q100',
            'q101' => 'Q101',
            'q102' => 'Q102',
            'q103' => 'Q103',
            'q104' => 'Q104',
            'q105' => 'Q105',
            'q106' => 'Q106',
            'q107' => 'Q107',
            'q108' => 'Q108',
            'q109' => 'Q109',
            'q110' => 'q110',
            'q111' => 'Q111',
            'q112' => 'Q112',
            'q113' => 'Q113',
            'q114' => 'Q114',
            'q115' => 'Q115',
            'q116' => 'Q116',
            'q117' => 'Q117',
            'q118' => 'Q118',
            'q119' => 'Q119',
            'q120' => 'q120',
            'biz_idea' => 'Biz Idea',
            'c1' => 'Enterprise',
            'c2' => 'Social',
            'c3' => 'Investigate',
            'c4' => 'Artistic',
            'c5' => 'Conventional',
            'c6' => 'Realistic',
        ];
    }

    public function statusArray(){
        return [0 => 'Not Started', 1 => 'Started', 3 => 'Submitted'];
    }

    public function statusLabelArray(){
        return [0 => 'Belum Mula / Not Started', 1 => 'Dalam Proses / In Progress', 3 => 'Telah Hantar / Submitted'];
    }

    public function getStatus1Text(){
		$list = $this->statusLabelArray();
        if(array_key_exists($this->answer_status, $list)){
            return $list[$this->answer_status];
        }
        
    }

    public function getStatus2Text(){
		$list = $this->statusLabelArray();
        if(array_key_exists($this->answer_status2, $list)){
            return $list[$this->answer_status2];
        }
        
    }
	
	public function getStatusText(){
		$list = $this->statusArray();
        if(array_key_exists($this->overall_status, $list)){
            return $list[$this->overall_status];
        }
        
    }
	
	public static function statusByUserBatch($user, $batch){
		$status = self::findOne(['can_id' => $user, 'bat_id' => $batch]);
		if($status){
			$status = $status->answer_status;
			$list = [0 => 'Not Started', 1 => 'Started', 3 => 'Submitted'];
			return $list[$status];
		}
	}

    public static function getAnswersByCat($can,$cat)
    {
        $listQuestion = Question::find()
        ->select('que_id')
        ->where(['grade_cat' => $cat])
        ->all();

        $array = array();
        foreach($listQuestion as $q){
            $obj = new \stdClass();
            $obj->quest = $q->que_id;
            $obj->answer = self::getOneAnswer($can,$q->que_id);
            $array[] = $obj;
        }
        
        return $array;
    }   

    public static function getOneAnswer($can,$quest){
        $colum = "q".$quest;
        $result = self::find()->select($colum)->where(['can_id' => $can])->one();
        return $result->$colum;
    }

    public function processOverallStatus(){
        if($this->answer_status == 3 && $this->answer_status2 == 3){
            $this->overall_status = 3;
            $this->finished_at = time();
        }

        if($this->answer_status == 1 || $this->answer_status2 == 1){
            $this->overall_status = 1;
        }


        return $this->save();
    }

/*     public function processOverallStatusx($status, $which, $user_id, $batch){
        //if 1 cari yg satu lg  - klu 0 set 1
        //if 3 cari yg satu lg - klu 3 set 3
        
        // $user = UserModel::getUserDataById($user_id);
        
        if(($status == 1 and $which == 1) 
            or ($status == 1 and $which == 2 and $this->answer_status == 0)){
            self::setOverallStatus(1,$user_id,$batch);
        }
        
        if(($status == 3 and $which == 1) or ($status == 3 and $which == 2 and $this->answer_status == 3)){
            self::setOverallStatus(3,$user_id,$batch);
            self::setFinishTime($user_id,$batch);
        }
    } */

    public static function setOverallStatus($status,$user,$batch)
    {
        Answer::updateAll(['overall_status' => $status], ['can_id' => $user, 'bat_id' => $batch]);
    }

    public static function updateLastSaved($user,$batch,$time,$qlast){
        Answer::updateAll(['answer_last_saved' => $time, 'question_last_saved' => $qlast, 'updated_at' => time()], ['can_id' => $user, 'bat_id' => $batch]);
    }

    public static function setFinishTime2($user,$batch)
    {
        Answer::updateAll(['finished_at' => Yii::$app->user->identity->user_last_login_timestamp], ['can_id' => $user, 'bat_id' => $batch]);
    }

    public static function setFinishTime($user,$batch)
    {
        Answer::updateAll(['finished_at' => time()], ['can_id' => $user, 'bat_id' => $batch]);
    }

    

    public function getBatch()
    {
        return $this->hasOne(Batch::className(), ['id' => 'bat_id']);
    }

    public function getCandidate()
    {
        return $this->hasOne(Candidate::className(), ['id' => 'can_id']);
    }

    public static function countResultSubmission(){
        return self::find()
        ->where(['overall_status' => 3])
        ->count();
    }

    public static function countSubmissionToday(){
        return self::find()
        ->where(['finished_at' => strtotime(date('Y-m-d'))])
        ->count();
    }
	
	public static function countDefaultBatchParticipant(){
        return self::find()
        ->alias('a')
        ->joinWith(['batch b'])
        ->andWhere(['b.bat_show' => 1])
        ->count();
    }

    public static function countDefaultBatchAnswer(){
        return self::find()
        ->alias('a')
        ->joinWith(['batch b'])
        ->where(['overall_status' => 3])
        ->andWhere(['b.bat_show' => 1])
        ->count();
    }
	
	public static function countDefaultBatchStarted(){
        return self::find()
        ->alias('a')
        ->joinWith(['batch b'])
        ->where(['overall_status' => 1])
        ->andWhere(['b.bat_show' => 1])
        ->count();
    }

    public static function countDefaultBatchNotAnswer(){
        return self::find()
        ->alias('a')
        ->joinWith(['batch b'])
        ->where(['overall_status' => 0])
        ->andWhere(['b.bat_show' => 1])
        ->count();
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

}
