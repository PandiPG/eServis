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

	public function createComponentAddServis(): Form
	{
		$form = new Form;
		$form->addText('date', 'Datum')
			->setRequired('Zadajte datum!')
			->setHtmlType('date')
			->setDefaultValue((new \DateTime)->format('Y-m-d'));
		$form->addSelect('type')
		$form->addInteger('km', 'Stav km')
				->addRule($form::MAX_LENGTH, '%label muže mít maximálne %d čisla', 6)
				->setHtmlAttribute('placeholder', 'Napište stav najetých km ');
		$form->addTextArea('operation', 'Servisí úkon');
		$form->addSubmit('send', 'Vytvořit');
		$form->onSuccess[] = [$this, 'addServisSubmit'];
		return $form;
	}

	public function formCreateGarage($form, $values)
	{
		$values = $form->getValues();
		$user = $this->user->identity;$res = $this->model->createGarage($values['name'], $user->id );
		$this->redirect('this');

	}


}