<?php session_start();
/*
	This module loads the head, header, footer &/or Social media sections.
*/
class Site extends CI_Controller 
{	
	var $slideshow_location;
	var $service_location;
	var $gallery_location;
	
	function __construct() 
	{
		parent:: __construct();
		
		$this->load->model('site_model');
		
		$this->slideshow_location = base_url().'assets/slideshow/';
		$this->service_location = base_url().'assets/service/';
		$this->gallery_location = base_url().'assets/gallery/';
  	}
	
	/********************************************************************************************
	*																							*
	*					INITIAL STAGE FOR ANY USER IS TO VIEW THE HOME PAGE						*
	*																							*
	********************************************************************************************/
	
	function index()
	{
		//Retrieve active slides
		$data['slides'] = $this->site_model->get_slides();
		$data['services'] = $this->site_model->get_services();
		$data['gallery_services'] = $this->site_model->get_gallery_services();
		$data['gallery'] = $this->site_model->get_gallery();
		$data['contacts'] = $this->site_model->get_contacts();
		
		$data['slideshow_location'] = $this->slideshow_location;
		$data['service_location'] = $this->service_location;
		$data['gallery_location'] = $this->gallery_location;
		
		$v_data['content'] = $this->load->view("home", $data, TRUE);
		
		$this->load->view("includes/templates/general", $v_data);
	}
	
	function gallery()
	{
		/*
			-----------------------------------------------------------------------------------------
			Retrieve active slides
			-----------------------------------------------------------------------------------------
		*/
  		$table = "gallery";
		$where = "gallery_status = 1";
		$items = "*";
		$order = "gallery_id";
		$data['slides'] = $this->administration_model->select_entries_where($table, $where, $items, $order);
		
		$this->load_head();
		$this->load->view("gallery", $data);
		$this->load_foot();
	}
	
	function services()
	{
		$this->load_head();
		$this->load->view("services");
		$this->load_foot();
	}
	
	function order()
	{
		$this->load_head();
		$this->load->view("order");
		$this->load_foot();
	}
	
	/********************************************************************************************
	*																							*
	*									INCLUDE HEADERS & FOOTERS								*
	*																							*
	********************************************************************************************/
	
	function load_head()
	{	
		$table = "contacts";
		$where = "contacts_id = 1";
		$items = "*";
		$order = "contacts_id";
		$data['contacts'] = $this->administration_model->select_entries_where($table, $where, $items, $order);
		
  		$table = "page";
		$where = "page_status = 1";
		$items = "*";
		$order = "page_position, page_name";
		
		$data['pages'] = $this->administration_model->select_entries_where($table, $where, $items, $order);
		
		$this->load->view("includes/head", $data);
		$this->load->view("includes/header",$data);
	}
	
	function load_left_menu()
	{	
		/*
			-----------------------------------------------------------------------------------------
			Retrieve categories
			-----------------------------------------------------------------------------------------
		*/
  		$table = "category";
		$where = "category_status = 1 AND category_parent = 0";
		$items = "*";
		$order = "category_name";
		$data2['categories'] = $this->administration_model->select_entries_where($table, $where, $items, $order);
		$this->load->view("includes/left_menu",$data2);
	}
	
	function load_foot()
	{
		$table = "contacts";
		$where = "contacts_id = 1";
		$items = "*";
		$order = "contacts_id";
		$data['contacts'] = $this->administration_model->select_entries_where($table, $where, $items, $order);
		$this->load->view("includes/footer", $data);
	}
	
	/********************************************************************************************
	*																							*
	*									WEBSITE CONTROL FUNCTIONS								*
	*																							*
	********************************************************************************************/
	function get_contacts()
	{
		$table = "contacts";
		$where = "contacts_id = 1";
		$items = "*";
		$order = "contacts_id";
		$data['contacts'] = $this->administration_model->select_entries_where($table, $where, $items, $order);
		
		return $data['contacts'];
	}
	function get_pages()
	{
  		$table = "page";
		$where = "page_status = 1";
		$items = "*";
		$order = "page_position, page_name";
		
		$data['pages'] = $this->administration_model->select_entries_where($table, $where, $items, $order);
		
		return $data['pages'];
	}
	
	function get_categories()
	{
  		$table = "category";
		$where = "category_status = 1 AND category_parent = 0";
		$items = "*";
		$order = "category_name";
		$data2['categories'] = $this->administration_model->select_entries_where($table, $where, $items, $order);
		
		return $data2['categories'];
	}
	
