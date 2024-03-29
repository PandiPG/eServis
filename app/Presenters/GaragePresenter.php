<?php

declare(strict_types=1);

namespace App\Presenters;

use App\Models\DatabaseModel;
use Nette\Application\UI\Form;
use Nette\Forms\Control;
use Nette\Forms\Form as FormsForm;

final class GaragePresenter extends BasePresenter
{

	private DatabaseModel $model;

	public function __construct(DatabaseModel $model)
	{
		$this->model = $model;
	}

	public function renderDefault($garageId)
	{	
		$vehicles = $this->model->getVehicles($garageId);
		if ( $vehicles === null ) {
			$this->redirect('AddVehicle:');
		}

		foreach ($vehicles as $vehicle) {
			//$vehicle['vyrobce'] = $this->model->getManufcturer($vehicles['vyrobce_id']);
			//$vehicle['model'] = $this->model->getModel($vehicles['model_id']);
			$vehicle['data'] = $this->model->getVehicleData($vehicle['vyrobce_id'], $vehicle['model_id'], $vehicle['ccm_id'], $vehicle['palivo_id'], $vehicle['prevodovka_id'], $vehicle['rok_vyroby'], $vehicle['kw_id'], $vehicle['id']);
		}

		$garage = $this->model->getGarage($this->getParameter('garageId'));
		$servisniUkony = $this->model->getServisOperation();
		bdump($servisniUkony);
		if ( isset($_POST['add-vehicle']) ) {
			$this->redirect('AddVehicle:');
		}

		$this->template->servisniUkony = $servisniUkony;
		$this->template->garage = $garage;
		$this->template->vehicles = $vehicles;
	}

	//public function createComponentAddVehicle(): Form
	//{
	//	$form = new Form;
	//	//jmeno
	//	$form->addText('name', 'Jméno:',)
	//		->addRule($form::MIN_LENGTH, '%label musí mít alespoň %d znaku.', 2);
	//	//katekorie
	//	$categories = $form->addSelect('category', 'Kategorie:', $this->model->getCategories())
	//		->setRequired('%label je povinní pole.')
	//		->setPrompt('Vyberte kategori');
	//	//vyrobce zavusli na kategorie
	//	$manufacturer = $form->addSelect('manufacturer', 'Výrobce:')
	//		->setRequired('%label je povinní pole.')
	//		->setHtmlAttribute('data-depends', $categories->getHtmlName())
	//		->setHtmlAttribute('data-url', $this->link('Vehicles:manufacturers', '#'))
	//		->setPrompt('Vyberte výrobce');
	//	$form->onAnchor[] = fn() => 
	//		$manufacturer->setItems($categories->getValue()
	//		? $this->model->getManufacturers($categories->getValue())
	//		:[]);
	//	//model zavusli na vyrobce
	//	$models = $form->addSelect('models', 'Model:')
	//		->setRequired('%label je povinní pole.')
	//		->setHtmlAttribute('data-depends', $manufacturer->getHtmlName())
	//		->setHtmlAttribute('data-url', $this->link('Vehicles:models', '#'))
	//		->setPrompt('Vyberte model');
	//	$form->onAnchor[] = fn() => 
	//		$models->setItems($manufacturer->getValue()
	//		? $this->model->getModels($manufacturer->getValue())
	//		:[]);
	//	//zbytek
	//	$form->addSelect('year', 'Rok výrovy:', $this->model->getYear())
	//		->setRequired('%label je povinní pole.')
	//		->setPrompt('Vyberte rok');
	//	/*$form->addText('typeKod', 'Radovy kod:')
	//		->addRule($form::MIN_LENGTH, '%label musí mít alespoň %d znaku.', 2);
	//	*/
	//	$form->addSelect('ccm', 'Obsah motoru:', $this->model->getCcm())
	//		->setRequired('%label je povinní pole.')
	//		->setPrompt('Vyberte ccm');
	//	$form->addSelect('kw', 'Výkon motoru (KW):', $this->model->getKw())
	//		->setRequired('%label je povinní pole.')
	//		->setPrompt('Vyberte výkon');
	//	$form->addSelect('transmission', 'Prevodovka:', $this->model->getTransmisson())
	//		->setRequired('%label je povinní pole.')
	//		->setPrompt('Vyberte převodovku');
	//	$form->addSelect('fuel', 'Palivo:', $this->model->getFuel())
	//		->setRequired('%label je povinní pole.')
	//		->setPrompt('Vyberte palivo');
	//	$form->addInteger('km', 'Stav km:')
	//		->addRule($form::MAX_LENGTH, '%label muže mít maximálne %d čisla', 6);
	//	$form->addText('vin', 'VIN:')
	//		->addRule($form::MIN_LENGTH, '%label musí mít přesne %d znaku.', 17);
	//	
	//	$form->addSubmit('addVehicle', 'Přidat');
	//	$form->onSuccess[] = [$this, 'formAddVehicle'];
	//	return $form;
	//	
	//}
	//
	//public function formAddVehicle($form, $values)
	//{
	//	$values = $form->getValues();
	//	bdump($values);
	//	bdump($this->user->identity->id);
	//	bdump($this->getParameter('garageId'));
	//	$this->model->addCar($values['name'], $values['category'], $values['manufacturer'], $values['models'], $values['year'], $values['ccm'],$values['kw'], $values['transmission'], $values['fuel'], $values['vin'], $this->getParameter('garageId'), $this->user->identity->id);
	//	return $form;
	//}

	//public function renderModal($id): void
	//{ 	
	//	$vehicleInfo = $this->model->getVehicleById($id);
	//	$vehicleInfo = $this->model->getVehicleData($vehicleInfo[0]['vyrobce_id'], $vehicleInfo[0]['model_id'], $vehicleInfo[0]['ccm_id'], $vehicleInfo[0]['palivo_id'], $vehicleInfo[0]['prevodovka_id'], $vehicleInfo[0]['rok_vyroby'], $vehicleInfo[0]['kw_id']);
	//	$this->template->render(__DIR__.'/templates/Garage/modal.latte');
	//}




}
?>