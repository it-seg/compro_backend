<?php
class Controller extends CController
{
    public $layout='//layouts/main';

    public function init()
    {
        parent::init();

        $cs = Yii::app()->clientScript;

        // Local Bootstrap
        $cs->registerCssFile(Yii::app()->baseUrl . '/css/bootstrap.min.css');

        $cs->registerCssFile(Yii::app()->baseUrl . '/css/bootstrap-icons.css');

        $cs->registerScriptFile(Yii::app()->baseUrl . '/js/bootstrap.bundle.min.js', CClientScript::POS_END);

        if (Yii::app()->controller->id == 'site' && isset(Yii::app()->controller->action) && Yii::app()->controller->action->id == 'login') {
            return;
        }

        if (Yii::app()->user->isGuest) {
            return;
        }

        $maxLife = 18000; // 30 menit or 1800 ms
        $loginTime = Yii::app()->session['login_time'] ?: 0;

        if ((time() - $loginTime) > $maxLife) {
            Yii::app()->user->logout();
            Yii::app()->user->setFlash('error', 'Session expired, please login again.');
            $this->redirect(['/site/login']);
        } else {
            $this->setSessionTimestamp();
        }
    }

    public function filters()
    {
        return [
            'accessControl',
        ];
    }

    public function accessRules()
    {
        return [
            // Allow these actions without login
            ['allow',
                'controllers' => ['site'],
                'actions' => ['login', 'error'], // you can add more public pages here
                'users' => ['*'], // everyone
            ],

            // All other pages require login
            ['allow',
                'users' => ['@'], // logged-in users only
            ],

            // Deny anything else
            ['deny',
                'users' => ['*'],
            ],
        ];
    }

    private function setSessionTimestamp()
    {
        // Check session expire in DB
        $sessionId = Yii::app()->session->sessionID;
        $row = Yii::app()->db->createCommand()
            ->select('expire')
            ->from('yii_session')
            ->where('id = :id', [':id' => $sessionId])
            ->queryRow();

        if ($row) {
            $now = time();

            $timeNow = date('Y-m-d h:i:s', $now);
            $timeExpire = date('Y-m-d h:i:s', (int)$row['expire']);

            Yii::app()->db->createCommand()
                ->update('yii_session',
                    ['login_time' => $timeNow, 'expired_time' => $timeExpire],
                    'id = :id',
                    [':id' => Yii::app()->session->sessionID]
                );
        }
    }

    protected function getWebsiteImagePath()
    {
        $params = Yii::app()->params['websiteImagePath'];

        if (DIRECTORY_SEPARATOR === '\\') {
            // Windows
            return realpath($params['windows']);
        }

        // Linux / Unix
        return realpath($params['linux']);
    }

}
