<?php
class Navigation extends CActiveRecord
{
    public static function model($className=__CLASS__) { return parent::model($className); }

    public function tableName() { return 'navigation'; }

    public function getDbConnection()
    {
        return Yii::app()->db_website;
    }

    public function rules()
    {
        return [
            ['label, url', 'required'],
            ['label', 'length', 'max'=>100],
            ['url', 'length', 'max'=>200],
            ['sort_order', 'numerical', 'integerOnly'=>true],
            ['id, label, url, sort_order', 'safe', 'on'=>'search'],
        ];
    }

    public function relations()
    {
        return [
            'subNavigations' => [self::HAS_MANY, 'SubNavigation', 'navigation_id'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id'=>'ID',
            'label'=>'English Label',
            'label_ind'=>'Label',
            'url'=>'URL',
            'sort_order'=>'Sort',
        ];
    }

    public function search()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('id',$this->id);
        $criteria->compare('label',$this->label,true);
        return new CActiveDataProvider($this, ['criteria'=>$criteria, 'pagination'=>['pageSize'=>20]]);
    }

    public function beforeSave()
    {
        if (parent::beforeSave()) {
            if ($this->isNewRecord && empty($this->id)) {
                $this->id = Yii::app()->db->createCommand('SELECT UUID()')->queryScalar();
            }

            if($this->sort_order == null || $this->sort_order == '')
                $this->sort_order = 0;

            return true;
        }
        return false;
    }
}
