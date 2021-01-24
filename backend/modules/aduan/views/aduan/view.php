<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use backend\modules\aduan\models\AduanProgress;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\modules\aduan\models\Aduan */

$this->title = 'Aduan#' . $model->id;
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
            <?php 
			$dateSubmit = date("d M Y", strtotime($model->created_at));
			$time =  date("g.iA", strtotime($model->created_at));
			echo $dateSubmit;
            ?>


        </span>
    </li>
    <!-- /.timeline-label -->

    <!-- timeline item -->
    <li>
        <!-- timeline icon -->
        <i class="fa fa-user bg-aqua"></i>
        <div class="timeline-item">

        

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
                            'label' => 'Kategori',
                            'value' => function($model){
                                return $model->topic->topic_name ;
                            }
                            
                        ],
                        
                        [
                            'label' => 'Maklumat Pengadu',
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
                        
                        /* [
                            'label' => 'Attached File',
                            'format' => 'raw',
                            'value' => function($model){
                                return Html::a('Download', ['download', 'id' => $model->id], [
                                'class' => 'btn btn-default btn-sm', 'target' => '_blank'])
                                ;
                            }
                        ], */
                        // 'captcha',   
                        ],
                         
    ]) ?>
            </div>

            
        </div>
    </li>
    <!-- END timeline item -->

            <li>
              <i class="fa fa-comments bg-yellow"></i>

              <div class="timeline-item" >
			  
			  <span class="time">Submit <i class="fa fa-clock-o"></i> <?=$time?></span>

                <h3 class="timeline-header"><a href="">Aduan: <?=Html::encode($model->title)?></a></h3>

                <div class="timeline-body">
				<?=Html::encode($model->aduan)?>
				
				<div>
				<?php 
				if($model->upload_url){
					echo '<br />Attached File: ' . Html::a(' Download <span class="glyphicon glyphicon-download-alt"></span>', ['download', 'id' => $model->id], [
                               'target' => '_blank']);
				}
				
			
				
				?>
                </div>
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
						
						
                        if($i == 1 and ($currentdate != $dateSubmit)){
                           
                            echo'
                                <li class="time-label">
                                    <span class="bg-red">
                                        '. $currentdate.'
                                    </span>
                                </li>
                                ';
                               
                        }
                        else if($i > 1 and ($currentdate != $olddate)){
                            echo'
                                <li class="time-label">
                                    <span class="bg-green">
                                        '.$currentdate.'
                                    </span>
                                </li>';
                         
                        }
                        $olddate = $currentdate;

                        echo '<li>
                            <!-- timeline icon -->
                            <i class="fa fa-comments bg-yellow"></i>
                            <div class="timeline-item">
                               <span class="time">'.$act->progress->progress .' <i class="fa fa-clock-o"></i>'.' ' .''.$time.'</span>

                                 <h3 class="timeline-header"><a href="">';
							if($act->created_by == 0){
								echo Html::encode($model->name);
							}else{
								echo 'Penyelia Aduan';
							}
								
							echo '</a></h3>

                                <div class="timeline-body">
                                    '.$act->action_text.'
                                </div>

                                
                            </div>
                        </li>

';
                    $i++;
                      }
                  }
            ?>
			
			
			
			<?php 
			if(!in_array($model->progress_id,[100,80])){
			?>
			
			<li>
              <i class="fa fa-envelope bg-blue"></i>

              <div class="timeline-item">
                
                <div class="timeline-body">
                


                <?php $form = ActiveForm::begin(); ?>
                <div class="row">
                        <div class="col-md-8">
                    <?= $form->field($actionCreate, 'action_text')->textarea(['rows' => 6])->label('Write Actions / Progress / Feedback:') ?>
                    <?= $form->field($model, 'progress_id')->dropDownList(
                            ArrayHelper::map(AduanProgress::find()->where(['admin_action'  => 1])->all(),'id','progress'), ['prompt' => 'Pilih salah satu' ] ) ?>
                        </div>

                    </div>   
                

                <h3 class="timeline-header">
                    
                    <?= Html::submitButton('Submit', ['class' => 'btn btn-success']) ?>
 

                </h3>

                <?php ActiveForm::end(); ?>
                </div>
                                
                </div>
            </li>
			
			<?php
			}
			?>

            
</ul>
                  
</div>



