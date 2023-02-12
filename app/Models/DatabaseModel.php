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

	public function getCategories()
	{
		$categories = [];
		foreach ( $this->database->table('kategoria')->fetchAll() as $row ) {
			$categories[$row->id] = $row->nazev;
		}
		return $categories;
	}

	public function getManufacturers($categoryId)
	{
		$manufacturers = $this->database->fetchAll('SELECT id,nazev FROM vyrobce WHERE kategorie_id=?', $categoryId);
		foreach ( $manufacturers as $row) {
			$manufacturers[$row->id] = $row->nazev;
		}
		foreach ($manufacturers as $row => $data ) {
			if ( !is_string($data) ) {
				unset($manufacturers[$row]);
			} 
		}

		$manufacturers[0] = 'Vyberte výrobce';
		return $manufacturers;
	}

	public function getModels($manufakturerId)
	{
		$models = $this->database->fetchAll('SELECT * FROM model WHERE vyrobce_id=?', $manufakturerId);
		foreach ( $models as $row) {
			$models[$row->id] = $row->nazev;
		}
		foreach ($models as $row => $data ) {
			if ( !is_string($data) ) {
				unset($models[$row]);
			} 
		}
		$models[0] = 'Vyberte model';
		bdump($models);
		return $models;
	}

	public function getCcm()
	{
		$ccms = [];//$this->database->fetchAll('SELECT id,oznaceni FROM ccm');
		foreach ( $this->database->table('ccm')->fetchAll() as $row)  {
			$ccms[$row->id] = $row->oznaceni;
		}
		return $ccms;
	}
	
}

?>