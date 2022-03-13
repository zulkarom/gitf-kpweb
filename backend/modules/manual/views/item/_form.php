<?php

use dosamigos\tinymce\TinyMce;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model backend\modules\manual\models\Item */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="item-form">

    <?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'type')->dropDownList($model->getTypes()) ?>


    
    <?= $form->field($model, 'item_text')->widget(TinyMce::className(), [
    'options' => ['rows' => 40],
    'language' => 'en',
    'clientOptions' => [
        //'inline' => true,
        //$content_css needs to be defined as "" or some css rules/files
        // 'content_css' => $content_css,
        'plugins' => [
            "advlist autolink lists link charmap print preview anchor",
            "searchreplace code fullscreen",
            "insertdatetime media table contextmenu paste",
            "image imagetools visualchars textcolor",
            "autosave colorpicker hr nonbreaking template"
        ],
        'toolbar1' => "undo redo | styleselect fontselect fontsizeselect forecolor backcolor | bold italic",
        'toolbar2' => "alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",

        'image_title' => false,
        'images_upload_url'=> Url::to(['upload-image']),
        // here we add custom filepicker only to Image dialog
        'file_picker_types'=>'image',
        // and here's our custom image picker
        'file_picker_callback'=> new JsExpression("function(callback, value, meta) {
            var input = document.createElement('input');
            input.setAttribute('type', 'file');
            input.setAttribute('accept', 'image/*');

            //If this is not included, the onchange function will not
            //be called the first time a file is chosen 
            //(at least in Chrome 58)
            var foo = document.getElementById('cms-page_content_ifr');
            foo.appendChild(input);

            input.onchange = function() {
                //alert('File Input Changed');
                //console.log( this.files[0] );

                var file = this.files[0];

                var reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onload = function () {
                    // Note: Now we need to register the blob in TinyMCEs image blob
                    // registry. In the next release this part hopefully won't be
                    // necessary, as we are looking to handle it internally.

                    //Remove the first period and any thing after it 
                    var rm_ext_regex = /(\.[^.]+)+/;
                    var fname = file.name;
                    fname = fname.replace( rm_ext_regex, '');

                    //Make sure filename is benign
                    var fname_regex = /^([A-Za-z0-9])+([-_])*([A-Za-z0-9-_]*)$/;
                    if( fname_regex.test( fname ) ) {
                        var id = fname + '-' + (new Date()).getTime(); //'blobid' + (new Date()).getTime();
                        var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
                        var blobInfo = blobCache.create(id, file, reader.result);
                        blobCache.add(blobInfo);

                        // call the callback and populate the Title field with the file name
                        callback(blobInfo.blobUri(), { title: file.name });
                    }
                    else {
                        alert( 'Invalid file name' );
                    }
                };
                //To get get rid of file picker input
                this.parentNode.removeChild(this);
            };

            input.click();
        }")
    ]
]);?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
