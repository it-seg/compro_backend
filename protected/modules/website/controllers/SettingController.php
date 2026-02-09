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
        $settings = Setting::model()->findAll();

        $grouped = [];
        foreach ($settings as $s) {
            $grouped[$s->key] = $s;
        }

        $this->render('index', [
            'settings' => $grouped,
        ]);
    }

    public function actionGetBgPair()
    {
        $key = Yii::app()->request->getQuery('key');
        $model = Setting::model()->findByAttributes(['key' => $key]);

        header('Content-Type: application/json');
        echo json_encode([
            'value' => $model ? $model->value : null
        ]);
        Yii::app()->end();
    }



}