<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\UserLibrary;
use Config\AppConfig;

class DashboardController extends BaseController
{

    public function __construct() {
        helper('common'); // Load your custom helper
    }
    public function index()
    {

        $user = session()->get('loggedUser');
        
        if (!$user || !isset($user['role'])) {
            return redirect()->to('/')->with('error', 'You need to login first.');
        }

        if ($user['role'] === 'admin') {
            return $this->adminDashboard();
        } else {
            return $this->customerDashboard();
        }
    }

    public function adminDashboard()
    {
        $userLibrary = new UserLibrary();
        
        $totalUsers = $userLibrary->countTotalUsers();
        $recentUsers = $userLibrary->getLastFiveUsers();
        $config = new AppConfig();
     
               
        return view('admin/dashboard', [
            'totalUsers' => $totalUsers,
            'recentUsers' => $recentUsers,
            'lastLogin' => session()->get('loggedUser')['last_login'],
            "project_name" =>$config->appName,
        ]);
    }

    public function customerDashboard()
    {
        return view('customer/dashboard', [
            'lastLogin' => (session()->get('loggedUser')['last_login'])?session()->get('loggedUser')['last_login']:date('Y-m-d H:i:s'),
        ]);
    }
}
