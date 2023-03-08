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

	public function actionDelete()
	{
		
		//bdump($garageId);
		bdump($_POST);
		$ids = explode(",", $_POST['vehicle_delete_id']);
		$vehicleId = substr($ids[0],10);
		$garageId = substr($ids[1],9);
		bdump($garageId);
		bdump($vehicleId);
		$res = $this->model->deleteVehicle( $vehicleId );
		if ( $res->getRowCount() !== 0 ) {
			$this->flashMessage('Vozidlo odstraněn.', 'success');
		}
		//$this->redirectUrl('../garage/?garageId='.$garageId);
		$this->redirect('Garage:default', $garageId);
		
		
	}

}


	