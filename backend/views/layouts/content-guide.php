<?php
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use dmstr\widgets\Alert;

?>
<div class="content-wrapper">
    <section class="content-header">
        <?php if (isset($this->blocks['content-header'])) { ?>
            <h1><?= $this->blocks['content-header'] ?></h1>
        <?php } else { ?>
            <h1>
                <?=Html::a('Documentation Outline', ['/user-manual'])?>
            </h1>
        <?php } ?>

    
    </section>

    <section class="content" style="font-size: 18px;">
        <?= Alert::widget() ?>
        <?= $content ?>
    </section>
</div>

<footer class="main-footer">
    Copyright &copy; 2018 - <?=date('Y')?> <a href="#">FKP PORTAL</a>. All rights
    reserved.
</footer>

<div class='control-sidebar-bg'></div>