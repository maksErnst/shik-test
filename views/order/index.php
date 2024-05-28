<?php
/** @var array $dateList */
/** @var \yii\data\ActiveDataProvider $dataProvider */
/** @var \app\models\OrderSearch $searchModel */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\PjaxAsset;

PjaxAsset::register($this);
?>
<h1>List</h1>
<div class="container">
    <div class="row">
        <div class="month-ul col-md-3">
            <?php foreach ($dateList as $year => $yearData): ?>
                <h2 class="date-link" data-year="<?=$year?>"><?= Html::encode($year) ?> (<?=$yearData['year_count']?>)</h2>
                <ul>
                    <?php foreach ($yearData['months'] as $monthData): ?>
                        <li class="date-link" data-year="<?=$year?>" data-month="<?=$monthData['month']?>">
                            <?php  $monthName = Yii::$app->formatter->asDate("{$year}-{$monthData['month']}-01", 'LLLL'); ?>
                            <?=$monthName . "({$monthData['count']})" ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endforeach; ?>
            <?= Html::beginForm(Url::current(), 'GET', ['id' => 'filter-form']); ?>

            <?= Html::activeHiddenInput($searchModel, 'year'); ?>
            <?= Html::activeHiddenInput($searchModel, 'month'); ?>

            <?= Html::endForm() ?>
        </div>
        <div class="col-md-9">
            <?= \yii\grid\GridView::widget([
                    'dataProvider' => $dataProvider,
                ]); ?>
        </div>
    </div>
</div>
<?php

$js = <<<JS
    const filterForm = $('#filter-form');
    const pjaxOptions = {
        timeout: 1000,
        container: '#w0',
        fragment: '#w0'
    };
    
    $('.date-link').click(function () {
        $('#ordersearch-year').val($(this).data('year'));
        $('#ordersearch-month').val($(this).data('month'));
        filterForm.submit();
    });    
    
    filterForm.on('submit', function(e) {
        e.preventDefault();
        $.pjax($.extend({}, pjaxOptions, {
            url: filterForm.attr('action'),
            data: filterForm.serialize()
        }));
    });
    
    $(document).on('click', '#w0 .pagination a, #w0 th a', function (e) {
        e.preventDefault();
        $.pjax($.extend({}, pjaxOptions, {
            url: $(this).attr('href')
        }));
    });

JS;

$this->registerJs($js);


