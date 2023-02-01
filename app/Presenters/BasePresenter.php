<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;

abstract class BasePresenter extends Nette\Application\UI\Presenter
{
    protected function startup()
    {
		parent::startup();
		
		if (!$this->getUser()->isLoggedIn()) {
			//$this->redirect('Login:');
		} else {
			//$this->redirect('Homepage:');
		}
    }
}