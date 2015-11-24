<?php
include_once ('sqlconnect.php');
include_once ("authConfig.php");
include_once ("authUtil.php");

/**
* 
*/
class User
{
	private $player_tag;
	private $password;
	private $email;
	private $id;

	
	function __construct($player_tag, $password, $email)
	{
		$this->player_tag = $player_tag;
		$this->password = $password;
		$this->email = $email;
		$this->id = NULL;
	}

	/**
	 * Adds the given user the database if the user is not already in the database.
	 * @return null on success and string containing error message on error.
	 */
	public function addUser() {
		session_start();
		$salt = authUtil::makeSalt(SALTSIZE);
		$hash = authUtil::makePassHash(HASHALGO, $salt, $this->player_tag, $this->password);
		$sql = SqlConnect::getInstance();
		$result = $sql->runQuery("SELECT member_id FROM Member where player_tag = '".$this->player_tag."';");
		if ($result->num_rows != 0) {
			return "Username already exists. Please select a different username.";
		}
		$query = "INSERT INTO Member (player_tag, email, pass_hash, salt) VALUES ('" . $this->player_tag . "', '" . $this->email . "', '" . $hash . "', '" . $salt . "');";
		$result = $sql->runQuery($query);
		$result = $sql->runQuery("SELECT member_id FROM Member where player_tag = '".$this->player_tag."';");
		$this->id = $result->fetch_assoc()["member_id"];
		$_SESSION["id"] = $this->id;
		$_SESSION["player_tag"] = $this->player_tag;
		return NULL;
	}

	/**
	 * Logins the user
	 * @return null on success and string containing error message on error. 
	 */
	public function login() {
		session_start();
		$sql = SqlConnect::getInstance();
		$result = $sql->runQuery("SELECT member_id, pass_hash, salt FROM Member where player_tag = '".$this->player_tag."';");
		if ($result->num_rows == 0) {
			return "Username does not exist.";
		}
		$row = $result->fetch_assoc();
		$hash = $row["pass_hash"];
		$salt = $row["salt"];
		$this->id = $row["member_id"];
		// verify that password matches with stored password
		$success = authUtil::verifyPass(HASHALGO, $hash, $salt, $this->player_tag, $this->password);
		if ($success) {
			$_SESSION["id"] = $this->id;
			$_SESSION["player_tag"] = $this->player_tag;
			return NULL;
		} else {
			return "Username and password did not match.";
		}
	}

	public function getId() {
		return $this->id;
	}

	/**
	 * Unsets the session variables that are set when a user logs in.
	 */
	public static function logout() {
		session_start();
		unset($_SESSION["id"]);
		unset($_SESSION["player_tag"]);
	}
}