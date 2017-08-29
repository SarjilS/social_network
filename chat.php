<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Chat extends CI_Controller {

	public function send_message()
	{
		$reciver = $_POST['receiver'];
		$msg = htmlspecialchars($this->input->post('msg'));
		$sender = $this->session->userdata('user');
		
		$this->load->model('chat_model');
		if($this->chat_model->send_message($sender, $reciver, $msg))
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function get_message()
	{
		$reciver = $_POST['fid'];
		$sender = $_POST['mid'];
		
		$this->load->model('chat_model');
		if($msg_data = $this->chat_model->get_message($sender, $reciver))
		{
			$data = array(
				'message'=> $msg_data->message,
				'time' => $msg_data->time, 
				'read'=> $msg_data->read
			 );
			 $msg_id = $msg_data->id;
			 $this->chat_model->read_message($msg_id);
		}
		else
		{
			return false;
		}

		echo json_encode($data);
	}
}

/* End of file chat.php */
/* Location: ./application/controllers/chat.php */