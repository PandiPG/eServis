<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;
use App\Models\DatabaseModel;
use Nette\Application\UI\Form;

final class AddGaragePresenter extends BasePresenter
{

	private DatabaseModel $model;

	public function __construct(DatabaseModel $model)
	{
		$this->model = $model;
	}

	public function createComponentCreateGarage(): Form
	{
		$form = new Form;
		$form->addText('name', 'Jméno')
			->setRequired('Zadajte jméno garáže')
			->addRule($form::MIN_LENGTH, '%labe musí mít alespoň %d znaku', 4);
		$form->addSubmit('send', 'Vytvořit');
		$form->onSuccess[] = [$this, 'formCreateGarage'];
		return $form;
	}

	public function formCreateGarage($form, $values)
	{
		$values = $form->getValues();
		$user = $this->user->identity;$res = $this->model->createGarage($values['name'], $user->id );
		$this->redirect('this');

	}


}