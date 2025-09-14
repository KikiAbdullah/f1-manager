<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
	public function getButtonOption(Request $request)
	{
		$data 		= $request->all();

		$view 		= [
			'status' 			=> true,
			'view' 				=> view('layouts.button_option')->with(['id' => $data['id'], 'btn' => $data['btn']])->render()
		];

		return response()->json($view);
	}
}
