<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UserModel;
use Config\Services;

class UserController extends BaseController
{
    
    public function index()
    {
        $userModel = new UserModel();
        
        
        $totalUsers = $userModel->where('role', 'customer')->countAllResults();

       
        $pager = Services::pager();;
        $page = $this->request->getVar('page') ?? 1; 
        $perPage = 5; 

       
        $users = $userModel->where('role', 'customer')
                           ->orderBy('id', 'DESC')
                           ->findAll($perPage, ($page - 1) * $perPage); 

        
        $pager->makeLinks($page, $perPage, $totalUsers); 

        
        $data['users'] = $users;
        $data['pager'] = $pager;

        return view('admin/users/index', $data);
    } 

    public function create()
    {
        return view('admin/users/create'); 
    }

    public function store()
    {
        $userModel = new UserModel();
        
        
        $this->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
        ]);

        $hash = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);

        $userModel->insert([
            'first_name' => $this->request->getPost('first_name'),
            'last_name' => $this->request->getPost('last_name'),
            'email' => $this->request->getPost('email'),
            'password' => $hash,
            'role' => 'customer', 
        ]);

        return redirect()->to('/admin/users')->with('success', 'User created successfully!');
    }

    public function edit($id)
    {
        $userModel = new UserModel();
        $data['user'] = $userModel->find($id); 
        return view('admin/users/edit', $data); 
    }
    public function update($id)
    {
        $userModel = new UserModel();
        
        
        $this->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|valid_email',
        ]);

        
        $data = [
            'first_name' => $this->request->getPost('first_name'),
            'last_name' => $this->request->getPost('last_name'),
            'email' => $this->request->getPost('email'),
        ];

        
        if ($this->request->getPost('password')) {
            $hash = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
            $data['password'] = $hash;
        }
       
        $userModel->update($id, $data); 
        return redirect()->to('/admin/users')->with('success', 'User updated successfully!');
    }
}
