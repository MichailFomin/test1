<?php
/**
 * Created by PhpStorm.
 * User: NOTEBOOK
 * Date: 04.04.2020
 * Time: 18:02
 */

class View
{
	//public $template_view; // здесь можно указать общий вид по умолчанию.

	function generate($content_view, $template_view, $data = null)
	{
		/*
		if(is_array($data)) {
			// преобразуем элементы массива в переменные
			extract($data);
		}
		*/

		include 'app/views/'.$template_view;
	}
}
