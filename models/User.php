<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use app\models\SignUpForm;

class User extends ActiveRecord implements IdentityInterface
{
    /**
     * @package app\models
     *
     * @property integer $id
     * @property string $first_name
     * @property string $last_name
     * @property string $email
     * @property string $authKey
     * @property string $accessToken
     * @property string $password
     * @property string $username
.     */
//    public $id;
//    public $username;
//    public $password;
//    public $email;
//    public $authKey;
//    public $accessToken;
//    public $first_name;
//    public $last_name;

    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub

        //set default values
        $this->first_name = 'Wilmer';
        $this->authKey = '';
        $this->email = '';
        $this->last_name = '';
        $this->password = '';
        $this->accessToken = '';
        $this->username = '';
    }

    public static function tableName()
    {
        return 'user'; // TODO: Change the autogenerated stub
    }

    public function rules()
    {
        $rules = [
//            [['first_name', 'last_name', 'email'], 'required'],
            [['first_name', 'last_name'], 'string'],
            [['email'], 'email'],
        ];
        return $rules;
    }

    public function create($data)
    {
        if($this->load($data)){
          //  $this->first_name = $data['first_name'];
            if($this->save()){
                return true;
            }
        }
    }

    /**
    * @inheritdoc
    */
    public static function findIdentity($id)
    {
        return isset(self::$users[$id]) ? new static(self::$users[$id]) : null;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        foreach (self::$users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }

        return null;
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        foreach (self::$users as $user) {
            if (strcasecmp($user['username'], $username) === 0) {
                return new static($user);
            }
        }

        return null;
    }

    public static function findByEmail($email)
    {
        foreach (self::$emails as $email){
            if (strcasecmp($email['email'], $email) === 0) {
                return new static($email);
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === $password;
    }

}