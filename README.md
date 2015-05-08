# EnvDetect

A small PHP library that allows for detecting application environments. This library autoloads
one of three files, 'local', 'staging', or 'production'. It looks for this file in the directory
where `EnvDetect::load()` is called from. The file should be named according to `.env.{$environment}.php`.

Currently Supported Detection Methods:
---

- Using Hostname: ( gethostname() )  *default*
- Using Server Name: ( $_SERVER['SERVER_NAME'] )
- Using Request Address: ( $_SERVER['REQUEST_ADDR'] )

Usage:
---

    $env = new kkeiper1103\EnvDetect\EnvDetect();
    
    // my machine's hostname is "ubuntu"
    $env->matchLocal([
        "ubuntu"
    ]);
    
    // will look for .env.local.php in the current directory
    $env->load();
    
Envisioned Usage:
---

I use this project to introduce configuration management to WordPress. I generally put all of 
the environment specific `define`s within the .env files. This project is not WordPress specific.

    <?php
    
    define("WP_SITEURL", "http://www.wrladv.local/");
    define("WP_HOME", WP_SITEURL);
    
    
    // ** MySQL settings - You can get this info from your web host ** //
    /** The name of the database for WordPress */
    define('DB_NAME', 'DATABASE NAME');
    
    /** MySQL database username */
    define('DB_USER', 'DATABASE USER');
    
    /** MySQL database password */
    define('DB_PASSWORD', 'DATABASE PASSWORD');
    
    /** MySQL hostname */
    define('DB_HOST', 'localhost');
    
    
    define('WP_DEBUG', false );
    
