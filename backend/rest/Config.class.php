<?php
class Config {
    public static function DB_HOST(){
        return Config::get_env("DB_HOST", "127.0.0.1");
    }

    public static function DB_SCHEMA(){
        return Config::get_env("DB_SCHEMA", "jewelry");
    }

    public static function DB_USERNAME(){
        return Config::get_env("DB_USERNAME", "root");
    }

    public static function DB_PASSWORD(){
        return Config::get_env("DB_PASSWORD", "rootroot");
    }   
    
    public static function DB_PORT(){
        return Config::get_env("DB_PORT", "3306");
    }

    public static function JWT_SECRET(){
        return "15aa5241d59303cc6b0e5b71344d2d99c331731713430f0df02a391b31671c35287a03dcee9177a10176d8f43450dd538f7b76eed1459ab88f9d431034612b430b1eb5da75211446523c1c7f9104fa70052c8b7c7d491772c919b051f68342620e65191e9b51d57fdef4a3694615ca1c6bb567f01281f8bf0e1ea6e862b15fa4fb0a6fc6fc24cd030744eca46fa43df0b72a7f64d291db112820a27ac9dd987f52a8d7f54e2652f040446e41223a80ccb52f02ef4e6d6317f60ab513083db4190684d79df3c7150b72b18997028dd0eda7ab0cfea52738a4d0a9dc1b54ef274cc37e9f5fbece7870a0f426e36c4424df98b6ca05e6202993e4ab2007f2843382";
      }
    
    public static function get_env($name, $default){
        return isset($_ENV[$name]) && trim($_ENV[$name]) != '' ? $_ENV[$name] : $default;
    }
}
?>