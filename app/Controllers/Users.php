<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class Users extends Controller
{
    public function register()
    {
        helper(['form']);
        echo view('templates/header');
        echo view('register');
    }

    public function registerSubmit()
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
            'user_type' => 'required|in_list[Employee,Dealer]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON(['errors' => $validation->getErrors()]);
        }

        $userModel = new UserModel();
        $data = [
            'first_name' => $this->request->getPost('first_name'),
            'last_name' => $this->request->getPost('last_name'),
            'email' => $this->request->getPost('email'),
            'password' => $this->request->getPost('password'),
            'user_type' => $this->request->getPost('user_type')
        ];
        $userModel->save($data);
        
        return $this->response->setJSON(['success' => 'User registered successfully.']);
    }

    public function login()
    {
        helper(['form']);
        echo view('templates/header');
        echo view('login');
    }

    public function loginSubmit()
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'email' => 'required|valid_email',
            'password' => 'required'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON(['errors' => $validation->getErrors()]);
        }

        $userModel = new UserModel();
        $user = $userModel->where('email', $this->request->getPost('email'))->first();

        if (!$user || !password_verify($this->request->getPost('password'), $user['password'])) {
            return $this->response->setJSON(['errors' => ['login' => 'Invalid login credentials.']]);
        }

        session()->set('loggedInUser', $user);
        return $this->response->setJSON(['success' => 'Login successful.']);
    }

    public function dashboard()
    {
        // Ensure the user is logged in
        if (!session()->has('loggedInUser')) {
            return redirect()->to('/login');
        }

        $user = session()->get('loggedInUser');
        echo view('templates/header');
        echo view('dashboard', ['user' => $user]);
    }

    public function dealer_profile()
    {
        // Ensure the user is logged in and is a Dealer
        if (!session()->has('loggedInUser') || session()->get('loggedInUser')['user_type'] != 'Dealer') {
            return redirect()->to('/login');
        }

        helper(['form']);
        echo view('templates/header');
        echo view('dealer_profile');
    }

    public function updateDealerProfile()
    {
        // Ensure the user is logged in and is a Dealer
        if (!session()->has('loggedInUser') || session()->get('loggedInUser')['user_type'] != 'Dealer') {
            return redirect()->to('/login');
        }

        $validation = \Config\Services::validation();
        $validation->setRules([
            'city' => 'required',
            'state' => 'required',
            'zip' => 'required'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON(['errors' => $validation->getErrors()]);
        }

        $userModel = new UserModel();
        $user = session()->get('loggedInUser');
        $data = [
            'city' => $this->request->getPost('city'),
            'state' => $this->request->getPost('state'),
            'zip' => $this->request->getPost('zip')
        ];
        $userModel->update($user['id'], $data);

        // Update session data
        $user = array_merge($user, $data);
        session()->set('loggedInUser', $user);

        return $this->response->setJSON(['success' => 'Profile updated successfully.']);
    }

    public function edit_dealer($id)
    {
        // Ensure the user is logged in
        if (!session()->has('loggedInUser')) {
            return redirect()->to('/login');
        }

        $userModel = new UserModel();
        $dealer = $userModel->find($id);

        if (!$dealer) {
            return redirect()->to('/dashboard');
        }

        helper(['form']);
        echo view('templates/header');
        echo view('edit_dealer', ['dealer' => $dealer]);
    }

    public function updateDealer($id)
    {
        // Ensure the user is logged in
        if (!session()->has('loggedInUser')) {
            return redirect()->to('/login');
        }

        $validation = \Config\Services::validation();
        $validation->setRules([
            'city' => 'required',
            'state' => 'required',
            'zip' => 'required'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON(['errors' => $validation->getErrors()]);
        }

        $userModel = new UserModel();
        $data = [
            'city' => $this->request->getPost('city'),
            'state' => $this->request->getPost('state'),
            'zip' => $this->request->getPost('zip')
        ];
        $userModel->update($id, $data);

        return $this->response->setJSON(['success' => 'Dealer updated successfully.']);
    }

    public function search_dealer()
    {
        // Ensure the user is logged in and is an Employee
        if (!session()->has('loggedInUser') || session()->get('loggedInUser')['user_type'] != 'Employee') {
            return redirect()->to('/login');
        }

        $userModel = new UserModel();
        $dealers = $userModel->where('user_type', 'Dealer')->like('zip', $this->request->getPost('zip'))->findAll();

        echo view('templates/header');
        echo view('dashboard', ['dealers' => $dealers]);
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
