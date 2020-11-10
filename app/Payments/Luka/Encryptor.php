<?php

namespace App\Payments\Luka;
use Illuminate\Support\Str;

use Config;

class Encryptor
{
    private $key;

    public function __construct()
    {
       $this->key = 'bf3c199c2470cb477d907b1e0917c17b';
    }


    public static function getKey(){
       return self::$key;
    }

    public static function method()
    {
         return Config::get('app.cipher');
    }

   public static function hash_key(){
       return hash('sha256', Str::substr(Config::get('app.key'), 7));
   }

   public static function iv()
   {
       /*$secret_iv = Str::substr(Config::get('app.key'), 7);
       $iv = substr(hash('sha256', $secret_iv), 0, 16);*/

       $strong = false; // set to false for next line
       $iv = openssl_random_pseudo_bytes(16, $strong);

       return $iv;
   }

   public static function encrypt($value, $iV)
   {
       $output = openssl_encrypt($value, self::method(), self::getKey(), 0, $iV);
       $output = base64_encode($output);

       return $output;
   }

   public static function decrypt($value)
   {
       $output = openssl_decrypt(base64_decode($value), self::method(), self::getKey(), 0, self::iv());
       return (int)$output;
   }
}
