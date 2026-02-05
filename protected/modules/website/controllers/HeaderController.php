<?php
class HeaderController extends Controller
{
    public function actionIndex()
    {
        $model = new Header('search');
        $model->unsetAttributes();
        if (isset($_GET['Header'])) $model->attributes = $_GET['Header'];
        $this->render('index', ['model' => $model]);
    }

    public function actionCreate()
    {
        $model = new Header;
        if (isset($_POST['Header'])) {
            $model->attributes = $_POST['Header'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Header created.');
                $this->redirect(['index']);
            }
        }
        $this->render('create', ['model' => $model]);
    }

    public function actionUpdate($id)
    {
        $model = Header::model()->findByPk($id);
        if (!$model) throw new CHttpException(404, 'Not found');
        if (isset($_POST['Header'])) {
            $model->attributes = $_POST['Header'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Header updated.');
                $this->redirect(['index']);
            }
        }
        $this->render('create', ['model' => $model]);
    }

}