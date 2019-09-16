<?php

namespace backend\modules\jeb\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\User;

/**
 * UserSearch represents the model behind the search form of `common\models\User`.
 */
class UserSearch extends User
{
	public $search_str;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['search_str'], 'string'],
			
        ];
    }

    /**
     * @inheritdoc
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
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = User::find()->orderBy('username ASC, fullname ASC');
		$query->joinWith(['staff', 'associate', 'authAssignments']);
		
		//->rightJoin('staff', 'staff.user_id = user.id')
		//->rightJoin('jeb_associate', 'jeb_associate.user_id = user.id')
		//;

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'pagination' => [
                'pageSize' => 20,
            ],


        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
		
		$roles = ['jeb-assistant-editor','jeb-assistant-editor-in-chief', 'jeb-associate-editor','jeb-editor-in-chief', 'jeb-managing-editor', 'jeb-publisher','jeb-reviewer', 'jeb-proof-reader'];
		
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
			'auth_assignment.item_name' => $roles

        ]);

        $query->andFilterWhere(['like', 'fullname', $this->search_str]);
		$query->orFilterWhere(['like', 'username', $this->search_str]);
		
		

        return $dataProvider;
    }
}
