<?php

namespace App\Controllers;

use App\Models\LaguModel;

class Main extends BaseController
{
	public function __construct()
	{
		$this->laguModel = new LaguModel();
	}

	public function index()
	{
		return view('index');
	}

	public function GetData()
	{
		$term = $this->request->getVar('term');
		$key = $this->request->getVar('key');

		$autocomplete = $this->laguModel->getData($term, $key);
		if ($autocomplete) {
			foreach ($autocomplete as $row) {
				$response[] = array("label" => $row[$key]);
			}
			echo json_encode($response);
		} else {
			$error = "No result";
			echo json_encode($error);
		}
	}

	public function postData()
	{
		$data = $this->request->getVar();
		$load = json_encode($data);
		$url = 'http://localhost:5010/gen_lyrics';
		$header = array('Content-Type:application/json');

		$ch = curl_init();
		curl_setopt_array($ch, array(
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_POST => TRUE,
			CURLOPT_POSTFIELDS => $load,
			CURLOPT_HTTPHEADER => $header,
		));
		$response = curl_exec($ch);

		curl_close($ch);

		if ($response == FALSE) {
			dd(curl_error($ch));
		} else {
			// $responData = json_decode($response, TRUE);
			//get response
			$data = json_decode(file_get_contents('php://input'), true);

			//output response
			echo '<pre>' . $data . '</pre>';
		}
	}
}
