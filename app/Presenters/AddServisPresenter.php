<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;
use App\Models\DatabaseModel;
use DateTime;
use Nette\Application\UI\Form;

final class AddServisPresenter extends BasePresenter
{

	private DatabaseModel $model;

	public function __construct(DatabaseModel $model)
	{
		$this->model = $model;
	}

	public function beforeRender()
	{
		$date = new DateTime();
		$date = $date->format('d.m.Y');
		$this->template->date = $date;
	}

	public function renderDefault($id) 
	{
		$this->createComponentAddServis($id);
		$vehicle = $this->model->getVehicleById($id)[0];
		$vehicleData = $this->model->getVehicleData($vehicle['vyrobce_id'], $vehicle['model_id'], $vehicle['ccm_id'], $vehicle['palivo_id'], $vehicle['prevodovka_id'], $vehicle['rok_vyroby'], $vehicle['kw_id'], $vehicle['id']);
		$vehicleData['vin'] = $vehicle['vin'];
		
		foreach ( $vehicleData as $key => $data) {
			unset($vehicleData['ccm']);
			unset($vehicleData['palivo']);
			unset($vehicleData['prevodovka']);
			unset($vehicleData['kw']);
		}

		$this->template->vehicleData = $vehicleData;
	}

	public function createComponentAddServis(): Form
	{	
		$vin = $this->model->getVinById($this->getParameter('id'));
		$vin = $vin->vin;

		$form = new Form;
		$form->addHidden('vehicleId', $this->getParameter('id'));
		$form->addHidden('vin', $vin);
		$form->addText('date', 'Datum')
			->setRequired('Zadajte datum!')
			->setHtmlType('date')
			->setDefaultValue((new \DateTime)->format('Y-m-d'));
		$form->addSelect('type', 'Typ servisu', $this->model->getServisTypes());
		$form->addInteger('km', 'Stav km')
				->addRule($form::MAX_LENGTH, '%label muže mít maximálne %d čisla', 6)
				->setHtmlAttribute('placeholder', 'Napište stav najetých km ');
		$form->addTextArea('operation', 'Servisí záznam');
		$form->addInteger('price', 'Cena')
			->setHtmlAttribute('float');
		$form->addSubmit('send', 'Vytvořit');
		$form->onSuccess[] = [$this, 'formAddServis'];
		return $form;
	}

	public function formAddServis($form, $values)
	{
		
		$values = $form->getValues();
		$user = $this->user->identity;
		$res = $this->model->addServisOperation($values->vehicleId, $values->date, $values->type, $values->km, $values->operation, $values->price, $values->vin);
		bdump($res->getRowCount());
		if ( $res->getRowCount() !== 0 ) {
			$this->flashMessage('Servisní úkon byl přidán', 'success');
		} /*else {
			$this->flashMessage('Servisní úkon se nepodařilo přidat', 'danger');
		}*/
		//$this->redirect('this');
	}


}