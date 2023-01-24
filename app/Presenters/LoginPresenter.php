<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;
use Nette\Application\UI\Form;

final class LoginPresenter extends Nette\Application\UI\Presenter
{
		protected function startup()
	{
		parent::startup();
		if (!$this->getUser()->isLoggedIn()) {
			$this->flashMessage('Nejste prihlašen.');
		}
	}

	
	public function createComponentRegistration(): Form 
	{
		$form = new Form;
		$form->addText('name', 'Jméno:');
		$form->addPassword('password', 'Heslo:');
		$form->addSubmit('send', 'Registrovat');
		$form->onSuccess[] = [$this, 'formSended'];
		return $form;
	}

	public function formSended($form, $values)
	{
		bdump($_POST);
		$values = $form->getValues();
		bdump($values);
		try {
			$this->getUser()->login($values['name'], $values['password']);
			$this->flashMessage('Super jsi tam!');
			$this->redirect('this');
		} catch (Nette\Security\AuthenticationException $e) {
			bdump($e);
			$this->flashMessage('Nedobrý');
		}
		

	}


}
