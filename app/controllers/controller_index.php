<?php
/**
 * Created by PhpStorm.
 * User: NOTEBOOK
 * Date: 04.04.2020
 * Time: 18:13
 */

class Controller_Index extends Controller
{

	function __construct()
	{
		session_start();
		$this->model = new Model_Index();
		$this->view = new View();
		$this->request = new Request();
	}

	function action_index()
	{
		$request_get = $this->request->get;
		$data['session'] = $_SESSION;

		if (isset($request_get['page'])) {
			$page = $request_get['page'];
		} else {
			$page = 1;
		}
		$jobs = $this->model->getJobs($request_get['column'], $request_get['sortAD'], $page);
		$data['get_job'] = $jobs;
		$data['request'] = $request_get;
		$data['server'] = $this->request->server;


		$count_jobs = $this->model->getCountJobs();
		$pages = ceil($count_jobs / 3);
		$data['pages'] = $pages;

		$list_pages = '';

		for ( $i = 1; $i < $pages+1; $i++) {
			$temp = array(
				'column' => $request_get['column'],
				'sortAD' => $request_get['sortAD'],
				'page' => $i,
			);
			$params = http_build_query($temp);
			if ($page == $i) {
				$list_pages .= '<li class="page-item active" aria-current="page">
								  <span class="page-link">
									' . $i . '
									<span class="sr-only">(current)</span>
								  </span>
								</li>';
			} else {
				$list_pages .= '<li class="page-item"><a class="page-link" href="' . $data['server']['HTTP_ORIGIN'] . '?' . $params . '">' . $i . '</a></li>';
			}

		}

		$data['pagination'] = '
			<div class="col-12 ">
         <nav aria-label="Page navigation example">
            <ul class="pagination">
               ' . $list_pages . '
            </ul>
         </nav>
      </div>
		';

		$this->view->generate('index_view.php', 'template_view.php', $data);
	}

	function action_add()
	{
		$request_post = $this->request->post;
		$request_get = $this->request->get;

		if (isset($request_get['page'])) {
			$page = $request_get['page'];
		} else {
			$page = 1;
		}

		if (!filter_var($request_post['create_email'], FILTER_VALIDATE_EMAIL)) {
			$data['error'] = 'E-mail адрес указан неверно.';
		}

		if ($request_post['create_name'] == '') {
			$data['error'] = 'Данные заполненны не корректно!';
		}



		if (!isset($data['error'])) {
			$data['add_job'] = $this->model->addJob($request_post['create_name'], $request_post['create_email'], $request_post['create_text_job']);
			$data['success'] = 'Новая задача успешно добавлена.';
		}
		$data['get_job'] = $this->model->getJobs($request_get['column'], $request_get['sortAD']);
		$data['request'] = $request_post;
		$data['server'] = $this->request->server;

		$count_jobs = $this->model->getCountJobs();
		$data['count_jobs'] = $count_jobs;
		$pages = ceil($count_jobs / 3);
		$data['pages'] = $pages;

		$list_pages = '';

		for ( $i = 1; $i < $pages+1; $i++) {
			$temp = array(
				'column' => $request_get['column'],
				'sortAD' => $request_get['sortAD'],
				'page' => $i,
			);
			$params = http_build_query($temp);
			if ($page == $i) {
				$list_pages .= '<li class="page-item active" aria-current="page">
								  <span class="page-link">
									' . $i . '
									<span class="sr-only">(current)</span>
								  </span>
								</li>';
			} else {
				$list_pages .= '<li class="page-item"><a class="page-link" href="' . $data['server']['HTTP_ORIGIN'] . '?' . $params . '">' . $i . '</a></li>';
			}
		}

		$data['pagination'] = '
			<div class="col-12 ">
         <nav aria-label="Page navigation example">
            <ul class="pagination">
               ' . $list_pages . '
            </ul>
         </nav>
      </div>
		';

		$this->view->generate('index_view.php', 'template_view.php', $data);
	}

	function action_edit() {
		$request_post = $this->request->post;
		$data['server'] = $this->request->server;

		if (isset($_SESSION['user']) && $_SESSION['user'] == 'admin') {
			$data['edit_job'] = $this->model->editJob($request_post['id'], $request_post['edit_description'], $request_post['edit_status']);
			$this->redirect('http://' . $data['server']['SERVER_NAME']);
		} else {

			$data['error'] = 'Авторизуйтесь для выполнения действий.';
			$this->view->generate('login_view.php', 'template_view.php', $data);
		}



	}

	function redirect($link)  //Перенаправляем на страничку
	{
		header("Location: $link");
		exit;
	}



}
