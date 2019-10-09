<?php 

namespace App\Http\Controllers\Utils;

class Helpers
{
    private $pers = ['Hour', 'Day', 'Week', 'Month', 'Year', 'Full Time'];
    private $currencies = array(
        'USD' => 'United States Dollar',
        'USX' => 'Ugandan Shillings',
        'FC' => 'Franc Congolais',
        'KSH' => 'Kenyan Shillings'
    );

    static function generateRandom($length){
        $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $pieces = [];
        $max = \mb_strlen($chars, '8bit') - 1;
        for($i = 0; $i < $length; $i++){
            $pieces[] = $chars[random_int(0, $max)];
        }
        return \implode('', $pieces);
    }

    static function getPers(){
        $help = new Helpers();
        return $help->pers;
    }

    static function getCurrencies(){
        $help = new Helpers();
        return $help->currencies;
    }

    static function findCurrency($key){
        $help = new Helpers();
        return $help->currencies[$key];
    }

    static function sms($text, $chars = 60){
        $text = $text. " ";
        $text = substr($text, 0, $chars);
        $text = substr($text, 0, strrpos($text, ' '));
        $text = $text. "...";
        
        return $text;
    }
}