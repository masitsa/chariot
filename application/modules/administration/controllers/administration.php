<?php session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

class Administration extends Controller {
	
	var $gallery_path;
	var $gallery_path2;
	var $gallery_path3;
	var $gallery_path4;
	var $gallery_path5;
	var $gallery_path6;
	var $slideshow_path;
	var $slideshow_location;
	
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
		$this->load->model('file_model');
		
		/*
			-----------------------------------------------------------------------------------------
			Set the cipher to be used for encryption
			-----------------------------------------------------------------------------------------
		*/
		//$this->encrypt->set_cipher(MCRYPT_RIJNDAEL_128);
			
		/*
			-----------------------------------------------------------------------------------------
			Authenticate the user
			-----------------------------------------------------------------------------------------
		*/
		if ( $this->session->userdata('login_state') != TRUE ) {
						
			redirect("administration/login/login_admin");
    	}
			
		/*
			-----------------------------------------------------------------------------------------
			Image location
			-----------------------------------------------------------------------------------------
		*/
		$this->gallery_path = realpath(APPPATH . '../assets/products');
		$this->gallery_path2 = realpath(APPPATH . '../assets/categories');
		$this->gallery_path3 = realpath(APPPATH . '../assets/slideshow');
		$this->gallery_path4 = realpath(APPPATH . '../assets/logo');
		$this->gallery_path5 = realpath(APPPATH . '../assets/brand');
		$this->gallery_path6 = realpath(APPPATH . '../assets/gallery');
		
        $this->load->library('image_lib');
		
