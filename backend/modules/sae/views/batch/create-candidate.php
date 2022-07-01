<?php

use yii\helpers\Html;
$this->title= 'Create Candidate';

?>
<div class="batch-create">

    <?= $this->render('_form_candidate', [
        'model' => $model,
        'modelBatch' => $modelBatch,
        'modelAnswer' => $modelAnswer,
    ]) ?>

</div>
