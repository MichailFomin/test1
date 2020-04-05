<?php
/**
 * Created by PhpStorm.
 * User: NOTEBOOK
 * Date: 04.04.2020
 * Time: 18:09
 */

class Controller_404 extends Controller
{
	function action_index()
	{

		$this->view->generate('404_view.php', 'template_view.php');
	}
}
