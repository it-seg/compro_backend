<?php
class Header extends CActiveRecord
{
    public static function model($className=__CLASS__) { return parent::model($className); }

    public function tableName() { return 'header_content'; }

    public function getDbConnection()
    {
        return Yii::app()->db_website;
    }

    public function rules()
    {
        return [
            ['content, type, content_english', 'required'],
            ['type', 'length', 'max'=>50],
            ['id, content, content_english','safe', 'on'=>'search'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id'=>'ID',
            'content'=>'Content',
            'content_english'=>'English Content',
            'type'=>'Type',
            'updated_at'=>'Updated At',
        ];
    }

    public function search()
    {
        $criteria = new CDbCriteria();

        $criteria->compare('id', $this->id);
        $criteria->compare('content', $this->content, true);
        $criteria->compare('content_english', $this->content_english, true);
        $criteria->compare('type', $this->type, true);

        $excludeTypes = [
            'about_button',
            'about_sub_title',
            'about_title',
            'about_value_p1',
            'about_value_p2',
            'header',
            'sub_header',
            'view_menus',
            'sub_view_menus',
            'hero_reservation',
            'sub_hero_reservation',
            'running_text',
            'space_title',
            'space_sub_title',
            'space_view_button',
            'about_button'
        ];
        $criteria->addNotInCondition('type', $excludeTypes);

        $criteria->order = 'id ASC';

        return new CActiveDataProvider($this, [
            'criteria' => $criteria,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
    }

    public function beforeSave()
    {
        if(parent::beforeSave()){
            $this->updated_at = new CDbExpression('NOW()');
            return true;
        }
        return false;
    }
}
