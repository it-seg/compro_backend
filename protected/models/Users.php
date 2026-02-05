<?php
class Users extends CActiveRecord
{
    public $retypepassword;

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'users';
    }

    public function relations()
    {
        return [
            'role' => [self::BELONGS_TO, 'Roles', 'role_id'],
        ];
    }

    public function rules()
    {
        return [
            ['fullname, username, password, role_id', 'required'],

            // Password required only when creating new user
            ['password, retypepassword, role_id', 'required', 'on' => 'insert'],

            // On update: password fields are optional
            ['password, retypepassword', 'safe', 'on' => 'update'],

            // If password filled, retype must match
            // move to controller
//            ['retypepassword', 'compare', 'compareAttribute' => 'password', 'message' => 'Passwords do not match.'],

            // Other rules...
        ];
    }

    public function search()
    {
        $criteria = new CDbCriteria;
        $criteria->with = ['role'];
        $criteria->together = true;

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.username', $this->username, true);
        $criteria->compare('t.fullname', $this->fullname, true);

        // 🔥 filter by role name
        $criteria->compare('role.name', $this->role_id, true);

        return new CActiveDataProvider($this, [
            'criteria' => $criteria,
            'pagination' => ['pageSize' => 20],
            'sort' => [
                'attributes' => [
                    '*',
                    'role.name' => [
                        'asc'  => 'role.name ASC',
                        'desc' => 'role.name DESC',
                    ],
                ],
                'defaultOrder' => 't.id DESC',
            ],
        ]);
    }


    public function validatePassword($password)
    {
        return password_verify($password, $this->password);
    }

    public function beforeSave()
    {
        if (parent::beforeSave()) {
            if ($this->isNewRecord && empty($this->id)) {
                $this->id = Yii::app()->db->createCommand('SELECT UUID()')->queryScalar();
            }

            // hash only if not already hashed
            if (!empty($this->password) && substr($this->password, 0, 4) !== '$2y$') {
                $this->password = password_hash($this->password, PASSWORD_BCRYPT, ["cost" => 13]);
                $validate = $this->validatePassword($_POST['Users']['retypepassword']);

                if(!$validate) {
                    echo json_encode('Password did not match');
                    return false;
                } else {
                    return true;
                }

            }
        }
        return true;
    }

}
