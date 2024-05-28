<?php

namespace app\controllers;

use app\models\Order;
use app\models\OrderSearch;
use Yii;
use yii\data\ActiveDataProvider;

class OrderController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $dateList = Order::getDateList();
        $searchModel = new OrderSearch();
        $query = $searchModel->search(Yii::$app->request->getQueryParams());

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->render('index', compact('dataProvider', 'searchModel', 'dateList'));
    }

}
