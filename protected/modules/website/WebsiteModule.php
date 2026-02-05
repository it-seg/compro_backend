<?php

class WebsiteModule extends CWebModule
{
    public function init()
    {
        // Import models and controllers inside module
        $this->setImport([
            'website.models.*',
            'website.controllers.*',
        ]);
    }

    public function beforeControllerAction($controller, $action)
    {
        return parent::beforeControllerAction($controller, $action);
    }
}
