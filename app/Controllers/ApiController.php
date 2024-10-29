<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class ApiController extends BaseController
{
    private $key = 'secretKey'; 

    // User login method
    public function login()
    {
        $data = $this->request->getJSON();

        if ($this->request->getMethod() === 'POST') {
            
            if ($data === null) {
                return $this->response->setStatusCode(400)->setJSON(['error' => 'Invalid JSON provided']);
            }

            
            $email = $data->email ?? null;
            $password = $data->password ?? null;

            
            if ($email === null || $password === null) {
                return $this->response->setStatusCode(400)->setJSON(['error' => 'Email and password are required']);
            }

            $userModel = new UserModel();
            $user = $userModel->where('email', $email)->first();

           
            if ($user && password_verify($password, $user['password'])) {
                
                $token = $this->generateJWT($user['id'], $user['email']);

               
                $responseData = [
                    'status' => 'success',
                    'message' => 'Login successful',
                    'slug' => "/dashboard",
                    'token' => $token,
                ];
                return $this->response->setStatusCode(200)->setJSON($responseData);
            } else {
                return $this->response->setStatusCode(401)->setJSON(['error' => 'Invalid credentials']);
            }
        }

        return $this->response->setStatusCode(405)->setJSON(['error' => 'Invalid request method']);
    }

    
    private function generateJWT($userId, $email)
    {
        $payload = [
            'iat' => time(), // Issued at
            'exp' => time() + 3600, // Expiration time (1 hour)
            'user_id' => $userId,
            'email' => $email,
        ];

        return JWT::encode($payload, $this->key, 'HS256'); 
    }

    
    public function register()
    {
        $authHeader = $this->request->getHeader('Authorization');
        $data = $this->request->getJSON();
        
        try {
           
            if ($authHeader) {
                $decoded = $this->verifyJWTToken($authHeader);
                if (!$decoded) {
                    return $this->response->setStatusCode(401)->setJSON(['error' => 'Token is invalid or expired']);
                }
            } else {
                return $this->response->setStatusCode(401)->setJSON(['error' => 'Authorization header not found']);
            }

            $userModel = new UserModel();

            
            if (!$this->validate([
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required|valid_email|is_unique[users.email]',
                'password' => 'required|min_length[6]',
            ])) {
                return $this->response->setStatusCode(400)->setJSON(['errors' => $this->validator->getErrors()]);
            }

           
            $hash = password_hash($data->password, PASSWORD_DEFAULT);

           
            $userModel->insert([
                'first_name' => $data->first_name,
                'last_name' => $data->last_name,
                'email' => $data->email,
                'password' => $hash,
                'role' => 'customer',
            ]);

            return $this->response->setStatusCode(201)->setJSON(['message' => 'User registered successfully']);
            
        } catch (\Exception $e) {
            return $this->response->setStatusCode(500)->setJSON(['error' => 'An error occurred: ' . $e->getMessage()]);
        }
    }

    public function getUsers()
{
    $userModel = new UserModel();
    
    
    $page = $this->request->getGet('page') ?? 1; 
    $perPage = 10; 

    
    $offset = ($page - 1) * $perPage;

    
    $users = $userModel->limit($perPage, $offset)->findAll();

    
    $totalUsers = $userModel->countAll();

    return $this->response->setStatusCode(200)->setJSON([
        'page' => (int) $page,
        'per_page' => $perPage,
        'total_users' => $totalUsers,
        'total_pages' => ceil($totalUsers / $perPage),
        'data' => $users,
    ]);
}



    public function updateUser($id)
    {
        
        $authHeader = $this->request->getHeader('Authorization');
       
        $data = $this->request->getJSON();
        

        if ($authHeader) {
            $decoded = $this->verifyJWTToken($authHeader);
            if (!$decoded) {
                return $this->response->setStatusCode(401)->setJSON(['error' => 'Token is invalid or expired']);
            }
        } else {
            return $this->response->setStatusCode(401)->setJSON(['error' => 'Authorization header not found']);
        }
        
    
        
        $validationRules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|valid_email',
        ];
    
        
        if (isset($data->password) && !empty($data->password)) {
            $validationRules['password'] = 'min_length[6]';
        }
    
        if (!$this->validate($validationRules)) {
            return $this->response->setStatusCode(400)->setJSON(['errors' => $this->validator->getErrors()]);
        }
    
        $userModel = new UserModel();
        $updateData = [
            'first_name' => $data->first_name,
            'last_name' => $data->last_name,
            'email' => $data->email,
        ];
        
        
        
        if (isset($data->password) && !empty($data->password)) {
            $updateData['password'] = password_hash($data->password, PASSWORD_DEFAULT);
        }
    
        
        $userModel->update($id, $updateData);
    
        return $this->response->setStatusCode(200)->setJSON(['message' => 'User updated successfully']);
    }
    



    private function verifyJWTToken($authHeader)
    {
        
        
        $token = str_replace("Authorization: ", "", $authHeader);
        $token = str_replace('Bearer ', '', $token);

        try {
           
            $decoded = JWT::decode($token, new Key($this->key, 'HS256'));
            
            return $decoded;
        } catch (\Exception $e) {
           
            return false; 
        }
    }
    
}
