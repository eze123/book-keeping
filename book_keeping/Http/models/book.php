<?php
require "../DBConnection.php";
class book{
    
    protected $conn;
    
    function __construct()
    {

        $this->conn = DBConnection::getInstance();

    }
    
    /**
     * Maps $_REQUEST["order"] values to actual db table column names
     * @var global $_REQUEST["order"]
     * @return array
     */
    private function getColumnOrder(){
        switch ($_REQUEST["order"][0] ["column"]){
            case "0":
                $strCol = "id";
                break;
            case "1":
                $strCol = "name";
                break;
            case "2":
                $strCol = "author";
                break;
            case "3":
                $strCol = "description";
                break;
            case "4":
                $strCol = "publication_date";
                break;
            case "5":
                $strCol = "rating";
                break;
        }

        return array($strCol, $_REQUEST["order"][0] ["dir"]);

    }
    
    /**
     * Retrieves the total number of records in the book table
     * @var PDO $conn
     * @return integer
     */
    private function getBookTotal(){
        $stmt = "SELECT * FROM book";
        $stmt = $this->conn->prepare($stmt);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return count($result);
    }
    
    /**
     * Retrieves records in the book table
     * @var PDO $conn
     * @var $_REQUEST $start
     * @var $_REQUEST $length
     * @return json
     */
    public function getBook(){
        $strStart = $_REQUEST["start"];
        $strLength = $_REQUEST["length"];
        
        if(isset($_REQUEST["order"])){
            list($strColName, $strColOrder) = book::getColumnOrder();
            $sqlStatement = "SELECT * FROM book ORDER BY $strColName $strColOrder LIMIT $strLength OFFSET $strStart";
        }
        else
            $sqlStatement = "SELECT * FROM book ORDER BY id LIMIT $strLength OFFSET $strStart";
            
        $pdoStatement = $this->conn->prepare($sqlStatement);
		$pdoStatement->execute();
		/* Fetch the entire row(s) */
	    $pdoResult = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);
        
        $object = new stdClass();
        $object->draw = (int)$_REQUEST["draw"];
        $object->recordsTotal = book::getBookTotal();
        $object->recordsFiltered = book::getBookTotal();
        
        for($k=0; $k<count($pdoResult); $k++){
            $a = array();
			foreach($pdoResult[$k] as $key=>$val)
				array_push($a, $val);
			$object->data[] = $a;
		}
		
		$out = json_encode($object);

		echo $out;
        
    }
    
    /**
     * Retrieves records in the book table based on search criteria
     * @var PDO $conn
     * @var $_REQUEST $search
     * @return json
     */
    public function getBookSearch(){
        $search = $_REQUEST["search"]["value"];
        $sqlStatement = "SELECT * FROM book WHERE name LIKE :search OR author LIKE :search OR publication_date LIKE :search OR description LIKE :search";
        /* Execute a prepared statement by passing an array of values */
        $pdoPrepare = $this->conn->prepare($sqlStatement);
        /* Bind the search variable's value then execute query */
		$pdoPrepare->execute(array(':search' => '%'.$search.'%'));
		/* Fetch the entire row(s) */
	    $pdoResult = $pdoPrepare->fetchAll(PDO::FETCH_ASSOC);
	    
	    $object = new stdClass();
        $object->draw = (int)$_REQUEST["draw"];
        $object->recordsTotal = book::getBookTotal();
        $object->recordsFiltered = count($pdoResult);
        
        for($k=0; $k<count($pdoResult); $k++){
            $a = array();
			foreach($pdoResult[$k] as $key=>$val)
				array_push($a, $val);
			
			$object->data[] = $a;
		}
		
		$out = json_encode($object);
		
		echo $out;
    }
    
    /**
     * Updates the notes field 
     * @var PDO $conn
     * @var $_POST $notes
     * @return json
     */
    public function updateNotes(){

        try {
        
            foreach($_POST["notes"] as $note){
                $row = $note[0];
                $theNote = $note[1];
                $sqlStatement = "UPDATE book SET notes = :notes WHERE id = :id";
                $stmt = $this->conn->prepare($sqlStatement);
                /* Use bindParam to bind the variable */
                $stmt->bindParam(':notes', $theNote);
                $stmt->bindParam(':id', $row);
        	    $stmt->execute();
        	    echo $stmt->rowCount() . " records UPDATED successfully";
            }
        }
        catch(PDOException $e)
            {
            error_log($e->getMessage(), 3, dirname(__FILE__).'/updateError.log');
            }
    }
    
    
}