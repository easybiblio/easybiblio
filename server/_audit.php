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