<?php
if ( ! defined('BASEPATH')){
	exit('No direct script access allowed');
}

class chat_model extends CI_Model
{
	public function send_message($sender, $reciver, $msg)
	{
		$this->load->database();
		$this->db->select('u_id');
		$this->db->where('user_name', $sender);
		$query = $this->db->get('users');
		$sender_id = $query->row()->u_id;
		
		$time = date("d/m/y")." ".date("h:i a");
		$message_data= array(
			'to' => $reciver,
			'from' => $sender_id,
			'message' => $msg,
			'time' => $time
		);
		
		$this->db->insert('chat', $message_data);
	}
	
	/*
	public function is_received($sender, $reciver)
	{
		$this->load->database();
		$this->db->select('id');
		$this->db->where('to', $reciver);
		$this->db->where('from', $sender);
		$this->db->where('read', 0);
		$query = $this->db->get('chat');
		
		return $query->num_rows();
	}
	*/
	
	public function get_message($sender, $reciver)
	{
		$this->load->database();
		$this->db->where('to', $reciver);
		$this->db->where('from', $sender);
		$this->db->where('read', 0);
		$this->db->order_by('id', 'DESC');
		$this->db->limit('1');
		$query = $this->db->get('chat');
		
		return $query->row();
	}
	
	public function read_message($msg_id)
	{
		$this->load->database();
		$msg = array('read' => '1');
		$this->db->where('id', $msg_id);
		$this->db->update('chat', $msg);
		return true;
	}
}
