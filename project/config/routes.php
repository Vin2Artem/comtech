<?php
	use \Core\Route;
	
	return [		
		new Route('/', 'login', 'index'),

		new Route('/admin/', 'admin', 'index'),
		new Route('/admin', 'admin', 'index'),
		new Route('/admin/contracts/', 'admin', 'indexContracts'),
		new Route('/admin/contracts', 'admin', 'indexContracts'),
		new Route('/admin/contracts/add/', 'admin', 'addContract'),
		new Route('/admin/contracts/add', 'admin', 'addContract'),

		new Route('/admin/users/', 'admin', 'indexUsers'),
		new Route('/admin/users', 'admin', 'indexUsers'),
		new Route('/admin/users/add/', 'admin', 'addUser'),
		new Route('/admin/users/add', 'admin', 'addUser'),
		new Route('/admin/users/edit/:id/', 'admin', 'editUser'),
		new Route('/admin/users/edit/:id', 'admin', 'editUser'),
		new Route('/admin/users/delete/:id/', 'admin', 'deleteUser'),
		new Route('/admin/users/delete/:id', 'admin', 'deleteUser'),

		new Route('/chats/', 'chats', 'index'),
		new Route('/chats', 'chats', 'index'),
		new Route('/chats/add/', 'chats', 'add'),
		new Route('/chats/add', 'chats', 'add'),
		new Route('/chats/:id/', 'chats', 'show'),
		new Route('/chats/:id', 'chats', 'show'),
		
		new Route('/cloud/', 'cloud', 'index'),
		new Route('/cloud', 'cloud', 'index'),
		new Route('/cloud/add/', 'cloud', 'add'),
		new Route('/cloud/add', 'cloud', 'add'),
		new Route('/cloud/download/:id/', 'cloud', 'download'),
		new Route('/cloud/download/:id', 'cloud', 'download'),
		new Route('/cloud/delete/:id/', 'cloud', 'delete'),
		new Route('/cloud/delete/:id', 'cloud', 'delete'),

		new Route('/login/', 'login', 'index'),
		new Route('/login', 'login', 'index'),

		new Route('/logout/', 'login', 'logout'),
		new Route('/logout', 'login', 'logout'),

		new Route('/news/', 'news', 'index'),
		new Route('/news', 'news', 'index'),
		new Route('/news/add/', 'news', 'addNews'),
		new Route('/news/add', 'news', 'addNews'),
		new Route('/news/edit/:id/', 'news', 'editNews'),
		new Route('/news/edit/:id', 'news', 'editNews'),
		new Route('/news/delete/:id/', 'news', 'deleteNews'),
		new Route('/news/delete/:id', 'news', 'deleteNews'),

		new Route('/payment/', 'payment', 'index'),
		new Route('/payment', 'payment', 'index'),
		
		new Route('/profile/', 'profile', 'index'),
		new Route('/profile', 'profile', 'index'),
		
		new Route('/schedule/', 'schedule', 'index'),
		new Route('/schedule', 'schedule', 'index'),
	];
	
