<?php
/**
 * Created by PhpStorm.
 * User: negut_000
 * Date: 5/5/2017
 * Time: 18:47
 */
   
function hash_bcrypt($pass){
        $options = ['cost'=>11];
       $hash = password_hash($pass, PASSWORD_BCRYPT, $options);
           return $hash;
    }



