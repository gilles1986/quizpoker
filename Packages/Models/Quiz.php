<?php
/**
 * User: Gilles
 * Date: 17.10.2015
 * Time: 11:18
 * 
 * Copyright 2015 quizpoker
 */

namespace Models;


use Framework\Logger;

class Quiz {

  private $questions = array();
  private $path;

  /**
   * Quiz constructor.
   */
  public function __construct($path) {
     $this->path = $path;
     $file =file_get_contents($path);
     $this->questions = json_decode($file);
  }


  public function getQuestions() {
    return $this->questions;
  }

  public function editQuestion($question) {
    $this->questions[$question['id']] = $question;
  }

  public function addQuestion($question) {
    $question['id'] = "";
    array_push($this->questions,$question);
    $this->reorder();
  }

  public function deleteQuestion($number) {
    array_splice($this->questions, $number, 1);
    $this->reorder();
  }


  public function reorder() {
    Logger::debug("reorder: ".count($this->questions)."", "Quiz");
    for($i=0; $i < count($this->questions); $i++) {
      if(is_array($this->questions[$i])) {
        $this->questions[$i]['id'] = $i;
      } else {
        $this->questions[$i]->id = $i;
      }

    }
    Logger::debug("reorder: ".print_r($this->questions, true)."", "Quiz");
  }

  public function getQuestion($number) {
    return $this->questions[$number];
  }

  public function getRandomQuestion(){
    $maxNumber = count($this->questions)-1;

    $random = rand(0, $maxNumber);

    return $this->questions[$random];

  }

  public function save() {
    $json = json_encode($this->questions);
    file_put_contents($this->path, $json);
  }




  private function arrayToObject($d) {
    if (is_array($d)) {
      /*
      * Return array converted to object
      * Using __FUNCTION__ (Magic constant)
      * for recursive call
      */
      return (object) array_map(__FUNCTION__, $d);
    }
    else {
      // Return object
      return $d;
    }
  }





}