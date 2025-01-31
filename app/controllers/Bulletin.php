<?php
use Core\Controller;
use Core\Flasher;
use Models\Bulletin_model;
use Config\Config;

class Bulletin extends Controller{

    public function viewBulletin(){
        $data['bulletin'] = Bulletin_model::all();
        $this->view('challange/index',$data);
    }

      public function store(){
        $text = $_POST['text'];
        if(strlen($text)<10 || strlen($text)>200){
          Flasher::setFlash('Failed, ', 'Text must be between 10 and 200 characters', 'primary');
          header('Location: '. Config::BASEURL . '/');
          return;
        };
        $bulletin = new Bulletin_model;
        $bulletin->text = $_POST['text'];
        $bulletin->timestamp = date('Y-m-d H:i:s');
        if($bulletin->insert() > 0){
      Flasher::setFlash('sucesss,', 'Bulletin successfuly added', 'success');
      header('Location: '. Config::BASEURL . '/');
        }
    }

     

}