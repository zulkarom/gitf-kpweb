<?php

/* @var $this yii\web\View */

$studentLevel = Yii::$app->session->get('studentLevel');
$levelLabel = $studentLevel === 'PG' ? 'POSTGRAD' : 'UNDERGRAD';
$isPostgrad = $studentLevel === 'PG';
$this->title = 'FKP STUDENT PORTAL - ' . $levelLabel;
$dirAsset = Yii::$app->assetManager->getPublishedUrl('@student/assets/adminlte');
?>

<!-- Small boxes (Stat box) -->
        <div class="row">
        <?php if ($isPostgrad) { ?>
          <div class="col-lg-6 col-12" id="semester-registration">
            <div class="small-box bg-info">
              <div class="inner">
                <h3>PG</h3>

                <p>Semester Registration</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="<?= \yii\helpers\Url::to(['/site/semester-registration']) ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-6 col-12" id="research-progress">
            <div class="small-box bg-success">
              <div class="inner">
                <h3>PG</h3>

                <p>Research Progress</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="#research-progress" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-6 col-12">
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>PG</h3>

                <p>My Profile</p>
              </div>
              <div class="icon">
                <i class="ion ion-person"></i>
              </div>
              <a href="<?= \yii\helpers\Url::to(['/profile/view']) ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-6 col-12">
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>PG</h3>

                <p>Change Password</p>
              </div>
              <div class="icon">
                <i class="ion ion-locked"></i>
              </div>
              <a href="<?= \yii\helpers\Url::to(['/site/request-password']) ?>" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
        <?php } else { ?>
           <div class="col-lg-3 col-6">
             <!-- small box -->
             <div class="small-box bg-info">
               <div class="inner">
                 <h3>#</h3>

                 <p>Study Registration</p>
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
                 <h3>#</h3>

                 <p>Semester Registration</p>
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
                 <h3>#</h3>

                 <p>Training Registration</p>
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
                 <h3>#</h3>

                 <p>Assessment</p>
               </div>
               <div class="icon">
                 <i class="ion ion-pie-graph"></i>
               </div>
               <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
             </div>
           </div>
        <?php } ?>

        </div>
