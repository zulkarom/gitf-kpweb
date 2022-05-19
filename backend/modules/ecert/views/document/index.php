<?php
use backend\assets\ExcelAsset;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

ExcelAsset::register($this);

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\ecert\models\DocumentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$str = $certType->event->event_name;
if (strlen($str) > 40) {
    $str = substr($str, 0, 37) . '...';
}
$this->title = $str;
$this->params['breadcrumbs'][] = [
    'label' => 'Event List',
    'url' => [
        '/ecert/event'
    ]
];
$this->params['breadcrumbs'][] = [
    'label' => $str,
    'url' => [
        '/ecert/event/view',
        'id' => $certType->event_id
    ]
];
$this->params['breadcrumbs'][] = [
    'label' => 'Cert Types',
    'url' => [
        '/ecert/event-type',
        'event' => $certType->event_id
    ]
];
$this->params['breadcrumbs'][] = 'Certificates';
?>
<div class="document-index">

    <?php
    // echo $this->render('_search', ['model' => $searchModel]); ?>


<h3><?php

echo $certType->type_name?></h3>

    <p>
        <?=Html::a('Add Certificate', ['create','type' => $certType->id], ['class' => 'btn btn-success'])?>
                <input type="file" id="xlf" style="display:none;" />
<button type="button" id="btn-importexcel" class="btn btn-info"><span class="fa fa-upload"></span> Import Data</button>

<a href="<?=Url::to(['/ecert/document/export-data','type' => $certType->id])?>" target="_blank" class="btn btn-warning">Download Excel</a>
    </p>
     <div class="box">
<div class="box-header"></div>
<div class="box-body">

    <?php
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn'
            ],
            'identifier',
            'participant_name',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{cert} {view} {update} {delete}',
                // 'visible' => false,
                'buttons' => [
                    'cert' => function ($url, $model) {
                        return Html::a('<span class="fa fa-file"></span>', [
                            'cert',
                            'id' => $model->id
                        ], [
                            'class' => 'btn btn-success btn-sm',
                            'target' => '_blank'
                        ]);
                    },
                    'view' => function ($url, $model) {
                        return Html::a('<span class="fa fa-search"></span>', [
                            'view',
                            'id' => $model->id
                        ], [
                            'class' => 'btn btn-info btn-sm'
                        ]);
                    },
                    'update' => function ($url, $model) {
                        return Html::a('<span class="fa fa-edit"></span>', [
                            'update',
                            'id' => $model->id
                        ], [
                            'class' => 'btn btn-warning btn-sm'
                        ]);
                    },
                    'delete' => function ($url, $model) {
                        return Html::a('<span class="fa fa-trash"></span>', [
                            'delete',
                            'id' => $model->id
                        ], [
                            'class' => 'btn btn-danger btn-sm',
                            'data' => [
                                'confirm' => 'Are you sure you want to delete this data?',
                                'method' => 'post'
                            ]
                        ]);
                    }
                ]
            ]
        ]
    ]);
    ?>
</div>
</div>
</div>


<?php

$form = ActiveForm::begin([
    'id' => 'form-data',
    'action' => Url::to([
        '/ecert/document/import-data',
        'type' => $certType->id
    ])
]);
?>
  <input type="hidden" id="json_data" name="json_data">
  <?php

ActiveForm::end();
?>

 <div class="modal" id="loadingModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

      <div class="modal-body" align="center">
        <h3>LOADING DATA...</h3>
      </div>

    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php

$this->registerJs('


$("#btn-importexcel").click(function(){
	document.getElementById("xlf").click();
});

var X = XLSX;

  function fixdata(data) {
    var o = "", l = 0, w = 10240;
    for(; l<data.byteLength/w; ++l) o+=String.fromCharCode.apply(null,new Uint8Array(data.slice(l*w,l*w+w)));
    o+=String.fromCharCode.apply(null, new Uint8Array(data.slice(l*w)));
    return o;
  }

  function to_jsObject(workbook) {
    var result = {};
    workbook.SheetNames.forEach(function(sheetName) {
      var roa = X.utils.sheet_to_json(workbook.Sheets[sheetName], {header:1});
      if(roa.length) result[sheetName] = roa;
    });
    return result;

  }

  var xlf = document.getElementById(\'xlf\');

  function handleFile(e) {
	var str;
	var row;
    var files = e.target.files;
    var f = files[0];

      var reader = new FileReader();
      reader.onload = function(e) {
        var data = e.target.result;
        var wb;
        var arr = fixdata(data);
          wb = X.read(btoa(arr), {type: \'base64\'});
          //console.log(to_jsObject(wb));
          var obj = to_jsObject(wb) ;
          for (var key in obj) {
            var sheet = obj[key];
			var i = 1;
      var myJSON = JSON.stringify(sheet);
      //console.log(myJSON);
            $("#import-excel").modal("hide");

            	$("#loadingModal").modal({
                   backdrop: "static",
                   keyboard: false,
                   show: true
                });
            $("#json_data").val(myJSON);
            $("#form-data").submit();
            break;
          }

      };
      reader.readAsArrayBuffer(f);


  }

  if(xlf.addEventListener){

  xlf.addEventListener(\'change\', handleFile, false);

  }


');




