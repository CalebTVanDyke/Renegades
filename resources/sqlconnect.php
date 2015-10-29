<?php
include_once ('config.php');

class SqlConnect {

	private $connection;
	private $username;
	private $password;
	private $database;
	private $connUrl;

	/**
	 * Grab default values
	 */
	public function __construct(){
		// Fatal error handler for PHP
		// ister_shutdown_function("Publisher::fatalHandler");
		$this->initialize();
	}

	/**
	 * Private function so it can't be called whenever
	 * Hides all connection info
	 */
	private function initialize(){
		try {
			// See 'constants.php'
			$this->connUrl = "mysql.cs.iastate.edu";
			$this->username = "dbu461rene";
			$this->database = "db461rene";
			$this->password = "yk2Gtcej3UAr";
			$this->connection = new mysqli($this->connUrl, $this->username, $this->password, $this->database);
			
			if (mysqli_connect_errno()) {
				throw new Exception("Failure to connect");
			}
		}
		catch (Exception $e) {
			// Zero is the default user, used for very low errors
			
			// Publisher::publishException($e->getTraceAsString(), $e->getMessage(), 0);
			SqlConnect::$lastException = $e;
			var_dump($this);
			return false;
		}
	}

	public function runQuery($query) {
		return $this->connection->query($query);
	}
}

?>
