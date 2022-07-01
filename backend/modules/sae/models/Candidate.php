<?php

namespace backend\modules\sae\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string|null $password_reset_token
 * @property string $email
 * @property int $status
 * @property string $can_name
 * @property string $department
 * @property int $can_batch
 * @property int $can_zone
 * @property int $finished_at
 * @property int $answer_status
 * @property int $answer_status2
 * @property int $overall_status
 * @property string $answer_last_saved
 * @property int $question_last_saved
 * @property string $answer_last_saved2
 * @property int $created_at
 * @property int $updated_at
 * @property string|null $verification_token
 */
class Candidate extends User
{
    public $c1;
    public $c2;
    public $c3;
    public $c4;
    public $c5;
    public $c6;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // [['username', 'auth_key', 'password_hash', 'email', 'can_name', 'department', 'can_batch', 'can_zone', 'finished_at', 'answer_status', 'answer_status2', 'overall_status', 'answer_last_saved', 'answer_last_saved2', 'created_at', 'updated_at'], 'required'],
            [['status', 'can_batch', 'can_zone', 'finished_at', 'answer_status', 'answer_status2', 'overall_status', 'question_last_saved', 'created_at', 'updated_at'], 'integer'],
            [['password_hash', 'password_reset_token', 'email', 'verification_token'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['can_name'], 'string', 'max' => 200],
            [['department'], 'string', 'max' => 80],
            [['answer_last_saved', 'answer_last_saved2'], 'string', 'max' => 8],
            [['username'], 'unique'],
            [['email'], 'unique'],
            [['password_reset_token'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'status' => 'Status',
            'can_name' => 'Full Name',
            'department' => 'Department',
            'can_batch' => 'Batch',
            'can_zone' => 'Can Zone',
            'finished_at' => 'Submission Time',
            'answer_status' => 'Status',
            'answer_status2' => 'Answer Status2',
            'overall_status' => 'Overall Status',
            'answer_last_saved' => 'Answer Last Saved',
            'question_last_saved' => 'Question Last Saved',
            'answer_last_saved2' => 'Answer Last Saved2',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'verification_token' => 'Verification Token',
            'c1' => 'Enterprise',
            'c2' => 'Social',
            'c3' => 'Investigate',
            'c4' => 'Artistic',
            'c5' => 'Conventional',
            'c6' => 'Realistic',
        ];
    }

    public function getBatch()
    {
        return $this->hasOne(Batch::className(), ['id' => 'can_batch']);
    }

    public function getAnswer()
    {
        return $this->hasOne(Answer::className(), ['can_id' => 'id']);
    }

    public function getStatusText(){
        return Common::status()[$this->answer_status];
    }

    private function columResultAnswers($bat_id){
        $result = Domain::find()->where(['bat_id' => $this->bat_id])->all();
        $colum = ["a.id", "a.username", "a.can_name", "a.department", "a.can_zone", "a.can_batch",  "b.bat_text" ,
        "a.answer_status", "a.overall_status", "a.finished_at"];
        $c=1;
        
        foreach($result as $row){
        if($c==1){$comma="";}else{$comma=", ";}
            $str = "";
            $quest = Question::find()->where(['grade_cat' => $row->grade_cat])->all();
            $i=1;
            $jumq = count($quest);
            // echo $jumq;die();
            foreach($quest as $rq){
                if($i == $jumq){$plus = "";}else{$plus=" + ";}
                $str .= "IF(q".$rq->que_id ." > 0,1,0) ". $plus ;
            $i++;
            }
            $str .= " as c". $row->grade_cat;
        $c++;  
        $colum[] = $str; 
        }
        return $colum;
    }

    public function candidateResult(){

        $query = self::find()
        ->alias('a')
        ->select($this->columResultAnswers())
        ->joinWith(['batch b', 'answer c'])
        ->where(['!=' ,'a.id', 1])
        ->all();

        return $query;
    }

    public static function countCandidates(){
        return self::find()
        ->where(['!=' ,'id', 1])
        ->count();
    }

}
