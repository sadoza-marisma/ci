<?php
defined('BASEPATH') or exit('No direct script access allowed');


use App\Models\Provincia;
use App\CIBlade;

class Welcome extends CI_Controller
{

	const VIEWS = FCPATH . 'app_laravel/Views/';
	const CACHE = FCPATH . 'app_laravel/cache/';

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */
	public function index()
	{


		$np = new Provincia();
		$np->nombre = date("h:m:s");
		$np->cod = '44';
		$np->comunidad_id = 1;
		$np->save();

		echo "Guardado ";
		var_dump($np);

		//CIBlade::view('hola');

	}

	public function show()
	{
		View::view('form');
	}

	public function hola()
	{
		App\CIBlade::view('hola');
		//echo "<h1>Hola Mundo</h1>";
		//$this->load->view('welcome_message');
	}
}