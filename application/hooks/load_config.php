<?php

function load_config(){
    $CI = &get_instance();
    foreach ($CI->app_config_model->get_all()->result() as $app_config){
        $CI->config->set_item($app_config->key, $app_config->value);
    }
    
    if($CI->config->item('language')){
        $CI->lang->switch_to($CI->config->item('language'));
    }
}