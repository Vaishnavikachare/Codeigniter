<?php
namespace App\Controllers;

use App\Models\UserModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $data = [];
        echo view('dashboard', $data);
    }

    public function updateProfile()
    {
        helper(['form', 'url']);
        $model = new UserModel();

        if ($this->request->getMethod() == 'POST') {
            $rules = [
                'city'  => 'required|min_length[2]|max_length[50]',
                'state' => 'required|min_length[2]|max_length[50]',
                'zip'   => 'required|min_length[5]|max_length[10]',
            ];

            if ($this->validate($rules)) {
                $data = [
                    'city'  => $this->request->getVar('city'),
                    'state' => $this->request->getVar('state'),
                    'zip'   => $this->request->getVar('zip'),
                ];
                $model->update(session()->get('id'), $data);
                return redirect()->to('/dashboard')->with('success', 'Profile updated');
            } else {
                $data['validation'] = $this->validator;
            }
        }

        echo view('update_profile', $data ?? []);
    }

    public function dealers()
    {
        $model = new UserModel();
        $data['dealers'] = $model->where('user_type', 'Dealer')->paginate(10);
        $data['pager'] = $model->pager;

        echo view('dealers', $data);
    }

    public function editDealer($id)
    {
        helper(['form', 'url']);
        $model = new UserModel();

        if ($this->request->getMethod() == 'post') {
            $rules = [
                'city'  => 'required|min_length[2]|max_length[50]',
                'state' => 'required|min_length[2]|max_length[50]',
                'zip'   => 'required|min_length[5]|max_length[10]',
            ];

            if ($this->validate($rules)) {
                $data = [
                    'city'  => $this->request->getVar('city'),
                    'state' => $this->request->getVar('state'),
                    'zip'   => $this->request->getVar('zip'),
                ];
                $model->update($id, $data);
                return redirect()->to('/dealers')->with('success', 'Dealer updated');
            } else {
                $data['validation'] = $this->validator;
            }
        }

        $data['dealer'] = $model->find($id);
        echo view('edit_dealer', $data);
    }

    public function employeeDashboard()
    {
        $model = new UserModel();
        
        // Fetch dealers with pagination
        $data['dealers'] = $model->where('user_type', 'Dealer')->paginate(10);
        $data['pager'] = $model->pager;

        return view('employee_dashboard', $data);
    }

    public function dealerDashboard()
    {
        $session = session();
        $model = new UserModel();
        $dealer = $model->find($session->get('id'));

        $data = [
            'dealer' => $dealer,
        ];

        return view('dealer_dashboard', $data);
    }

}

