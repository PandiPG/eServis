<?php
namespace App\Models;

use Nette\Security\Passwords;

final class DatabaseModel {

	use \Nette\SmartObject;

	private \Nette\Database\Explorer $database;

	public function __construct(\Nette\Database\Explorer $database)
	{
		$this->database = $database;
	}

	public function getUser($name)
	{
		$res = $this->database->fetchAll('SELECT * FROM user');
		foreach ($res as $row) {
			$username = $row->jmeno;
			 $pass = $row->heslo;
		}
		
		if ( is_array($res) && isset($res[0]) ) {
			return $res[0];
		} else {
			return null;

		}
	}

	public function putUser($name, $pass) {
		return $this->database->query('INSERT INTO user', [
			'jmeno' => $name,
			'heslo' => $pass,
		]);

	}

	public function findUser($name)
	{
		$res = $this->database->fetchAll('SELECT * FROM user WHERE jmeno= ?', $name);
		foreach ($res as $row) {
			$username = $row->jmeno;
			 $pass = $row->heslo;
		}

		if ( is_array($res) && isset($res[0]) ) {
			return $res[0];
		} else {
			return null;

		}
	}
}

?>