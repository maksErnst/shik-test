<?php

namespace app\models;

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


    public static function getDateList(): array
    {
        $orders = (new Query())
            ->select([
                'EXTRACT(YEAR FROM created_at) AS year',
                'EXTRACT(MONTH FROM created_at) AS month',
                'COUNT(*) AS count',
            ])
            ->from('order')
            ->groupBy('year, month')
            ->orderBy(['year' => SORT_ASC, 'month' => SORT_ASC,])
            ->all();

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
