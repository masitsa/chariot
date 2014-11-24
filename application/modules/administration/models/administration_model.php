<?php

class Administration_model extends Model {
	
	/*
		-----------------------------------------------------------------------------------------
		Retrieve all data from a table in the database
		-----------------------------------------------------------------------------------------
	*/
	 function select($table)
    {
        $query = $this->db->get($table);
		return $query->result();
    }
	
	 function select_order($table, $order, $orient)
    {
        $this->db->select("*");
        $this->db->from($table);
        $this->db->order_by($order, $orient);
       
        $query = $this->db->get();
		return $query->result();
    }
	
	function select_pagination($limit, $start, $table, $where, $items, $order)
	{
		$this->db->limit($limit, $start);
        
        $this->db->select($items);
		$this->db->from($table);
        $this->db->where($where);
		$this->db->order_by($order, "asc"); 
		
		$query = $this->db->get();
 
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
	}
	
	/*
		-----------------------------------------------------------------------------------------
		Retrieve particular data from multiple tables in the database
		-----------------------------------------------------------------------------------------
	*/
	 function select_entries_where($table, $where, $items, $order)
    {
        $this->db->select($items);
        $this->db->from($table);
        $this->db->where($where);
        $this->db->order_by($order, "asc");
       
        $query = $this->db->get();
       
        return $query->result();
    }
	
	/*
		-----------------------------------------------------------------------------------------
		Retrieve particular data from multiple tables in the database
		-----------------------------------------------------------------------------------------
	*/
	 function select_entries_where2($table, $where, $items, $order)
    {
        $this->db->select($items);
        $this->db->from($table);
        $this->db->where($where);
        $this->db->order_by($order, "DESC");
       
        $query = $this->db->get();
       
        return $query->result();
    }
	
	/*
		-----------------------------------------------------------------------------------------
		Save data to the database
		-----------------------------------------------------------------------------------------
	*/
	 function insert($table, $items)
    {
        $this->db->insert($table, $items);
		
		return $this->db->insert_id();
    }
	
	/*
		-----------------------------------------------------------------------------------------
		Updates data in the database
		-----------------------------------------------------------------------------------------
	*/
	 function update($table, $items, $field, $key)
    {
		$this->db->where($field, $key);
        $this->db->update($table, $items);
    }
	
	/*
		-----------------------------------------------------------------------------------------
		Deletes data in the database
		-----------------------------------------------------------------------------------------
	*/
	 function delete($table, $field, $key)
    {
		$this->db->where($field, $key);
        $this->db->delete($table);
    }  
    
	public function items_count($table, $where) {
        $this->db->where($where);
		$this->db->from($table);
        return $this->db->count_all_results();
    }
	
	/*
		-----------------------------------------------------------------------------------------
		Select a number of items from a particluar database table; inverse order
		-----------------------------------------------------------------------------------------
	*/
	function select_limit2($limit, $table, $where, $items, $order)
	{
		$this->db->limit($limit);
        
        $this->db->select($items);
		$this->db->from($table);
        $this->db->where($where);
		$this->db->order_by($order, "desc"); 
		
		$query = $this->db->get();
 
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
	}
	function select_limit($limit, $table, $where, $items, $order)
	{
		$this->db->limit($limit);
        
        $this->db->select($items);
		$this->db->from($table);
        $this->db->where($where);
		$this->db->order_by($order, "asc"); 
		
		$query = $this->db->get();
 
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
	}
	
	function limit_text($text, $limit) 
	{
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
					$return .= $pieces[$r]."</i><br/><i>";
				}
				else{
					$return .= $pieces[$r]." ";
				}
			}
		}
		
		else{
			$return = "<i>".$text;
		}
		return $return.'</i><br/>';
    }
	
	public function upload_slideshow_image($slideshow_path)
	{
		//upload product's gallery images
		$resize['width'] = 1920;
		$resize['height'] = 1010;
		
		if(isset($_FILES['slideshow_image']['tmp_name']))
		{
			//delete any other uploaded image
			$this->file_model->delete_file($slideshow_path."\\".$this->session->userdata('slideshow_file_name'));
			
			//delete any other uploaded thumbnail
			$this->file_model->delete_file($slideshow_path."\\thumbnail_".$this->session->userdata('slideshow_file_name'));
			//Upload image
			$response = $this->file_model->upload_file($slideshow_path, 'slideshow_image', $resize);
			if($response['check'])
			{
				$file_name = $response['file_name'];
				$thumb_name = $response['thumb_name'];
				
				//crop file to 1920 by 1010
				$response_crop = $this->file_model->crop_file($slideshow_path."\\".$file_name, 1920, 1010);
				
				if(!$response_crop)
				{
					$this->session->set_userdata('slideshow_error_message', $response_crop);
				
					return FALSE;
				}
				
				else
				{	
					//Set sessions for the image details
					$this->session->set_userdata('slideshow_file_name', $file_name);
					$this->session->set_userdata('slideshow_thumb_name', $thumb_name);
				
					return TRUE;
				}
			}
		
			else
			{
				$this->session->set_userdata('slideshow_error_message', $response['error']);
				
				return FALSE;
			}
		}
		
		else
		{
			$this->session->set_userdata('vendor_logo_error_message', '');
			return FALSE;
		}
	}
}
