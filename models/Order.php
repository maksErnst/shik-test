<?php

namespace app\models;

use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Query;

/**
 * This is the model class for table "order".
 *
 * @property int $id
 * @property float|null $sum
 * @property string $created_at
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'order';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['sum'], 'number'],
            [['created_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'sum' => 'Sum',
            'created_at' => 'Created At',
        ];
    }

    public static function search(): ActiveDataProvider
    {
        $query = self::find();
        $params = Yii::$app->request->queryParams;

        if (isset($params['month']) && $params['month'] != null) {
            $query->andWhere(['EXTRACT(MONTH FROM created_at)' => $params['month']]);
        }

        if (isset($params['year']) && $params['year'] != null) {
            $query->andWhere(['EXTRACT(YEAR FROM created_at)' => $params['year']]);
        }

        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 15,
            ]
        ]);
    }

    public static function getAvailableMonthsYears(): array
    {
        $orders = (new Query())
            ->select([
                'EXTRACT(YEAR FROM created_at) AS year',
                'EXTRACT(MONTH FROM created_at) AS month',
                'COUNT(*) AS count',
            ])
            ->from('order')
            ->groupBy([
                'EXTRACT(YEAR FROM created_at)',
                'EXTRACT(MONTH FROM created_at)',
            ])
            ->orderBy([
                'year' => SORT_ASC,
                'month' => SORT_ASC,
            ])
            ->all();    //Тут лучше билдер, чем AR, т.к. модели на выходе не нужны. В идеале закэшировать и условно по тригеру события очищать.

        $result = [];
        foreach ($orders as $order) {
            $year = $order['year'];
            $month = $order['month'];
            $count = $order['count'];

            if (!isset($result[$year])) {
                $result[$year] = ['year_count' => 0, 'months' => []];
            }

            $result[$year]['year_count'] += $count;
            $result[$year]['months'][] = ['month' => $month, 'count' => $count];
        }

        return $result;
    }
}
