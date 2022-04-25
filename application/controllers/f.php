<?php
defined('BASEPATH') or exit('No direct script access allowed');

use App\Models\Provincia;
//use Illuminate\Validation\Validator;
use Laravel_from_CI\Validator;
use Laravel_from_CI\View;

class F extends CI_Controller
{

	public function show()
	{
		View::view('form');
	}

	public function show1()
	{
		View::view('form1');
	}

	public function upload()
	{
		View::view('upload');
	}

	public function u1()
	{
		View::view('upload1');
	}

	public function store()
	{
		log_message('debug', "POST - " . print_r($_POST, true));


		$rules = [
			'nombre' => 'required|size:5',
			'numero' => 'required|max:10',
			'fecha' =>  'required|date_format:Y-m-d'
		];
		$messages = [];
		/*
			'required' => 'El campo :attribute  es obligatorio',
			'numero.max' => 'El número debe ser menor o igual que 10',
			'fecha.date_format' => 'Date not in correct format'
		];*/
		$validator = Validator::make($_POST, $rules, $messages);
		if ($validator->fails()) {
			$errors = array_map(
				function ($v) {
					return implode(', ', $v);
				},
				$validator->errors()->toArray()
			);
			return $this->output
				->set_content_type('application/json')
				//->set_status_header(200)
				->set_output(json_encode([
					'error' => true,
					'errors' => $errors,
					'data' => $_POST
				]));
		}


		return $this->output
			->set_content_type('application/json')
			//->set_status_header(200)
			->set_output(json_encode([
				'error' => false,
				'errors' => [],
				'data' => $_POST
			]));
	}
}