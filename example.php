<?php

require_once 'input.php';
require_once 'hash.php';
require_once 'cookie.php';
require_once 'encrypt.php';


    //set cookie
    Cookie::set("author","baris");
    
    
    //delete cookie if it is set
    Cookie::delete("name");
    
    //get information from if it is set
    Cookie::get("name");
    
    
    Cookie::instance()->setsecure(true);
    
    //set path
    Cookie::instance()->setpath("/");
    
    //set domain
    Cookie::instance()->setdomain(".example.com");
    
    
    //set time
    Cookie::instance()->settime(60*60*24);
    
    
  




?>


