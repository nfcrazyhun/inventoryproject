<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Workpiece;

/**
 * WorkpieceSearch represents the model behind the search form of `app\models\Workpiece`.
 */
class WorkpieceSearch extends Workpiece
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'category_id', 'in_stock', 'min_stock'], 'integer'],
            [['name'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @param null|integer $filterCondition
     * @return ActiveDataProvider
     */
    public function search($params,$filterCondition=null)
    {

        $query = Workpiece::find()->with('category');   //eager load with category relationship

        if ($filterCondition > 0){
            if ($filterCondition == 1) { $query->where('in_stock > min_stock'); }   //green
            if ($filterCondition == 2) { $query->where('in_stock < min_stock'); }   //red
            if ($filterCondition == 3) { $query->with('histories'); }                        //orange
        }

        //dd($query->getRawSql());

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 7],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'category_id' => $this->category_id,
            'in_stock' => $this->in_stock,
            'min_stock' => $this->min_stock,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
