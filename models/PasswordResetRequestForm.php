<?php
namespace app\models;

use Yii;

use app\models\User;
use yii\base\Model;

/**
 * Password reset request form
 */
class PasswordResetRequestForm extends Model
{
    public $email;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => 'app\models\User',
                //'filter' => ['status' => User::STATUS_ACTIVE],
                'message' => 'E-mail não cadastrado'
            ],
        ];
    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return boolean whether the email was send
     */
    public function sendEmail()
    {
        /* @var $user Usuario */
        $user = User::findByUsername($this->email);

        if ($user) {
            if (!User::isPasswordResetTokenValid($user->token)) {
                $user->generatePasswordResetToken();
            }

            if ($user->save(false)) {
                return \Yii::$app->mailer->compose('passwordResetToken-html', ['user' => $user])
                    ->setFrom([\Yii::$app->params['adminEmail'] => \Yii::$app->name . ' robot'])
                    ->setTo($this->email)
                    ->setSubject('Password reset for ' . \Yii::$app->name)
                    ->send();
            }
        }

        return false;
    }
}
