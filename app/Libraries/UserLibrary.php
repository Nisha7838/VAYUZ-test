<?php

namespace App\Libraries;

use App\Models\UserModel;

class UserLibrary
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function getLastFiveUsers()
    {
        return $this->userModel->orderBy('created_at', 'desc')->limit(5)->findAll();
    }

    public function countTotalUsers()
    {
        return $this->userModel->countAll();
    }
}
