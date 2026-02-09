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
        if (isset($_POST['Pair']['value'])) {
            $pairKey = str_replace('_bg_1','_bg_2',$model->key);
            $pair = Setting::model()->findByAttributes(['key'=>$pairKey]);
            if ($pair) {
                $pair->value = $_POST['Pair']['value'];
                $pair->save();
            }
        }

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
    public function actionEditBackground($key)
    {
        // key = about_bg_1, contact_bg_1, dll
        if (!preg_match('/_bg_1$/', $key)) {
            throw new CHttpException(400, 'Invalid background key');
        }

        $bg1 = Setting::model()->findByAttributes(['key'=>$key]);
        if (!$bg1) throw new CHttpException(404);

        $bg2Key = str_replace('_bg_1', '_bg_2', $key);
        $bg2 = Setting::model()->findByAttributes(['key'=>$bg2Key]);
        if (!$bg2) throw new CHttpException(404);

        $this->render('create', [
            'model' => $bg1,
        ]);

    }




}