<?php

declare(strict_types=1);

namespace App\Presenters;

use App\Models\DatabaseModel;
use Nette\Application\UI\Form;

final class AddVehiclePresenter extends BasePresenter
{

	private DatabaseModel $model;

	public function __construct(DatabaseModel $model)
	{
		 $this->model = $model;
	}


	public function renderDefault()
	{

	}


	public function createComponentAddVehicle(): Form
	{

		$form = new Form;

		//jmeno
		$form->addText('name', 'Jméno:',)
			->addRule($form::MIN_LENGTH, '%label musí mít alespoň %d znaku.', 2)
			->setHtmlAttribute('placeholder', 'napiste jméno vozidla');
		//katekorie
		$categories = $form->addSelect('category', 'Kategorie:', $this->model->getCategories())
			->setRequired('%label je povinní pole.')
			->setPrompt('Vyberte kategori');
		//vyrobce zavusli na kategorie
		$manufacturer = $form->addSelect('manufacturer', 'Výrobce:')
			->setRequired('%label je povinní pole.')
			->setHtmlAttribute('data-depends', $categories->getHtmlName())
			->setHtmlAttribute('data-url', $this->link('Vehicles:manufacturers', '#'))
			->setPrompt('Vyberte výrobce');
		$form->onAnchor[] = fn() => 
			$manufacturer->setItems($categories->getValue()
			? $this->model->getManufacturers($categories->getValue())
			:[]);
		//model zavusli na vyrobce
		$models = $form->addSelect('models', 'Model:')
			->setRequired('%label je povinní pole.')
			->setHtmlAttribute('data-depends', $manufacturer->getHtmlName())
			->setHtmlAttribute('data-url', $this->link('Vehicles:models', '#'))
			->setPrompt('Vyberte model');
		$form->onAnchor[] = fn() => 
			$models->setItems($manufacturer->getValue()
			? $this->model->getModels($manufacturer->getValue())
			:[]);
		//zbytek
		$form->addSelect('year', 'Rok výrovy:', $this->model->getYear())
			->setRequired('%label je povinní pole.')
			->setPrompt('Vyberte rok');
		$form->addSelect('ccm', 'Obsah motoru:', $this->model->getCcm())
			->setRequired('%label je povinní pole.')
			->setPrompt('Vyberte ccm');
		$form->addSelect('kw', 'Výkon motoru (KW):', $this->model->getKw())
			->setRequired('%label je povinní pole.')
			->setPrompt('Vyberte výkon');
		$form->addSelect('transmission', 'Prevodovka:', $this->model->getTransmisson())
			->setRequired('%label je povinní pole.')
			->setPrompt('Vyberte převodovku');
		$form->addSelect('fuel', 'Palivo:', $this->model->getFuel())
			->setRequired('%label je povinní pole.')
			->setPrompt('Vyberte palivo');
		$form->addInteger('km', 'Stav km:')
			->addRule($form::MAX_LENGTH, '%label muže mít maximálne %d čisla', 6)
			->setHtmlAttribute('placeholder', 'Napište stav najetých km');
		$form->addText('vin', 'VIN:')
			->addRule($form::MIN_LENGTH, '%label musí mít přesne %d znaku.', 17)
			->setHtmlAttribute('placeholder', 'Napište VIN:');
		$garages = $form->addSelect('garage', 'Garáž:', $this->model->getGarages($this->user->identity->id))
			->setRequired('%label je povinní pole.')
			->setPrompt('Vyberte garáž');
		$form->addSubmit('addVehicle', 'Přidat');
		$form->onSuccess[] = [$this, 'formAddVehicle'];
		return $form;
		
	}

	public function formAddVehicle($form, $values)
	{
		$values = $form->getValues();
		bdump($values);
		$this->model->addCar($values['name'], $values['category'], $values['manufacturer'], $values['models'], $values['year'], $values['ccm'],$values['kw'], $values['transmission'], $values['fuel'], $values['vin'], $values['garage'], $this->user->identity->id);
		return $form;
	}
}


?>