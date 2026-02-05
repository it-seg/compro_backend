<?php

class RolesController extends Controller {

    public function actionCreate()
    {
        $model = new Roles;

        if (isset($_POST['Roles'])) {
            $model->attributes = $_POST['Roles'];
            if ($model->save()) {
                $this->redirect(['roles/index']);
            } else {
                echo json_encode($model->getErrors());
            }
        }

        $this->render('form', ['model' => $model]);
    }

    public function actionUpdate($id)
    {
        $model = Roles::model()->findByPk($id);
        $oldSection = $model->section;

        if (isset($_POST['Roles'])) {

            if (!isset($_POST['Roles']['section'])) {
                $_POST['Roles']['section'] = $oldSection;
            }

            $model->attributes = $_POST['Roles'];

            if ($model->save()) {
                $this->redirect(['roles/index']);
            } else {
                var_dump($model->getErrors());
                exit;
            }
        }

        $this->render('form', ['model' => $model]);
    }

    public function actionIndex()
    {
        $model = new Roles('search');
        $model->unsetAttributes();

        if (isset($_GET['Roles'])) {
            $model->attributes = $_GET['Roles'];
        }

        $this->render('index', [
            'model' => $model
        ]);
    }

}
