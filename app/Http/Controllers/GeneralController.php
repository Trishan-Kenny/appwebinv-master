<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Routing\ResponseFactory;

class GeneralController extends Controller
{
	public function actionIndexAdmin()
	{
		return view('general/indexadmin');
	}

	public function actionDataBackup(ResponseFactory $responseFactory)
	{
		$fileName='backup_inventory.sql';
		$fileNameDownload='backup_inventory_'.date('Y-m-d_H-i-s').'.sql';

		exec(config('var.COMMAND_BACKUP').' '.config('var.DB_DATABASE').' --password='.config('var.DB_PASSWORD').' --user='.config('var.DB_USERNAME').' --single-transaction > '.storage_path().'/'.$fileName);

		return $responseFactory->download(storage_path().'/'.$fileName, $fileNameDownload)->deleteFileAfterSend(true);
	}
}
?>