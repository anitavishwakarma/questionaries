<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Services extends CI_Controller {
    
    /* call parent constructor */
    function __construct() {
        parent::__construct();
        $this->output->set_content_type('application/json');
    }

    /**
     * @Function: index
     * @Purpose:  index action for this controller
     */
    public function index() {
    }
    
    /**
     * @Function: get_qus_type
     * @Purpose:  Get All Questions Types
     */
    public function get_qus_type() {        
        try{
            $getData = $this->input->get();
            $data['fields'] = array('id' => 'id', 'type' => 'type', 'value' => 'type_value');
        
            /* add condition to get only a single question based on id */
            if(isset($getData['id']) && !empty($getData['id']) && is_numeric($getData['id'])){
                $data['condition'] = array('id' => $getData['id']);
            }else if(isset($getData['id']) && !is_numeric($getData['id'])){
                throw new Exception("Invalid Id value.");                 
            }

            /* add condition to get data from specific offset */
            if(isset($getData['offset']) && $getData['offset'] >= 0){
                $data['offset'] = $getData['offset'];
            } else if(isset($getData['offset']) && $getData['offset'] < 0){
                throw new Exception("Invalid offset value."); 
            } 
            
            /* add limit to get only limited records */
            if(isset($getData['limit']) && !empty($getData['limit']) && $getData['limit'] > 0){
                $data['limit'] = $getData['limit'];
            } else if(isset($getData['limit']) && $getData['limit'] <= 0){
                throw new Exception("Invalid limit value."); 
            } 
        
            $this->load->model('qus_mngmnt_model');
            $resultData = $this->qus_mngmnt_model->getData(TBL_QUS_TYPE, $data);
            $this->output->set_output(json_encode(array('success' => 1, 'data' => $resultData)));
        }catch(Exception $e){
            $this->output->set_output(json_encode(array('error' => $e->getMessage())));
        }
    }
        
    /**
     * @Function: get_qus
     * @Purpose:  Get All Questions to display
     */
    public function get_qus() {        
        try{
            $getData = $this->input->get();
            $data['fields'] = array('id' => 'id', 'qus' => 'question', 'ans' => 'answer', 'type' => 'question_type');
        
            /* add condition to get only a single question based on id */
            if(isset($getData['id']) && !empty($getData['id']) && is_numeric($getData['id'])){
                $data['condition'] = array('id' => $getData['id']);
            }else if(isset($getData['id']) && !is_numeric($getData['id'])){
                throw new Exception("Invalid Id value.");                 
            }
            
            /* add condition to get data from specific offset */
            if(isset($getData['offset']) && $getData['offset'] >= 0){
                $data['offset'] = $getData['offset'];
            } else if(isset($getData['offset']) && $getData['offset'] < 0){
                throw new Exception("Invalid offset value."); 
            } 
            
            /* add limit to get only limited records */
            if(isset($getData['limit']) && !empty($getData['limit']) && $getData['limit'] > 0){
                $data['limit'] = $getData['limit'];
            } else if(isset($getData['limit']) && $getData['limit'] <= 0){
                throw new Exception("Invalid limit value."); 
            } 
        
            /* get only parent questions */
            $data['condition']['parent_qus_id >'] = 0;
            
            $this->load->model('qus_mngmnt_model');
            $resultData = $this->qus_mngmnt_model->getData(TBL_QUS, $data);
            $this->output->set_output(json_encode(array('success' => 1, 'data' => $resultData)));
        }catch(Exception $e){
            $this->output->set_output(json_encode(array('error' => $e->getMessage())));
        }
    }
    
    /**
     * @Function: get_sub_qus
     * @Purpose:  Get Sub Questions for a question
     */
    public function get_sub_qus() {        
        try{
            $getData = $this->input->get();
            $data['fields'] = array('id' => 'id', 'qus' => 'question', 'ans' => 'answer', 'type' => 'question_type');
        
            /* add condition to get only a single question based on id */
            if(isset($getData['id']) && !empty($getData['id']) && is_numeric($getData['id'])){
                $data['condition'] = array('parent_qus_id' => $getData['id']);
            }else {
                throw new Exception("Invalid Id value.");                 
            }
            
            $this->load->model('qus_mngmnt_model');
            $resultData = $this->qus_mngmnt_model->getData(TBL_QUS, $data);
            $this->output->set_output(json_encode(array('success' => 1, 'data' => $resultData)));
        }catch(Exception $e){
            $this->output->set_output(json_encode(array('error' => $e->getMessage())));
        }
    }
}

/* End of file qus_management.php
 * Location: ./application/controllers/services.php
 * Purpose: Manage function for web servies
 * Author: Anita V
 */