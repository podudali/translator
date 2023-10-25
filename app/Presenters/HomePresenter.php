<?php

namespace App\Presenters;

use Nette;
use Nette\Application\UI\Presenter;
use App\Model\TranslatorModel;

class HomePresenter extends Presenter {

    private $model;
    public function __construct(TranslatorModel $model){
        $this->model = $model;
    }
    public function beforeRender() {
    }
    public function renderDefault() {
        if(isset($_POST['user_message'])) {
            $userMessage = $_POST['user_message'];
            $lang = $_POST['lang'] ?? 'rus';
            $bot = $this->model->getChatBot($userMessage, $lang);
            echo $bot;
        }
    }
}
