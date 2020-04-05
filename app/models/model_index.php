<?php
/**
 * Created by PhpStorm.
 * User: NOTEBOOK
 * Date: 04.04.2020
 * Time: 18:57
 */

class Model_Index extends Model
{

	private $host = 'localhost';
	private $dbname = 'mytest2000';
	private $user = 'mytest2000';
	private $password = 'TEst2000';
	private $db;

	function __construct() {
		try {
			$this->db = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->user, $this->password);
			$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->db->exec("set names utf8");
		}
		catch(PDOException $e) {
			echo $e->getMessage();
		}
	}

	public function getJobs($column = null, $sort = null, $page = 1) {
		$jobs_per_page = 3;

		if ($page == 1) {
			$start = 0;
			$offset = strval($jobs_per_page);
		} else {
			$start = strval((($page-1)*$jobs_per_page));
			$offset = strval($jobs_per_page);
		}

		switch($column) {
			case 'name':
				$query = $this->db->query('SELECT * from test_jobs WHERE id > 0 ORDER BY username ' . $sort . ' LIMIT ' . $start . ', ' . $offset);
				$jobs = $query->fetchAll(PDO::FETCH_ASSOC);
				return $jobs;
			break;
			case 'email':
				$query = $this->db->query('SELECT * from test_jobs WHERE id > 0 ORDER BY email ' . $sort . ' LIMIT ' . $start . ', ' . $offset);
				$jobs = $query->fetchAll(PDO::FETCH_ASSOC);
				return $jobs;
				break;
			case 'status':
				$query = $this->db->query('SELECT * from test_jobs WHERE id > 0 ORDER BY status ' . $sort . ' LIMIT ' . $start . ', ' . $offset);
				$jobs = $query->fetchAll(PDO::FETCH_ASSOC);
				return $jobs;
				break;
			default:
				$query = $this->db->query('SELECT * from test_jobs WHERE id > 0 ORDER BY username ' . $sort . ' LIMIT ' . $start . ', ' . $offset);
				$jobs = $query->fetchAll(PDO::FETCH_ASSOC);
				return $jobs;
		}


	}

	public function getCountJobs() {
		$query = $this->db->query('SELECT COUNT(*) from test_jobs WHERE id > 0');
		$cnt = $query->fetchAll(PDO::FETCH_NUM);
		return $cnt[0][0];
	}

	public function addJob($username, $email, $description) {
		$query = $this->db->prepare('INSERT INTO test_jobs (username, email, description) VALUES (?, ?, ?)');
		$result = $query->execute(array($username, $email, $description));
		return $result;

	}

	public function getJobDescription($id) {
		$query = $this->db->query('SELECT description, status from test_jobs WHERE id = ' . $id);
		return $query->fetchAll(PDO::FETCH_ASSOC);
	}

	public function editJob($id, $description, $status) {

		$description_old = $this->getJobDescription($id);

		if ($description_old[0]['description'] == $description) {
			$query = $this->db->prepare('UPDATE test_jobs SET description=?, status=? WHERE id = ?');
			$result = $query->execute(array($description, $status, $id));
		} else {
			$query = $this->db->prepare('UPDATE test_jobs SET description=?, status=?, updated=1 WHERE id = ?');
			$result = $query->execute(array($description, $status, $id));
		}

		return $result;

	}


}
