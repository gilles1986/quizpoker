<?php
/**
 * User: Gilles
 * Date: 17.10.2015
 * Time: 09:51
 */

namespace Controller;


use Framework\Logger;
use Framework\Logic\Utils\JSClassIncluder;
use Models\Quiz;
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
    $this->smarty->assign("collapseNav", "in ");

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

  public function play() {
    $quiz = new Quiz($this->config['quizDataPath']);
    $this->smarty->assign("question", $quiz->getRandomQuestion());
    $this->smarty->assign("collapseNav", "");
    $this->smarty->assign("showReload", true);
    $this->view("Quizpoker","play");
  }

  public function editQuestions() {
    $quiz = new Quiz($this->config['quizDataPath']);
    $this->assign("questions", $quiz->getQuestions());
    $this->view("Quizpoker","editQuestions");
  }

  public function addQuestions() {
    $this->view("Quizpoker","addQuestions");
  }

  public function editQuestion() {
    $quiz = new Quiz($this->config['quizDataPath']);
    $request = print_r($this->getRequest(), true);
    Logger::debug("editQuestion: ".$request, "Quizpoker");
    $this->assign("question", $quiz->getQuestion($this->getRequest()['id']));
    $this->view("Quizpoker","editQuestion");
  }

  public function doEditQuestion() {
    $quiz = new Quiz($this->config['quizDataPath']);
    if($this->isValid()) {
      $quiz->editQuestion($this->getRequest());
      $quiz->save();
      Logger::debug("Editiere Frage : ".print_r($this->getRequest(), true), "Quizpoker");
      $this->redirect("editQuestions");
    } else {
      $this->assign("question", $this->getRequest());
      $this->redirect("editQuestion");
    }

  }

  public function doAddQuestion() {
    $quiz = new Quiz($this->config['quizDataPath']);
    if($this->isValid()) {
      $quiz->addQuestion($this->getRequest());
      Logger::debug("Speichere nach hinzufügen: ".print_r($quiz->getQuestions(), true), "Quizpoker");
      $quiz->save();
      $this->smarty->assign("success", true);
    } else {
      $this->assign("question", $this->getRequest());
    }

    $this->redirect("addQuestions");

  }

  public function deleteQuestion() {
    $quiz = new Quiz($this->config['quizDataPath']);
    $request = print_r($this->getRequest(), true);
    Logger::debug("deleteQuestion: ".$request, "Quizpoker");
    $id = $this->getRequest()['id'];
    $quiz->deleteQuestion($id);

    $quiz->save();

    $this->redirect("editQuestions");
  }


}

?>