<?php
/**
 * Created by PhpStorm.
 * User: NOTEBOOK
 * Date: 05.04.2020
 * Time: 15:45
 */

class Model_Login extends Model
{
	public function get_admin_data()
	{
		return array(
				'login' => 'admin',
				'password' => '123',
		);
	}
}
