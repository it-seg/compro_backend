<?php

class UsersController extends Controller {

    public function actionCreate()
    {
        $model = new Users;

        if (isset($_POST['Users'])) {
            $model->attributes = $_POST['Users'];
            if ($model->save()) {
                $this->redirect(['users/index']);
            } else {
                echo json_encode($model->getErrors());
            }
        }

        $roles = CHtml::listData(Roles::model()->findAll(['order' => 'name ASC']), 'id', 'name');
        $this->render('form', ['model' => $model, 'roles' => $roles]);
    }

    public function actionUpdate($id)
    {
        $model = Users::model()->findByPk($id);

        $changePassword = isset($_GET['action']) && $_GET['action'] == 'change-password' ?
            true : false;

        if (isset($_POST['Users'])) {
            if(!$changePassword) {
                $model->username = $_POST['Users']['username'];
                $model->fullname = $_POST['Users']['fullname'];
                $model->role_id = $_POST['Users']['role_id'];
            } else
                $model->attributes = $_POST['Users'];

            if ($model->save()) {
                $this->redirect(['users/index']);
            } else {
                echo json_encode($model->getErrors());
            }
        }

        $roles = CHtml::listData(Roles::model()->findAll(['order' => 'name ASC']), 'id', 'name');
        $this->render('form', ['model' => $model, 'roles' => $roles]);
    }

    public function actionIndex()
    {
        $model = new Users('search');
        $model->unsetAttributes();

        if (isset($_GET['Users'])) {
            $model->attributes = $_GET['Users'];
        }

        $this->render('index', [
            'model' => $model
        ]);
    }

}
