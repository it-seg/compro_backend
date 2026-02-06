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


    public function actionUpdate($id)
    {
        $model = Homepage::model()->findByPk($id);
        if (!$model) throw new CHttpException(404, 'Not found');
        if (isset($_POST['Homepage'])) {
            $model->attributes = $_POST['Homepage'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Homepage updated.');
                $this->redirect(['index']);
            }
        }
        $this->render('create', ['model' => $model]);
    }

}