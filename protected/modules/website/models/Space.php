<?php

/**
 * @property string $images_folder_url
 */
class Space extends CActiveRecord
{
    /**
     * @return string table name
     */
    public $status;

    public static function model($className=__CLASS__) { return parent::model($className); }

    public function tableName() { return 'space'; }

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
            // required
            ['slug, title, desc', 'required'],

            // length
            ['slug', 'length', 'max'=>50],
            ['title, title_ind', 'length', 'max'=>100],
            ['images_folder_url', 'length', 'max'=>255],

            // numbers
            ['is_active', 'numerical', 'integerOnly'=>true],
            ['sort_order', 'numerical', 'integerOnly'=>true],

            // safe
            ['title_ind, desc_ind, updated_at, images_folder_url', 'safe'],

            // for search
            ['id, slug, title, title_ind, is_active, sort_order, images_folder_url', 'safe', 'on'=>'search'],
        ];
    }

    /**
     * @return array relational rules
     */
    public function relations()
    {
        return [
            // define relations here if needed
        ];
    }

    /**
     * @return array attribute labels
     */
    public function attributeLabels()
    {
        return [
            'id'          => 'ID',
            'slug'        => 'Slug',
            'title'       => 'English Title',
            'title_ind'   => 'Title',
            'desc'        => 'English Description',
            'desc_ind'    => 'Description',
            'is_active'   => 'Status',
            'sort_order'  => 'Sort Order',
            'created_at'  => 'Created At',
            'updated_at'  => 'Updated At',
            'images_folder_url' => 'Images Folder',

        ];
    }

    /**
     * @return CActiveDataProvider
     */
    public function search()
    {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('slug', $this->slug, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('title_ind', $this->title_ind, true);
        $criteria->compare('is_active', $this->is_active);
        $criteria->compare('sort_order', $this->sort_order);
        $criteria->compare('images_folder_url', $this->images_folder_url, true);


        return new CActiveDataProvider($this, [
            'criteria' => $criteria,
            'sort' => [
                'defaultOrder' => 'sort_order ASC'
            ]
        ]);
    }

    public function beforeSave()
    {
        if (parent::beforeSave()) {
            if ($this->isNewRecord && empty($this->id)) {
                $this->id = Yii::app()->db->createCommand('SELECT UUID()')->queryScalar();
                $this->created_at = new CDbExpression('NOW()');
            }

            if (strpos($this->slug,' '))
                $this->slug = str_replace(' ','-', $this->slug);

            if($this->sort_order == null || $this->sort_order == '')
                $this->sort_order = 0;

            $this->updated_at = new CDbExpression('NOW()');

            return true;
        }
        return false;
    }
}
