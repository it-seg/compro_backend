<?php
class SettingController extends Controller
{
    public function actionCreate()
    {
        $model = new Setting;

        if (isset($_POST['Setting'])) {
            $model->attributes = $_POST['Setting'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Setting created.');
                $this->redirect(['index']);
            }
        }

        $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = Setting::model()->findByPk($id);
        if (!$model) throw new CHttpException(404, 'Not found');
        if (isset($_POST['Setting'])) {
            $model->attributes = $_POST['Setting'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Setting updated.');
                $this->redirect(['index']);
            }
        }

        $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionIndex()
    {
        $model = new Setting('search');
        $model->unsetAttributes();
        if (isset($_GET['Setting'])) $model->attributes = $_GET['Setting'];
        $this->render('index', ['model' => $model]);
    }
}