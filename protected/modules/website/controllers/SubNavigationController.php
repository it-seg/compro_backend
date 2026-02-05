<?php
class SubNavigationController extends Controller
{
    public function actionIndex()
    {
        $model = new SubNavigation('search');
        $model->unsetAttributes();
        if (isset($_GET['SubNavigation'])) $model->attributes = $_GET['SubNavigation'];
        $this->render('index', ['model' => $model]);
    }

    public function actionCreate()
    {
        $model = new SubNavigation;
        if (isset($_POST['SubNavigation'])) {
            $model->attributes = $_POST['SubNavigation'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Sub navigation created.');
                $this->redirect(['index']);
            }
        }
        // load navigation list for dropdown
        $navs = CHtml::listData(Navigation::model()->findAll(['order' => 'sort_order ASC']), 'id', 'label');
        $this->render('create', ['model' => $model, 'navs' => $navs]);
    }

    public function actionUpdate($id)
    {
        $model = SubNavigation::model()->findByPk($id);
        if (!$model) throw new CHttpException(404, 'Not found');
        if (isset($_POST['SubNavigation'])) {
            $model->attributes = $_POST['SubNavigation'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', 'Sub navigation updated.');
                $this->redirect(['index']);
            }
        }
        $navs = CHtml::listData(Navigation::model()->findAll(['order' => 'sort_order ASC']), 'id', 'label');
        $this->render('create', ['model' => $model, 'navs' => $navs]);
    }

}