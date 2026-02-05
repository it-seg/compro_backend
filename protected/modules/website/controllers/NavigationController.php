<?php
class NavigationController extends Controller
{
    public function actionIndex()
    {
        $model = new Navigation('search');
        $model->unsetAttributes();
        if (isset($_GET['Navigation'])) $model->attributes = $_GET['Navigation'];
        $this->render('index', ['model' => $model]);
    }

    public function actionCreate()
    {
        $model = new Navigation;
        if (isset($_POST['Navigation'])) {
            $model->attributes = $_POST['Navigation'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Navigation created.');
                $this->redirect(['index']);
            }
        }
        $this->render('create', ['model' => $model]);
    }

    public function actionUpdate($id)
    {
        $model = Navigation::model()->findByPk($id);
        if (!$model) throw new CHttpException(404, 'Not found');
        if (isset($_POST['Navigation'])) {
            $model->attributes = $_POST['Navigation'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Navigation updated.');
                $this->redirect(['index']);
            }
        }
        $this->render('create', ['model' => $model]);
    }

}