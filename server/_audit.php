<?php
class Audit {

    private $database;
	
	public function __construct($database){
		$this->database = $database;
	}
	
    public function login() {
        $this->audit('LOGIN');
    }
    
    public function logout() {
        $this->audit('LOGOUT');
    }
    
    public function bookLost($details) {
        $this->audit('BOOK_LOST', $details);
    }
    
    public function bookFound($details) {
        $this->audit('BOOK_FOUND', $details);
    }
    
    public function bookLent($details) {
        $this->audit('BOOK_LENT', $details);
    }
    
    public function bookReturn($details) {
        $this->audit('BOOK_RETURN', $details);
    }
    
    public function newBook($details) {
        $this->audit('NEW_BOOK', $details);
    }
    
    public function updateBook($details) {
        $this->audit('UPDATE_BOOK', $details);
    }
    
    public function newPerson($details) {
        $this->audit('NEW_PERSON', $details);
    }
    
    public function updatePerson($details) {
        $this->audit('UPDATE_PERSON', $details);
    }
    
    // This function inserts an audit in the table TB_AUDIT
    private function audit($operation, $details) {
      $columns = array(
        "#timestamp" => "STR_TO_DATE('" . date('d/m/Y H:i:s') . "','%d/%m/%Y %H:%i:%s')",
        "username" => $_SESSION['_ebb_username'],
        "operation" => $operation,
        "details" => $details
      );

      $this->database->insert("tb_audit", $columns);
    }
    
}
?>