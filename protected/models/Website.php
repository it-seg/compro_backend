<?php
class Website extends CActiveRecord
{
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'users';
    }

    public function search()
    {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('content', $this->content, true);
        $criteria->compare('type', $this->type, true);

        return new CActiveDataProvider($this, [
            'criteria' => $criteria,
            'pagination' => ['pageSize' => 20],
            'sort' => [
                'defaultOrder' => 'id DESC',
            ],
        ]);
    }

}
