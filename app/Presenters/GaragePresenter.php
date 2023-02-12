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
		
		$form->addText('name', 'Jméno')
			->setRequired('%label je povinní pole.')
			->addRule($form::MIN_LENGTH, '%label musí mít alespoň %d znaku.', 2);
		
		
		$manufacturer = $form->addSelect('manufacturer', 'Výrobce', $this->model->getManufacturers())
			->setPrompt('Vyberte výrobce');
		$models = $form->addSelect('models', 'Models')
			->setHtmlAttribute('data-depends', $manufacturer->getHtmlName())
			->setHtmlAttribute('data-url', $this->link('Vehicles:models', '#'))
			->setPrompt('Vyberte model');
		$form->onAnchor[] = fn() => 
			$models->setItems($manufacturer->getValue()
			? $this->model->getModels($manufacturer->getValue())
			:[]);
		

		
		$form->addText('typeKod', 'Radovy kod')
			->addRule($form::MIN_LENGTH, '%label musí mít alespoň %d znaku.', 2);
		$form->addText('ccm', 'Obsah motoru')
			->setRequired('%label je povinní pole.')
			->addRule($form::MIN_LENGTH, '%label musí mít alespoň %d znaku.', 2);
		$form->addText('transmission', 'Prevodovka')
			->setRequired('%label je povinní pole.')
			->addRule($form::MIN_LENGTH, '%label musí mít alespoň %d znaku.', 6);
		$form->addText('fuel', 'Palivo')
			->setRequired('%label je povinní pole.')
			->addRule($form::MIN_LENGTH, '%label musí mít alespoň %d znaku.', 3);
		$form->addText('vin', 'VIN')
			->addRule($form::MIN_LENGTH, '%label musí mít přesne %d znaku.', 17);
		$form->addText('category', 'Kategorie')
			->setRequired('%label je povinní pole.');
		$form->addSubmit('addVehicle', 'Přidat');
		$form->onSuccess[] = [$this, 'formAddVehicle'];
		return $form;
		
	}

	public function formAddVehicle($form, $values)
	{
		$values = $form->getValues();
		bdump($values);
	}

	public function actionModels($manufacturer): void
	{

		$models = $this->model->getModels($manufacturer);
		$this->sendJson($models);

	}
}
?>