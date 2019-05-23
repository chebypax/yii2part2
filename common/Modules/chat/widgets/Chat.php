<?php
namespace common\modules\chat\widgets;

use common\modules\chat\widgets\assets\ChatAsset;
use Yii;
use yii\bootstrap\Widget;


class Chat extends Widget
{
    public $wsPort = 8080;
    public $user;
    public $photo;

    public function __construct($config = [])
{
    parent::__construct($config);

}

    public function init()
    {
        $this->view->registerJsVar('wsPort', $this->wsPort);
        $this->view->registerJsVar('user', $this->user);
        $this->view->registerJsVar('photo', $this->photo);
        ChatAsset::register($this->view);

    }
    public function run()
    {
        return $this->render('chat');
    }
}
