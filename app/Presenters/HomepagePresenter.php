<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;


final class HomepagePresenter extends BasePresenter
{

	public function renderDefault() {
	bdump('*****');
	//bdump($this->getPresenter());
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
