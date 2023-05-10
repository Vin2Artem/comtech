<?php
	namespace Core;
	use Project\Components\Helper;
	
	error_reporting(E_ALL);
	ini_set('display_errors', 'on');
	ini_set('session.gc_maxlifetime', 604800);
	
	require_once $_SERVER['DOCUMENT_ROOT'] . '/project/config/connection.php';
	
	spl_autoload_register(function($class) {
		preg_match('#(.+)\\\\(.+?)$#', $class, $match);
		
		$nameSpace = str_replace('\\', DIRECTORY_SEPARATOR, strtolower($match[1]));
		$className = $match[2];
		
		$path = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . $nameSpace . DIRECTORY_SEPARATOR . $className . '.php';
		
		if (file_exists($path)) {
			require_once $path;
			
			if (class_exists($class, false)) {
				return true;
			} else {
				throw new \Exception("Класс $class не найден в файле $path. Проверить правильность написания имени класса внутри указанного файла.");
			}
		} else {
			throw new \Exception("Для класса $class не найден файл $path. Проверить наличие файла по указанному пути. Пространство имен класса должно совпадать с тем, которое пытается найти фреймворк для данного класса. Например, создан класс модели, но не применён use.");
		}
	});
	require_once $_SERVER['DOCUMENT_ROOT'] . '/project/config/startPage.php';
	
	Helper::init();
	
	$routes = require $_SERVER['DOCUMENT_ROOT'] . '/project/config/routes.php';
	
	$track = ( new Router )      -> getTrack($routes, $_SERVER['REQUEST_URI']);
	$page  = ( new Dispatcher )  -> getPage($track);
	
	echo (new View) -> render($page);
