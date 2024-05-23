<?php

namespace app\controllers;

use app\models\Order;
use Yii;

class OrderController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $dataProvider = Order::search(); //в целом можно и полноценную searchModel здесь использовать, но по мне это избыточно

        if (Yii::$app->request->isPjax) {
            return $this->renderAjax('_list', compact('dataProvider')); //для того, чтобы $availableMonthsYears наполнилась только раз
        }

        $availableMonthsYears = Order::getAvailableMonthsYears();

        return $this->render('index', compact('dataProvider', 'availableMonthsYears'));
    }

}
