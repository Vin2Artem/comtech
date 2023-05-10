<?php
	namespace Project\Controllers;
	use \Core\Controller;
	use Project\Models\Schedule;
	
	class ScheduleController extends Controller
	{
		public function index() {
            session_start();
            if (!isset($_SESSION['user'])) {
                return $this->redirect('/');
            }

            $user = $_SESSION['user'];

			$this->title = 'Расписание';
			
			return $this->render('schedule/index', [
                'user' => $user,
                'schedule' => Schedule::getAll()
            ]);
		}
	}
