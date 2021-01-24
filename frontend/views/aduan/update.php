<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use backend\modules\aduan\models\AduanProgress;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\modules\aduan\models\Aduan */

$this->title = 'Kemaskini Aduan';
$this->params['breadcrumbs'][] = ['label' => 'Aduans', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>

<div class="aduan-index">
     <section class="contact-page spad pt-0">
        <div class="container">

<h3><?= Html::encode($this->title) ?>#<?=$model->id?></h3>  
<div align="right"><a href="https://fkp-portal.umk.edu.my/web/aduan">Kembali ke Halaman Aduan</a>
</div>

<br />
		
<div class="aduan-update">




<style>
table.detail-view th {
    width:15%;
}

.timeline {
    position: relative;
    margin: 0 0 30px 0;
    padding: 0;
    list-style: none;
	
}

.timeline>li {
    position: relative;
    margin-right: 10px;
    margin-bottom: 15px;
}


.bg-red {
    background-color: #dd4b39 !important;
	color: #fff !important;
}

.timeline>.time-label>span {
    font-weight: 600;
    padding: 5px;
    display: inline-block;
    background-color: #fff;
    border-radius: 4px;
}

.timeline>li>.fa, .timeline>li>.glyphicon, .timeline>li>.ion {
    width: 30px;
    height: 30px;
    font-size: 15px;
    line-height: 30px;
    position: absolute;
    color: #666;
    background: #d2d6de;
    border-radius: 50%;
    text-align: center;
    left: 18px;
    top: 0;
}

.timeline>li>.timeline-item>.time {
    color: #999;
    float: right;
    padding: 10px;
    font-size: 12px;
}

.timeline>li>.timeline-item>.timeline-header {
    margin: 0;
    color: #555;
    border-bottom: 1px solid #f4f4f4;
    padding: 10px;
    font-size: 16px;
    line-height: 1.1;
}

.timeline>li>.timeline-item>.timeline-body, .timeline>li>.timeline-item>.timeline-footer {
    padding: 10px;
}

.timeline:before {
    content: '';
    position: absolute;
    top: 0;
    bottom: 0;
    width: 4px;
    background: #ddd;
    left: 31px;
    margin: 0;
    border-radius: 2px;
}
timeline>li:before, .timeline>li:after {
    content: " ";
    display: table;
}

timeline>li>.timeline-item>.time {
    color: #999;
    float: right;
    padding: 10px;
    font-size: 12px;
}
.timeline>li>.timeline-item {
    -webkit-box-shadow: 0 1px 1px rgba(0,0,0,0.1);
    box-shadow: 0 1px 1px rgba(0,0,0,0.1);
    border-radius: 3px;
    margin-top: 0;
    background: #fff;
    color: #444;
    margin-left: 60px;
    margin-right: 15px;
    padding: 0;
    position: relative;
	border: 1px solid #f4f4f4;
}

</style>


<div class="aduan-view">

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
                                    <span class="bg-red">
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
                                <span class="time">'.$act->progress->progress .' <i class="fa fa-clock-o"></i>'.' ' .''.$time.'</span>

                                <h3 class="timeline-header"><a href="">';
							if($act->created_by == 0){
								echo Html::encode($model->name);
							}else{
								echo 'Penyelia Aduan';
							}
								
							echo '</a></h3>

                                <div class="timeline-body">
                                    '.Html::encode($act->action_text) .'
                                </div>

                                
                            </div>
                        </li>
                        <!-- END timeline item -->

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
                        <div class="col-md-10">
                    <?= $form->field($actionCreate, 'action_text')->textarea(['rows' => 6])->label('Hantar maklum balas atas tindakan') ?>
                    <?php 
					$model->progress_id = 40;
					echo $form->field($model, 'progress_id')->dropDownList(
                            ArrayHelper::map(AduanProgress::find()->where(['user_action'  => 1])->all(),'id','progress'), ['prompt' => 'Pilih salah satu' ] )->label('Pilihan Status') ?>
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





</div>



     </div>
    </section>
</div>