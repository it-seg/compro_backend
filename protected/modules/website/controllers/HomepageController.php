<?php
class HomepageController extends Controller
{
    public function actionIndex()
    {
        $model = new Homepage('search');
        $model->unsetAttributes();
        if (isset($_GET['Homepage'])) $model->attributes = $_GET['Homepage'];
        $this->render('index', ['model' => $model]);
    }


    public function actionCreate()
    {
        $model = new Homepage;

        if (isset($_POST['Homepage'])) {
            $model->attributes = $_POST['Homepage'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Homepage section created.');
                $this->redirect(['index']);
            }
        }

        $this->render('create', ['model' => $model]);
    }

    public function actionUpdate($id)
    {
        $model = Homepage::model()->findByPk($id);
        if (!$model) {
            throw new CHttpException(404, 'Data not found');
        }

        if (isset($_POST['Homepage'])) {
            $model->attributes = $_POST['Homepage'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Homepage section updated.');
                $this->redirect(['index']);
            }
        }

        $this->render('create', ['model' => $model]);
    }

}