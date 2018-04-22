<?php

class formValidator {
    public $hasError = false;
    public $errorMessages = [];

    public function validate($form_data) {
        foreach($form_data as $key => $form_input) {
            if(isset($form_input['validation']['required'])) {
                $this->validate_required($form_input['name'], $form_input['data'], $form_input['validation']['required']);
            }
            if(isset($form_input['validation']['type'])) {
                $this->validate_type($form_input['name'], $form_input['data'], $form_input['validation']['type']);
            }
            if(isset($form_input['validation']['matches'])) {
                $match_key = $form_input['validation']['matches'];
                $this->validate_match($form_input['name'], $form_input['data'], $form_data[$match_key]['name'], $form_data[$match_key]['data']);
            }
            if(isset($form_input['validation']['exists'])) {
                $this->validate_exists($key, $form_input['name'], $form_input['data'], $form_input['validation']['exists']);
            }
            if(isset($form_input['validation']['max'])) {
                $this->validate_max($form_input['name'], $form_input['data'], $form_input['validation']['max']);
            }
        }
    }

    private function validate_required($name, $data, $required) {
        if($required == true) {
            if($data === NULL || empty($data)) {
                $this->validation_error('Field ' . $name . ' is required.');
            }
        }
        return;
    }

    // private function validate_type($name, $data, $type) {
    //     $data = ($type)$data;
    //     if(gettype($data) !== $type) {
    //         $this->validation_error('Field ' . $name . ' is not valid. It should be a ' . $type . '.');
    //     }
    //     return;
    // }

    private function validate_match($name, $data, $match_name, $match_data) {
        if($data != $match_data) {
            $this->validation_error('Field ' . $match_name . ' must match ' . $name . '.');
        }
        return;
    }

    private function validate_max($name, $data, $max) {
        if($data > $max) {
            $this->validation_error($name . ' can not be greater than ' . $max . '.');
        }
        return;
    }

    private function validate_exists($key, $name, $data, $exists) {
        $sql = 'SELECT * FROM ' . $exists[2] . ' WHERE ' . $exists[1] . ' = :' . $exists[1];
        $input_data = [$key => [ 'data' => $data ]];
        $isExists = $exists[3]->checkExists($input_data, $sql);
        if($isExists != $exists[0]) {
            if($isExists) {
                $this->validation_error('The ' . $name . ' ' . $data . ' already exists.');
            } else {
                $this->validation_error('The ' . $name . ' ' . $data . ' does not exist.');
            }
        }
        return;
    }

    private function validation_error($message) {
        $this->hasError = true;
        array_push($this->errorMessages, $message);
    }
}