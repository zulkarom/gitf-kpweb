<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\EventSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Events';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-breadcrumb">
		<div class="container">
			<a href="<?=Url::to(['/site'])?>"><i class="fa fa-home"></i> Home</a> <i class="fa fa-angle-right"></i>
			<span>Upcoming Events</span>
		</div>
	</div>
	
<section class="about-section">
		<div class="container">
		

<?= ListView::widget([
        'dataProvider' => $dataProvider,
		
		'summary' => false,
		'itemOptions' => ['tag' => null],
		'options' => ['class' => 'row'],
        'itemView' => function ($model, $key, $index, $widget) {
			
			return '<div class="col-md-6 event-item">
					<div class="event-thumb">
						<img src="'.Url::to(['event/download', 'attr' => 'promoimg', 'id' => $model->id]) . '" alt="">
						<div class="event-date">
							<span>'.   Yii::$app->formatter->asDate($model->date_start, 'medium') . '</span>
							
						</div>
					</div>
					<div class="event-info">
						<h4>'. $model->name . '</h4>
						<p><i class="fa fa-calendar-o"></i>'.  Yii::$app->formatter->asTime($model->time_start, 'php:h:i A') . ' - '.  Yii::$app->formatter->asTime($model->time_end, 'php:h:i A') . '<i class="fa fa-map-marker"></i> '. $model->venue . '</p>
						<a href="'. Url::to(['event/view', 'id' => $model->id]). '" class="event-readmore">MORE INFO <i class="fa fa-angle-double-right"></i></a>
					</div>
				</div>';
			
			
           // return Html::a(Html::encode($model->name), ['view', 'id' => $model->id]);
        },
    ]) ?>


 </div>
	</section>
	
	
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

 

    

