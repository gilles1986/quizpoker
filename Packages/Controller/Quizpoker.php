<?php
/**
 * User: Gilles
 * Date: 17.10.2015
 * Time: 09:51
 */

namespace Controller;


use Framework\Logger;
use Framework\Logic\Utils\JSClassIncluder;
use Models\QuizImporter;
use Framework\Logic\Utils\jsonHandler;

class Quizpoker extends TplAbstractController {

  private $CONFIGPATH = "";

  private $config;

  public function _prepare($action) {

    // Applikationsconfig für Quizpoker laden
    $this->config = jsonHandler::parseJson(CONFIG . "/quizConfig.json");

    // JS Dateien laden aus config-Folder
    $scripts = JSClassIncluder::load(json_decode(file_get_contents(CONFIG . "javascript.json")));
    $this->smarty->assign("jsscript", $scripts);

    // Nimmt das Template in Views/tplTypes/quiz als Rahmenlayout
    $this->setTemplateType("quiz");

    return parent::_prepare($action);
  }

  public function import() {

    $data = QuizImporter::import($this->config['importPath']);
    $this->smarty->assign("data", $data);

    $this->view("Quizpoker","import");
  }

  public function main() {
    $this->view("Quizpoker","main");
  }


}

?>