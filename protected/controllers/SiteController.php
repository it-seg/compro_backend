<?php
class SiteController extends Controller
{
    public function actionIndex()
    {
        if (Yii::app()->user->isGuest) {
            $this->redirect(array('site/login'));
        } else {
            $this->render('index');
        }
    }

    public function actionLogin()
    {
        // Jika sudah login, jangan tampilkan login lagi
        if (!Yii::app()->user->isGuest) {
            $this->redirect(array('admin/index'));
            Yii::app()->end();
        }

        $model = new LoginForm;

        if (isset($_POST['LoginForm'])) {
            $model->attributes = $_POST['LoginForm'];

            if ($model->validate() && $model->login()) {
                $this->redirect(array('site/index'));
                Yii::app()->end();
            }
        }

        $this->render('login', array('model' => $model));
    }


    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect(array('site/login'));
    }

    public function actionError()
    {
        if($error=Yii::app()->errorHandler->error) {
            if(Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }
}
