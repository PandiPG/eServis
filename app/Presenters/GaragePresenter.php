<?php

declare(strict_types=1);

namespace App\Presenters;

use App\Models\DatabaseModel;
use Nette\Application\UI\Form;

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
		$this->template->vehicles = $vehicles;
	}

	public function createComponentAddVehicle(): Form
	{
		$form = new Form;
		//jmeno
		$form->addText('name', 'Jméno:')
			->setRequired('%label je povinní pole.')
			->addRule($form::MIN_LENGTH, '%label musí mít alespoň %d znaku.', 2);
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
		/*$form->addText('typeKod', 'Radovy kod:')
			->addRule($form::MIN_LENGTH, '%label musí mít alespoň %d znaku.', 2);
		*/
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
		$form->addText('vin', 'VIN:')
			->addRule($form::MIN_LENGTH, '%label musí mít přesne %d znaku.', 17);
		
		$form->addSubmit('addVehicle', 'Přidat');
		$form->onSuccess[] = [$this, 'formAddVehicle'];
		return $form;
		
	}

	public function formAddVehicle($form, $values)
	{
		$values = $form->getValues();
		bdump($values);
	}

}
?>