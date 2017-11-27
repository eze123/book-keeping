<?php
class connect{
    /**
     * Database Connection Settings
    */
    public $localhost = array(
    	'driver' => 'mysql',
    	'host' => 'localhost',
    	'dbname' => 'ezekingc_book_management',
    	'username' => 'ezekingc_bookadmin',
    	'password' => 'eze123'
	);
	
    function __construct() {
        return $this->localhost;
    }
}