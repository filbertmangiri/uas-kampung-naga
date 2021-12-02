<?php

namespace Config;

use App\Filters\Auth\Admin;
use App\Filters\Auth\LoggedIn;
use App\Filters\Auth\LoggedOut;
use App\Filters\Auth\Management;
use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\Honeypot;

class Filters extends BaseConfig
{
	/**
	 * Configures aliases for Filter classes to
	 * make reading things nicer and simpler.
	 *
	 * @var array
	 */
	public $aliases = [
		'csrf'			=> CSRF::class,
		'toolbar'		=> DebugToolbar::class,
		'honeypot'		=> Honeypot::class,
		'logged-in'		=> LoggedIn::class,
		'logged-out'	=> LoggedOut::class,
		'admin'			=> Admin::class,
		'management'	=> [
			LoggedIn::class,
			Management::class
		]
	];

	/**
	 * List of filter aliases that are always
	 * applied before and after every request.
	 *
	 * @var array
	 */
	public $globals = [
		'before' => [
			// 'honeypot',
			// 'csrf',
			// 'logged-in' => [
			//     'except' => [
			//         '',
			//         'login'
			//     ]
			// ],
			// 'logged-in:not' => [
			//     'except'
			// ]
		],
		'after' => [
			'toolbar',
			// 'honeypot',
		],
	];

	/**
	 * List of filter aliases that works on a
	 * particular HTTP method (GET, POST, etc.).
	 *
	 * Example:
	 * 'post' => ['csrf', 'throttle']
	 *
	 * @var array
	 */
	public $methods = [];

	/**
	 * List of filter aliases that should run on any
	 * before or after URI patterns.
	 *
	 * Example:
	 * 'isLoggedIn' => ['before' => ['account/*', 'profiles/*']]
	 *
	 * @var array
	 */
	public $filters = [
		// 'logged-in' => [
		//     'before' => [
		//         'logout',
		//         'dashboard'
		//     ]
		// ],
		// 'logged-in:not' => [
		//     'before' => [
		//         'login',
		//         'register'
		//     ]
		// ]
	];
}
