<?php

declare(strict_types=1);

namespace App\Presenters;

use App\Models\Authenticator;
use App\Models\DatabaseModel;
use Nette\Application\UI\Form;
use Nette\Security\Authenticator as SecurityAuthenticator;
use Nette\Security\Passwords;

final class LoginPresenter extends BasePresenter
{
	/** @var Passwords */
	private Passwords $passwords;
	/** @var DatabaseModel */
	private  DatabaseModel $model;

	private SecurityAuthenticator $authenticator;

	public function __construct(DatabaseModel $model, Passwords	$passwords, Authenticator $authenticator)
	{
		$this->model = $model;
		$this->passwords = $passwords;
		$this->authenticator = $authenticator;
	}

	public function renderRegistration()
	{
		$this->createComponentRegistration();
	}

	public function renderDefault()
	{
		$this->createComponentLogin();
	}

	//			REGISTRACE
	public function createComponentRegistration(): Form
	{
		$form = new Form;
		$form->addText('name', 'Jméno:')
			->setRequired('Zadajte prosím %label')
			->addRule($form::MIN_LENGTH, '%label musi mít elespoň %d znaku', 5)
			->addCondition($form::MIN_LENGTH, 5);
			//->addRule($form::PATTERN, '%label musí obsahovat velké i malé písmo', '^(?=.*[^a-z]$)(?=.*[^A-Z$])$');
		$form->addPassword('password', 'Heslo:')
			->setRequired('Zadajte prosím %label')
			->addRule($form::MIN_LENGTH, '%label musí obsahovat alespon %d znaku', 8)
			->addCondition($form::MIN_LENGTH, 8);
		//->addRule($form::PATTERN, '%label musí obsahovat velké i malé písmo', '^[a-zA-Z]$')
		//->addCondition($form::PATTERN, '^[a-zA-Z]*$')
		//	->addRule($form::PATTERN, '%label musí obsahovat číslici', '.*[0-9].*');
		$form->addSubmit('send', 'Registrovat');
		$form->onSuccess[] = [$this, 'formRegSended'];
		return $form;
	}

	public function formRegSended($form, $values)
	{
		$values = $form->getValues();
		$user = $this->model->findUser($values['name']);

		if ( empty($user) ) {
			$values['password'] = $this->passwords->hash($values['password']);
			$res = $this->model->addUser($values['name'], $values['password']);
		}else if (isset($user['jmeno']) && $user['jmeno'] !== $values['name']) {
			$values = $form->getValues();
			$values['password'] = $this->passwords->hash($values['password']);
			$res = $this->model->addUser($values['name'], $values['password']);
			$this->flashMessage('Registrace byla úspěšná.');
			$this->redirect('Login:');
		} else {
			$this->flashMessage('Uživatelské jméno již existue, zvolte jinou.');
		}
	}

	//			PRIHLASENI
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
		$values = $form->getValues();
		try {
			$this->user->login($values->name, $values->password);
			$this->user->setExpiration('30 minutes');
			$this->flashMessage('Prihlaseni bylo uspěšné', 'success');
			$this->redirect('Homepage:');
		} catch (\Nette\Security\AuthenticationException $e) {
			$this->flashMessage($e->getMessage(), 'danger');
		}		
	}
	
}
