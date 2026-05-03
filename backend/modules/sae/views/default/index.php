<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'SAE Dashboard';

$batchItems = ArrayHelper::map($batches, 'id', 'bat_text');
$selectedBatchId = $selectedBatch ? $selectedBatch->id : null;
$totalParticipants = (int) $stats['total'];
$percentage = function ($value) use ($totalParticipants) {
    if ($totalParticipants <= 0) {
        return '0%';
    }

    return round(((int) $value / $totalParticipants) * 100) . '%';
};

$cards = [
    [
        'title' => 'Total Participants',
        'value' => $stats['total'],
        'subtitle' => 'All records in this batch',
        'class' => 'card-total',
        'url' => Url::to(['/sae/answer/index', 'AnswerSearch' => ['bat_id' => $selectedBatchId]]),
    ],
    [
        'title' => 'Submitted',
        'value' => $stats['submitted'],
        'subtitle' => 'Completed assessments',
        'percentage' => $percentage($stats['submitted']),
        'class' => 'card-submitted',
        'url' => Url::to(['/sae/answer/index', 'AnswerSearch' => ['bat_id' => $selectedBatchId, 'answer_status' => 3]]),
    ],
    [
        'title' => 'In Progress',
        'value' => $stats['in_progress'],
        'subtitle' => 'Started but not finished',
        'percentage' => $percentage($stats['in_progress']),
        'class' => 'card-progress',
        'url' => Url::to(['/sae/answer/index', 'AnswerSearch' => ['bat_id' => $selectedBatchId, 'answer_status' => 1]]),
    ],
    [
        'title' => 'Not Started',
        'value' => $stats['not_started'],
        'subtitle' => 'No submission activity yet',
        'percentage' => $percentage($stats['not_started']),
        'class' => 'card-pending',
        'url' => Url::to(['/sae/answer/index', 'AnswerSearch' => ['bat_id' => $selectedBatchId, 'answer_status' => 0]]),
    ],
];

$this->registerCss(<<<CSS
.sae-default-index {
    padding: 8px 0 24px;
}

.sae-dashboard-hero {
    background: linear-gradient(135deg, #173b7a 0%, #1ea896 45%, #f7b32b 100%);
    border-radius: 18px;
    color: #fff;
    padding: 28px 30px;
    margin-bottom: 24px;
    box-shadow: 0 18px 35px rgba(23, 59, 122, 0.18);
}

.sae-dashboard-hero h1 {
    margin: 0 0 8px;
    font-size: 30px;
    font-weight: 700;
}

.sae-dashboard-hero p {
    margin: 0;
    font-size: 15px;
    max-width: 760px;
}

.sae-dashboard-panel {
    background: #fff;
    border-radius: 18px;
    padding: 22px;
    box-shadow: 0 10px 25px rgba(17, 24, 39, 0.08);
    margin-bottom: 24px;
}

.sae-dashboard-panel .form-group {
    margin-bottom: 0;
}

.sae-dashboard-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 18px;
}

.sae-stat-card {
    display: block;
    border-radius: 18px;
    padding: 22px;
    color: #fff;
    text-decoration: none;
    min-height: 170px;
    position: relative;
    overflow: hidden;
    box-shadow: 0 16px 32px rgba(15, 23, 42, 0.14);
    transition: transform .18s ease, box-shadow .18s ease;
}

.sae-stat-card:hover,
.sae-stat-card:focus {
    color: #fff;
    text-decoration: none;
    transform: translateY(-4px);
    box-shadow: 0 22px 38px rgba(15, 23, 42, 0.2);
}

.sae-stat-card:before {
    content: "";
    position: absolute;
    inset: auto -40px -40px auto;
    width: 120px;
    height: 120px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.14);
}

.sae-stat-card__eyebrow,
.sae-stat-card__hint {
    position: relative;
    z-index: 1;
}

.sae-stat-card__eyebrow {
    font-size: 13px;
    text-transform: uppercase;
    letter-spacing: .08em;
    opacity: .9;
}

.sae-stat-card__value {
    position: relative;
    z-index: 1;
    font-size: 42px;
    font-weight: 700;
    line-height: 1;
    margin: 14px 0 10px;
}

.sae-stat-card__hint {
    font-size: 14px;
    opacity: .96;
}

.sae-stat-card__meta {
    position: relative;
    z-index: 1;
    display: inline-block;
    margin-top: 14px;
    padding: 6px 10px;
    border-radius: 999px;
    background: rgba(255, 255, 255, 0.16);
    font-size: 13px;
    font-weight: 600;
}

.card-total {
    background: linear-gradient(135deg, #2563eb 0%, #06b6d4 100%);
}

.card-submitted {
    background: linear-gradient(135deg, #059669 0%, #34d399 100%);
}

.card-progress {
    background: linear-gradient(135deg, #d97706 0%, #fbbf24 100%);
}

.card-pending {
    background: linear-gradient(135deg, #7c3aed 0%, #ec4899 100%);
}

.sae-dashboard-link {
    margin-top: 24px;
}
CSS
);
?>
<div class="sae-default-index">
    <div class="sae-dashboard-hero">
        <h1>ONLINE 2U2I INTERVIEW</h1>
        <p>
            Monitor participant progress by batch and open a filtered participant list directly from each card.
        </p>
    </div>

    <div class="sae-dashboard-panel">
        <?= Html::beginForm(['/sae/default/index'], 'get') ?>
        <div class="row">
            <div class="col-md-6">
                <?= Html::label('Batch', 'sae-batch-id', ['class' => 'control-label']) ?>
                <?= Html::dropDownList(
                    'batch_id',
                    $selectedBatchId,
                    $batchItems,
                    [
                        'id' => 'sae-batch-id',
                        'class' => 'form-control',
                        'prompt' => 'Select batch',
                        'onchange' => 'this.form.submit()',
                    ]
                ) ?>
            </div>
            <div class="col-md-6">
                <?php if ($selectedBatch): ?>
                    <label class="control-label">Quick Link</label>
                    <div class="sae-dashboard-link">
                        <?= Html::a(
                            'Open Full Participant List',
                            ['/sae/answer/index', 'AnswerSearch' => ['bat_id' => $selectedBatch->id]],
                            ['class' => 'btn btn-primary']
                        ) ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?= Html::endForm() ?>
    </div>

    <div class="sae-dashboard-grid">
        <?php foreach ($cards as $card): ?>
            <?= Html::a(
                '<div class="sae-stat-card__eyebrow">' . Html::encode($card['title']) . '</div>' .
                '<div class="sae-stat-card__value">' . Html::encode($card['value']) . '</div>' .
                '<div class="sae-stat-card__hint">' . Html::encode($card['subtitle']) . '</div>' .
                (!empty($card['percentage']) ? '<div class="sae-stat-card__meta">' . Html::encode($card['percentage']) . ' of total</div>' : ''),
                $selectedBatch ? $card['url'] : 'javascript:void(0)',
                ['class' => 'sae-stat-card ' . $card['class']]
            ) ?>
        <?php endforeach; ?>
    </div>

    <p class="sae-dashboard-link">
        Interview page:
        <a href="https://fkp-portal.umk.edu.my/2u2i" target="_blank">https://fkp-portal.umk.edu.my/2u2i</a>
    </p>
</div>
