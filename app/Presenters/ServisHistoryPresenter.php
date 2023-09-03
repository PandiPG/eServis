<?php
declare (strict_types=1);

namespace App\Presenters;
use App\Models\DatabaseModel;
use Latte\Runtime\Template;

class ServisHistoryPresenter extends BasePresenter
{

	private DatabaseModel $model;

	public function __construct(DatabaseModel $model)
	{
		$this->model = $model;
	}

	public function renderDefault($id)
	{
		$mena = \Nette\Neon\Neon::decode(file_get_contents('../config/common.neon'))['parameters']['mena'];
		bdump($id);
		$vehicle =  $this->model->getVehicleById($id)[0];

		$vehicleData = $this->model->getVehicleData($vehicle['vyrobce_id'], $vehicle['model_id'], $vehicle['ccm_id'], $vehicle['palivo_id'], $vehicle['prevodovka_id'], $vehicle['rok_vyroby'], $vehicle['kw_id'], $vehicle['id']);
		

		$history = $this->model->getServisOperationByVehicleId($id);
		$this->template->mena = $mena;
		$this->template->vehicleData = $vehicleData;
		$this->template->history = $history;
		$this->template->garageId = $this->model->getGarageIdByVehicleId($this->getParameter('id'));
	}
}
?>