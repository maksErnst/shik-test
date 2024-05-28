<?php


namespace app\models;

use yii\base\Model;

class OrderSearch extends Order
{
    public $year;
    public $month;

    public function rules(): array
    {
        return [
            [['year', 'month'], 'string'],
        ];
    }

    public function scenarios(): array
    {
        return Model::scenarios();
    }

    public function search($params): \yii\db\ActiveQuery
    {
        $query = Order::find()->select('id, sum, created_at');

        if (!($this->load($params) && $this->validate())) {
            return $query;
        }

        if (isset($this->year)) {
            $query->andFilterWhere(['EXTRACT(YEAR FROM created_at)' => $this->year]);
        }

        if (isset($this->month)) {
            $query->andFilterWhere(['EXTRACT(MONTH FROM created_at)' => $this->month]);
        }

        return $query;
    }

}