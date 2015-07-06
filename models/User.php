<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "usuario".
 *
 * @property integer $id
 * @property integer $nome
 * @property string $email
 * @property string $senha
 * @property string $token
 * @property string $auth_key
 * @property integer $perfil
 * @property integer $ativo
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    //Constantes para armazenar papéis
    const MASTER = 0;
    const ADMIN = 1;

    //Atributo "virtual". Não existe campo respectivo na tabela
    public $senha_confirm;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'usuario';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nome', 'email', 'senha', 'perfil'], 'required'],
            [['perfil', 'ativo'], 'integer'],
            [[ 'email'], 'email'],
            [['email', 'token', 'auth_key'], 'string', 'max' => 250],
            [['senha', 'senha_confirm'], 'string', 'max'=>10, 'min' => 7],
            ['senha', 'checkSenhas'],            
            [['senha_confirm', 'token'], 'safe'],
        ];
    }

    public function checkSenhas($attribute, $params)
    {           
        if($this->senha != $this->senha_confirm)
            $this->addError($attribute, 'As senhas não conferem');        
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nome' => 'Nome',
            'email' => 'E-mail',
            'senha' => 'Senha',
            'token' => 'Token',
            'auth_key' => 'Auth Key',
            'perfil' => 'Perfil',
            'ativo' => 'Ativo',
            'senha_confirm' => 'Repita a senha'
        ];
    }

    /**
     * Finds user by username
     *
     * @param  string      $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['email' => $username]);
        
        //return static::findOne(['email' => $username]);
    }
    
    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }
    
    /**
     * @inheritdoc
     */
    /* modified */
    public static function findIdentityByAccessToken($token, $type = null)
    {
          return static::findOne(['token' => $token]);
    }
    
     /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne(['token' => $token]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);
        return $timestamp + $expire >= time();
    }
    
    public function getPerfilNome()
    {
        return $this->perfil == static::MASTER ? 'Gerente' : 'Administrativo';
    }

    public function getAtivoNome()
    {
        return $this->ativo == 1 ? 'Sim' : 'Não';
    }
    
    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }
    
    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->senha = Yii::$app->security->generatePasswordHash($password);
    }
    
    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }
    
    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->senha);
    }
    
    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->token = null;
    }
}
