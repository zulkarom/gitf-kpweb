<?php
namespace backend\modules\protege\models;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 * Offer Letter form
 * to create reference to offer letter
 */
class OfferForm extends Model
{
    public $companies;
    public $session_id;
    public $is_published;
    public $available_slot;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['companies','available_slot','is_published'], 'required'],

            [['is_published', 'available_slot'], 'integer'],

            ['companies', 'each', 'rule' => ['integer']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'companies' => 'Companies (active)',
            'is_published' => 'Status',
        ];
    }

    public function added(){
        $success = 0;
        $fail = 0;
        if($this->companies){
            foreach($this->companies as $c){
                //cari dah ada ke tak?
                $offer = CompanyOffer::findOne(['session_id' => $this->session_id, 'company_id' => $c]);
                if(!$offer){
                    $offer = new CompanyOffer();
                    $offer->session_id = $this->session_id;
                    $offer->company_id = $c;
                    $offer->available_slot = $this->available_slot;
                    $offer->is_published = $this->is_published;
                    $offer->created_at = time();
                    $offer->updated_at = time();
                    if($offer->save()){
                        $success++;
                    }else{
                        $fail++;
                    }
                }
                
            }
        }
        if($success > 0){
            $text = $success > 1 ? 'companies' : 'company';
            Yii::$app->session->addFlash('success', "Successfully added ".$success." " . $text);
        }
        if($fail > 0){
            $text = $fail > 1 ? 'companies' : 'company';
            Yii::$app->session->addFlash('error', "Failed to add ".$fail." " . $text);
        }

        return true;
    }

    public static function listActiveCompanies(){
        return ArrayHelper::map(Company::find()->where(['status' => 10])->orderBy('company_name ASC')->all(), 'id', 'company_name');
    }

    public static function listActiveCompaniesNotAdded($session){
        $ada = ArrayHelper::map(CompanyOffer::find()
        ->where(['session_id' => $session])
        ->all(), 'id', 'company_id');
        return ArrayHelper::map(Company::find()
        ->where(['status' => 10])->andWhere(['NOT IN', 'id', $ada])->all(), 'id', 'company_name');
    }

}
