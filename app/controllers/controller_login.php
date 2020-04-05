<?php
/**
 * Created by PhpStorm.
 * User: NOTEBOOK
 * Date: 05.04.2020
 * Time: 15:42
 */

class Controller_Login extends Controller
{

	function __construct()
	{
		session_start();
		$this->model = new Model_Login();
		$this->view = new View();
		$this->request = new Request();
	}

	function action_index()
	{

		$request_post = $this->request->post;
		$data['request'] = $request_post;
		$this->view->generate('login_view.php', 'template_view.php', $data);
	}

	function action_auth()
	{

		$request_post = $this->request->post;
		$data['server'] = $this->request->server;
		$is_admin = $this->is_admin($request_post['username'], $request_post['password']);

		$data['request'] = $request_post;
		$data['is_admin'] = $is_admin;
		if ($is_admin) {
			$this->redirect($data['server']['HTTP_ORIGIN']);

		} else {
			$data['error'] = 'Вы ввели неправильные данные для авторизации.';
			$this->view->generate('login_view.php', 'template_view.php', $data);
		}

	}

	function is_admin($login, $password) {
		$admin_data = $this->model->get_admin_data();

		if ($admin_data['login'] === $login && $admin_data['password'] === $password) {

			$_SESSION['username'] = $login;
			$_SESSION['password'] = $password;
			$_SESSION['user'] = 'admin';
			return true;
		} else {
			return false;
		}
	}

	function action_logout()
	{
		unset($_SESSION['username']);
		unset($_SESSION['password']);
		unset($_SESSION['user']);
		$data['server'] = $this->request->server;

		$this->redirect('http://' . $data['server']['SERVER_NAME']);

	}

	function redirect($link)  //Перенаправляем на страничку
	{
		header("Location: $link");
		exit;
	}

}
