<?php
	namespace Project\Controllers;
	use \Core\Controller;
	use Project\Components\Helper;
	use Project\Models\News;
	
	class NewsController extends Controller
	{
		public function index() {
            session_start();
            if (!isset($_SESSION['user'])) {
                return $this->redirect('/');
            }

            $user = $_SESSION['user'];

			$this->title = 'Новости';
			
			return $this->render('news/index', [
                'user' => $user,
				'news' => News::getAll()
            ]);
		}
		
		public function addNews(array $params) {
            session_start();
            if (!isset($_SESSION['user'])) {
                return $this->redirect('/');
            }

            $user = $_SESSION['user'];
			
			if($user->role !== "Менеджер") {
				Helper::log("Попытка обращения к странице добавления новости. UserInfo = [{$user->getUserInfo()}]", LOG_WARN);
                return $this->redirect(START_PAGE);
			}

			$this->title = 'Добавление новости';
			
			return $this->render('news/add', [
                'user' => $user,
            ]);
		}
		
		public function editNews(array $params) {
            session_start();
            if (!isset($_SESSION['user'])) {
                return $this->redirect('/');
            }

            $user = $_SESSION['user'];
			
			if($user->role !== "Менеджер") {
				Helper::log("Попытка обращения к странице изменения новости. UserInfo = [{$user->getUserInfo()}]", LOG_WARN);
                return $this->redirect(START_PAGE);
			}

			$this->title = 'Редактирование новости';
			
			return $this->render('news/edit', [
                'user' => $user,
                'news' => News::getById($params['id']),
            ]);
		}
		
		public function deleteNews(array $params) {
            session_start();
            if (!isset($_SESSION['user'])) {
                return $this->redirect('/');
            }

            $user = $_SESSION['user'];
			
			if($user->role !== "Менеджер") {
				Helper::log("Попытка обращения к странице удаления новости. UserInfo = [{$user->getUserInfo()}]", LOG_WARN);
                return $this->redirect(START_PAGE);
			}

			$this->title = 'Удаление новости';
			
			return $this->render('news/delete', [
                'user' => $user,
                'news' => News::getById($params['id']),
            ]);
		}
	}
