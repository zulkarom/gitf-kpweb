<?php

namespace backend\modules\staff\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\staff\models\Staff;

/**
 * StaffSearch represents the model behind the search form of `backend\modules\staff\models\Staff`.
 */
class StaffSearch extends Staff
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['staff_id', 'is_academic', 'position_id', 'position_status', 'working_status', 'teach_pg', 'staff_level', 'staff_department', 'is_super', 'progress', 'total_progress', 'trash', 'publish', 'user_active', 'user_deleted', 'user_account_type', 'user_suspension_timestamp', 'user_last_login_timestamp', 'user_failed_logins', 'user_last_failed_login', 'user_password_reset_timestamp'], 'integer'],
            [['staff_no', 'user_name', 'user_password_hash', 'staff_email', 'staff_name', 'staff_name_pub', 'staff_title', 'staff_edu', 'leave_start', 'leave_end', 'leave_note', 'rotation_post', 'staff_expertise', 'staff_gscholar', 'officephone', 'handphone1', 'handphone2', 'staff_ic', 'staff_dob', 'date_begin_umk', 'date_begin_service', 'staff_note', 'personal_email', 'ofis_location', 'staff_cv', 'staff_img', 'staff_interest', 'user_password_reset_hash', 'session_id'], 'safe'],
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
        $query = Staff::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'staff_id' => $this->staff_id,
            'is_academic' => $this->is_academic,
            'position_id' => $this->position_id,
            'position_status' => $this->position_status,
            'working_status' => $this->working_status,
            'leave_start' => $this->leave_start,
            'leave_end' => $this->leave_end,
            'staff_dob' => $this->staff_dob,
            'date_begin_umk' => $this->date_begin_umk,
            'date_begin_service' => $this->date_begin_service,
            'teach_pg' => $this->teach_pg,
            'staff_level' => $this->staff_level,
            'staff_department' => $this->staff_department,
            'is_super' => $this->is_super,
            'progress' => $this->progress,
            'total_progress' => $this->total_progress,
            'trash' => $this->trash,
            'publish' => $this->publish,
            'user_active' => $this->user_active,
            'user_deleted' => $this->user_deleted,
            'user_account_type' => $this->user_account_type,
            'user_suspension_timestamp' => $this->user_suspension_timestamp,
            'user_last_login_timestamp' => $this->user_last_login_timestamp,
            'user_failed_logins' => $this->user_failed_logins,
            'user_last_failed_login' => $this->user_last_failed_login,
            'user_password_reset_timestamp' => $this->user_password_reset_timestamp,
        ]);

        $query->andFilterWhere(['like', 'staff_no', $this->staff_no])
            ->andFilterWhere(['like', 'user_name', $this->user_name])
            ->andFilterWhere(['like', 'user_password_hash', $this->user_password_hash])
            ->andFilterWhere(['like', 'staff_email', $this->staff_email])
            ->andFilterWhere(['like', 'staff_name', $this->staff_name])
            ->andFilterWhere(['like', 'staff_name_pub', $this->staff_name_pub])
            ->andFilterWhere(['like', 'staff_title', $this->staff_title])
            ->andFilterWhere(['like', 'staff_edu', $this->staff_edu])
            ->andFilterWhere(['like', 'leave_note', $this->leave_note])
            ->andFilterWhere(['like', 'rotation_post', $this->rotation_post])
            ->andFilterWhere(['like', 'staff_expertise', $this->staff_expertise])
            ->andFilterWhere(['like', 'staff_gscholar', $this->staff_gscholar])
            ->andFilterWhere(['like', 'officephone', $this->officephone])
            ->andFilterWhere(['like', 'handphone1', $this->handphone1])
            ->andFilterWhere(['like', 'handphone2', $this->handphone2])
            ->andFilterWhere(['like', 'staff_ic', $this->staff_ic])
            ->andFilterWhere(['like', 'staff_note', $this->staff_note])
            ->andFilterWhere(['like', 'personal_email', $this->personal_email])
            ->andFilterWhere(['like', 'ofis_location', $this->ofis_location])
            ->andFilterWhere(['like', 'staff_cv', $this->staff_cv])
            ->andFilterWhere(['like', 'staff_img', $this->staff_img])
            ->andFilterWhere(['like', 'staff_interest', $this->staff_interest])
            ->andFilterWhere(['like', 'user_password_reset_hash', $this->user_password_reset_hash])
            ->andFilterWhere(['like', 'session_id', $this->session_id]);

        return $dataProvider;
    }
}
