<?php

namespace App\Http\Controllers\Utils;

class JobStatus
{
    private $statuses = [];

    public function __constructor(){
        $this->setValues();
    }

    protected function setValues(){

        $this->statuses = array(
            '0' => 'Employed',
            '1' => 'Underemployed',
            '2' => 'Unemployed but not looking',
            '3' => 'Unemployed and Actively looking'
        );
    }

    static function all(){
        $_this = new JobStatus();
        $_this->setValues();
        return $_this->statuses;
    }

    static function getJobStatus($key){
        $_this = new JobStatus();
        $_this->setValues();
        return $_this->statuses[$key];
    }
}