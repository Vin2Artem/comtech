<?php
	namespace Project\Controllers;
	use \Core\Controller;
	use Project\Components\Helper;
	use Project\Models\Chat;
	use Project\Models\Message;
	
	class ChatsController extends Controller
	{
		public function index() {
            session_start();
            if (!isset($_SESSION['user'])) {
                return $this->redirect('/');
            }

            $user = $_SESSION['user'];

			$this->title = 'Чаты';
			
			return $this->render('chats/index', [
                'user' => $user,
				'chats' => Chat::getAllByUser($user->id)
            ]);
		}

		public function show(array $params) {
            session_start();
            if (!isset($_SESSION['user'])) {
                return $this->redirect('/');
            }

            $chat = $_SESSION['chat'] = Chat::getById($params['id']);
            $user = $_SESSION['user'];

			if (gettype($chat) === "string") {
				Helper::log("$chat (id = {$params['id']}). UserInfo = [{$user->getUserInfo()}]", LOG_WARN);
                return $this->redirect("/chats");
			}

			if (!$chat->isAvailableForUser($user->id)) {
				Helper::log("Попытка обращения к недоступному чату (id = {$params['id']}). UserInfo = [{$user->getUserInfo()}]", LOG_WARN);
                return $this->redirect("/chats");
			}

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                return $this->sendMessange($params);
            }

			$this->title = 'Чаты';
			
			return $this->render('chats/show', [
                'user' => $user,
				'msgs' => $chat->getMessages()
            ]);
		}

		public function sendMessange(array $params) {
			$chat = $_SESSION['chat'];
			$user = $_SESSION['user'];
			$errors = '';
            if (!isset($chat) || $chat === '') {
                $errors .= "Проблема с чатом\n";
            }
            if (!isset($_POST['text']) || trim($_POST['text']) === '') {
                $errors .= "Сообщение не введено\n";
            }
            if ($errors !== '') {
				$this->layout = "empty";
				return $this->render('error/error', ['msg' => trim($errors)]);
            }
			$text = $_POST['text'];
			$file = $_POST['file'];
			$msg = $_POST['msg'];

			$temp = $chat->sendMessage($user, $text, $file, $msg);
			if (gettype($temp) === "string") {
				echo $temp;
			}
			
			return $this->redirect('/chats/' . $params['id']);
		}
	}