	function all_products($category_id)
	{
		$table = "product, category, brand_model, brand";
		$items = "brand_model.brand_model_name, brand.brand_name, product_code, product_id, category_name, product_description, product_name, product_selling_price, product_buying_price, product_status, product_balance, product_image_name, product_date";
		$order = "product_name";
		
		if($category_id == 0){
			$where = "product.category_id = category.category_id AND product.brand_model_id = brand_model.brand_model_id AND brand_model.brand_id = brand.brand_id AND product.product_status = 1";
		}
		
		else{
			$where = "product.category_id = category.category_id AND product.brand_model_id = brand_model.brand_model_id AND brand_model.brand_id = brand.brand_id AND product.product_status = 1 AND product.category_id = ".$category_id;
		}
		
		/*
			-----------------------------------------------------------------------------------------
			Pagination
			-----------------------------------------------------------------------------------------
		*/
		$config['base_url'] = site_url().'site/all_products';
		$config['total_rows'] = $this->administration_model->items_count($table, $where);
		$config['uri_segment'] = 3;
		$config['per_page'] = 20;
		$config['full_tag_open'] = '<ul class="pagination pagination-lg">';
		$config['full_tag_close'] = '</ul>';
		
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		
		$config['next_tag_open'] = '<li>';
		$config['next_link'] = '<span class="glyphicon glyphicon-chevron-right"></span>';
		$config['next_tag_close'] = '</li>';
		
		$config['prev_tag_open'] = '<li>';
		$config['prev_link'] = '<span class="glyphicon glyphicon-chevron-left"></span>';
		$config['prev_tag_close'] = '</li>';
		
		$config['cur_tag_open'] = '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$this->pagination->initialize($config);
        $data["links"] = $this->pagination->create_links();
		
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		/*
			-----------------------------------------------------------------------------------------
			Retrieve products
			-----------------------------------------------------------------------------------------
		*/
		
		$data['products'] = $this->administration_model->select_pagination($config["per_page"], $page, $table, $where, $items, $order);
		
		$data['contacts'] = $this->get_contacts();
		$data['pages'] = $this->get_pages();
		$data['categories'] = $this->get_categories();
		
		$this->load->view("products", $data);
	}
	
	function view_product($product_id)
	{
		$table = "product, category, brand_model, brand";
		$items = "product_year, brand_model.brand_model_name, brand.brand_name, product_code, product_id, category_name, product_description, product_name, product_selling_price, product_buying_price, product_status, product_balance, product_image_name, product_date";
		$order = "product_name";
		$where = "product.category_id = category.category_id AND product.brand_model_id = brand_model.brand_model_id AND brand_model.brand_id = brand.brand_id AND product.product_status = 1 AND product.product_id = ".$product_id;
		
		$data['product'] = $this->administration_model->select_entries_where($table, $where, $items, $order);
		
		$items = "*";
		$table = "product_image";
        $where = "(product_id = ".$product_id.")";
		$order = "product_id"; 
		$data['product_images'] = $this->administration_model->select_entries_where($table, $where, $items, $order);
		
		$this->load->view("view_product", $data);
	}
	
	function category($category_id)
	{
		/*
			-----------------------------------------------------------------------------------------
			Retrieve products
			-----------------------------------------------------------------------------------------
		*/
  		$table = "product, category";
		$where = "product.category_id = category.category_id AND product.product_status = 1 AND product.category_id = ".$category_id;
		$items = "product_code, product_id, category_name, product_description, product_name, product_selling_price, product_buying_price, product_status, product_balance, product_image_name, product_date";
		$order = "product_name";
		
		/*
			-----------------------------------------------------------------------------------------
			Pagination
			-----------------------------------------------------------------------------------------
		*/
		$config['base_url'] = site_url().'site/category/'.$category_id;
		$config['total_rows'] = $this->administration_model->items_count($table, $where);
		$config['uri_segment'] = 4;
		$config['per_page'] = 20;
		$config['full_tag_open'] = '<ul class="pagination pagination-lg">';
		$config['full_tag_close'] = '</ul>';
		
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		
		$config['next_tag_open'] = '<li>';
		$config['next_link'] = '<span class="glyphicon glyphicon-chevron-right"></span>';
		$config['next_tag_close'] = '</li>';
		
		$config['prev_tag_open'] = '<li>';
		$config['prev_link'] = '<span class="glyphicon glyphicon-chevron-left"></span>';
		$config['prev_tag_close'] = '</li>';
		
		$config['cur_tag_open'] = '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$this->pagination->initialize($config);
        $data["links"] = $this->pagination->create_links();
		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		/*
			-----------------------------------------------------------------------------------------
			Retrieve products
			-----------------------------------------------------------------------------------------
		*/
		$data['products'] = $this->administration_model->select_pagination($config["per_page"], $page, $table, $where, $items, $order);
		
		$this->load_head();
		$this->load->view("products", $data);
		$this->load_foot();
	}
	
