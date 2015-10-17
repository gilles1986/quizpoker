<?php
/**
 * User: Gilles
 * Date: 17.10.2015
 * Time: 10:17
 */


/**
 * Aufbau einer Datei die Importiert werden kann
 *
 * - Frage Nr 1
 * - Hinweis 1
 * - Hinweis 2
 * - Antwort Nr 1
 * ##
 * - Frage Nr 2
 * - Hinweis 1
 * - Hinweis 2
 * - Antwort Nr 2
 *
 */

namespace Models;


use Framework\Errors\Exception;
use Framework\Errors\WrongSizeException;
use Framework\Logger;

class QuizImporter {

  public static function import($path) {
    Logger::debug("Import data from ".$path, "Importer");
    $file = file_get_contents($path);
    $data = self::executeImport($file);
    file_put_contents("F:/importData.json", json_encode($data));

    return $data;
  }

  private static function executeImport($data) {

    $dataObject = array();
    $data = self::cleanDataString($data);
    $questions = explode("####", $data);

    $counter = 0;

    foreach ($questions as $questionString) {
      try {
        $questionObject = self::createQuestionObject($questionString, $counter);
        $counter++; // QuestionId
        array_push($dataObject, $questionObject);
      } catch(WrongSizeException $e){
        Logger::warning($e->getMessage(), "Quizimporter");
        continue;}
    }

    return $dataObject;
  }

  private static function cleanDataString($data) {
    $data = str_replace("\r","",$data); // Falls im Windows Style
    $data = str_replace("\n##\n","####",$data); // Zeilenumbrüche entfernen
    return $data;
  }


  private static function createQuestionObject($questionString, $questionId) {

    $lines = explode("\n", $questionString);
    return self::linesToQuestionObject($lines, $questionId);
  }

  private static function linesToQuestionObject($lines, $questionId) {
    $question = array();

    Logger::debug("Import Question ".print_r($lines, true), "QuizImporter");

    if(count($lines) < 4) throw new WrongSizeException("Wrong size for lines ".print_r($lines, true));

    $question['id'] = $questionId;
    $question['question'] = self::cleanLine($lines[0]);
    $question['hint1'] = self::cleanLine($lines[1]);
    $question['hint2'] = self::cleanLine($lines[2]);
    $question['answer'] = self::cleanLine($lines[3]);

    return $question;
  }

  private static function cleanLine($line) {
    $line = substr($line,1);
    return trim($line);
  }


}

?>