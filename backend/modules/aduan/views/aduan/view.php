<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

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
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

<div class="box">
<div class="box-header">
<div class="box-body">


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
            'created_at',
            [
                'label' => 'Status',
                'value' => function($model){
                    return $model->progress->progress ;
                }
                
            ],
            [
                'label' => 'Information',
                'value' => function($model){
                    return $model->nric.' / '.$model->name.' / '.$model->email.' / '.$model->address;
                }
            ],

            // 'name',
            // 'nric',
            // 'address:ntext',
            // 'email:email',
            // 'phone',
            [
                'label' => 'Topic',
                'value' => function($model){
                    return $model->topic->topic_name ;
                }
                
            ],
            'title',
            'aduan:ntext',
            // 'declaration',
            'upload_url:ntext',
            // 'captcha',
            
            
        ],
    ]) ?>


</div>
</div>
</div>
</div>

<p>
<?= Html::a('Create Action', ['/aduan/aduan-action/create', 'id' => $model->id], ['class' => 'btn btn-warning']) ?>
</p>
    <div class="box">
        <div class="box-header">
          <div class="a">
            <div class="box-title"><b>Aduan Action</b></div>
          </div>
        </div>
          <div class="box-body">
            <table class="table">
                <thead>
                  <tr>
                    <th style="width:5%">No.</th>
                    <th>Title</th>
                    <th>Action Text</th>
                    <th>Action</th>
                  </tr>
                
                     <?php 
                
                    if($modelAction){
                    $i = 1;
                      foreach($modelAction as $action){
                        
                      echo '<tr><td>'.$i.'</td>
                            <td>'.$action->title.'</td>
                            <td>'.$action->action_text.'</td>
                            <td>
                            <a href="' . Url::to(['/aduan/aduan-action/update', 'id' => $action->id, 'sid' => $model->id]) . '" class="btn btn-primary btn-sm" ><span class="glyphicon glyphicon-pencil"></span></a>

                            <a href="' . Url::to(['/aduan/aduan-action/delete', 'id' => $action->id]) . '" class="btn btn-danger btn-sm" ><span class="glyphicon glyphicon-trash"></span></a>

                            

                            </td>';
                                    
                            $i++;
                       }
                     }
                          ?>
                  </tr>
                </thead>
              </table>
              
              
              
          </div>
        </div>
        

    

    

</div>



