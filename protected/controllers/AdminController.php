<?php

class AdminController extends Controller
{
    public function actionIndex()
    {
        $total_users = Users::model()->count();
        $current_user = Yii::app()->user->name;

        $this->render('index', [
            'total_users' => $total_users,
            'current_user' => $current_user,
        ]);
    }
}
