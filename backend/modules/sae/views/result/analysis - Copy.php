<?php

use yii\helpers\Html;
// use yii\grid\GridView;
use yii\bootstrap4\Modal;
use kartik\export\ExportMenu;
use yii\grid\GridView;
use yii\helpers\Url;
use softark\duallistbox\DualListbox;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ResultSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Analysis';
$this->params['breadcrumbs'][] = $this->title;
\backend\assets\DualListboxAsset::register($this);

?>

<div class="result-index">
<div class="card card-primary">
<div class="card-body">
<div class="row">
<!-- <div class="col-2">
</div> -->
<div class="col-8">



           <?php $form = ActiveForm::begin([
                'id' => 'favorite-form',
                'enableAjaxValidation' => false,
            ]); ?>
			
			
<div class="listbox-area" >
  <div class="left-area">
    <span id="ms_av_l" class="listbox-label"><b>Available Domain</b></span>
    <ul id="ms_imp_list" tabindex="0" role="listbox" style="height: 400px; overflow:auto" aria-labelledby="ms_av_l" aria-multiselectable="true">
      <li id="ms_opt1" role="option" aria-selected="false">Leather seats</li>
      <li id="ms_opt2" role="option" aria-selected="false">Front seat warmers</li>
      <li id="ms_opt3" role="option" aria-selected="false">Rear bucket seats</li>
      <li id="ms_opt4" role="option" aria-selected="false">Rear seat warmers</li>
      <li id="ms_opt5" role="option" aria-selected="false">Front sun roof</li>
      <li id="ms_opt6" role="option" aria-selected="false">Rear sun roof</li>
      <li id="ms_opt7" role="option" aria-selected="false">Cloaking capability</li>
      <li id="ms_opt8" role="option" aria-selected="false">Food synthesizer</li>
      <li id="ms_opt9" role="option" aria-selected="false">Advanced waste recycling system</li>
      <li id="ms_opt10" role="option" aria-selected="false">Turbo vertical take-off capability</li>
	  <li id="ms_opt10" role="option" aria-selected="false">Turbo vertical take-off capability</li>
	  <li id="ms_opt10" role="option" aria-selected="false">Turbo vertical take-off capability</li><li id="ms_opt10" role="option" aria-selected="false">Turbo vertical take-off capability</li>
	  <li id="ms_opt10" role="option" aria-selected="false">Turbo vertical take-off capability</li>
	  <li id="ms_opt10" role="option" aria-selected="false">Turbo vertical take-off capability</li>
    </ul>
    <button type="button" id="ex2-add" class="move-right-btn" aria-keyshortcuts="Alt+ArrowRight Enter" aria-disabled="true">Add</button>
  </div>
  <div class="right-area">
    <span id="ms_ch_l" class="listbox-label"><b>Selected Domain</b></span>
    <ul id="ms_unimp_list" style="height: 400px; overflow:auto" tabindex="0" role="listbox" aria-labelledby="ms_ch_l" aria-activedescendant="" aria-multiselectable="true">
    </ul>
    <button type="button" id="ex2-delete" class="move-left-btn" aria-keyshortcuts="Alt+ArrowLeft Delete" aria-disabled="true">Remove</button>
  </div>
  <div class="offscreen">Last change: <span aria-live="polite" id="ms_live_region"></span></div>
</div>




            <?php /* echo $form->field($model, 'grad_ids')->widget(DualListbox::className(),[
                    'items' => $items,
                    'options' => [
                        'multiple' => true,
                        'size' => 8,
                    ],
                    'clientOptions' => [
                        'nonSelectedListLabel' => 'Available Domain',
                        'selectedListLabel' => 'Selected Domain',
                        'moveOnSelect' => false,
                    ],
                ])
                ->hint(false)
                ->label(false); */
            ?>



    <?php if($batch->column1):?>
    <div class="card card-primary card-outline">
        <div class="card-body">
            <?php echo $form->field($model2, 'col_ids')->widget(DualListbox::className(),[
                    'items' => $items2,
                    'options' => [
                        'multiple' => true,
                        'size' => 8,
                    ],
                    'clientOptions' => [
                        'nonSelectedListLabel' => 'Available '.$batch->column1,
                        'selectedListLabel' => 'Selected '.$batch->column1,
                        'moveOnSelect' => false,
                    ],
                ])
                ->hint(false)
                ->label(false);
            ?>

        </div>
    </div>
    <?php endif;?>

    <?php if($batch->column2):?>
    <div class="card card-primary card-outline">
        <div class="card-body">
            <?php echo $form->field($model2, 'col2_ids')->widget(DualListbox::className(),[
                    'items' => $items3,
                    'options' => [
                        'multiple' => true,
                        'size' => 8,
                    ],
                    'clientOptions' => [
                        'nonSelectedListLabel' => 'Available '.$batch->column2,
                        'selectedListLabel' => 'Selected '.$batch->column2,
                        'moveOnSelect' => false,
                    ],
                ])
                ->hint(false)
                ->label(false);
            ?>
        </div>
    </div>
    <?php endif;?>

    <?php if($batch->column3):?>
    <div class="card card-primary card-outline">
        <div class="card-body">
           

            <?php echo $form->field($model2, 'col3_ids')->widget(DualListbox::className(),[
                    'items' => $items4,
                    'options' => [
                        'multiple' => true,
                        'size' => 8,
                    ],
                    'clientOptions' => [
                        'nonSelectedListLabel' => 'Available '.$batch->column3,
                        'selectedListLabel' => 'Selected '.$batch->column3,
                        'moveOnSelect' => false,
                    ],
                ])
                ->hint(false)
                ->label(false);
            ?>

        </div>
    </div>
    <?php endif;?>

    <?php if($batch->column4):?>
    <div class="card card-primary card-outline">
        <div class="card-body">
           

            <?php echo $form->field($model2, 'col4_ids')->widget(DualListbox::className(),[
                    'items' => $items5,
                    'options' => [
                        'multiple' => true,
                        'size' => 8,
                    ],
                    'clientOptions' => [
                        'nonSelectedListLabel' => 'Available '.$batch->column4,
                        'selectedListLabel' => 'Selected '.$batch->column4,
                        'moveOnSelect' => false,
                    ],
                ])
                ->hint(false)
                ->label(false);
            ?>
        </div>
    </div>
    <?php endif;?>

<div class="row">
<div class="col-md-3"> <?= $form->field($batch, 'result_limit')->input('number', ['min' => 1, 'step' => 1]) ?></div>



</div>
    
   

    <div class="form-group">
        <?= Html::submitButton('VIEW RESULT', [
            'class' => 'btn btn-primary'
        ]) ?>
    </div>

    <?php ActiveForm::end(); ?>
        
</div>
<div class="col-2">
</div>
</div>
</div>
</div>
</div>


