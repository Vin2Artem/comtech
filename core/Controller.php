<?php
	namespace Core;
	
	class Controller
	{
		protected $layout = 'default';
		protected $title = 'defaultTitle';
		
		protected function render($view, $data = []) {
			return new Page($this->layout, $this->title, $view, $data);
		}

		protected function redirect($url) {
			return header('Location: '.$url);
		}
	}
