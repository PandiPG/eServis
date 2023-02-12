<?php
namespace App\Models;

use Nette\SmartObject;


class DatabaseModel {

	use SmartObject;

	protected \Nette\Database\Explorer $database;

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

	public function getGarage($id) 
	{
		$garages =  $this->database->fetchAll('SELECT * FROM muj_garaz WHERE user_id= ?', $id);
		foreach ( $garages as $garage) {
			$garageName = $garage->jmeno;
		}
		bdump($garages);
		return $garages;
	
	}

	public function createGarage($jmeno, $id)
	{
		return $this->database->query('INSERT INTO muj_garaz', [
			'jmeno' => $jmeno,
			'user_id' => $id
		]);
	}

	public function getVehicles($garageId)
	{
		$vehicles =  $this->database->fetchAll('SELECT * FROM vozidlo WHERE muj_garaz_id=?', $garageId);
		foreach ( $vehicles as $vehicle ) {
			$vehicleName = $vehicle->jmeno;
		}
		return $vehicles;
	}

	
	public function getManufacturers()
	{
		$manufacturers = [];//$this->database->fetchAll('SELECT * FROM vyrobce');
		foreach ( $this->database->table('vyrobce')->fetchAll() as $row) {
			$manufacturers[$row->id] = $row->nazev;
		}
		return $manufacturers;
	}
	public function getModels($manufakturerId)
	{
		$models = $this->database->fetchAll('SELECT * FROM model where vyrobce_id=?', $manufakturerId);
		foreach ( $models as $row) {
			$models[$row->id] = $row->nazev;
		}
		foreach ($models as $row => $data ) {
			if ( !is_string($data) ) {
				unset($models[$row]);
			} 
		}
		bdump($models);
		return $models;
	}
	
}

?>