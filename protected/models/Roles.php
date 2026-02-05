<?php
class Roles extends CActiveRecord
{
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'roles';
    }

    public function rules()
    {
        return [
            ['name', 'required'],
            ['section', 'safe'],
        ];
    }

    public static function sectionOptions()
    {
        return [
            'DASHBOARD' => 'Dashboard',
            'USERS' => 'Users',
            'USERS|CREATE' => 'Users Create',
            'USERS|EDIT' => 'Users Edit',
            'USERS|PASSWORD' => 'Users Password',
            'ROLES' => 'Roles',
            'ROLES|CREATE' => 'Roles Create',
            'ROLES|EDIT' => 'Roles Edit',
            'WEBSITE' => 'Website',
            'WEBSITE|SETTING' => 'Website Setting',
            'WEBSITE|SETTING|CREATE' => 'Website Setting Create',
            'WEBSITE|HEADER' => 'Website Header',
            'WEBSITE|HEADER|CREATE' => 'Website Header Create',
            'WEBSITE|EVENTS' => 'Website Events',
            'WEBSITE|EVENTS|CREATE' => 'Website Events Create',
            'WEBSITE|NAVIGATION' => 'Website Navigation',
            'WEBSITE|NAVIGATION|CREATE' => 'Website Navigation Create',
            'WEBSITE|MENU' => 'Website Menu',
            'WEBSITE|MENU|CREATE' => 'Website Menu Create',
            'WEBSITE|NEWS' => 'Website News',
            'WEBSITE|NEWS|CREATE' => 'Website News Create',
            'WEBSITE|SPACE' => 'Website Space',
            'WEBSITE|SPACE|CREATE' => 'Website Space Create',
            'WEBSITEIMAGES' => 'Website Images',
            'WEBSITEIMAGES|UPLOAD' => 'Website Images Upload',
            'WEBSITEIMAGES|SETCOVER' => 'Website Images Set Cover',
            'WEBSITEIMAGES|RENAME' => 'Website Images Rename',
            'WEBSITEIMAGES|DELETE' => 'Website Images Delete',
        ];
    }

    protected function afterFind()
    {
        parent::afterFind();

        if ($this->section && is_string($this->section)) {
            $this->section = explode(',', $this->section);
        }
    }

    protected function beforeSave()
    {
        if (is_array($this->section)) {
            $this->section = implode(',', array_unique($this->section));
        }

        return parent::beforeSave();
    }

    public function search()
    {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('section', $this->section, true);

        return new CActiveDataProvider($this, [
            'criteria' => $criteria,
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'defaultOrder' => 'id DESC',
            ],
        ]);
    }

}
