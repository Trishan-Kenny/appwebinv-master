<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Routing\ResponseFactory;

class IndexController extends Controller
{
	public function actionIndex()
	{
		return view('index/index');
	}
}
?>