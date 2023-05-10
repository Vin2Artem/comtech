<?php
	namespace Project\Controllers;
	use \Core\Controller;
	use Project\Components\Helper;
	use Project\Models\Contract;
	
	class PaymentController extends Controller
	{
		public function index() {
            session_start();
            if (!isset($_SESSION['user'])) {
                return $this->redirect('/');
            }

            $user = $_SESSION['user'];
			
			if($user->role !== "Заказчик") {
				Helper::log("Попытка обращения к странице с графиком оплат. UserInfo = [{$user->getUserInfo()}]", LOG_WARN);
                return $this->redirect(START_PAGE);
			}

			$this->title = 'График оплат';
			
			return $this->render('payment/index', [
                'user' => $user,
                'contracts' => $user->getContracts()
            ]);
		}
	}
