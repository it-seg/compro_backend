<?php
class Setting extends CActiveRecord
{
    public $status;

    public static function model($className=__CLASS__) { return parent::model($className); }

    public function tableName() { return 'setting'; }

    public function getDbConnection()
    {
        return Yii::app()->db_website;
    }

    public function rules()
    {
        return [
            ['key, value', 'required'],
            ['key, value','safe', 'on'=>'search'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id'=>'ID',
            'key'=>'Key',
            'value'=>'Value',
        ];
    }

    public function search()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('id',$this->id);
        $criteria->compare('`key`',$this->key,true);
        $criteria->compare('`value`',$this->value,true);
        $excludeTypes = [
            'whatsApp_number',
            'map',
            'email',
            'phone_number',
            'address',
            'tiktok_username',
            'instagram__username',
            'facebook_username',
            'logo',
            'hero_interval',
            'instagramToken'
        ];
        $criteria->addNotInCondition('`key`', $excludeTypes);

        $criteria->order = '`key`';

        return new CActiveDataProvider($this, ['criteria'=>$criteria, 'pagination'=>['pageSize'=>20]]);
    }

    public function beforeSave()
    {
        if(parent::beforeSave()){
            if ($this->isNewRecord && empty($this->id))
                $this->id = Yii::app()->db->createCommand('SELECT UUID()')->queryScalar();

            return true;
        }
        return false;
    }
}
