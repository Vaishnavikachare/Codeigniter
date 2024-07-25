<?php
namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function register()
    {
        helper(['form', 'url']);
    
        $model = new UserModel();

        if ($this->request->getMethod() == 'POST') {
            $rules = [
                'first_name' => 'required|min_length[2]|max_length[50]',
                'last_name'  => 'required|min_length[2]|max_length[50]',
                'email'      => 'required|valid_email|is_unique[users.email]',
                'password'   => 'required|min_length[8]',
                'user_type'  => 'required|in_list[Employee,Dealer]',
            ];
    
            if ($this->validate($rules)) {
                $data = [
                    'first_name' => $this->request->getVar('first_name'),
                    'last_name'  => $this->request->getVar('last_name'),
                    'email'      => $this->request->getVar('email'),
                    'password'   => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
                    'user_type'  => $this->request->getVar('user_type'),
                ];
    
                log_message('info', 'Attempting to save data: ' . json_encode($data));
    
                if ($model->save($data)) {
                    log_message('info', 'Data saved successfully.');
                    return redirect()->to('/login')->with('success', 'Registration Successful');
                } else {
                    log_message('error', 'Data save failed: ' . json_encode($model->errors()));
                }
            } else {
                log_message('error', 'Validation errors: ' . json_encode($this->validator->getErrors()));
                $data['validation'] = $this->validator;
            }
        }
    
        echo view('register', $data ?? []);
    }
    
    public function login()
    {
        helper(['form', 'url']);
        $model = new UserModel();

        if ($this->request->getMethod() == 'POST') {
            $rules = [
                'email'    => 'required|valid_email',
                'password' => 'required|min_length[8]',
            ];

            if ($this->validate($rules)) {
                $user = $model->where('email', $this->request->getVar('email'))->first();

                if ($user && password_verify($this->request->getVar('password'), $user['password'])) {
                    $this->setUserSession($user);

                    if ($user['user_type'] == 'Dealer' && !$user['city']) {
                        return redirect()->to('/update-profile');
                    } elseif ($user['user_type'] == 'Dealer') {
                        return redirect()->to('/dealer-dashboard');
                    } else {
                        return redirect()->to('/employee-dashboard');
                    }
                } else {
                    $data['error'] = 'Invalid login credentials';
                }
            } else {
                $data['validation'] = $this->validator;
            }
        }

        echo view('login', $data ?? []);
    }


    private function setUserSession($user)
    {
        $data = [
            'id'        => $user['id'],
            'first_name'=> $user['first_name'],
            'last_name' => $user['last_name'],
            'email'     => $user['email'],
            'user_type' => $user['user_type'],
            'isLoggedIn'=> true,
        ];

        session()->set($data);
        return true;
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }

    public function checkEmail()
    {
        $email = $this->request->getVar('email');
        $model = new UserModel();

        $user = $model->where('email', $email)->first();

        if ($user) {
            return $this->response->setJSON(['valid' => false]);
        } else {
            return $this->response->setJSON(['valid' => true]);
        }
    }

}
