<?php
/**
 * Created by PhpStorm.
 * User: NOTEBOOK
 * Date: 04.04.2020
 * Time: 18:02
 */

class Controller {

	public $model;
	public $view;

	function __construct()
	{
		$this->view = new View();
	}

	# действие, вызываемое по умолчанию
	function action_index()
	{
	}
}
