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

	public function actionModels($manufakturer): void
	{
		$models = $this->model->getModels($manufakturer);
		$this->sendJson($models);
	}


}