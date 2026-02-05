<?php

/**
 * @property string $images_folder_url
 */
class Menu extends CActiveRecord
{
    public $status;

    public static function model($className=__CLASS__) { return parent::model($className); }

    public function tableName() { return 'menu'; }

    public function getDbConnection()
    {
        return Yii::app()->db_website;
    }

    public function rules()
    {
        return [
            ['slug, name, name_ind', 'required'],

            ['slug', 'length', 'max'=>50],
            ['name, name_ind', 'length', 'max'=>100],
            ['images_folder_url', 'length', 'max'=>255],

            ['sort_order, is_active', 'numerical', 'integerOnly'=>true],

            // SAFE
            ['images_folder_url, updated_at', 'safe'],

            // SEARCH
            ['id, slug, name, name_ind, is_active, sort_order, images_folder_url', 'safe', 'on'=>'search'],
        ];
    }


    public function attributeLabels()
    {
        return [
            'id'=>'ID',
            'name'=>'English Menu',
            'name_ind'=>'Menu',
            'slug'=>'Slug',
            'is_active'=>'Status',
            'sort_order'=>'Sort',
            'updated_at'=>'Updated At',
            'created_at'=>'Created At',
            'status' => 'Status',
        ];
    }

    public function search()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('id',$this->id);
        $criteria->compare('name_ind',$this->name_ind,true);
        $criteria->compare('name',$this->name,true);
        $criteria->compare('slug',$this->slug,true);
        $criteria->compare('is_active',$this->is_active,true);
        $criteria->compare('sort_order',$this->sort_order,true);

        return new CActiveDataProvider($this, [
            'criteria' => $criteria,
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'defaultOrder' => 'sort_order',
            ],
        ]);
    }

    public function beforeSave()
    {
        if(parent::beforeSave()){
            if ($this->isNewRecord && empty($this->id)) {
                $this->id = Yii::app()->db->createCommand('SELECT UUID()')->queryScalar();
                $this->created_at = new CDbExpression('NOW()');
            }

            if($this->sort_order == null || $this->sort_order == '')
                $this->sort_order = 0;

            $this->updated_at = new CDbExpression('NOW()');

            return true;
        }
        return false;
    }
}
