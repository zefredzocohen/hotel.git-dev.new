<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Room extends MY_Controller {
		function __construct(){
			parent:: __construct();
			$this->load->model('post_room_model');
                        $this->load->model('Address_model');
                        $this->load->model('Amenities_model');
                        $this->load->model('Experience_model');
		}

		public function search(){
                    $_location = trim($this->input->get('location'));
                    if($_location!=NULL) $_location = vn_str_filter (strtolower ($_location));
                    $search_input = array(
                        'location'  =>  $_location,
                        'checkin'   =>  trim($this->input->get('checkin')),
                        'checkout'  =>  trim($this->input->get('checkout')),
                        'guest'     =>  trim($this->input->get('guest')),
                    );
                    $total = $this->post_room_model->search($search_input)->num_rows();
                    $data['total'] = $total;
                    
                    $config['total_rows'] = $data['total'];
                    $config['base_url'] = rtrim(base_url()."site/room/search?location=".$_GET['location']);
                    $config['per_page'] = 2;
                    $config['use_page_numbers'] = TRUE;
                    $config['page_query_string'] = TRUE;
                    $config['query_string_segment'] = 'page';
                    $config['uri_segment'] = 4;
                    // config pagintion với bootraps
                    $config['full_tag_open'] = '<ul class="pagination">';
                    $config['full_tag_close'] = '</ul>';
                    $config['first_link'] = false;
                    $config['last_link'] = false;
                    $config['first_tag_open'] = '<li>';
                    $config['first_tag_close'] = '</li>';
                    $config['prev_link'] = '&laquo';
                    $config['prev_tag_open'] = '<li class="prev">';
                    $config['prev_tag_close'] = '</li>';
                    $config['next_link'] = '&raquo';
                    $config['next_tag_open'] = '<li>';
                    $config['next_tag_close'] = '</li>';
                    $config['last_tag_open'] = '<li>';
                    $config['last_tag_close'] = '</li>';
                    $config['cur_tag_open'] = '<li class="active"><a href="#">';
                    $config['cur_tag_close'] = '</a></li>';
                    $config['num_tag_open'] = '<li>';
                    $config['num_tag_close'] = '</li>';
                    
                    $this->pagination->initialize($config);
                    $data['pagination_link'] = $this->pagination->create_links();
                    $data['per_page'] = $config['per_page'];
                    if(isset($_GET['checkin'])&&trim($_GET['checkin'])!=''){
                        $data['checkin'] = trim($_GET['checkin']);
                    }
                    if(isset($_GET['checkout'])&&trim($_GET['checkout'])!=''){
                        $data['checkout'] = trim($_GET['checkout']);
                    }
                    if(isset($_GET['guest'])&&trim($_GET['guest'])!=''){
                        $data['guest'] = trim($_GET['guest']);
                    }
                    $amenities = $this->input->post('amenities')?$this->input->post('amenities'):'';
                    $experiences = $this->input->post('experiences')?$this->input->post('experiences'):'';
                    $bedroom = $this->input->post('bedroom')?$this->input->post('bedroom'):'';
                    $bathroom = $this->input->post('bathroom')?$this->input->post('bathroom'):'';
                    $beds = $this->input->post('beds')?$this->input->post('beds'):'';
                    
                    if($amenities!=''||$experiences!=''||$bedroom!=''||$bathroom!=''||$beds!=''){
                        echo json_encode(array(
                            'result'    =>'result',
                        ));
                        exit;
                    }
                    
                    
                    
                    $start = isset($_GET['page'])&&trim($_GET['page'])!=''?$_GET['page']-1:0;
                    
                    $this->load->library('pagination', $config);
                    $list_room = $this->post_room_model->search($search_input,$data['per_page'],$start)->result();
                    if(count($list_room)>0){
                    //get room type
                        foreach ($list_room as $line => $room){
                            $data['room_type'][$line] = array($room->house_type_name, $room->house_type_id);
                            $data['amenities'] = !isset($data['amenities'])?explode(',', $room->amenities):array_merge($data['amenities'],array_diff(explode(',', $room->amenities),$data['amenities']));
                            $data['experience'] = !isset($data['experience'])?explode(',', $room->experience):array_merge($data['experience'],array_diff(explode(',', $room->experience),$data['experience']));
                            $data['price_range'][$line] = $room->price_night_vn;
                        }
                        $data['table_amenities']= get_checkbox_manage_table('amenities','Tiện nghi',  $this, 120,$this->Amenities_model->getListAll());
                        $data['table_experiences'] = get_checkbox_manage_table('experiences','Trải nghiệm',  $this, 120,$this->Experience_model->getListAll());
                        $data['list_room'] = $list_room;
                        sort($data['price_range']);
                        $data['price_range_min'] = min($data['price_range']);
                        $data['price_range_max'] = $data['price_range_min']*100; 
                        unset($data['price_range']);
                        if($list_room){
                                $data['list_room'] = $list_room;
                        }
                        else{
                            $data['list_room'] = NULL;
                        }
                    }
                    $data['temp'] = ('site/room/list_room');
                    $this->load->view('site/layout', isset($data) ? ($data) : null);
	    }

		function room_detail(){
                    if(isset($_GET['ch_in'])&&trim($_GET['ch_in'])!=''){
                        $data['ch_in'] = trim($_GET['ch_in']);
                    }
                    if(isset($_GET['ch_out'])&&trim($_GET['ch_out'])!=''){
                        $data['ch_out'] = trim($_GET['ch_out']);
                    }
                    if(isset($_GET['guest'])&&trim($_GET['guest'])!=''){
                        $data['guest'] = trim($_GET['guest']);
                    }
                    $this->load->model('amenities_model');

                    $id = $this->uri->rsegment(3);
                    $id = (int)$id;
                    $data_room = array(
                        'room_id'=>$id,
                        
                    );
                    $this->session->set_userdata($data_room);
                    $input = array();

                    $list_amenities = $this->amenities_model->get_list();
                    $data['list_amenities'] = $list_amenities;
                    $info = $this->post_room_model->getInfoDetail($id,$input);

                    if($info){
                            $data['info'] = $info;
                    }

                    $data['meta_title'] = 'room_detail';
                    $data['temp'] = ('site/room/room_detail');
                    $this->load->view('site/layout_index', isset($data) ? ($data) : null);
		}
                
                function order_room(){
                    if(!isset($_SESSION['user_name'])){
                        redirect('site/home/register');
                    }else{
                        $data['temp'] = ('site/room/order');
                    $this->load->view('site/layout', isset($data) ? ($data) : null);
                    }
                }
	}
?>