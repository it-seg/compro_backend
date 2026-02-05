<?php

class News extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public $status;

    public static function model($className=__CLASS__) { return parent::model($className); }

    public function tableName() { return 'news'; }

    public function getDbConnection()
    {
        return Yii::app()->db_website;
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return [
            // required
            ['title, slug, content, publish_date, is_active', 'required'],

            // length
            ['title, slug, image, title_ind', 'length', 'max' => 255],

            // numerical
            ['is_main, is_active', 'numerical', 'integerOnly' => true],

            // safe for massive assign
            [
                'short_content, content, short_content_ind, content_ind, updated_at',
                'safe'
            ],

            // search scenario
            [
                'id, title, slug, publish_date, is_main, is_active,
                 title_ind',
                'safe',
                'on' => 'search'
            ],
        ];
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return [
            // contoh kalau nanti ada relasi
            // 'author' => [self::BELONGS_TO, 'User', 'created_by'],
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'English Title',
            'slug' => 'Slug',
            'short_content' => 'English Short Content',
            'content' => 'English Content',
            'image' => 'Image Path ',
            'publish_date' => 'Publish Date',
            'is_main' => 'Main News',
            'is_active' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',

            'title_ind' => 'Title',
            'short_content_ind' => 'Short Content',
            'content_ind' => 'Content',
        ];
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     */
    public function search()
    {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('slug', $this->slug, true);
        $criteria->compare('publish_date', $this->publish_date, true);
        $criteria->compare('is_main', $this->is_main);
        $criteria->compare('is_active', $this->is_active);
        $criteria->compare('title_ind', $this->title_ind, true);

        return new CActiveDataProvider($this, [
            'criteria' => $criteria,
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'defaultOrder' => 'is_main DESC, publish_date DESC',
            ],
        ]);
    }

    public function beforeSave()
    {
        if (parent::beforeSave()) {

            if ($this->isNewRecord) {
                $this->created_at = new CDbExpression('NOW()');
            }

            if (strpos($this->slug, ' ') !== false) {
                $this->slug = str_replace(' ', '-', $this->slug);
            }

            if ($this->is_main == 1) {
                News::model()->updateAll(['is_main' => 0]);
            }

            $this->updated_at = new CDbExpression('NOW()');
            return true;
        }
        return false;
    }
}
