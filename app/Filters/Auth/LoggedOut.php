<?php

namespace App\Filters\Auth;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class LoggedOut implements FilterInterface
{
	public function before(RequestInterface $request, $arguments = null)
	{
		if (session('acc_logged_in') === true) {
			return redirect()->to(base_url());
		}
	}

	public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
	{
		// Do something here
	}
}