		//path to image directory
		$this->slideshow_path = realpath(APPPATH . '../assets/slideshow');
		$this->slideshow_location = base_url().'assets/slideshow/';
  	}
	
	public function index()
	{
		redirect('administration/login/login_admin');
	}
	
	/********************************************************************************************
	*																							*
	*									INCLUDE HEADERS & FOOTERS								*
	*																							*
	********************************************************************************************/
	
	function select_navigation()
	{
  		$table = "navigation";
		$where = "navigation.navigation_id > 0";
		$items = "navigation_id, navigation_name, navigation_url";
		$order = "navigation_name";
		
		$result = $this->administration_model->select_entries_where($table, $where, $items, $order);
		
		return $result;
	}
	
	function select_sub_navigation()
	{
  		$table = "sub_navigation";
		$where = "sub_navigation.navigation_id = ".$_SESSION['navigation_id'];
		$items = "sub_navigation_id, sub_navigation_name, sub_navigation_url";
		$order = "sub_navigation_id";
		
		$result = $this->administration_model->select_entries_where($table, $where, $items, $order);
		
		return $result;
	}
	
	function load_head()
	{
		$data2['navigation'] = $this->select_navigation();
		$data['navigation'] = $this->select_sub_navigation();
		
		$table = "contacts";
		$where = "contacts_id = 1";
		$items = "*";
		$order = "contacts_id";
		$data3['contacts'] = $this->administration_model->select_entries_where($table, $where, $items, $order);
		
		$this->load->view("includes/head", $data3);
		$this->load->view("includes/login_head", $data2);
		$this->load->view("includes/header");
		$this->load->view('includes/nav',$data);
	}
	
	function load_foot()
	{
		$this->load->view("includes/footer");
	}
	
	function load_login()
	{
		$this->load->view("includes/login_head");
	}
	
	function do_upload($gallery_path) 
	{
		/*
			-----------------------------------------------------------------------------------------
			Upload an image
			-----------------------------------------------------------------------------------------
		*/
		$config = array(
			'allowed_types' => 'JPG|JPEG|jpg|jpeg|gif|png',
			'upload_path' => $gallery_path,
			'quality' => "100%",
			'file_name' => "image_".date("Y")."_".date("m")."_".date("d")."_".date("H")."_".date("i")."_".date("s"),
			'max_size' => 2000
		);
		
		$this->load->library('upload', $config);
		if($this->upload->do_upload() == FALSE)
		{
			return "FALSE";
		}
		else{
			$image_data = $this->upload->data();
			return $image_data;
		}
	}
	
	function create_thumb($path, $gallery_path, $file_name)
	{
		/*
			-----------------------------------------------------------------------------------------
			Create a thumbnail
			-----------------------------------------------------------------------------------------
		*/
		$resize_conf = array(
			'source_image'  => $path,
			'new_image'     => $path.'thumbs/'.$file_name,
			'create_thumb'  => FALSE,
			'width'         => 80,
			'height'        => 60,
			'maintain_ratio' => true,
		);
		
		 $this->image_lib->initialize($resize_conf);
		 
		if ( ! $this->image_lib->resize())
		{
			return $this->image_lib->display_errors();
		}
		
		else
		{
			return TRUE;
		}
	}
	
	function resize_image($path, $gallery_path, $file_name)
	{
		$resize_conf = array(
			'source_image'  => $path,
			'new_image'     => $path.'images/'.$file_name,
			'create_thumb'  => FALSE,
			'width' => 460,
			'height' => 345,
			'maintain_ratio' => true,
		);
		
		$this->image_lib->initialize($resize_conf);
		 
		 if ( ! $this->image_lib->resize())
		{
		 	return $this->image_lib->display_errors();
		}
		
		else
		{
			return TRUE;
		}
	}
	
	function resize_image_slideshow($path, $gallery_path, $file_name)
	{
		$resize_conf = array(
			'source_image'  => $path,
			'new_image'     => $path.'images/'.$file_name,
			'create_thumb'  => FALSE,
			'width' => 500,
			'height' => 500,
			'maintain_ratio' => true,
		);
		
		$this->image_lib->initialize($resize_conf);
		 
		 if ( ! $this->image_lib->resize())
		{
		 	return $this->image_lib->display_errors();
		}
		
		else
		{
			return TRUE;
		}
	}
	
	/**
	 * Upload multiple files for a gallery
	 *
	 * @param int product_id
	 *
	 */
    function upload_gallery($product_id)
    {
		//Libraries
        $this->load->library('upload');
        $this->load->library('image_lib');
    
        // Change $_FILES to new vars and loop them
        foreach($_FILES['gallery'] as $key=>$val)
        {
            $i = 1;
            foreach($val as $v)
            {
                $field_name = "file_".$i;
                $_FILES[$field_name][$key] = $v;
                $i++;   
            }
        }
        // Unset the useless one ;)
        unset($_FILES['gallery']);
    
        // Put each errors and upload data to an array
        $error = array();
        $success = array();
        
        // main action to upload each file
        foreach($_FILES as $field_name => $file)
        {
		
		$upload_conf = array(
			'allowed_types' => 'JPG|JPEG|jpg|jpeg|gif|png',
			'upload_path' => realpath('assets/products'),
			'quality' => "100%",
			'file_name' => "image_".date("Y")."_".date("m")."_".date("d")."_".date("H")."_".date("i")."_".date("s"),
			'max_size' => 20000,
			'maintain_ratio' => true,
			'height' => 345,
			'width' => 460
         );
    
        $this->upload->initialize( $upload_conf );
		
		if ( ! $this->upload->do_upload($field_name))
		{
			// if upload fail, grab error 
			$error['upload'][] = $this->upload->display_errors();
		}
		else
		{
			// otherwise, put the upload datas here.
			// if you want to use database, put insert query in this loop
			$upload_data = $this->upload->data();
			
			// set the resize config
			$resize_conf = array(
				// it's something like "/full/path/to/the/image.jpg" maybe
				'source_image'  => $upload_data['full_path'], 
				'new_image'     => $upload_data['file_path'].'gallery/'.$upload_data['file_name'],
				'create_thumb'     => FALSE,
				'width' => 460,
				'height' => 345,
				'maintain_ratio' => true,
				);

			// initializing
			$this->image_lib->initialize($resize_conf);

			// do it!
			if ( ! $this->image_lib->resize())
			{
				// if got fail.
				$error['resize'][] = $this->image_lib->display_errors();
			}
			else
			{
				// otherwise, put each upload data to an array.
				$success[] = $upload_data;
			}
			
			$data = array(//get the items from the form
				'product_id' => $product_id,
				'product_image_name' => $upload_data['file_name'],
				'product_image_thumb' => 'thumb_'.$upload_data['file_name']
			);
		
			$insert = $this->db->insert('product_image', $data);
			
			// set the resize config
			$resize_conf = array(
				// it's something like "/full/path/to/the/image.jpg" maybe
				'source_image'  => $upload_data['full_path'], 
				// and it's "/full/path/to/the/" + "thumb_" + "image.jpg
				// or you can use 'create_thumbs' => true option instead
				'new_image'     => $upload_data['file_path'].'gallery/thumb_'.$upload_data['file_name'],
				'width'         => 80,
				'height'        => 60,
				'maintain_ratio' => true,
				);

			// initializing
			$this->image_lib->initialize($resize_conf);

			// do it!
			if ( ! $this->image_lib->resize())
			{
				// if got fail.
				$error['resize'][] = $this->image_lib->display_errors();
			}
			else
			{
				// otherwise, put each upload data to an array.
				$success[] = $upload_data;
			}
			//delete_files($upload_data['full_path']);
		}
			
        }

        // see what we get
        if(count($error > 0))
        {
            $data['error'] = $error;
        }
        else
        {
            $data['success'] = $upload_data;
        }
		return TRUE;
    }
	
	/**
	 * Delete gallery image
	 *
	 * @param int product_image_id
	 *
	 */
	function delete_gallery_image($product_image_id, $product_id, $page){
		
		$data['product_images'] = $this->products_model->delete_product_image($product_image_id);
		$this->update_product($product_id, $page);
	}
	
	/********************************************************************************************
	*																							*
	*									CATEGORIES FUNCTIONS									*
	*																							*
	********************************************************************************************/
	
	function list_categories($navigation_id, $sub_navigation_id)
	{
		$_SESSION['navigation_id'] = $navigation_id;
		$_SESSION['sub_navigation_id'] = $sub_navigation_id;
		
  		$table = "category";
		$where = "category_id > 0";
		$items = "*";
		$order = "category_parent, category_name";
		
		$data['categories'] = $this->administration_model->select_entries_where($table, $where, $items, $order);
		
		$this->load_head();
		$this->load->view("categories/categories_list", $data);
		$this->load_foot();
	}
	
	function add_category($navigation_id, $sub_navigation_id)
	{
		$_SESSION['navigation_id'] = $navigation_id;
		$_SESSION['sub_navigation_id'] = $sub_navigation_id;
		/*
			-----------------------------------------------------------------------------------------
			Validate the input 
			-----------------------------------------------------------------------------------------
		*/
		$this->form_validation->set_rules('category_preffix', 'Preffix', 'trim|required|is_unique[category.category_preffix]|xss_clean');
		$this->form_validation->set_rules('category_name', 'Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('category_id', 'Category Parent', 'numeric|xss_clean');
		//$this->form_validation->set_rules('userfile', 'Image', 'required|xss_clean');
		$this->form_validation->set_message("is_unique", "A unique preffix is requred.");

		if ($this->form_validation->run())
		{
			if(is_uploaded_file($_FILES['userfile']['tmp_name']))
			{
				$gallery_path = $this->gallery_path2;
				/*
					-----------------------------------------------------------------------------------------
					Upload image
					-----------------------------------------------------------------------------------------
				*/
				$image_data = $this->do_upload($gallery_path);
			
				if($image_data == "FALSE"){
					echo $this->upload->display_errors('<p>', '</p>');
					$file_name = "";
				}
				else{
					$path = $image_data['full_path'];
					$file_path = $image_data['file_path'];
					$file_name = $image_data['file_name'];
					$file_type = $image_data['file_type'];
			
					/*
						-----------------------------------------------------------------------------------------
						Resize image
						-----------------------------------------------------------------------------------------
					*/
					$create = $this->resize_image($path, $gallery_path, $file_name);
			
					/*
						-----------------------------------------------------------------------------------------
						Create thumbnail
						-----------------------------------------------------------------------------------------
					*/
					$create = $this->create_thumb($path, $gallery_path, $file_name);
				}
			}
			
			else{
				$file_name = '';
			}
			
			$data = array(
				'category_name'=>$this->input->post('category_name'),
				'category_parent'=>$this->input->post('category_parent'),
				'category_preffix'=>$this->input->post('category_preffix'),
				'category_image_name'=>$file_name
			);
			
			$table = "category";
			$this->administration_model->insert($table, $data);
			$this->list_categories($_SESSION['navigation_id'], $_SESSION['sub_navigation_id']);
			//redirect('administration/add_category/'.$_SESSION['navigation_id']."/".$_SESSION['sub_navigation_id']);
		}
		
		else
		{
			/*
				-----------------------------------------------------------------------------------------
				Add a new category
				-----------------------------------------------------------------------------------------
			*/
		
			$table = "category";
			$where = "category_id > 0";
			$items = "*";
			$order = "category_name";
			
			$data['children'] = $this->administration_model->select_entries_where($table, $where, $items, $order);
			
			$this->load_head();
			$this->load->view("categories/add_category", $data);
			$this->load_foot();
		}
	}
	
	function edit_category($category_id)
	{
		/*
			-----------------------------------------------------------------------------------------
			Validate the input 
			-----------------------------------------------------------------------------------------
		*/
		$this->form_validation->set_rules('category_preffix', 'Preffix', 'trim|required|xss_clean');
		$this->form_validation->set_rules('category_name', 'Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('category_id', 'Category Parent', 'numeric|xss_clean');
		//$this->form_validation->set_rules('userfile', 'Image', 'required|xss_clean');
		$this->form_validation->set_message("is_unique", "A unique preffix is requred.");

		if ($this->form_validation->run())
		{
			if(is_uploaded_file($_FILES['userfile']['tmp_name']))
			{
				$gallery_path = $this->gallery_path2;
				/*
					-----------------------------------------------------------------------------------------
					Upload image
					-----------------------------------------------------------------------------------------
				*/
				$image_data = $this->do_upload($gallery_path);
			
				if($image_data == "FALSE"){
					echo $this->upload->display_errors('<p>', '</p>');
					$file_name = "";
				}
				else{
					$path = $image_data['full_path'];
					$file_path = $image_data['file_path'];
					$file_name = $image_data['file_name'];
					$file_type = $image_data['file_type'];
			
					/*
						-----------------------------------------------------------------------------------------
						Resize image
						-----------------------------------------------------------------------------------------
					*/
					$create = $this->resize_image($path, $gallery_path, $file_name);
			
					/*
						-----------------------------------------------------------------------------------------
						Create thumbnail
						-----------------------------------------------------------------------------------------
					*/
					$create = $this->create_thumb($path, $gallery_path, $file_name);
				}
			}
			
			else{
				$file_name = $this->input->post('category_image_name');
			}
			
			$data = array(
				'category_name'=>$this->input->post('category_name'),
				'category_parent'=>$this->input->post('category_parent'),
				'category_preffix'=>$this->input->post('category_preffix'),
				'category_image_name'=>$file_name
			);
			
			$table = "category";
			$this->administration_model->update($table, $data, "category_id", $category_id);
			redirect('administration/list_categories/1/1');
		}
		
		else
		{
			/*
				-----------------------------------------------------------------------------------------
				Add a new category
				-----------------------------------------------------------------------------------------
			*/
		
			$table = "category";
			$where = "category_id = ".$category_id;
			$items = "*";
			$order = "category_name";
			$data['category'] = $this->administration_model->select_entries_where($table, $where, $items, $order);
			
			$where = "category_id > 0";
			$items = "*";
			$order = "category_name";
			$data['children'] = $this->administration_model->select_entries_where($table, $where, $items, $order);
			
			$this->load_head();
			$this->load->view("categories/edit_category", $data);
			$this->load_foot();
		}
	}
	
	function delete_category($category_id)
	{
		$this->administration_model->delete("category", "category_id", $category_id);
		
		echo "true";
	}
	
	function deactivate_category($category_id)
	{
		$data = array(
			'category_status'=>0
		);
		
		$table = "category";
		$this->administration_model->update($table, $data, "category_id", $category_id);
		
		redirect('administration/list_categories/1/1');
	}
	
	function activate_category($category_id)
	{
		$data = array(
			'category_status'=>1
		);
		
		$table = "category";
		$this->administration_model->update($table, $data, "category_id", $category_id);
		
		redirect('administration/list_categories/1/1');
	}
	
	/********************************************************************************************
	*																							*
	*										ORDERS FUNCTIONS									*
	*																							*
	********************************************************************************************/
	
	function list_orders($navigation_id, $sub_navigation_id)
	{
		$_SESSION['navigation_id'] = $navigation_id;
		$_SESSION['sub_navigation_id'] = $sub_navigation_id;
		
  		$table = "`order`";
		$where = "order_id > 0";
		$items = "*";
		$order = "order_date";
		
		$data['orders'] = $this->administration_model->select_entries_where2($table, $where, $items, $order);
		
		$this->load_head();
		$this->load->view("orders/orders_list", $data);
		$this->load_foot();
	}
	
	function complete_order($order_id)
	{
		$data = array(
			'order_status'=>1
		);
		
		$table = "`order`";
		$this->administration_model->update($table, $data, "order_id", $order_id);
		
		redirect('administration/list_orders/3/23');
	}
	
	/********************************************************************************************
	*																							*
	*									BRANDS FUNCTIONS										*
	*																							*
	********************************************************************************************/
	
	function brands($navigation_id, $sub_navigation_id)
	{
		$_SESSION['navigation_id'] = $navigation_id;
		$_SESSION['sub_navigation_id'] = $sub_navigation_id;
		
  		$table = "brand";
		$where = "brand_id > 0";
		$items = "*";
		$order = "brand_name";
		
		$config['total_rows'] = $this->administration_model->items_count($table, $where);
		$config['base_url'] = site_url().'administration/brands/'.$navigation_id."/".$sub_navigation_id;
		$config['per_page'] = 30;
		$config['uri_segment'] = 5;
		
		$this->pagination->initialize($config);
		
		$page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
		
		$data['brands'] = $this->administration_model->select_pagination($config["per_page"], $page, $table, $where, $items, $order);
		
        $data["links"] = $this->pagination->create_links();
		
		$this->load_head();
		$this->load->view("brands/brand_list", $data);
		$this->load_foot();
	}
	
	function add_brand($navigation_id, $sub_navigation_id)
	{
		$_SESSION['navigation_id'] = $navigation_id;
		$_SESSION['sub_navigation_id'] = $sub_navigation_id;
		/*
			-----------------------------------------------------------------------------------------
			Validate the input 
			-----------------------------------------------------------------------------------------
		*/
		$this->form_validation->set_rules('brand_name', 'Brand Name', 'trim|required|xss_clean');

		if ($this->form_validation->run())
		{
			if(is_uploaded_file($_FILES['userfile']['tmp_name']))
			{
				$gallery_path = $this->gallery_path5;
				/*
					-----------------------------------------------------------------------------------------
					Upload image
					-----------------------------------------------------------------------------------------
				*/
				$image_data = $this->do_upload($gallery_path);
			
				if($image_data == "FALSE"){
					echo $this->upload->display_errors('<p>', '</p>');
					$file_name = "";
				}
				else{
					$path = $image_data['full_path'];
					$file_path = $image_data['file_path'];
					$file_name = $image_data['file_name'];
					$file_type = $image_data['file_type'];
			
					/*
						-----------------------------------------------------------------------------------------
						Resize image
						-----------------------------------------------------------------------------------------
					*/
					$create = $this->resize_image($path, $gallery_path, $file_name);
			
					/*
						-----------------------------------------------------------------------------------------
						Create thumbnail
						-----------------------------------------------------------------------------------------
					*/
					$create = $this->create_thumb($path, $gallery_path, $file_name);
				}
			}
			
			else{
				$file_name = '';
			}
			
			$data = array(
				'brand_name'=>$this->input->post('brand_name'),
				'brand_image_name'=>$file_name
			);
			
			$table = "brand";
			$this->administration_model->insert($table, $data);
			redirect('administration/add_brand/'.$_SESSION['navigation_id']."/".$_SESSION['sub_navigation_id']);
		}
		
		else
		{
			$this->load_head();
			$this->load->view("brands/add_brand");
			$this->load_foot();
		}
	}
	
	function edit_brand($brand_id)
	{
		$this->form_validation->set_rules('brand_name', 'Brand Name', 'trim|required|xss_clean');

		if ($this->form_validation->run())
		{
			if(is_uploaded_file($_FILES['userfile']['tmp_name']))
			{
				$gallery_path = $this->gallery_path5;
				/*
					-----------------------------------------------------------------------------------------
					Upload image
					-----------------------------------------------------------------------------------------
				*/
				$image_data = $this->do_upload($gallery_path);
			
				if($image_data == "FALSE"){
					echo $this->upload->display_errors('<p>', '</p>');
					$file_name = "";
				}
				else{
					$path = $image_data['full_path'];
					$file_path = $image_data['file_path'];
					$file_name = $image_data['file_name'];
					$file_type = $image_data['file_type'];
			
					/*
						-----------------------------------------------------------------------------------------
						Resize image
						-----------------------------------------------------------------------------------------
					*/
					$create = $this->resize_image($path, $gallery_path, $file_name);
			
					/*
						-----------------------------------------------------------------------------------------
						Create thumbnail
						-----------------------------------------------------------------------------------------
					*/
					$create = $this->create_thumb($path, $gallery_path, $file_name);
				}
			}
			
			else{
				$file_name = $this->input->post('hidden_image');
			}
			
			$data = array(
				'brand_name'=>$this->input->post('brand_name'),
				'brand_image_name'=>$file_name
			);
			
			$table = "brand";
			$this->administration_model->update($table, $data, "brand_id", $brand_id);
			redirect('administration/brands/'.$_SESSION['navigation_id']."/".$_SESSION['sub_navigation_id']);
		}
		
		else
		{
			$table = "brand";
			$where = "brand_id = ".$brand_id;
			$items = "*";
			$order = "brand_name";
			$data['brands'] = $this->administration_model->select_entries_where($table, $where, $items, $order);
			
			$this->load_head();
			$this->load->view("brands/edit_brand", $data);
			$this->load_foot();
		}
	}
	
	function delete_brand($brand_id)
	{
		$this->administration_model->delete("brand", "brand_id", $brand_id);
		
		echo "true";
	}
	
	function deactivate_brand($brand_id)
	{
		$data = array(
			'brand_status'=>0
		);
		
		$table = "brand";
		$this->administration_model->update($table, $data, "brand_id", $brand_id);
		
		redirect('administration/brands/'.$_SESSION['navigation_id']."/".$_SESSION['sub_navigation_id']);
	}
	
	function activate_brand($brand_id)
	{
		$data = array(
			'brand_status'=>1
		);
		
		$table = "brand";
		$this->administration_model->update($table, $data, "brand_id", $brand_id);
		
		redirect('administration/brands/'.$_SESSION['navigation_id']."/".$_SESSION['sub_navigation_id']);
	}
	
	/********************************************************************************************
	*																							*
	*									MODELS FUNCTIONS										*
	*																							*
	********************************************************************************************/
	
	function brand_models($navigation_id, $sub_navigation_id)
	{
		$_SESSION['navigation_id'] = $navigation_id;
		$_SESSION['sub_navigation_id'] = $sub_navigation_id;
		
  		$table = "brand_model, brand";
		$where = "brand_model.brand_id = brand.brand_id";
		$items = "brand.brand_id, brand_name, brand_model_name, brand_model_id, brand_model_status";
		$order = "brand_name, brand_model_name";
		
		$config['total_rows'] = $this->administration_model->items_count($table, $where);
		$config['base_url'] = site_url().'administration/brand_models/'.$navigation_id."/".$sub_navigation_id;
		$config['per_page'] = 30;
		$config['uri_segment'] = 5;
		
		$this->pagination->initialize($config);
		
		$page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
		
		$data['brand_models'] = $this->administration_model->select_pagination($config["per_page"], $page, $table, $where, $items, $order);
		
        $data["links"] = $this->pagination->create_links();
		
		$this->load_head();
		$this->load->view("brands/brand_model_list", $data);
		$this->load_foot();
	}
	
	function add_brand_model($navigation_id, $sub_navigation_id)
	{
		$_SESSION['navigation_id'] = $navigation_id;
		$_SESSION['sub_navigation_id'] = $sub_navigation_id;
		/*
			-----------------------------------------------------------------------------------------
			Validate the input 
			-----------------------------------------------------------------------------------------
		*/
		$this->form_validation->set_rules('brand_id', 'Brand', 'trim|required|numeric|xss_clean');
		$this->form_validation->set_rules('brand_model_name', 'Model Name', 'trim|required|xss_clean');

		if ($this->form_validation->run())
		{	
			$data = array(
				'brand_id'=>$this->input->post('brand_id'),
				'brand_model_name'=>$this->input->post('brand_model_name')
			);
			
			$table = "brand_model";
			$this->administration_model->insert($table, $data);
			redirect('administration/add_brand_model/'.$_SESSION['navigation_id']."/".$_SESSION['sub_navigation_id']);
		}
		
		else
		{
			$table = "brand";
			$where = "brand_status = 1";
			$items = "*";
			$order = "brand_name";
			$data['brands'] = $this->administration_model->select_entries_where($table, $where, $items, $order);
			
			$this->load_head();
			$this->load->view("brands/add_brand_model", $data);
			$this->load_foot();
		}
	}
	
	function edit_brand_model($brand_model_id)
	{
		$this->form_validation->set_rules('brand_id', 'Brand', 'trim|required|numeric|xss_clean');
		$this->form_validation->set_rules('brand_model_name', 'Model Name', 'trim|required|xss_clean');

		if ($this->form_validation->run())
		{	
			$data = array(
				'brand_id'=>$this->input->post('brand_id'),
				'brand_model_name'=>$this->input->post('brand_model_name')
			);
			
			$table = "brand_model";
			$this->administration_model->update($table, $data, "brand_model_id", $brand_model_id);
			redirect('administration/brand_models/'.$_SESSION['navigation_id']."/".$_SESSION['sub_navigation_id']);
		}
		
		else
		{
			$table = "brand";
			$where = "brand_status = 1";
			$items = "*";
			$order = "brand_name";
			$data['brands'] = $this->administration_model->select_entries_where($table, $where, $items, $order);
			
			$table = "brand_model, brand";
			$where = "brand_model.brand_id = brand.brand_id AND brand_model_id = ".$brand_model_id;
			$items = "brand.brand_id, brand_name, brand_model_name, brand_model_id";
			$order = "brand_name, brand_model_name";
			
			$data['brand_models'] = $this->administration_model->select_entries_where($table, $where, $items, $order);
			
			$this->load_head();
			$this->load->view("brands/edit_brand_model", $data);
			$this->load_foot();
		}
	}
	
	function delete_brand_model($brand_model_id)
	{
		$this->administration_model->delete("brand_model", "brand_model_id", $brand_model_id);
		
		echo "true";
	}
	
	function deactivate_brand_model($brand_model_id)
	{
		$data = array(
			'brand_model_status'=>0
		);
		
		$table = "brand_model";
		$this->administration_model->update($table, $data, "brand_model_id", $brand_model_id);
		
		redirect('administration/brand_models/'.$_SESSION['navigation_id']."/".$_SESSION['sub_navigation_id']);
	}
	
	function activate_brand_model($brand_model_id)
	{
		$data = array(
			'brand_model_status'=>1
		);
		
		$table = "brand_model";
		$this->administration_model->update($table, $data, "brand_model_id", $brand_model_id);
		
		redirect('administration/brand_models/'.$_SESSION['navigation_id']."/".$_SESSION['sub_navigation_id']);
	}
	
	/********************************************************************************************
	*																							*
	*									PRODUCTS FUNCTIONS										*
	*																							*
	********************************************************************************************/
	
	function list_products($navigation_id, $sub_navigation_id)
	{
		$_SESSION['navigation_id'] = $navigation_id;
		$_SESSION['sub_navigation_id'] = $sub_navigation_id;
		
  		$table = "product, category";
		$where = "product.category_id = category.category_id";
		$items = "product_code, product_id, category_name, product_description, product_name, product_selling_price, product_buying_price, product_status, product_balance, product_image_name, product_date";
		$order = "product_name";
		
		$config['total_rows'] = $this->administration_model->items_count($table, $where);
		$config['base_url'] = site_url().'administration/list_products/'.$navigation_id."/".$sub_navigation_id;
		$config['per_page'] = 30;
		$config['uri_segment'] = 5;
		
		$this->pagination->initialize($config);
		
		$page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
		
		$data['products'] = $this->administration_model->select_pagination($config["per_page"], $page, $table, $where, $items, $order);
		
        $data["links"] = $this->pagination->create_links();
		
		$this->load_head();
		$this->load->view("products/products_list", $data);
		$this->load_foot();
	}
	
	function add_product($navigation_id, $sub_navigation_id)
	{
		$_SESSION['navigation_id'] = $navigation_id;
		$_SESSION['sub_navigation_id'] = $sub_navigation_id;
		/*
			-----------------------------------------------------------------------------------------
			Validate the input 
			-----------------------------------------------------------------------------------------
		*/
		$this->form_validation->set_rules('product_year', 'Product Year', 'trim|required|numeric|xss_clean');
		$this->form_validation->set_rules('brand_id', 'Brand', 'trim|required|numeric|xss_clean');
		$this->form_validation->set_rules('brand_model_id', 'Model', 'trim|required|numeric|xss_clean');
		$this->form_validation->set_rules('product_description', 'Description', 'trim|required|xss_clean');
		$this->form_validation->set_rules('product_name', 'Product Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('product_selling_price', 'Selling Price', 'trim|required|xss_clean');
		$this->form_validation->set_rules('product_buying_price', 'Buying Price', 'trim|xss_clean');
		$this->form_validation->set_rules('product_balance', 'Balance', 'trim|required|numeric|xss_clean');
		$this->form_validation->set_rules('category_id', 'Category', 'trim|required|numeric|xss_clean');
		$this->form_validation->set_message("is_unique", "A unique code is requred.");

		if ($this->form_validation->run())
		{
			if(is_uploaded_file($_FILES['userfile']['tmp_name']))
			{
				$gallery_path = $this->gallery_path;
				/*
					-----------------------------------------------------------------------------------------
					Upload image
					-----------------------------------------------------------------------------------------
				*/
				$image_data = $this->do_upload($gallery_path);
			
				if($image_data == "FALSE"){
					echo $this->upload->display_errors('<p>', '</p>');
					$file_name = "";
				}
				else{
					$path = $image_data['full_path'];
					$file_path = $image_data['file_path'];
					$file_name = $image_data['file_name'];
					$file_type = $image_data['file_type'];
			
					/*
						-----------------------------------------------------------------------------------------
						Resize image
						-----------------------------------------------------------------------------------------
					*/
					$create = $this->resize_image($path, $gallery_path, $file_name);
			
					/*
						-----------------------------------------------------------------------------------------
						Create thumbnail
						-----------------------------------------------------------------------------------------
					*/
					$create = $this->create_thumb($path, $gallery_path, $file_name);
				}
			}
			
			else{
				$file_name = '';
			}
			
			/*
				-----------------------------------------------------------------------------------------
				Create Product Number
				-----------------------------------------------------------------------------------------
			*/
			$table = "category";
			$where = "category_id = ".$this->input->post('category_id');
			$items = "category_preffix";
			$order = "category_preffix";
			
			$result = $this->administration_model->select_entries_where($table, $where, $items, $order);
			foreach ($result as $row):
				$category_preffix =  $row->category_preffix;
			endforeach;
			
			$table = "product";
			$where = "product_code LIKE '".$category_preffix."%'";
			$items = "MAX(product_code) AS number";
			$order = "number";
			
			$result = $this->administration_model->select_entries_where($table, $where, $items, $order);
			if($result != NULL){
				foreach ($result as $row):
					$number =  $row->number;
					$number++;//go to the next number
				endforeach;
				
				if($number == 1){
					$number = $category_preffix."001";
				}
			}
			else{//start generating receipt numbers
				$number = $category_preffix."001";
			}
			
			$data = array(
				'product_code'=>$number,
				'product_year'=>$this->input->post('product_year'),
				'brand_model_id'=>$this->input->post('brand_model_id'),
				'product_description'=>$this->input->post('product_description'),
				'product_name'=>$this->input->post('product_name'),
				'product_selling_price'=>$this->input->post('product_selling_price'),
				'product_buying_price'=>$this->input->post('product_buying_price'),
				'product_balance'=>$this->input->post('product_balance'),
				'category_id'=>$this->input->post('category_id'),
				'product_image_name'=>$file_name
			);
			
			$table = "product";
			$product_id = $this->administration_model->insert($table, $data);
			
			if($product_id > 0){
				$this->upload_gallery($product_id);
			}
			redirect('administration/add_product/'.$_SESSION['navigation_id']."/".$_SESSION['sub_navigation_id']);
		}
		
		else
		{
			/*
				-----------------------------------------------------------------------------------------
				Add a new product
				-----------------------------------------------------------------------------------------
			*/
			$table = "category";
			$where = "category_id > 0";
			$items = "*";
			$order = "category_name";
			$data['children'] = $this->administration_model->select_entries_where($table, $where, $items, $order);
			
			$table = "brand";
			$where = "brand_id > 0";
			$items = "*";
			$order = "brand_name";
			$data['brands'] = $this->administration_model->select_entries_where($table, $where, $items, $order);
			
			$this->load_head();
			$this->load->view("products/add_product", $data);
			$this->load_foot();
		}
	}
	
	function get_brand_models($brand_id)
	{
		$table = "brand_model";
		$where = "brand_id = ".$brand_id;
		$items = "*";
		$order = "brand_model_name";
		$data['brand_models'] = $this->administration_model->select_entries_where($table, $where, $items, $order);
		
		$this->load->view("products/models", $data);
	}
	
	function edit_product($product_id)
	{
		/*
			-----------------------------------------------------------------------------------------
			Validate the input 
			-----------------------------------------------------------------------------------------
		*/
		$this->form_validation->set_rules('brand_id', 'Brand', 'trim|required|numeric|xss_clean');
		$this->form_validation->set_rules('brand_model_id', 'Model', 'trim|required|numeric|xss_clean');
		$this->form_validation->set_rules('product_code', 'Code', 'trim|xss_clean');
		$this->form_validation->set_rules('product_description', 'Description', 'trim|required|xss_clean');
		$this->form_validation->set_rules('product_name', 'Product Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('product_selling_price', 'Selling Price', 'trim|required|xss_clean');
		$this->form_validation->set_rules('product_buying_price', 'Buying Price', 'trim|required|xss_clean');
		$this->form_validation->set_rules('product_balance', 'Balance', 'trim|required|numeric|xss_clean');
		$this->form_validation->set_rules('category_id', 'Category', 'trim|required|numeric|xss_clean');
		$this->form_validation->set_message("is_unique", "A unique code is requred.");

		if ($this->form_validation->run())
		{
			if(is_uploaded_file($_FILES['userfile']['tmp_name']))
			{
				$gallery_path = $this->gallery_path;
				/*
					-----------------------------------------------------------------------------------------
					Upload image
					-----------------------------------------------------------------------------------------
				*/
				$image_data = $this->do_upload($gallery_path);
			
				if($image_data == "FALSE"){
					echo $this->upload->display_errors('<p>', '</p>');
					$file_name = "";
				}
				else{
					$path = $image_data['full_path'];
					$file_path = $image_data['file_path'];
					$file_name = $image_data['file_name'];
					$file_type = $image_data['file_type'];
			
					/*
						-----------------------------------------------------------------------------------------
						Resize image
						-----------------------------------------------------------------------------------------
					*/
					$create = $this->resize_image($path, $gallery_path, $file_name);
			
					/*
						-----------------------------------------------------------------------------------------
						Create thumbnail
						-----------------------------------------------------------------------------------------
					*/
					$create = $this->create_thumb($path, $gallery_path, $file_name);
				}
			}
			
			else{
				$file_name = $this->input->post('product_image_name');
			}
			
			$data = array(
				'product_year'=>$this->input->post('product_year'),
				'product_code'=>$this->input->post('product_code'),
				'product_description'=>$this->input->post('product_description'),
				'product_name'=>$this->input->post('product_name'),
				'product_selling_price'=>$this->input->post('product_selling_price'),
				'product_buying_price'=>$this->input->post('product_buying_price'),
				'product_balance'=>$this->input->post('product_balance'),
				'category_id'=>$this->input->post('category_id'),
				'product_image_name'=>$file_name
			);
			
			if($this->input->post('brand_id') == "0"){
				$data['brand_model_id'] = $this->input->post('model_id');
			}
			else{
				$data['brand_model_id'] = $this->input->post('brand_model_id');
			}
			
			$table = "product";
			$this->administration_model->update($table, $data, "product_id", $product_id);
			$this->upload_gallery($product_id);
			redirect('administration/list_products/2/3');
		}
		
		else
		{
			/*
				-----------------------------------------------------------------------------------------
				Add a new product
				-----------------------------------------------------------------------------------------
			*/
			$table = "product, category";
			$where = "product.category_id = category.category_id AND product.product_id = ".$product_id;
			$items = "product.category_id, product_year, brand_model_id, product_code, product_id, category_name, product_description, product_name, product_selling_price, product_buying_price, product_status, product_balance, product_image_name, product_date";
			$order = "product_name";
			$data['product'] = $this->administration_model->select_entries_where($table, $where, $items, $order);
			
			$table = "brand";
			$where = "brand_id > 0";
			$items = "*";
			$order = "brand_name";
			$data['brands'] = $this->administration_model->select_entries_where($table, $where, $items, $order);
			
			$items = "*";
			$table = "product_image";
			$where = "(product_id = ".$product_id.")";
			$order = "product_id"; 
			$data['product_images'] = $this->administration_model->select_entries_where($table, $where, $items, $order);
			
			$table = "category";
			$where = "category_id > 0";
			$items = "*";
			$order = "category_name";
			
			$data['children'] = $this->administration_model->select_entries_where($table, $where, $items, $order);
			
			$this->load_head();
			$this->load->view("products/edit_product", $data);
			$this->load_foot();
		}
	}
	
	function delete_product($product_id)
	{
		$this->administration_model->delete("product", "product_id", $product_id);
		
		echo "true";
	}
	
	function deactivate_product($product_id)
	{
		$data = array(
			'product_status'=>0
		);
		
		$table = "product";
		$this->administration_model->update($table, $data, "product_id", $product_id);
		
		redirect('administration/list_products/2/3');
	}
	
	function activate_product($product_id)
	{
		$data = array(
			'product_status'=>1
		);
		
		$table = "product";
		$this->administration_model->update($table, $data, "product_id", $product_id);
		
		redirect('administration/list_products/2/3');
	}
	
	function view_product($product_id)
	{
  		$table = "product, category, brand_model, brand";
		$where = "product.category_id = category.category_id AND product.brand_model_id = brand_model.brand_model_id AND brand_model.brand_id = brand.brand_id AND product.product_id = ".$product_id;
		$items = "brand_model.brand_model_name, brand.brand_name, product_year, product_code, product_id, category_name, product_description, product_name, product_selling_price, product_buying_price, product_status, product_balance, product_image_name, product_date";
		$order = "product_name";
		$data['product'] = $this->administration_model->select_entries_where($table, $where, $items, $order);
		
		$items = "*";
		$table = "product_image";
        $where = "(product_id = ".$product_id.")";
		$order = "product_id"; 
		$data['product_images'] = $this->administration_model->select_entries_where($table, $where, $items, $order);
		
		$this->load->view("products/view_product", $data);
	}
	
	/********************************************************************************************
	*																							*
	*									SLIDESHOW FUNCTIONS										*
	*																							*
	********************************************************************************************/
	
	function slideshow($navigation_id, $sub_navigation_id)
	{
		$_SESSION['navigation_id'] = $navigation_id;
		$_SESSION['sub_navigation_id'] = $sub_navigation_id;
		
  		$table = "slideshow";
		$where = "slideshow_id > 0";
		$items = "*";
		$order = "slideshow_id";
		
		$data['slides'] = $this->administration_model->select_entries_where($table, $where, $items, $order);
		$data['slideshow_location'] = $this->slideshow_location;
		
		$this->load_head();
		$this->load->view("slideshow/list_slides", $data);
		$this->load_foot();
	}
	
	function add_slide($navigation_id, $sub_navigation_id)
	{
		$_SESSION['navigation_id'] = $navigation_id;
		$_SESSION['sub_navigation_id'] = $sub_navigation_id;
		$data['slideshow_location'] = 'http://placehold.it/300x300';
		
		$this->session->unset_userdata('slideshow_error_message');
		
		//upload image if it has been selected
		$response = $this->administration_model->upload_slideshow_image($this->slideshow_path);
		if($response)
		{
			$data['slideshow_location'] = $this->slideshow_location.$this->session->userdata('slideshow_file_name');
		}
		
		//case of upload error
		else
		{
			$data['slideshow_error'] = $this->session->userdata('slideshow_error_message');
		}
		
		$slideshow_error = $this->session->userdata('slideshow_error_message');
		
		$this->form_validation->set_rules('check', 'check', 'trim|xss_clean');
		$this->form_validation->set_rules('slideshow_name', 'Title', 'trim|xss_clean');
		$this->form_validation->set_rules('slideshow_description', 'Description', 'trim|xss_clean');

		if ($this->form_validation->run())
		{	
			if(empty($slideshow_error))
			{
				$data2 = array(
					'slideshow_name'=>$this->input->post("slideshow_name"),
					'slideshow_description'=>$this->input->post("slideshow_description"),
					'slideshow_image_name'=>$this->session->userdata('slideshow_file_name')
				);
				
				$table = "slideshow";
				$this->administration_model->insert($table, $data2);
				$this->session->unset_userdata('slideshow_file_name');
				$this->session->unset_userdata('slideshow_thumb_name');
				$this->session->unset_userdata('slideshow_error_message');
				
				redirect('administration/slideshow/4/5');
			}
		}
		
		$table = "slideshow";
		$where = "slideshow_id > 0";
		$items = "*";
		$order = "slideshow_id";
		
		$data['slides'] = $this->administration_model->select_entries_where($table, $where, $items, $order);
		
		$slideshow = $this->session->userdata('slideshow_file_name');
		
		if(!empty($slideshow))
		{
			$data['slideshow_location'] = $this->slideshow_location.$this->session->userdata('slideshow_file_name');
		}
		$data['error'] = $slideshow_error;
		
		$this->load_head();
		$this->load->view("slideshow/add_slide", $data);
		$this->load_foot();
	}
	
	function edit_slide($slideshow_id)
	{
		/*
			-----------------------------------------------------------------------------------------
			Validate the input 
			-----------------------------------------------------------------------------------------
		*/
		$this->form_validation->set_rules('slideshow_name', 'Title', 'trim|xss_clean');
		$this->form_validation->set_rules('slideshow_description', 'Description', 'trim|xss_clean');

		if ($this->form_validation->run())
		{
			if(is_uploaded_file($_FILES['userfile']['tmp_name']))
			{
				$gallery_path = $this->gallery_path3;
				/*
					-----------------------------------------------------------------------------------------
					Upload image
					-----------------------------------------------------------------------------------------
				*/
				$image_data = $this->do_upload($gallery_path);
			
				if($image_data == "FALSE"){
					echo $this->upload->display_errors('<p>', '</p>');
					$file_name = "";
				}
				else{
					$path = $image_data['full_path'];
					$file_path = $image_data['file_path'];
					$file_name = $image_data['file_name'];
					$file_type = $image_data['file_type'];
			
					/*
						-----------------------------------------------------------------------------------------
						Resize image
						-----------------------------------------------------------------------------------------
					*/
					$create = $this->resize_image_slideshow($path, $gallery_path, $file_name);
				}
			}
			
			else{
				$file_name = $this->input->post('slideshow_image_name');
			}
			
			$data = array(
				'slideshow_name'=>$this->input->post('slideshow_name'),
				'slideshow_description'=>$this->input->post('slideshow_description'),
				'slideshow_image_name'=>$file_name
			);
			
			$table = "slideshow";
			$this->administration_model->update($table, $data, "slideshow_id", $slideshow_id);
			
			redirect('administration/slideshow/4/5');
		}
		
		else
		{
			/*
				-----------------------------------------------------------------------------------------
				Edit a slideshow
				-----------------------------------------------------------------------------------------
			*/
		
			$table = "slideshow";
			$where = "slideshow_id = ".$slideshow_id;
			$items = "*";
			$order = "slideshow_id";
			
			$data['slides'] = $this->administration_model->select_entries_where($table, $where, $items, $order);
			
			$this->load_head();
			$this->load->view("slideshow/edit_slide", $data);
			$this->load_foot();
		}
	}
	
	function delete_slideshow($slideshow_id)
	{
		//delete image
		$table = "slideshow";
		$where = "slideshow_id = ".$slideshow_id;
		$items = "*";
		$order = "slideshow_id";
		
		$slides = $this->administration_model->select_entries_where($table, $where, $items, $order);
		$image_name = $slides[0]->slideshow_image_name;
		$slideshow_path = $this->slideshow_path;
		
		//delete any other uploaded image
		$this->file_model->delete_file($slideshow_path."\\".$image_name);
		
		//delete any other uploaded thumbnail
		$this->file_model->delete_file($slideshow_path."\\thumbnail_".$image_name);
		
		$this->administration_model->delete("slideshow", "slideshow_id", $slideshow_id);
		
		echo "true";
	}
	
	function deactivate_slideshow($slideshow_id)
	{
		$data = array(
			'slideshow_status'=>0
		);
		
		$table = "slideshow";
		$this->administration_model->update($table, $data, "slideshow_id", $slideshow_id);
		
		redirect('administration/slideshow/4/5');
	}
	
	function activate_slideshow($slideshow_id)
	{
		$data = array(
			'slideshow_status'=>1
		);
		
		$table = "slideshow";
		$this->administration_model->update($table, $data, "slideshow_id", $slideshow_id);
		
		redirect('administration/slideshow/4/5');
	}
	
	/********************************************************************************************
	*																							*
	*									GALLERY FUNCTIONS										*
	*																							*
	********************************************************************************************/
	
	function gallery($navigation_id, $sub_navigation_id)
	{
		$_SESSION['navigation_id'] = $navigation_id;
		$_SESSION['sub_navigation_id'] = $sub_navigation_id;
		
  		$table = "gallery";
		$where = "gallery_id > 0";
		$items = "*";
		$order = "gallery_id";
		
		$data['slides'] = $this->administration_model->select_entries_where($table, $where, $items, $order);
		
		$this->load_head();
		$this->load->view("gallery/list_slides", $data);
		$this->load_foot();
	}
	
	function add_gallery($navigation_id, $sub_navigation_id)
	{
		$_SESSION['navigation_id'] = $navigation_id;
		$_SESSION['sub_navigation_id'] = $sub_navigation_id;
		/*
			-----------------------------------------------------------------------------------------
			Validate the input 
			-----------------------------------------------------------------------------------------
		*/
		$this->form_validation->set_rules('check', 'check', 'required');

		if ($this->form_validation->run())
		{
			
			//Libraries
			$this->load->library('upload');
			$this->load->library('image_lib');
		
			// Change $_FILES to new vars and loop them
			foreach($_FILES['gallery'] as $key=>$val)
			{
				$i = 1;
				foreach($val as $v)
				{
					$field_name = "file_".$i;
					$_FILES[$field_name][$key] = $v;
					$i++;   
				}
			}
			// Unset the useless one ;)
			unset($_FILES['gallery']);
		
			// Put each errors and upload data to an array
			$error = array();
			$success = array();
			
			// main action to upload each file
			foreach($_FILES as $field_name => $file)
			{
			
				$upload_conf = array(
					'allowed_types' => 'JPG|JPEG|jpg|jpeg|gif|png',
					'upload_path' => realpath('assets/gallery'),
					'quality' => "100%",
					'file_name' => "image_".date("Y")."_".date("m")."_".date("d")."_".date("H")."_".date("i")."_".date("s"),
					'max_size' => 20000,
					'maintain_ratio' => true,
					/*'height' => 345,*/
					'width' => 900
				 );
			
				$this->upload->initialize( $upload_conf );
				
				if ( ! $this->upload->do_upload($field_name))
				{
					// if upload fail, grab error 
					$error['upload'][] = $this->upload->display_errors();
				}
				else
				{
					// otherwise, put the upload datas here.
					// if you want to use database, put insert query in this loop
					$upload_data = $this->upload->data();
					
					// set the resize config
					$resize_conf = array(
						// it's something like "/full/path/to/the/image.jpg" maybe
						'source_image'  => $upload_data['full_path'], 
						'new_image'     => $upload_data['file_path'].'images/'.$upload_data['file_name'],
						'create_thumb'     => FALSE,
						'width' => 460,
						'height' => 345,
						'maintain_ratio' => true,
						);
		
					// initializing
					$this->image_lib->initialize($resize_conf);
		
					// do it!
					if ( ! $this->image_lib->resize())
					{
						// if got fail.
						$error['resize'][] = $this->image_lib->display_errors();
					}
					else
					{
						// otherwise, put each upload data to an array.
						$success[] = $upload_data;
					}
					
					$data = array(//get the items from the form
						'gallery_image_name' => $upload_data['file_name']
					);
				
					$insert = $this->db->insert('gallery', $data);
				}
				
			}
	
			// see what we get
			if(count($error > 0))
			{
				$data['error'] = $error;
			}
			else
			{
				$data['success'] = $upload_data;
			}
			redirect('administration/gallery/11/9');
		}
		
		else
		{
			/*
				-----------------------------------------------------------------------------------------
				Add a new slide
				-----------------------------------------------------------------------------------------
			*/
		
			/*$table = "gallery";
			$where = "gallery_id > 0";
			$items = "*";
			$order = "gallery_id";
			
			$data['slides'] = $this->administration_model->select_entries_where($table, $where, $items, $order);*/
			
			$this->load_head();
			$this->load->view("gallery/add_slide");
			$this->load_foot();
		}
	}
	
	function delete_gallery($gallery_id)
	{
		$this->administration_model->delete("gallery", "gallery_id", $gallery_id);
		
		echo "true";
	}
	
	function deactivate_gallery($gallery_id)
	{
		$data = array(
			'gallery_status'=>0
		);
		
		$table = "gallery";
		$this->administration_model->update($table, $data, "gallery_id", $gallery_id);
		
		redirect('administration/gallery/11/9');
	}
	
	function activate_gallery($gallery_id)
	{
		$data = array(
			'gallery_status'=>1
		);
		
		$table = "gallery";
		$this->administration_model->update($table, $data, "gallery_id", $gallery_id);
		
		redirect('administration/gallery/11/9');
	}
	
	/********************************************************************************************
	*																							*
	*									MODULES FUNCTIONS										*
	*																							*
	********************************************************************************************/
	
	function modules($navigation_id, $sub_navigation_id)
	{
		$_SESSION['navigation_id'] = $navigation_id;
		$_SESSION['sub_navigation_id'] = $sub_navigation_id;
		
  		$table = "navigation";
		$where = "navigation.navigation_id > 0";
		$items = "*";
		$order = "navigation_name";
		
		$data['navigation'] = $this->administration_model->select_entries_where($table, $where, $items, $order);
		
		$this->load_head();
		$this->load->view("modules/list_modules", $data);
		$this->load_foot();
	}
	
	function add_module($navigation_id, $sub_navigation_id)
	{
		$_SESSION['navigation_id'] = $navigation_id;
		$_SESSION['sub_navigation_id'] = $sub_navigation_id;
		
		/*
			-----------------------------------------------------------------------------------------
			Validate the input 
			-----------------------------------------------------------------------------------------
		*/
		$this->form_validation->set_rules('module_url', 'Module URL', 'trim|required|xss_clean');
		$this->form_validation->set_rules('module_name', 'Module Name', 'trim|required|xss_clean');

		if ($this->form_validation->run())
		{
			$data = array(
				'navigation_name'=>$this->input->post("module_name"),
				'navigation_url'=>$this->input->post("module_url")
			);
			
			$table = "navigation";
			$this->administration_model->insert($table, $data);
			redirect('administration/add_module/'.$_SESSION['navigation_id'].'/'.$_SESSION['sub_navigation_id'].'');
		}
		
		else
		{
			/*
				-----------------------------------------------------------------------------------------
				Add a new module
				-----------------------------------------------------------------------------------------
			*/
			$this->load_head();
			$this->load->view("modules/add_module");
			$this->load_foot();
		}
	}
	
	function edit_module($navigation_id)
	{	
		/*
			-----------------------------------------------------------------------------------------
			Validate the input 
			-----------------------------------------------------------------------------------------
		*/
		$this->form_validation->set_rules('module_url', 'Module URL', 'trim|required|xss_clean');
		$this->form_validation->set_rules('module_name', 'Module Name', 'trim|required|xss_clean');

		if ($this->form_validation->run())
		{
			$data = array(
				'navigation_name'=>$this->input->post("module_name"),
				'navigation_url'=>$this->input->post("module_url")
			);
			
			$table = "navigation";
			$this->administration_model->update($table, $data, "navigation_id", $navigation_id);
			redirect('administration/modules/'.$_SESSION['navigation_id'].'/'.$_SESSION['sub_navigation_id'].'');
		}
		
		else
		{
			$table = "navigation";
			$where = "navigation.navigation_id = ".$navigation_id;
			$items = "*";
			$order = "navigation_name";
			
			$data['navigation'] = $this->administration_model->select_entries_where($table, $where, $items, $order);
			/*
				-----------------------------------------------------------------------------------------
				Add a new module
				-----------------------------------------------------------------------------------------
			*/
			$this->load_head();
			$this->load->view("modules/edit_module", $data);
			$this->load_foot();
		}
	}
	
	function delete_module($navigation_id)
	{
		$this->administration_model->delete("sub_navigation", "navigation_id", $navigation_id);
		$this->administration_model->delete("navigation", "navigation_id", $navigation_id);
		
		echo "true";
	}
	
	function sub_modules($navigation_id, $sub_navigation_id)
	{
		$_SESSION['navigation_id'] = $navigation_id;
		$_SESSION['sub_navigation_id'] = $sub_navigation_id;
		
  		$table = "navigation, sub_navigation";
		$where = "navigation.navigation_id = sub_navigation.navigation_id";
		$items = "navigation.navigation_id, navigation.navigation_name, navigation.navigation_url, sub_navigation.sub_navigation_name, sub_navigation.sub_navigation_url, sub_navigation.sub_navigation_id";
		$order = "navigation_name, sub_navigation_name";
		
		$data['navigation'] = $this->administration_model->select_entries_where($table, $where, $items, $order);
		
		$this->load_head();
		$this->load->view("modules/list_sub_modules", $data);
		$this->load_foot();
	}
	
	function add_sub_module($navigation_id, $sub_navigation_id)
	{
		$_SESSION['navigation_id'] = $navigation_id;
		$_SESSION['sub_navigation_id'] = $sub_navigation_id;
		
		/*
			-----------------------------------------------------------------------------------------
			Validate the input 
			-----------------------------------------------------------------------------------------
		*/
		$this->form_validation->set_rules('module_id', 'Module', 'trim|required|numeric|xss_clean');
		$this->form_validation->set_rules('sub_module_url', 'Sub Module URL', 'trim|required|xss_clean');
		$this->form_validation->set_rules('sub_module_name', 'Sub Module Name', 'trim|required|xss_clean');

		if ($this->form_validation->run())
		{
			$data = array(
				'navigation_id'=>$this->input->post("module_id"),
				'sub_navigation_name'=>$this->input->post("sub_module_name"),
				'sub_navigation_url'=>$this->input->post("sub_module_url")
			);
			
			$table = "sub_navigation";
			$this->administration_model->insert($table, $data);
			redirect('administration/add_sub_module/'.$_SESSION['navigation_id'].'/'.$_SESSION['sub_navigation_id'].'');
		}
		
		else
		{
			$table = "navigation";
			$where = "navigation.navigation_id > 0";
			$items = "*";
			$order = "navigation_name";
			
			$data['navigation'] = $this->administration_model->select_entries_where($table, $where, $items, $order);
			/*
				-----------------------------------------------------------------------------------------
				Add a new module
				-----------------------------------------------------------------------------------------
			*/
			$this->load_head();
			$this->load->view("modules/add_sub_module", $data);
			$this->load_foot();
		}
	}
	
	function edit_sub_module($sub_navigation_id)
	{	
		/*
			-----------------------------------------------------------------------------------------
			Validate the input 
			-----------------------------------------------------------------------------------------
		*/
		$this->form_validation->set_rules('module_id', 'Module', 'trim|required|numeric|xss_clean');
		$this->form_validation->set_rules('sub_module_url', 'Sub Module URL', 'trim|required|xss_clean');
		$this->form_validation->set_rules('sub_module_name', 'Sub Module Name', 'trim|required|xss_clean');

		if ($this->form_validation->run())
		{
			$data = array(
				'navigation_id'=>$this->input->post("module_id"),
				'sub_navigation_name'=>$this->input->post("sub_module_name"),
				'sub_navigation_url'=>$this->input->post("sub_module_url")
			);
			
			$table = "sub_navigation";//echo $this->input->post("module_id");
			$this->administration_model->update($table, $data, "sub_navigation_id", $sub_navigation_id);
			redirect('administration/sub_modules/'.$_SESSION['navigation_id'].'/'.$_SESSION['sub_navigation_id'].'');
		}
		
		else
		{
			$table = "navigation";
			$where = "navigation.navigation_id > 0";
			$items = "*";
			$order = "navigation_name";
			$data['navigation'] = $this->administration_model->select_entries_where($table, $where, $items, $order);
			
			$table = "navigation, sub_navigation";
			$where = "sub_navigation.sub_navigation_id = ".$sub_navigation_id." AND navigation.navigation_id = sub_navigation.navigation_id";
			$items = "navigation.navigation_id, navigation.navigation_name, navigation.navigation_url, sub_navigation.sub_navigation_name, sub_navigation.sub_navigation_url, sub_navigation.sub_navigation_id";
			$order = "navigation_name, sub_navigation_name";
			$data['sub_navigation'] = $this->administration_model->select_entries_where($table, $where, $items, $order);
			/*
				-----------------------------------------------------------------------------------------
				Add a new module
				-----------------------------------------------------------------------------------------
			*/
			$this->load_head();
			$this->load->view("modules/edit_sub_module", $data);
			$this->load_foot();
		}
	}
	
	function delete_sub_module($sub_navigation_id)
	{
		$this->administration_model->delete("sub_navigation", "sub_navigation_id", $sub_navigation_id);
		
		echo "true";
	}
	
	/********************************************************************************************
	*																							*
	*									CONTACTS FUNCTIONS										*
	*																							*
	********************************************************************************************/
	
	function contacts($navigation_id, $sub_navigation_id)
	{
		$_SESSION['navigation_id'] = $navigation_id;
		$_SESSION['sub_navigation_id'] = $sub_navigation_id;
		
		/*
			-----------------------------------------------------------------------------------------
			Validate the input 
			-----------------------------------------------------------------------------------------
		*/
		$this->form_validation->set_rules('email', 'Email', 'trim|valid_email|xss_clean');
		$this->form_validation->set_rules('phone', 'Phone', 'trim|xss_clean');
		$this->form_validation->set_rules('post', 'Postal Address', 'trim|xss_clean');
		$this->form_validation->set_rules('physical', 'Physical Address', 'trim|xss_clean');
		$this->form_validation->set_rules('facebook', 'Facebook Address', 'trim|xss_clean');
		$this->form_validation->set_rules('blog', 'Blog', 'trim|xss_clean');
		$this->form_validation->set_rules('motto', 'Motto', 'trim|xss_clean');

		if ($this->form_validation->run())
		{
			if(is_uploaded_file($_FILES['userfile']['tmp_name']))
			{
				$gallery_path = $this->gallery_path4;
				/*
					-----------------------------------------------------------------------------------------
					Upload image
					-----------------------------------------------------------------------------------------
				*/
				$image_data = $this->do_upload($gallery_path);
			
				if($image_data == "FALSE"){
					echo $this->upload->display_errors('<p>', '</p>');
					$file_name = "";
				}
				else{
					$path = $image_data['full_path'];
					$file_path = $image_data['file_path'];
					$file_name = $image_data['file_name'];
					$file_type = $image_data['file_type'];
			
					/*
						-----------------------------------------------------------------------------------------
						Resize image
						-----------------------------------------------------------------------------------------
					*/
					$create = $this->resize_image($path, $gallery_path, $file_name);
			
					/*
						-----------------------------------------------------------------------------------------
						Create thumbnail
						-----------------------------------------------------------------------------------------
					*/
					$create = $this->create_thumb($path, $gallery_path, $file_name);
				}
			}
			
			else{
				$file_name = $this->input->post("logo");
			}
			$data = array(
				'email'=>$this->input->post("email"),
				'phone'=>$this->input->post("phone"),
				'post'=>$this->input->post("post"),
				'physical'=>$this->input->post("physical"),
				'site_name'=>$this->input->post("site_name"),
				'blog'=>$this->input->post("blog"),
				'logo'=>$file_name,
				'motto'=>$this->input->post("motto"),
				'facebook'=>$this->input->post("facebook")
			);
			
			$table = "contacts";
			$this->administration_model->update($table, $data, "contacts_id", "1");
			redirect('administration/contacts/'.$_SESSION['navigation_id'].'/'.$_SESSION['sub_navigation_id']);
		}
		
		else
		{
			$table = "contacts";
			$where = "contacts_id = 1";
			$items = "*";
			$order = "contacts_id";
			
			$data['contacts'] = $this->administration_model->select_entries_where($table, $where, $items, $order);
			
			$this->load_head();
			$this->load->view("contacts/list_contacts", $data);
			$this->load_foot();
		}
	}
	
	/********************************************************************************************
	*																							*
	*									PAGES FUNCTIONS											*
	*																							*
	********************************************************************************************/
	
	function pages($navigation_id, $sub_navigation_id)
	{
		$_SESSION['navigation_id'] = $navigation_id;
		$_SESSION['sub_navigation_id'] = $sub_navigation_id;
		
  		$table = "page";
		$where = "page_id > 0";
		$items = "*";
		$order = "page_position, page_name";
		
		$data['pages'] = $this->administration_model->select_entries_where($table, $where, $items, $order);
		
		$this->load_head();
		$this->load->view("pages/list_pages", $data);
		$this->load_foot();
	}
	
	function add_page($navigation_id, $sub_navigation_id)
	{
		$_SESSION['navigation_id'] = $navigation_id;
		$_SESSION['sub_navigation_id'] = $sub_navigation_id;
		/*
			-----------------------------------------------------------------------------------------
			Validate the input 
			-----------------------------------------------------------------------------------------
		*/
		$this->form_validation->set_rules('page_name', 'Page Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('page_url', 'Page URL', 'trim|required|xss_clean');
		$this->form_validation->set_rules('page_position', 'Page Position', 'trim|required|numeric|xss_clean');

		if ($this->form_validation->run())
		{
			$data = array(
				'page_name'=>$this->input->post("page_name"),
				'page_position'=>$this->input->post("page_position"),
				'page_url'=>$this->input->post("page_url")
			);
			
			$table = "page";
			$this->administration_model->insert($table, $data);
			redirect('administration/add_page/'.$_SESSION['navigation_id'].'/'.$_SESSION['sub_navigation_id']);
		}
		
		else
		{
			$this->load_head();
			$this->load->view("pages/add_page");
			$this->load_foot();
		}
	}
	
	function edit_page($page_id)
	{
		/*
			-----------------------------------------------------------------------------------------
			Validate the input 
			-----------------------------------------------------------------------------------------
		*/
		$this->form_validation->set_rules('page_name', 'Page Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('page_url', 'Page URL', 'trim|required|xss_clean');
		$this->form_validation->set_rules('page_position', 'Page Position', 'trim|required|numeric|xss_clean');

		if ($this->form_validation->run())
		{
			$data = array(
				'page_name'=>$this->input->post("page_name"),
				'page_position'=>$this->input->post("page_position"),
				'page_url'=>$this->input->post("page_url")
			);
			
			$table = "page";
			$this->administration_model->update($table, $data, "page_id", $page_id);
			redirect('administration/pages/'.$_SESSION['navigation_id'].'/'.$_SESSION['sub_navigation_id']);
		}
		
		else
		{
			$table = "page";
			$where = "page_id = ".$page_id;
			$items = "*";
			$order = "page_name";
			
			$data['pages'] = $this->administration_model->select_entries_where($table, $where, $items, $order);
			
			$this->load_head();
			$this->load->view("pages/edit_page", $data);
			$this->load_foot();
		}
	}
	
	function delete_page($page_id)
	{
		$this->administration_model->delete("page", "page_id", $page_id);
		
		echo "true";
	}
	
	function deactivate_page($page_id)
	{
		$data = array(
			'page_status'=>0
		);
		
		$table = "page";
		$this->administration_model->update($table, $data, "page_id", $page_id);
		
		redirect('administration/pages/'.$_SESSION['navigation_id'].'/'.$_SESSION['sub_navigation_id']);
	}
	
	function activate_page($page_id)
	{
		$data = array(
			'page_status'=>1
		);
		
		$table = "page";
		$this->administration_model->update($table, $data, "page_id", $page_id);
		
		redirect('administration/pages/'.$_SESSION['navigation_id'].'/'.$_SESSION['sub_navigation_id']);
	}
	
	function crop()
	{
		$response_crop = $this->file_model->crop_file($this->slideshow_path."\\f8a8761d84de3e5f360b8f0b90fccc5f.JPG", 1920, 1010);
		
		var_dump($response_crop);
	}
}