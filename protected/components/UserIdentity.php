<?php
class UserIdentity extends CUserIdentity
{
    private $_id;

    public function authenticate()
    {
        $user = Users::model()->findByAttributes(['username' => $this->username]);
        $role = Roles::model()->findByPk($user->role_id);

        if ($user === null) {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        } elseif (!$user->validatePassword($this->password)) {
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        } else {
            $this->_id = $user->id;
            $this->username = $user->username;
            $this->errorCode = self::ERROR_NONE;

            // Set absolute session login timestamp *only on successful login*
            Yii::app()->session['login_time'] = time();

            //Listed role in session
            Yii::app()->session['permissions'] = $role->section;
        }

        return !$this->errorCode;
    }

    public function getId()
    {
        return $this->_id;
    }
}
