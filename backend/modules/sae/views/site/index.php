<?php

use backend\modules\sae\models\Candidate;
use backend\modules\sae\models\Batch;
use backend\modules\sae\models\Answer;
use backend\modules\sae\models\GradeCategory;
use richardfan\widget\JSRegister;
use yii\helpers\Url;

$this->title = 'Dashboard';
$defaultBatch = Batch::findOne(['bat_show' => 1]);
?>

<?php if( \Yii::$app->user->can('manage-admin')){ ?>
<section class="content">
      <div class="container-fluid">
        
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?php echo Candidate::countCandidates()?></h3>

                <p> All Participants</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3><?php echo Batch::countBatches()?></h3>

                <p>Batches</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3><?php echo Answer::countResultSubmission()?></h3>

                <p>Total Result Submission</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3><?php echo Answer::countSubmissionToday()?></h3>

                <p>Submission Today</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        
       
      </div><!-- /.container-fluid -->
    </section>
    <br/>
	<?php } ?>
    <h3><?php echo Batch::defaultBatch()?></h3>
    <br/>
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
		
		<div class="col-lg-6 col-6">
		  
		<?php 
		$count_submit = Answer::countDefaultBatchAnswer();
		$count_started =  Answer::countDefaultBatchStarted();
		$count_notstarted = Answer::countDefaultBatchNotAnswer();
		
		?>  
		  <div class="row">
<div class="col-lg-6 col-6">
            <!-- small box -->
		
            <div class="small-box bg-info">
			
              <div class="inner">
                <h3><?php echo Answer::countDefaultBatchParticipant()?></h3>

                <p>Total Participants</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="<?php echo Url::to(['/answer/index'])?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
			
          </div>
          <!-- ./col -->
          <div class="col-lg-6 col-6">
           <div class="small-box bg-success">
              <div class="inner">
                <h3><?php echo $count_submit?></h3>

                <p>Submitted</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="<?php echo Url::to(['/answer/index', 'AnswerSearch[answer_status]' => 3])?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
		  
		  <div class="col-lg-6 col-6">
           <div class="small-box bg-warning">
              <div class="inner">
                <h3><?php echo $count_started ?></h3>

                <p>Started</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="<?php echo Url::to(['/answer/index', 'AnswerSearch[answer_status]' => 1])?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
		  
		  <div class="col-lg-6 col-6">
           <div class="small-box bg-danger">
              <div class="inner">
                <h3><?php echo $count_notstarted?></h3>

                <p>Not Started</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="<?php echo Url::to(['/answer/index', 'AnswerSearch[answer_status]' => 0])?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

</div>
		  
		  
		  
		</div>
          
   
          <div class="col-lg-4 col-4">
            <div class="card card-warning">
            <div class="card-body">
              <canvas id="pieChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            </div>
            <!-- /.card-body -->
          </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
       
      </div><!-- /.container-fluid -->
    </section>


<?php
  
  $answer = [];
  $started = [];
  $notAnswer = [];

  $answer[] =$count_submit;
  $started[] = $count_started;
  $notAnswer[] = $count_notstarted;
?>

<?php JSRegister::begin(); ?>
<script>
  $(function () {
    //-------------
    //- PIE CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.

    var data_answer = <?php echo json_encode($answer)?>;
    var data_not_answer = <?php echo json_encode($notAnswer)?>;
    var data_started = <?php echo json_encode($started)?>;

    var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
    var pieData        = {
      labels: [
          'Submitted',
          'Started',
          'Not Started',
      ],
      datasets: [
        {
          data: [data_answer,data_started, data_not_answer],
          backgroundColor : ['#28a745', '#ffc107',  '#dc3545'],
        }
      ]
    }
    var pieOptions     = {
      maintainAspectRatio : false,
      responsive : true,
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    new Chart(pieChartCanvas, {
      type: 'pie',
      data: pieData,
      options: pieOptions
    })

  });

</script>
<?php JSRegister::end(); ?>