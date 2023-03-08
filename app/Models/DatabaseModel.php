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

	public function addUser($name, $pass) {
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

	public function getGarages($id) 
	{
		$garages =  $this->database->fetchAll('SELECT * FROM muj_garaz WHERE user_id= ?', $id);
		foreach ( $garages as $row) {
			$garages[$row->id] = $row->jmeno;
		}
		foreach ( $garages as $row => $data ) {
			if ( !is_string($data) ) {
				unset($garages[$row]);
			}
		}
		return $garages;	
	}

	public function getGarage($garageId)
	{
		return $this->database->fetch('SELECT jmeno FROM muj_garaz WHERE id=?', $garageId);			
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
	
	public function getTransmisson()
	{
		$transmissions = [];//$this->database->fetchAll('SELECT id,oznaceni FROM ccm');
		foreach ( $this->database->table('prevodovka')->fetchAll() as $row)  {
			$transmissions[$row->id] = $row->nazev;
		}
		return $transmissions;
	}

	public function getFuel()
	{
		$fuels = [];//$this->database->fetchAll('SELECT id,oznaceni FROM ccm');
		foreach ( $this->database->table('palivo')->fetchAll() as $row)  {
			$fuels[$row->id] = $row->nazev;
		}
		return $fuels;
	}

	public function getYear()
	{
		$years = [];//$this->database->fetchAll('SELECT id,oznaceni FROM ccm');
		foreach ( $this->database->table('rok')->fetchAll() as $row)  {
			$years[$row->id] = $row->rok;
		}
		return $years;
	}
	
	public function getKw()
	{
		$kws = [];//$this->database->fetchAll('SELECT id,oznaceni FROM ccm');
		foreach ( $this->database->table('kw')->fetchAll() as $row)  {
			$kws[$row->id] = $row->kw;
		}
		return $kws;
	}

	public function addCar($name, $category, $manufacturer, $model, $year, $ccm, $kw, $transmission, $fuel, $vin, $garageId, $userId)
	{
		return $this->database->query('INSERT INTO vozidlo', [
			'vin' => $vin,
			'ccm_id' => $ccm,
			'kategorie_id' => $category,
			'user_id' => $userId,
			'model_id' =>$model,
			'muj_garaz_id' => $garageId,
			'palivo_id' => $fuel,
			'vyrobce_id' => $manufacturer,
			'prevodovka_id' => $transmission,
			'jmeno' => $name,
			'rok_vyroby' => $year,
			'kw_id' => $kw,
			]
		);
	}

	public function getVehicleData($manufacturerId, $modelId, $ccmId, $palivoId, $prevodovkaId, $rokVyrobyId, $kwId)
	{
		$vehiclesdata['vyrobce'] = $this->database->fetch('SELECT nazev FROM vyrobce WHERE id=?', $manufacturerId);		
		$vehiclesdata['model'] = $this->database->fetch('SELECT nazev FROM model WHERE id=?', $modelId);
		$vehiclesdata['ccm'] = $this->database->fetch('SELECT oznaceni FROM ccm WHERE id=?', $ccmId);
		$vehiclesdata['palivo'] = $this->database->fetch('SELECT nazev FROM palivo WHERE id=?', $palivoId);
		$vehiclesdata['prevodovka'] = $this->database->fetch('SELECT nazev FROM prevodovka WHERE id=?', $prevodovkaId);
		$vehiclesdata['rokVyroby'] = $this->database->fetch('SELECT rok FROM rok WHERE id=?', $rokVyrobyId);
		$vehiclesdata['kw'] = $this->database->fetch('SELECT kw FROM kw WHERE id=?', $kwId);
		
		return $vehiclesdata;		
	}

	public function getVehicleById($id)
	{
		return $this->database->fetchAll('SELECT * FROM vozidlo WHERE id=?', $id);
	}

	public function deleteVehicle($id)
	{
		return $this->database->query('DELETE FROM vozidlo WHERE id=?', $id);
	}
	
}

?>