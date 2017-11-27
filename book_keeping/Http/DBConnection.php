<?php
require( dirname(__FILE__).'/connect.class.php' );
class DBConnection{
    
    /**
     * @var object
     * mysql connection instance
     */
    private static $instance = null;

    /**
     * @var PDO
     */
    private $dbconnect = null;

 
    function __construct() {

        try {
            $aryConnectionParms = new connect();
            $this->dbconnect = new PDO("mysql:host={$aryConnectionParms->localhost['host']};dbname={$aryConnectionParms->localhost['dbname']}", $aryConnectionParms->localhost['username'], $aryConnectionParms->localhost['password']); 
            //Set common attributes
            $this->dbconnect->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION ); 

            return $this->dbconnect;

        }
        catch (PDOException $e) {

            echo 'ERROR: ' . $e->getMessage();
        }
    }
    
    public function getDb() {
        if ($this->$dbconnect instanceof PDO) {
                return $this->dbconnect;
        }
    }
    
    /**
         * @return PDO
        */
        public static function getInstance() {
            if(!isset(self::$instance)) {
                self::$instance = new DBConnection();
            }
            return self::$instance->dbconnect;
        }

    public function closeConnection() {

        $this->dbconnect = null;
    }


}