<?php
class NavigationLandingController extends Controller
{
    public function actionIndex()
    {
        $model = new NavigationLanding('search');
        $model->unsetAttributes();
        if (isset($_GET['NavigationLanding'])) $model->attributes = $_GET['NavigationLanding'];
        $this->render('index', ['model' => $model]);
    }

    public function actionCreate()
    {
        $model = new NavigationLanding;
        if (isset($_POST['NavigationLanding'])) {
            $model->attributes = $_POST['NavigationLanding'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Navigation Landing created.');
                $this->redirect(['index']);
            }
        }
        $this->render('create', ['model' => $model]);
    }

    public function actionUpdate($id)
    {
        $model = NavigationLanding::model()->findByPk($id);
        if (!$model) throw new CHttpException(404, 'Not found');
        if (isset($_POST['NavigationLanding'])) {
            $model->attributes = $_POST['NavigationLanding'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Navigation Landing updated.');
                $this->redirect(['index']);
            }
        }
        $this->render('create', ['model' => $model]);
    }

}