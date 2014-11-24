<?php session_start();
/*
	This module loads the head, header, footer &/or Social media sections.
*/
class Site extends Controller {
	
	/********************************************************************************************
	*																							*
	*			BY DEFAULT ALL ACTIONS WARANTY LOADING THE ENCRYPTION CIPHER			 		*
	*																							*
	*																							*
	********************************************************************************************/
	var $slideshow_path;
	var $slideshow_location;
	
	function __construct() 
	{
		/*
			-----------------------------------------------------------------------------------------
			Set the cipher to be used for encryption
			-----------------------------------------------------------------------------------------
		*/
		//$this->encrypt->set_cipher(MCRYPT_RIJNDAEL_128);
		
		/*
			-----------------------------------------------------------------------------------------
			Load the requred model
			-----------------------------------------------------------------------------------------
		*/
		$this->load->model('administration/administration_model');
		$this->slideshow_location = base_url().'assets/slideshow/';
  	}
	
	/********************************************************************************************
	*																							*
	*					INITIAL STAGE FOR ANY USER IS TO VIEW THE HOME PAGE						*
	*																							*
	********************************************************************************************/
	
	function index()
	{
		/*
			-----------------------------------------------------------------------------------------
			Retrieve active slides
			-----------------------------------------------------------------------------------------
		*/
  		$table = "slideshow";
		$where = "slideshow_status = 1";
		$items = "*";
		$order = "slideshow_id";
		$data['slides'] = $this->administration_model->select_entries_where($table, $where, $items, $order);
		
		$data['contacts'] = $this->get_contacts();
		$data['pages'] = $this->get_pages();
		$data['slideshow_location'] = $this->slideshow_location;
		
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
		$table = "contacts";
		$where = "contacts_id = 1";
		$items = "*";
		$order = "contacts_id";
		$data['contacts'] = $this->administration_model->select_entries_where($table, $where, $items, $order);
		
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
			foreach($data['contacts'] as $cat){
				$email = $cat->email;
			}
			$this->load->library('email');

			$this->email->from($this->input->post('sender_email'), $this->input->post('sender_name'));
			$this->email->to($email);
			
			$this->email->subject($this->input->post('subject'));
			$this->email->message($this->input->post('message'));
			
			$this->email->send();
			$_SESSION['contact_success'] = "Your email has been sent.";
			//echo $this->email->print_debugger();
			redirect('site/contact');
		}
		
		else
		{
			$this->load_head();
			$this->load->view("contacts", $data);
			$this->load_foot();
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
}