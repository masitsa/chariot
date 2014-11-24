<?php session_start();

class Login extends Controller {
	
	/********************************************************************************************
	*																							*
	*			BY DEFAULT ALL ACTIONS WARANTY A CHECK TO SEE WHETHER THE ADMINISTRATOR'S 		*
	*										SESSION IS ACTIVE									*
	*																							*
	********************************************************************************************/
	
	function __construct() 
	{
		/*
			-----------------------------------------------------------------------------------------
			Load the requred model
			-----------------------------------------------------------------------------------------
		*/
		$this->load->model('administration_model');
		
		/*
			-----------------------------------------------------------------------------------------
			Set the cipher to be used for encryption
			-----------------------------------------------------------------------------------------
		*/
		//$this->encrypt->set_cipher(MCRYPT_RIJNDAEL_128);
  	}
	
	/********************************************************************************************
	*																							*
	*									SESSION CONTROL FUNCTIONS								*
	*																							*
	********************************************************************************************/
	
	function load_head()
	{
		
		$table = "contacts";
		$where = "contacts_id = 1";
		$items = "*";
		$order = "contacts_id";
		$data3['contacts'] = $this->administration_model->select_entries_where($table, $where, $items, $order);
		
		$this->load->view("includes/head", $data3);
		$this->load->view("includes/header");
	}
	
	function load_foot()
	{
		$this->load->view("includes/footer");
	}
	
	function logout()
	{
		/*
			-----------------------------------------------------------------------------------------
			Destroy the current session
			-----------------------------------------------------------------------------------------
		*/
		$this->session->sess_destroy();
		
		/*
			-----------------------------------------------------------------------------------------
			Request user to login
			-----------------------------------------------------------------------------------------
		*/
		$this->login_admin();
	}
	
	function login_admin()
	{
		/*
			-----------------------------------------------------------------------------------------
			Validate the input 
			-----------------------------------------------------------------------------------------
		*/
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|exists[admin.admin_email]|xss_clean');//First Name is required
		$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');//Last Name is required
		$this->form_validation->set_message("exists", "The email provided has not been registered.");

		if ($this->form_validation->run())
		{
			/*
				-----------------------------------------------------------------------------------------
				Retrieve login details from input form
				-----------------------------------------------------------------------------------------
			*/
			$email = $this->input->post("email");
			$password = hash('sha512', $this->input->post("password"));
		
			/*
				-----------------------------------------------------------------------------------------
				Check to see if the user is an administrator
				-----------------------------------------------------------------------------------------
			*/
			$table = "admin";
        	$where = "(admin_status = 1) AND (admin_email = '".$email."') AND (admin_password = '".$password."')";
        	$items = "*";
        	$order = "admin_fname";
			
			$result = $this->administration_model->select_entries_where($table, $where, $items, $order);
		
			/*
				-----------------------------------------------------------------------------------------
				If administrator exists, forward to requested destination page
				-----------------------------------------------------------------------------------------
			*/
			if(count($result) > 0){
				/*
					-----------------------------------------------------------------------------------------
					Retrieve the administrator's first name
					-----------------------------------------------------------------------------------------
				*/
				foreach ($result as $res){
					$first_name = $res->admin_fname;
					$user_id = $res->admin_id;
				}
			
				/*
					-----------------------------------------------------------------------------------------
					Create the user's session
					-----------------------------------------------------------------------------------------
				*/
				$newdata = array(
					'user_id'  => $user_id,
					'user_type'  => 1,
					'user'  => $first_name,
					'login_state' => TRUE
				);
				$this->session->set_userdata($newdata);
				
				redirect("administration/list_products/2/3");
			}
		
			/*
				-----------------------------------------------------------------------------------------
				Otherwise ask them to login again
				-----------------------------------------------------------------------------------------
			*/
			else{
				$_SESSION['error'] = "Incorrect details. Please try again";
				redirect("administration/login/login_admin");
			}
		}
		
		else
		{
			/*
				-----------------------------------------------------------------------------------------
				Request user to login
				-----------------------------------------------------------------------------------------
			*/
			$this->load_head();
			$this->load->view("login/login_user");
			$this->load_foot();
		}
	}
}