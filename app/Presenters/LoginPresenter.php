<?php

declare(strict_types=1);

namespace App\Presenters;

use App\Models\LoginModel;
use Nette\Application\UI\Form;

final class LoginPresenter extends BasePresenter
{
	private LoginModel $model;

	public function __construct(LoginModel $model)
	{
		$this->model = $model;
	}
	
	public function renderRegistration()
	{		
		$this->createComponentRegistration();
	}

	public function renderDefault($database)
	{

		bdump('FUCK');
		$user = $this->model->getUser();
		bdump($user);
		//if (!$this->user->isLoggedIn()) {
		//	$this->redirect('Login:registration');
		//}

		$this->createComponentLogin();
	}


	public function createComponentRegistration(): Form
	{
		$form = new Form;
		$form->addText('name', 'Jméno:');
		$form->addPassword('password', 'Heslo:');
		$form->addSubmit('send', 'Registrovat');
		$form->onSuccess[] = [$this, 'formRegSended'];
		return $form;
	}

	public function formRegSended($form, $values)
	{
		bdump($_POST);
		$values = $form->getValues();
		bdump($values);
		$res = $this->model->putUser($values['name'], $values['password']);
		bdump($res);
	}
	//ATCSINALNI DATABASEMODELRE - MEGCSINALNI A REGISTRACIOT (MEGMONDANI H MINDENI OK) - ES A BEJELENTKEZEST
	public function createComponentLogIn(): Form
	{
		$form = new Form;
		$form->addText('name', 'Jméno:');
		$form->addPassword('password', 'Heslo:');
		$form->addSubmit('send', 'Prihlasit');
		$form->onSuccess[] = [$this, 'formLogInSended'];
		return $form;
	}

	public function formLogInSended($form, $values)
	{
		bdump($_POST);
		$values = $form->getValues();
		bdump($values);
		try {
			$this->getUser()->login($values['name'], $values['password']);
			$this->flashMessage('Prihlaseni bylo uspěšné');
			$this->redirect('Homepage:');
		} catch (Nette\Security\AuthenticationException $e) {
			bdump($e);
			$this->flashMessage('Nespravne jmeno nebo helso');
		}
	}
}
