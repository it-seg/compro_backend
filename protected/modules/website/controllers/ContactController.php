<?php
class ContactController extends Controller
{
    public function actionIndex()
    {
        $types = [
            'whatsApp_number',
            'map',
            'email',
            'phone_number',
            'address',
            'tiktok_username',
            'instagram__username',
            'facebook_username'
        ];

        $criteria = new CDbCriteria();
        $criteria->addInCondition('`key`', $types);
        $criteria->order = 'id ASC';

        $settingItems = Setting::model()->findAll($criteria);

        $this->render('index', [
            'settingItems' => $settingItems,
        ]);
    }

    public function actionUpdateSetting($type)
    {
        $model = Setting::model()->findByAttributes([
            'key' => $type,
        ]);

        if (!$model) {
            throw new CHttpException(404, 'Data tidak ditemukan');
        }

        if (isset($_POST['Setting'])) {
            $model->attributes = $_POST['Setting'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Konten berhasil diperbarui');
                $this->redirect(['index']);
            }
        }

        $this->render('update_header', [
            'model' => $model,
        ]);
    }



}