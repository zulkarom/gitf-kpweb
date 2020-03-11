<?php

namespace backend\modules\questbank\models;

use Yii;

class Course extends \backend\modules\esiap\models\Course
{
	public function getQuestions()
    {
        return $this->hasMany(Question::className(), ['course_id' => 'id']);
    }


}
