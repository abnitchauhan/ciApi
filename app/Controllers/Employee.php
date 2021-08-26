<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\EmployeeModel;

class Employee extends BaseController
{
	use ResponseTrait;
	 
	 	//Display All Users
		public function index()
		{
			$model = new EmployeeModel();
			$data['employees'] = $model->orderBy('id', 'DESC')->findAll();
			return $this->respond($data);
		}

		// Create User
		public function create()
		{
			$model = new EmployeeModel();
			$data = ['name' => $this->request->getVar('name'),
					 'email' => $this->request->getVar('email'),];
			
			 $model->insert($data); 

				$response = ['status'=> 201,
							'error' => null,
							'message' => 'Employee Created Successfully',
							]; 
				return $this->respondCreated($response); 
		}
		
		// Display Single User 
		public function show($id = null)
		{
			$model = new EmployeeModel();
			$data = $model->where('id', $id)->first();
			if($data)
			{
				return $this->respond($data);
			}
			else{
				return $this->failNotFound('No Employee Found');
			}
		}

		//Update User
		public function update($id = null){
			$model = new EmployeeModel();
			 	$data = [
				'name' => $this->request->getVar('name'),
				'email'  => $this->request->getVar('email'),
			]; 
				$model->update($id, $data);
			$response = [
			  'status'   => 200,	
			  'error'    => null,
			  'messages' => [
				  'success' => 'Employee updated successfully'
			  ]
		  ];
		  return $this->respond($response);
		}

		// Delete User
			public function delete($id = null)
			{
				$model = new EmployeeModel();
				$data  = $model->where('id', $id)->delete($id);
				if($data)
				{
					$model->delete($id);
					$response = ['status' => 200,
								'error' => null,
								'message' =>['Employee Deleted Successfully']
							];
					return $this->respondDeleted($response);
				}
				else
				{
					return $this->failNotFound('Employee Not Found');
				}
			}

}
