<?php

declare (strict_types=1);

namespace App\Presenters;

use App\Models\DatabaseModel;

final class DeleteVehiclePresenter extends BasePresenter
{
	private DatabaseModel $model;

	public function __construct(DatabaseModel $model)
	{
		$this->model = $model;
	}

	public function actionDeleteVehicle($id)
	{
		$res = $this->model->deleteVehicle($this->model->getVehicleById($id));
		bdump($res);
		//$this->flashMessage('Vozidlo bylo vymazaný.');
	}

}

?>