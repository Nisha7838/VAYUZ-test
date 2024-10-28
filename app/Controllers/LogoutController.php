<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;



class LogoutController extends BaseController
{
    public function index()
    {
        $userModel = new UserModel();
        $user = session()->get('loggedUser');

        if ($user) {
            
            $userModel->update($user['id'], [
                'last_login' => date('Y-m-d H:i:s') 
            ]);
        }

        session()->destroy();
        return redirect()->to('/'); 
    }
}
