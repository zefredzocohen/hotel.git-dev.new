<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//require_once 'admin/AdminHome.php';
class payments extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->model('mail_template_model');
        $this->load->model('mail_history_model');
        $this->load->library('email');
    }

    public function index()
    {
    }
    function book(){
        
        $config = get_config_email($this->config->item('address_email'),$this->config->item('pass_email'));
         $data = array(
             'user_name'=> ' bạn',
             'home_page' => 'Star View',
             'email' =>$config['smtp_user'],
             'post_room_id' =>$config['smtp_user'],
             'price' =>$config['smtp_user'],
             'check_in' =>$config['smtp_user'],
             'check_out' =>$config['smtp_user'],
             'post_room_id' =>$config['smtp_user'],
             'post_room_id' =>$config['smtp_user'],
             
             
                 );
        echo $this->email->print_debugger();
        echo 'Đặt phòng thành công';
        echo $this->sendEmail($this, 'lehai04.1991.9@gmail.com', 'Email thông báo đặt phòng', 'email đặt phòng thành công từ người quản trị đến người đặt phòng',$config);
        echo $this->sendEmail($this, $this->config->item('address_email'), 'Email thông báo đặt phòng', 'email đặt phòng thành công từ hệ thống đến người quản trị ',$config);
        echo $this->sendEmail($this, 'zefredzocohen@gmail.com', 'Email thông báo đặt phòng', 'email đặt phòng thành công từ hệ thống đến Đối tác ',$config);
    }
    
    function sendEmail(&$mail_object, $mailTo,$mailSubject,$content,$config){
        $this->email->initialize($config);
        $this->email->from($this->config->item('address_email'), $this->config->item('name_company'));
        $mail_object->email->to($mailTo); 
        $mail_object->email->set_mailtype("html");
        $mail_object->email->subject($mailSubject);
//         $body = $this->load->view('email_config_order.php',$data,TRUE);
        $mail_object->email->message($content);   
        return $mail_object->email->send();
    }


}