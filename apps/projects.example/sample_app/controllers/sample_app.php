<?php

/**
 * Description of sample_app
 *
 * @author ramin ashrafimanesh <ashrafimanesh@gmail.com>
 */
class sample_app {
    public function index(Request $Request){
        load_app_model('sample_model', 'sample_app');
        
        $sample_model=new sample_model();
        $result=$sample_model->get_rows();
        dd($Request->get(),__LINE__,$result);
    }
}
