<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;

abstract class BasePresenter extends Nette\Application\UI\Presenter
{
	    /** @var Nette\Database\Context */
		private $database;

		public function __construct(Nette\Database\Connection $database)
		{
			$this->database = $database;
		}

    protected function startup()
    {
		parent::startup();
		if (!$this->getUser()->isLoggedIn()) {
			//$this->redirect('Login:');
		} else {
			$this->redirect('Homepage:');
		}
    }
}