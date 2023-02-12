<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;
use App\Models\DatabaseModel;

final class VehiclesPresenter extends BasePresenter
{

	private DatabaseModel $model;

	public function __construct(DatabaseModel $model)
	{
		$this->model = $model;
	}

	public function actionModels($manufacturerId): void
	{
		$models = $this->model->getModels($manufacturerId);
		$this->sendJson($models);
	}


}