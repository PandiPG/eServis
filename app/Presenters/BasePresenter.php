<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;

abstract class BasePresenter extends Nette\Application\UI\Presenter
{
    protected function startup()
    {
		parent::startup();
        $this->session->start();
		
		if (!$this->getUser()->isLoggedIn() && $this->getPresenter()->name !== 'Login' ) {
			$this->redirect('Login:');
		} else if ( $this->getUser()->isLoggedIn() && $this->getPresenter()->name === 'Login' ){
			$this->redirect('Homepage:');
		}
    }

	//			ODHLASENI
	public function actionOut()
	{
		bdump('actionOut');
		$this->user->logout(true);
		$this->flashMessage('Odlášení bylo úspěnšé.');
		$this->redirect('Login:');
	}
}