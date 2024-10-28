<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class CustomerFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Check if the user is logged in and has customer role
        $session = session();
        if (!$session->has('role') || $session->get('role') !== 'customer') {
            // Redirect to login or some other page
            return redirect()->to('/')->with('error', 'You must be a customer to access this page.');
        }
    }

}
