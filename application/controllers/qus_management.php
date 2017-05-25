<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Qus_Management extends CI_Controller {
    
    /* call parent constructor */
    function __construct() {
        parent::__construct();
    }

    /**
     * @Function: index
     * @Purpose:  Index Page for this controller, which is used to display the first view to users
     */
    public function index() {
        /* load header */
        $headerData['title']    = 'Question Management';
        $this->load->view('include/header', $headerData);
        $this->load->model('qus_mngmnt_model');
        $resultData = $this->qus_mngmnt_model->getData(TBL_QUS_TYPE, array('fields' => array('id', 'type_value')));
        $data['qusType']  = $resultData;
        $this->load->view('qus_management', $data);
        $this->load->view('include/footer');
    }
        
    /**
     * @Function: save_qus
     * @Purpose:  Save Question detail
     */
    public function save_qus() {
        try{
            $data = $this->input->post();        
            $this->load->model('qus_mngmnt_model');
            $resultData       = $this->qus_mngmnt_model->saveQusData($data);
            if($resultData){
                echo json_encode(array('success' => 1));
            }else{
                echo json_encode(array('error' => 1));
            }
        }catch(Exception $e){
            echo json_encode(array('error' => $e->getMessage()));
        }
    }
}

/* End of file qus_management.php
 * Location: ./application/controllers/qus_management.php
 * Purpose: Manage function for managing the questions
 * Author: Anita V
 */