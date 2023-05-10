<?php
	namespace Project\Controllers;
	use \Core\Controller;
	use Project\Models\Contract;
	
	class ProfileController extends Controller
	{
		public function index() {
            session_start();
            if (!isset($_SESSION['user'])) {
                return $this->redirect('/');
            }

            $user = $_SESSION['user'];

			$this->title = 'Профиль';
			
			return $this->render('profile/index', [
                'user' => $user,
            ]);
		}

		public function edit() {
			// #
		}
	}
