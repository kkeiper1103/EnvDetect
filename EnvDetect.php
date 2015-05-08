<?php
/**
 * Created by PhpStorm.
 * User: kkeiper
 * Date: 5/7/15
 * Time: 3:38 PM
 */

namespace kkeiper1103\EnvDetect;


/**
 * Class EnvDetect
 * @package kkeiper1103\EnvDetect
 */
class EnvDetect {

    /**
     * @var array
     *
     * array of elements to test against for a local environment
     */
    protected $_local = array();

    /**
     * @var array
     *
     * array of elements to test against for a staging environment
     */
    protected $_staging = array();

    /**
     * @var array
     *
     * array of elements to test against for a production environment
     */
    protected $_production = array();

    /**
     * @var string
     *
     * Valid values: hostname, requestaddr, servername
     */
    protected $_method = "hostname";



    public function matchLocal($array) {

        $this->_local = $array;

        return $this;
    }

    public function matchStaging($array) {

        $this->_staging = $array;

        return $this;
    }

    /**
     *
     */
    public function load() {

        $env = "production";

        if( $this->testLocal() )
            $env = "local";

        elseif( $this->testStaging() )
            $env = "staging";


        $file = getcwd() . "/.env.{$env}.php";

        if( is_readable( $file ) )
            require_once $file;
        else
            throw new MissingEnvFileException( __DIR__ . "/" . $file );
    }

    /**
     * @return bool
     */
    private function testLocal() {

        if( $this->_method == "hostname" )
        {
            return in_array( gethostname(), $this->_local );
        }
        elseif( $this->_method == "servername" )
        {
            return in_array( $_SERVER['SERVER_NAME'], $this->_local );
        }
        elseif( $this->_method == "requestaddr" )
        {
            return in_array( $_SERVER['REQUEST_ADDR'], $this->_local );
        }

        return false;
    }

    /**
     * @return bool
     */
    private function testStaging() {

        if( $this->_method == "hostname" )
        {
            return in_array( gethostname(), $this->_staging );
        }
        elseif( $this->_method == "servername" )
        {
            return in_array( $_SERVER['SERVER_NAME'], $this->_staging );
        }
        elseif( $this->_method == "requestaddr" )
        {
            return in_array( $_SERVER['REQUEST_ADDR'], $this->_staging );
        }

        return false;
    }

    /**
     * @return $this
     */
    public function useRequestAddress() {
        $this->_method = "requestaddr";

        return $this;
    }

    /**
     * @return $this
     */
    public function useServerName() {
        $this->_method = "servername";

        return $this;
    }

    /**
     * @return $this
     */
    public function useHostname() {
        $this->_method = "hostname";

        return $this;
    }


}