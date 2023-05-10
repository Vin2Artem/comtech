<?php
namespace Project\Controllers;

use \Core\Controller;
use Project\Components\Helper;
use Project\Models\Cloud;

class CloudController extends Controller
{
	public function index() {
		session_start();
		if (!isset($_SESSION['user'])) {
			return $this->redirect('/');
		}

		$user = $_SESSION['user'];

		if ($user->role !== "Обучающийся") {
			Helper::log("Попытка обращения к облаку. UserInfo = [{$user->getUserInfo()}]", LOG_WARN);
			return $this->redirect(START_PAGE);
		}

		$this->title = 'Облако';

		return $this->render('cloud/index', [
			'user' => $user,
			'files' => $user->getFiles()
		]);
	}
	public function add() {
		session_start();
		if (!isset($_SESSION['user'])) {
			return $this->redirect('/');
		}

		$user = $_SESSION['user'];

		if ($user->role !== "Обучающийся") {
			Helper::log("Попытка обращения к облаку. UserInfo = [{$user->getUserInfo()}]", LOG_WARN);
			return $this->redirect(START_PAGE);
		}

		if(!isset($_FILES['file'])) {
            $this->layout = "empty";
            return $this->render('error/error', ['msg' => "Файл отсутствует"]);
		}

		$msg = $user->uploadFile($_FILES['file']);

        if (gettype($msg) === 'string') {
            $this->layout = "empty";
            return $this->render('error/error', ['msg' => $msg]);
        }

		return $this->redirect('/cloud');
	}

	public function download(array $params) {
		session_start();
		if (!isset($_SESSION['user'])) {
			return $this->redirect('/');
		}

		$user = $_SESSION['user'];

		if ($user->role !== "Обучающийся") {
			Helper::log("Попытка обращения к облаку. UserInfo = [{$user->getUserInfo()}]", LOG_WARN);
			return $this->redirect(START_PAGE);
		}

		if ($user->getFile($params["id"]) === false) {
			// # change to redirect: file does not exist
			return $this->redirect('/cloud');
		}

		// no return - getFile prints
	}

	public function delete(array $params) {
		session_start();
		if (!isset($_SESSION['user'])) {
			return $this->redirect('/');
		}

		$user = $_SESSION['user'];

		if ($user->role !== "Обучающийся") {
			Helper::log("Попытка обращения к облаку. UserInfo = [{$user->getUserInfo()}]", LOG_WARN);
			return $this->redirect(START_PAGE);
		}

		$msg = $user->deleteFile($params["id"]);
		if (gettype($msg) === "string") {
            $this->layout = "empty";
            return $this->render('error/error', ['msg' => $msg]);
		}

		return $this->redirect('/cloud');
	}
}