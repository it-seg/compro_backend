<?php
class Setting extends CActiveRecord
{
    public $status;

    public static function model($className=__CLASS__) { return parent::model($className); }

    public function tableName() { return 'setting'; }

    public function getDbConnection()
    {
        return Yii::app()->db_website;
    }

    public function rules()
    {
        return [
            ['key, value', 'required'],
            ['key, value','safe', 'on'=>'search'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id'=>'ID',
            'key'=>'Key',
            'value'=>'Value',
        ];
    }

    public function search()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('id',$this->id);
        $criteria->compare('`key`',$this->key,true);
        $criteria->compare('`value`',$this->value,true);
        $excludeTypes = [
            'whatsApp_number',
            'map',
            'email',
            'phone_number',
            'address',
            'tiktok_username',
            'instagram__username',
            'facebook_username',
            'logo',
            'hero_interval',
            'instagramToken'
        ];
        $criteria->addNotInCondition('`key`', $excludeTypes);

        $criteria->order = '`key`';

        return new CActiveDataProvider($this, ['criteria'=>$criteria, 'pagination'=>['pageSize'=>20]]);
    }

    public function beforeSave()
    {
        if(parent::beforeSave()){
            if ($this->isNewRecord && empty($this->id))
                $this->id = Yii::app()->db->createCommand('SELECT UUID()')->queryScalar();

            return true;
        }
        return false;
    }

    public function getValuePreview()
    {
        $key   = $this->key;
        $value = CHtml::encode($this->value);

        // === Gradient (_bg_1 + _bg_2) ===
        if (preg_match('/_bg_1$/', $key)) {

            $pairKey = str_replace('_bg_1', '_bg_2', $key);

            $pair = self::model()->findByAttributes(['key' => $pairKey]);

            if ($pair) {
                $color1 = $value;
                $color2 = CHtml::encode($pair->value);

                return "
                    <div style='display:flex;align-items:center;gap:12px'>
                        <div style='
                            width:120px;
                            height:36px;
                            background: linear-gradient(180deg, {$color1}, {$color2});
                            border:1px solid #ccc;
                            border-radius:6px;
                        '></div>
                        <div>
                            <code>{$color1}</code><br>
                            <code>{$color2}</code>
                        </div>
                    </div>
                ";
            }
        }

        // === Solid color ===
        if (preg_match('/^#([a-f0-9]{3}|[a-f0-9]{6})$/i', $value)) {
            return "
                <div style='display:flex;align-items:center;gap:10px'>
                    <div style='
                        width:28px;
                        height:28px;
                        background:{$value};
                        border:1px solid #ccc;
                        border-radius:4px;
                    '></div>
                    <code>{$value}</code>
                </div>
            ";
        }

        return $value;
    }
}
