<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\staff\models\StaffSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Staff';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="staff-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Staff', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'staff_id',
            'staff_no',
            'user_name',
            'user_password_hash',
            'staff_email:email',
            //'staff_name',
            //'staff_name_pub',
            //'staff_title',
            //'staff_edu',
            //'is_academic',
            //'position_id',
            //'position_status',
            //'working_status',
            //'leave_start',
            //'leave_end',
            //'leave_note:ntext',
            //'rotation_post',
            //'staff_expertise',
            //'staff_gscholar',
            //'officephone',
            //'handphone1',
            //'handphone2',
            //'staff_ic',
            //'staff_dob',
            //'date_begin_umk',
            //'date_begin_service',
            //'staff_note',
            //'personal_email:email',
            //'ofis_location',
            //'staff_cv',
            //'staff_img',
            //'teach_pg',
            //'staff_level',
            //'staff_interest:ntext',
            //'staff_department',
            //'is_super',
            //'progress',
            //'total_progress',
            //'trash',
            //'publish',
            //'user_active',
            //'user_deleted',
            //'user_account_type',
            //'user_suspension_timestamp',
            //'user_last_login_timestamp',
            //'user_failed_logins',
            //'user_last_failed_login',
            //'user_password_reset_hash',
            //'user_password_reset_timestamp',
            //'session_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
