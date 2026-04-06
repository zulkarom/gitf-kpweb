<?php

use yii\helpers\Html;

$this->title = 'Create Short Link';

?>

<div class="urlredirect-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
