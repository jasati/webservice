<?php 

use Jasati\Core\Master_Controller;

/**
* master controller
*/
class Site_Controller extends Master_Controller
{

	public function index()
	{
		$this->view->tema="Site";
	}
}