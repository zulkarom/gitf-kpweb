<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap\Modal;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model backend\modules\postgrad\models\KursusKategori */

$this->title = $model->kategori_name;
$this->params['breadcrumbs'][] = ['label' => 'Kursus Kategori', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>


<div class="box">
        <div class="box-header"><b>Senarai Kursus</b></div>
        <div class="box-body">
            <div class="table-responsive"> <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>NAME</th>
                        <th></th>
                    </tr>
                    <?php 
                        $i = 1;
                        if($model->kursus){
                            foreach ($model->kursus as $kursus) {
                                
                                echo'<tr>
                                <td>'.$i.'</td>
                                <td>'.$kursus->kursus_name.'</td>
                                <td><a href="' . Url::to(['/postgrad/kursus-kategori/delete-kursus', 'id' => $kursus->id, 'cat' => $model->id]) . '" data-confirm="Are you sure to delete this?"><span class="fa fa-trash fa-xs"></span></a></td>
                                </tr>';
                                $i++;
                                
                            }
                        }
                    ?>               
                </thead>
            </table></div>
                    
            <br/>

                <p>
                    <?php echo Html::button('<span class="fa fa-plus"></span> Tambah Kursus', ['value' => Url::to(['/postgrad/kursus/create','pid' => $model->id]), 'class' => 'btn btn-success btn-sm', 'id' => 'modalBttnKursus']);
                    
                        Modal::begin([
                            'header' => '<h4>Tambah Kursus</h4>',
                            'id' =>'createKursus',
                            'size' => 'modal-lg'
                        ]);

                    echo '<div id="formCreateKursus"></div>';

                    Modal::end();

                    $this->registerJs('
                    $(function(){
                      $("#modalBttnKursus").click(function(){
                          $("#createKursus").modal("show")
                            .find("#formCreateKursus")
                            .load($(this).attr("value"));
                      });
                    });
                    ');
                
                
                    ?>
                </p>
        </div>
    </div>
