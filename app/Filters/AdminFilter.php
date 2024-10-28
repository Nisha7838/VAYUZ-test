<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AdminFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Check if the user is logged in and has admin role
        $session = session();
        if (!$session->has('role') || $session->get('role') !== 'admin') {
            // Redirect to login or some other page
            return redirect()->to('/')->with('error', 'You must be an admin to access this page.');
        }
    }

}
