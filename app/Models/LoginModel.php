<?php
namespace App\Models;

final class LoginModel {

	use \Nette\SmartObject;

	private \Nette\Database\Explorer $database;

	public function __construct(\Nette\Database\Explorer $database)
	{
		$this->database = $database;
	}

	public function getUser()
	{
		$res = $this->database->fetchAll('SELECT * FROM user');
		foreach ($res as $row) {
			$username = $row->jmeno;
			 $pass = $row->heslo;
		}

		//$res->getRowCount();
		return $res;
	}

	public function addUser($name, $pass) {
		return $this->database->query('INSERT INTO user', [
			'jmeno' => $name,
			'heslo' => $pass,
		]);
	}
}

?>