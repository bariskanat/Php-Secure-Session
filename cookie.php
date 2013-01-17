<?php

class Cookie{
    
    private static $instance;
    
    private static $httponly=true;
    
    private static $expire=86400;    
    
    private static $secure=false;
    
    private static $path="/";
    
    private static $domain=null;
    
   
   
    
    private function __construct(){}
    
    public static function instance()
    {
        if(!isset(self::$instance))
        {
            self::$instance=new self;
            
        }
        
        return self::$instance;
    }
    
    
    /**
     * 
     * @param string $name
     * @param mix $value
     */
    
    public static function set($name,$value)
    {
       
        self::instance()->setcookie($name,$value);
    }
    
    /**
     * RETURN COOKIE IF IT IS SET
     * @param string $name
     * @return boolean
     */
    public static function get($name)
    {
        if(!self::has($name))return false;
        $secret=self::decode($_COOKIE[$name])['secret'];
      
        if(self::secret()!=$secret)
        {
           
            self::delete($name);
            
        }
        else 
        {
            
            
            return self::decode($_COOKIE[$name])['key'];
        }
    }
    
    /**
     * DELETE THE COOKIE
     * @param string $name
     * @return boolean
     */
    public static function delete($name)
    {
        if(!self::has($name))return false;
        unset($_COOKIE[$name]);
        return setcookie($name, NULL, time()-400, self::$path, self::$domain, self::$secure, self::$httponly);
    }
  
    
    /**
     * 
     * @param string $name
     * @return type
     */
    public static function has($name)
    {
        return self::instance()->exists($name);
    }
    
    /**
     * 
     * @param string $name
     */
    private function exists($name)
    {
        return Input::cookie($name);
    }
    
    
   static function secret($secret=null)
    {
        if(!is_null($secret)) return Hash::create_hash ($secret);
        $key=  Input::user_agent().Input::ip();
        return Hash::create_hash($key);
    }


    /**
     * set cokkie
     * @param string $name
     * @param mix $value
     */
    private  function setcookie($name,$value)
    {
        $info=["key"=>$value,"secret"=> self::secret()];
        $value=self::instance()->encode($info);         
        setcookie($name, $value,time()+ self::$expire, self::$path, self::$domain, self::$secure, self::$httponly);
        
    }    
   
    
    
    /**
     * return decrypted  information
     * @param type $value
     */
    public static function decode($value)
    {
        return Encrypt::decode($value, md5(self::secret()));
        
    }
    
   
    
    /**
     * return encrypted data
     * @param type $value
     */
    public static function encode($input)
    {
        return Encrypt::encode($input, md5(self::secret()));
        
    } 
    
    /**
     * 
     * @param string $key
     * @return boolean|\Cookie
     */
    public function setsecure($key)
    {
        if(!is_bool($key))return false;
        self::$secure=$key;
        return $this;
    }
    
    /**
     * 
     * @param int $time
     * @return boolean|\Cookie
     */
    public function settime($time)
    {
        if(!is_int($time))return false;
        self::$expire=$time;
        return $this;
    }
    
    
    /**
     * 
     * @param string $host
     * @return \Cookie
     */
    public function sethost($host)
    {
        self::$domain=$host;
        return $this;
    }
    
    /**
     * 
     * @param string $path
     * @return \Cookie
     */
    
    public function setpath($path)
    {
        self::$path=$path;
        return $this;
    }
    
    
}