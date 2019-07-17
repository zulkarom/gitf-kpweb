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
			<span>Latest News</span>
		</div>
	</div>
	
<section class="about-section">
		<div class="container">
		

<?= ListView::widget([
        'dataProvider' => $dataProvider,
		'summary' => false,
		'itemOptions' => ['tag' => null],
		'options' => ['class' => 'row'],
        'itemView' => function ($new, $key, $index, $widget) {
			
			return '<div class="col-xl-6">
					<div class="blog-item">
						<div class="blog-thumb set-bg" data-setbg=" ' . Url::to(['event/download', 'attr' => 'newsimg', 'id' => $new->id]) . '"></div>
						<div class="blog-content">
							<h4><a href=" ' . Url::to(['event/news', 'id' => $new->id]) . '" style="color:#000"> ' . $new->name . ' </a></h4>
							<div class="blog-meta">
								<span><i class="fa fa-calendar-o"></i> ' .  Yii::$app->formatter->asDate($new->date_start, 'medium') . ' </span>
								<span><i class="fa fa-user"></i> Admin</span>
							</div>
							<p> ' . limit_text($new->report_1) . ' </p>
						</div>
					</div>
				</div>';
			
		
        },
    ]) ?>


 </div>
	</section>
	
	
    <?php

function limit_text($text, $limit=20) {
      if (str_word_count($text, 0) > $limit) {
          $words = str_word_count($text, 2);
          $pos = array_keys($words);
          $text = substr($text, 0, $pos[$limit]) . '...';
      }
      return $text;
    }

	?>

 

    

