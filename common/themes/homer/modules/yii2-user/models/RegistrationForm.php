<?php
/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 19/11/2561
 * Time: 21:53
 */
namespace homer\user\models;

use dektrium\user\models\RegistrationForm as BaseRegistrationForm;
use dektrium\user\models\User;

class RegistrationForm extends BaseRegistrationForm
{
    /**
     * Add a new field
     * @var string
     */
    public $name;
    public $sex_id;
    public $first_name;
    public $last_name;
    public $birthday;
    public $tel;
    public $province;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = parent::rules();
        $rules[] = ['name', 'safe'];
        $rules[] = ['name', 'string', 'max' => 255];
        $rules[] = [['sex_id', 'first_name', 'last_name', 'birthday', 'tel', 'province'], 'required'];
        return $rules;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $labels = parent::attributeLabels();
        $labels['name'] = \Yii::t('user', 'Name');
        $labels['sex_id'] = 'เพศ';
        $labels['first_name'] = 'ชื่อ';
        $labels['last_name'] = 'นามสกุล';
        $labels['birthday'] = 'ว/ด/ป เกิด';
        $labels['tel'] = 'เบอร์โทรศัพท์';
        $labels['province'] = 'จังหวัด';
        return $labels;
    }

    /**
     * @inheritdoc
     */
    public function loadAttributes(User $user)
    {
        // here is the magic happens
        $user->setAttributes([
            'email' => $this->email,
            'username' => $this->username,
            'password' => $this->password,
        ]);
        /** @var Profile $profile */
        $profile = \Yii::createObject(Profile::className());
        $profile->setAttributes([
            'name' => $this->name,
            'sex_id' => $this->sex_id,
            'first_name' => $this->first_name,
            'birthday' => $this->birthday,
            'tel' => $this->tel,
            'province' => $this->province,
        ]);
        $user->setProfile($profile);
    }
}