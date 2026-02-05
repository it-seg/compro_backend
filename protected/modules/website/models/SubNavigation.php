<?php
class SubNavigation extends CActiveRecord
{
    public static function model($className=__CLASS__) { return parent::model($className); }

    public function tableName() { return 'sub_navigation'; }

    public function getDbConnection()
    {
        return Yii::app()->db_website;
    }

    public function rules()
    {
        return [
            ['navigation_id, label, url', 'required'],
            ['navigation_id, sort_order', 'numerical', 'integerOnly'=>true],
            ['label, url', 'length', 'max'=>255],
            ['id, navigation_id, label, url, sort_order', 'safe', 'on'=>'search'],
        ];
    }

    public function relations()
    {
        return [
            'navigation' => [self::BELONGS_TO, 'Navigation', 'navigation_id'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id'=>'ID',
            'navigation_id'=>'Navigation',
            'label'=>'Label',
            'url'=>'URL',
            'sort_order'=>'Sort',
        ];
    }

    public function search()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('id',$this->id);
        $criteria->compare('label',$this->label,true);
        $criteria->compare('navigation_id',$this->navigation_id);
        return new CActiveDataProvider($this, ['criteria'=>$criteria, 'pagination'=>['pageSize'=>20]]);
    }
}
