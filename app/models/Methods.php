<?php

  /**
   *
   */
  class Methods extends Eloquent
  {

    public static function getRealIpAddr()
    {

      if (!empty($_SERVER['HTTP_CLIENT_IP'])){ //check ip from share internet

        $ip=$_SERVER['HTTP_CLIENT_IP'];

      }elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){ //to check ip is pass from proxy

        $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];

      }else{

        $ip=$_SERVER['REMOTE_ADDR'];

      }

      return $ip;

    }

    public static function getBrowser(){

      $user_agent = $_SERVER['HTTP_USER_AGENT'];

      if(strpos($user_agent, 'MSIE') !== FALSE){

         return 'Internet explorer';

      }elseif(strpos($user_agent, 'Edge') !== FALSE){

         return 'Microsoft Edge';

      }elseif(strpos($user_agent, 'Trident') !== FALSE){

         return'Internet explorer';

      }elseif(strpos($user_agent, 'Opera Mini') !== FALSE){

         return "Opera Mini";

      }elseif(strpos($user_agent, 'Opera') || strpos($user_agent, 'OPR') !== FALSE){

         return "Opera";

      }elseif(strpos($user_agent, 'Firefox') !== FALSE){

         return 'Mozilla Firefox';

      }elseif(strpos($user_agent, 'Chrome') !== FALSE){

         return 'Google Chrome';

      }elseif(strpos($user_agent, 'Safari') !== FALSE){

         return "Safari";

      }else{

         return 'No detectado';

      }

    }

  }

?>
