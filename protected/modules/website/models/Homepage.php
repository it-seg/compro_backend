<?php

class Homepage extends CActiveRecord
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'homepage_sections';
    }

    public function getDbConnection()
    {
        return Yii::app()->db_website;
    }

    public function rules()
    {
        return [
            // create & update
            ['section_key', 'required'],
            ['section_key', 'length', 'max'=>50],
            ['is_active, sort_order', 'numerical', 'integerOnly'=>true],
            ['is_active', 'in', 'range'=>[0,1]],

            // search
            ['id, section_key, is_active, sort_order', 'safe', 'on'=>'search'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id'          => 'ID',
            'section_key' => 'Section',
            'is_active'   => 'Status',
            'sort_order'  => 'Urutan',
        ];
    }

    public function search()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->id);
        $criteria->compare('section_key', $this->section_key, true);
        $criteria->compare('is_active', $this->is_active);
        $criteria->compare('sort_order', $this->sort_order);

        return new CActiveDataProvider($this, [
            'criteria' => $criteria,
            'pagination' => [
                'pageSize' => 20
            ]
        ]);
    }

    protected function beforeSave()
    {
        if (!parent::beforeSave()) {
            return false;
        }

        // default values
        if ($this->isNewRecord && $this->is_active === null) {
            $this->is_active = 1;
        }

        if ($this->sort_order === null || $this->sort_order === '') {
            $this->sort_order = 0;
        }

        return true;
    }
}
