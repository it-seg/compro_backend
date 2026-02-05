<?php

class Events extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public $status;

    public static function model($className=__CLASS__) { return parent::model($className); }

    public function tableName() { return 'events'; }

    public function getDbConnection()
    {
        return Yii::app()->db_website;
    }

    /**
     * @return array validation rules
     */
    public function rules()
    {
        return [
            // required fields
            ['title, event_date', 'required'],

            // length validations
            ['title', 'length', 'max' => 150],
            ['title_ind, description_ind, image_url', 'length', 'max' => 255],

            // numerical
            ['is_active', 'numerical', 'integerOnly' => true],

            // safe attributes
            ['description, event_time, created_at, updated_at', 'safe'],

            // search scenario
            ['id, title, title_ind, event_date, is_active', 'safe', 'on' => 'search'],
        ];
    }

    /**
     * @return array relational rules
     */
    public function relations()
    {
        return [];
    }

    /**
     * @return array attribute labels
     */
    public function attributeLabels()
    {
        return [
            'id'              => 'ID',
            'title'           => 'English Title',
            'title_ind'       => 'Title',
            'description'     => 'English Description',
            'description_ind' => 'Description',
            'image_url'       => 'Image Path',
            'event_date'      => 'Event Date',
            'event_time'      => 'Event Time',
            'is_active'       => 'Active',
            'created_at'      => 'Created At',
            'updated_at'      => 'Updated At',
        ];
    }

    /**
     * @return CActiveDataProvider
     */
    public function search()
    {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('title_ind', $this->title_ind, true);
        $criteria->compare('event_date', $this->event_date, true);
        $criteria->compare('is_active', $this->is_active);

        return new CActiveDataProvider($this, [
            'criteria'   => $criteria,
            'pagination' => ['pageSize' => 20],
        ]);
    }

}
