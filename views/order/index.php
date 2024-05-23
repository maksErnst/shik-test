<?php
use yii\helpers\Html;
use yii\widgets\Pjax;
?>
<h1>List</h1>
<div class="container">
    <div class="row">
        <div class="month-ul col-md-3">
            <?php foreach ($availableMonthsYears as $year => $yearData): ?>
                <h2 class="link-filter" data-year="<?=$year?>" data-month=""><?= Html::encode($year) ?> (<?=$yearData['year_count']?>)</h2>
                <ul>
                    <?php foreach ($yearData['months'] as $monthData): ?>
                        <li class="link-filter" data-year="<?=$year?>" data-month="<?=$monthData['month']?>">
                            <?php  $monthName = Yii::$app->formatter->asDate("{$year}-{$monthData['month']}-01", 'LLLL'); ?>
                            <?=$monthName . "({$monthData['count']})" ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endforeach; ?>
        </div>
        <div class="col-md-9">
            <?php Pjax::begin(['id' => 'orders-list']); ?>
            <?= \yii\widgets\ListView::widget([
                    'dataProvider' => $dataProvider,
                    'itemView' => '_order'
                ]);
            ?>
            <?php Pjax::end(); ?>
        </div>
    </div>
</div>