	function contact()
	{
		//get contact
		$table = "contacts";
		$where = "contacts_id = 1";
		$this->db->where($where);
		$contact_query = $this->db->get($table);
		
		/*
			-----------------------------------------------------------------------------------------
			Validate the input 
			-----------------------------------------------------------------------------------------
		*/
		$this->form_validation->set_rules('sender_email', 'Your Email', 'trim|required|valid_email|xss_clean');
		$this->form_validation->set_rules('sender_name', 'Your Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('subject', 'Subject', 'trim|required|xss_clean');
		$this->form_validation->set_rules('message', 'Message', 'trim|required|xss_clean');

		if ($this->form_validation->run())
		{
			if($contacts->num_rows() > 0)
			{
				//retrieve email
				foreach($contacts->result() as $cat)
				{	
					$email = $cat->email;
				}
				
				//send email
				$this->load->library('email');
	
				$this->email->from($this->input->post('sender_email'), $this->input->post('sender_name'));
				$this->email->to($email);
				
				$this->email->subject($this->input->post('subject'));
				$this->email->message($this->input->post('message'));
				
				$this->email->send();
				$this->session->set_userdata('message_success', "Your email has been sent.");
				//echo $this->email->print_debugger();
				redirect('home#contact');
			}
		
			else
			{
				$this->session->set_userdata('message_error', 'An internal error has occured. Could not send your email :-(');
				redirect('home#contact');
			}
		}
		
		else
		{
			$this->session->set_userdata('message_error', validation_errors());
			redirect('home#contact');
		}
	}
	
	function save_order($page)
	{	
		/*
			-----------------------------------------------------------------------------------------
			Validate the input 
			-----------------------------------------------------------------------------------------
		*/
		$this->form_validation->set_rules('names', 'Names', 'trim|required|xss_clean');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email|xss_clean');
		$this->form_validation->set_rules('phone', 'Phone', 'trim|required|xss_clean');
		$this->form_validation->set_rules('service', 'Service', 'trim|required|xss_clean');
		$this->form_validation->set_rules('description', 'Description', 'trim|required|xss_clean');

		/*
			-----------------------------------------------------------------------------------------
			For invalid form items, return to the input form to rectify them
			-----------------------------------------------------------------------------------------
		*/
		if ($this->form_validation->run() == FALSE)
		{
			if($page == 1)
			{
				$this->services();
			}
			else
			{
				$this->order();
			}
		}
		
		else//if the input is valid
		{
			$email = $this->input->post("email");
			$phone = $this->input->post("phone");
			$names = $this->input->post("names");
			$service = $this->input->post("service");
			$description = $this->input->post("description");
			
			$data = array(
				'order_customer'=>$this->input->post('names'),
				'order_service'=>$this->input->post('service'),
				'order_description'=>$this->input->post('description'),
				'order_email'=>$this->input->post('email'),
				'order_phone'=>$this->input->post('phone')
			);
			
			$table = "`order`";
			$this->administration_model->insert($table, $data);
			
			$email_config = Array(
				'protocol'  => 'smtp',
				'smtp_host' => 'smtp.gmail.com',
				'smtp_port' => '465',
				'smtp_user' => 'alvaromasitsa104@gmail.com',
				'smtp_pass' => 'wadpass@',
				'mailtype'  => 'html',
				'starttls'  => true,
				'newline'   => "\r\n"
			);
		 
			$this->load->library('email', $email_config);

			$this->email->from($email, $names);
			$this->email->to('alvaromasitsa104@gmail.com');
			$this->email->cc($email);
			/*$this->email->bcc('them@their-example.com');*/
			
			$this->email->subject($service);
			$this->email->message($description);
			
			$this->email->send();
			echo print_r($this->email->print_debugger(), true);
			/*$_SESSION['email_success'] = "Your order has been placed.";
			
			if($page == 1)
			{
				redirect("site/services");
			}
			else
			{
				redirect("site/order");
			}*/
		}
	}
	
	function text_limit()
	{
		$text = "I am so tired of being here surppressed by all my childish fears. If you have to leave. I wish that";
		
		$limit = 5;
		$pieces = explode(" ", $text);
		$total_words = count($pieces);
		
		if ($total_words > $limit) 
		{
			$return = "<i>";
			$count = 0;
			for($r = 0; $r < $total_words; $r++)
			{
				$count++;
				if(($count%$limit) == 0)
				{
					$return .= $pieces[$r]."</i><br/>";
				}
				else{
					$return .= $pieces[$r]." ";
				}
			}
		}
		
		else{
			$return = "<i>".$text. '</i><br/>';
		}
		echo $return;
	}
	
	public function contact2()
	{
		//get contact
		$table = "contacts";
		$where = "contacts_id = 1";
		$this->db->where($where);
		$contact_query = $this->db->get($table);
		
		if($contact_query->num_rows() > 0)
		{
			//retrieve email
			foreach($contact_query->result() as $cat)
			{	
				$email = $cat->email;
			}
		}
		
		else
		{
			$email = 'chariotstudio@gmail.com';
		}
		
		//Your E-mail
		$your_email = $email;
		
		//Default Subject if 'subject' field not specified
		$default_subject = 'From Contact Form';
		
		//Message if 'name' field not specified
		$name_not_specified = 'No Name';
		
		//Message if 'message' field not specified
		$message_not_specified = 'No Message';
		
		//Message if e-mail sent successfully
		$email_was_sent = 'Thanks, your message was successfully sent';
		
		//Message if e-mail not sent (server not configured)
		$server_not_configured = 'Sorry, mail server not configured';
		
		///////////////////////////
		//Contact Form Processing//
		///////////////////////////
		$errors = array();
		if(isset($_POST['message']) and isset($_POST['name'])) {
			if(!empty($_POST['name']))
				$sender_name  = stripslashes(strip_tags(trim($_POST['name'])));
			
			if(!empty($_POST['message']))
				$message      = stripslashes(strip_tags(trim($_POST['message'])));
			
			if(!empty($_POST['email']))
				$sender_email = stripslashes(strip_tags(trim($_POST['email'])));
			
			if(!empty($_POST['subject']))
				$subject      = stripslashes(strip_tags(trim($_POST['subject'])));
		
		
			//Message if no sender name was specified
			if(empty($sender_name)) {
				$errors[] = $name_not_specified;
			}
		
			//Message if no message was specified
			if(empty($message)) {
				$errors[] = $message_not_specified;
			}
		
			$from = (!empty($sender_email)) ? 'From: '.$sender_email : '';
		
			$subject = (!empty($subject)) ? $subject : $default_subject;
		
			$message = (!empty($message)) ? wordwrap($message, 70) : '';
		
			//sending message if no errors
			if(empty($errors)) {
				if (mail($your_email, $subject, $message, $from)) {
					echo $email_was_sent;
				} else {
					$errors[] = $server_not_configured;
					echo implode('<br>', $errors );
				}
			} else {
				echo implode('<br>', $errors );
			}
		} else {
			// if "name" or "message" vars not send ('name' attribute of contact form input fields was changed)
			echo '"name" and "message" variables were not received by server. Please check "name" attributes for your input fields';
		}
	}
	
	public function place_order()
	{
		//get contact
		$table = "contacts";
		$where = "contacts_id = 1";
		$this->db->where($where);
		$contact_query = $this->db->get($table);
		
		if($contact_query->num_rows() > 0)
		{
			//retrieve email
			foreach($contact_query->result() as $cat)
			{	
				$email = $cat->email;
			}
		}
		
		else
		{
			$email = 'chariotstudio@gmail.com';
		}
		
		//Your E-mail
		$your_email = $email;
		
		//Default Subject if 'subject' field not specified
		$default_subject = 'Photo Order';
		
		//Message if 'name' field not specified
		$name_not_specified = 'No Name';
		
		//Message if 'message' field not specified
		$message_not_specified = 'No Message';
		
		//Message if e-mail sent successfully
		$email_was_sent = 'Thanks, your message was successfully sent';
		
		//Message if e-mail not sent (server not configured)
		$server_not_configured = 'Sorry, mail server not configured';
		
		///////////////////////////
		//Contact Form Processing//
		///////////////////////////
		$errors = array();
		if(isset($_POST['message']) and isset($_POST['name'])) {
			if(!empty($_POST['name']))
				$sender_name  = stripslashes(strip_tags(trim($_POST['name'])));
			
			if(!empty($_POST['message']))
				$message      = stripslashes(strip_tags(trim($_POST['message'])));
			
			if(!empty($_POST['email']))
				$sender_email = stripslashes(strip_tags(trim($_POST['email'])));
			
			if(!empty($_POST['subject']))
				$subject      = stripslashes(strip_tags(trim($_POST['subject'])));
		
		
			//Message if no sender name was specified
			if(empty($sender_name)) {
				$errors[] = $name_not_specified;
			}
		
			//Message if no message was specified
			if(empty($message)) {
				$errors[] = $message_not_specified;
			}
		
			$from = (!empty($sender_email)) ? 'From: '.$sender_email : '';
		
			$subject = (!empty($subject)) ? $subject : $default_subject;
		
			$message = (!empty($message)) ? wordwrap($message, 70) : '';
		
			//sending message if no errors
			if(empty($errors)) {
				if (mail($your_email, $subject, $message, $from)) {
					echo $email_was_sent;
				} else {
					$errors[] = $server_not_configured;
					echo implode('<br>', $errors );
				}
			} else {
				echo implode('<br>', $errors );
			}
		} else {
			// if "name" or "message" vars not send ('name' attribute of contact form input fields was changed)
			echo '"name" and "message" variables were not received by server. Please check "name" attributes for your input fields';
		}
	}
}