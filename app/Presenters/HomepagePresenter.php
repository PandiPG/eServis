<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;
use App\Models\DatabaseModel;
use Nette\Application\UI\Form;

final class HomepagePresenter extends BasePresenter
{

	private DatabaseModel $model;

	public function __construct(DatabaseModel $model)
	{
		$this->model = $model;
	}

	public function renderDefault() {
		$garages = $this->model->getGarages($this->user->identity->id);	
	
		$this->template->garages = $garages;
	}

		//			ODHLASENI
	public function actionOut()
	{
		$this->user->logout(true);
		$this->flashMessage('Odlášení bylo úspěnšé.');
		$this->redirect('Login:');
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
