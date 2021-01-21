<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use backend\modules\aduan\models\AduanProgress;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\modules\aduan\models\Aduan */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Aduan', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<style>
table.detail-view th {
    width:15%;
}
</style>


<div class="aduan-view">
    <p>
        
        <?php 
        // Html::a('Delete', ['download', 'id' => $model->id], [
        //     'class' => 'btn btn-danger',
        //     'data' => [
        //         'confirm' => 'Are you sure you want to delete this item?',
        //         'method' => 'post',
        //     ],
        // ]) 
        ?>
    </p>

    <ul class="timeline">

    <!-- timeline time label -->
    <li class="time-label">
        <span class="bg-red">
            <?=
            $date = date("d M Y", strtotime($model->created_at));
            $date
            ?>


        </span>
    </li>
    <!-- /.timeline-label -->

    <!-- timeline item -->
    <li>
        <!-- timeline icon -->
        <i class="fa fa-user bg-aqua"></i>
        <div class="timeline-item">

            <span class="time"><i class="fa fa-clock-o"></i></span>

            <h3 class="timeline-header"><a href="">Information</a></h3>

            <div class="timeline-body">
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        // 'id',
                        // 'created_at',
                        [
                            'label' => 'Status',
                            'value' => function($model){
                                return $model->progress->progress ;
                            }
                            
                        ],
                        [
                            'label' => 'Category',
                            'value' => function($model){
                                return $model->topic->topic_name ;
                            }
                            
                        ],
                        
                        [
                            'label' => 'Personal',
                            'format' => 'html',
                            'value' => function($model){
                                return $model->name."<br/>".$model->nric."<br/>".$model->email."<br/>".$model->address;
                            }
                        ],

                        // 'name',
                        // 'nric',
                        // 'address:ntext',
                        // 'email:email',
                        // 'phone',
                        
                        
                        // 'aduan:ntext',
                        // 'declaration',
                        
                        [
                            'label' => 'Attached File',
                            'format' => 'raw',
                            'value' => function($model){
                                return Html::a('Download', ['download', 'id' => $model->id], [
                                'class' => 'btn btn-default btn-sm', 'target' => '_blank'])
                                ;
                            }
                        ],
                        // 'captcha',   
                        ],
                         
    ]) ?>
            </div>

            
        </div>
    </li>
    <!-- END timeline item -->

            <li>
              <i class="fa fa-comments bg-yellow"></i>

              <div class="timeline-item">

                <h3 class="timeline-header"><a href=""><?=$model->title?></a></h3>

                <div class="timeline-body">
                  <?=$model->aduan?>
                </div>
                
              </div>
            </li>

            <?php
            
            if($action){
                    $i = 1;
                    $olddate='x';
                      foreach($action as $act){
                        $currentdate = date("d M Y", strtotime($act->created_at));
                        $time =  date("g.iA", strtotime($act->created_at));
                        if($i == 1 && $currentdate != $date){
                           
                            echo'
                                <li class="time-label">
                                    <span class="bg-green">
                                        '.$currentdate.'
                                    </span>
                                </li>
                                ';
                               
                        }
                        else if($currentdate != $olddate){
                            echo'
                                <li class="time-label">
                                    <span class="bg-green">
                                        '.$currentdate.'
                                    </span>
                                </li>';
                         
                        }
                        $olddate = $currentdate;

                        echo'

                        <!-- timeline item -->
                        <li>
                            <!-- timeline icon -->
                            <i class="fa fa-comments bg-yellow"></i>
                            <div class="timeline-item">
                                <span class="time"><i class="fa fa-clock-o"></i>'.' ' .''.$time.'</span>

                                <h3 class="timeline-header"><a href="">Support Team</a></h3>

                                <div class="timeline-body">
                                    '.$act->action_text.'
                                </div>

                                
                            </div>
                        </li>
                        <!-- END timeline item -->

';
                    $i++;
                      }
                  }
            ?>

            <li>
              <i class="fa fa-envelope bg-blue"></i>

              <div class="timeline-item">
                
                <div class="timeline-body">
                


                <?php $form = ActiveForm::begin(); ?>
                <div class="row">
                        <div class="col-md-6">
                    <?= $form->field($actionCreate, 'action_text')->textarea(['rows' => 6]) ?>
                    <?= $form->field($model, 'progress_id')->dropDownList(
                            ArrayHelper::map(AduanProgress::find()->where(['admin_action'  => 1])->all(),'id','progress'), ['prompt' => 'Pilih salah satu' ] ) ?>
                        </div>

                    </div>   
                

                <h3 class="timeline-header">
                    
                    <?= Html::submitButton('Add Feedback', ['class' => 'btn btn-info btn-sm']) ?>
 

                </h3>

                <?php ActiveForm::end(); ?>
                </div>
                                
                </div>
            </li>
</ul>
                  
</div>



