<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->model('Address_model');
    }
    public function index()
    {
        $data['meta_title'] = 'STAR VIEW Home page';
        $data['temp'] = ('site/home/index');
        $this->load->view('site/layout_index', isset($data) ? ($data) : null);
    }
    public function bookroom()
    {
        $data['meta_title'] = 'Bookroom - ';
        $data['temp'] = ('site/home/bookroom');
        $this->load->view('site/layout', isset($data) ? ($data) : null);
    }
    public function listroom()
    {
        $data['meta_title'] = 'Listroom';
        $data['temp'] = ('site/home/listroom');
        $this->load->view('site/layout_index', isset($data) ? ($data) : null);
    }
    public function login()
    {
        $data['meta_title'] = 'Login';
        $data['temp'] = ('site/home/login');
        $this->load->view('site/layout', isset($data) ? ($data) : null);
    }
    public function postnews1()
    {
        $data['meta_title'] = 'Postnews1';
        $data['temp'] = ('site/home/postnews1');
        $this->load->view('site/layout', isset($data) ? ($data) : null);
    }
    public function postnews2()
    {
        $data['meta_title'] = 'Postnews2';
        $data['temp'] = ('site/home/postnews2');
        $this->load->view('site/layout', isset($data) ? ($data) : null);
    }
    public function postnews3()
    {
        $data['meta_title'] = 'Postnews3';
        $data['temp'] = ('site/home/postnews3');
        $this->load->view('site/layout', isset($data) ? ($data) : null);
    }
    public function postnews_success()
    {
        $data['meta_title'] = 'Postnews_success';
        $data['temp'] = ('site/home/postnews_success');
        $this->load->view('site/layout', isset($data) ? ($data) : null);
    }
    public function register()
    {
        $data['meta_title'] = 'Register';
        $data['temp'] = ('site/home/register');
        $this->load->view('site/layout', isset($data) ? ($data) : null);
    }
    public function process($query = ''){
        //get data from address_model vs $query
        $query = strtolower(trim($_POST['query']));
        $query_no = vn_str_filter($query);
        $data = $this->Address_model->getAddress($query_no);
        if(count($data)>0){
            foreach ($data as $key =>$value){
                //search theo tên đường
                if(count(explode(strtolower($query_no), strtolower($value['address_detail_ascii'])))>1){
                    $result[$key] = $value['address_detail'];
                //search theo tên quan, huyện    
                }elseif (count(explode(strtolower($query_no),strtolower($value['district_ascii'])))>1) {
                    $result[$key] = $value['district'].', '.$value['provincial'].', '.$value['country'];
                //search theo tên tỉnh, thành phố
                }elseif(count(explode(strtolower($query_no),strtolower($value['provincial_ascii'])))>1){
                    $result[$key] = $value['provincial'].', '.$value['country'];
                //search theo tên quốc gia
                }elseif(count(explode(strtolower($query_no),strtolower($value['country_ascii'])))>1){
                     $result[$key] = $value['country'];
                // search mặc định
                }else{
//                $result[$key] = $value['address_street'].', '.$value['district'].', '.$value['provincial'].', '.$value['country'];
                $result[$key] = $value['address_detail'];
                }
            }
            $result = array_unique($result);
            echo json_encode($result);
        }else   
            echo json_encode (array(
                'result'=>'',
            ));
        exit();
    }
}
