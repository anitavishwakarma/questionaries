<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Qus_mngmnt_model extends CI_Model {
    /** @Function: __construct */
    function __construct() {
        parent::__construct();
    }

    /**
     * @Function: getData
     * @Purpose:  get data for question details
     */
    public function getData($tableName, $data) {
        $fields = isset($data['fields']) ? $data['fields'] : '*';
        $this->db->select($fields);   
        /* if need to check any condition */
        if(isset($data['condition']) && !empty($data['condition']) && isset($data['limit']) && !empty($data['limit']) && isset($data['offset']) && $data['offset'] >= 0){
            $query = $this->db->get_where($tableName, $data['condition'], $data['limit'], $data['offset']);
        }else if(isset($data['limit']) && !empty($data['limit']) && $data['limit'] > 0 && isset($data['offset']) && $data['offset'] >= 0){ /* else if need to get some specific range data */
            $query = $this->db->get($tableName, $data['limit'], $data['offset']);
        }else if(isset($data['condition']) && !empty($data['condition']) ){ /* else if need to get some specific range data */
            $query = $this->db->get_where($tableName, $data['condition']);
        }else { /* else need to get data without condition and limit */
            $query = $this->db->get($tableName);
        }
        return $query->result();
    }
    
    /**
     * @Function: saveQusData
     * @Purpose:  Save data for question details
     */
    public function saveQusData($data) {
        try{
            if(is_array($data) && !empty($data)){
                if(isset($data['qus']) && is_array($data['qus']) && !empty($data['qus'])){
                    $this->db->trans_start();
                    foreach($data['qus'] as $qKey => $qVal){ 
                        /* if sub question then no need to traverse it separately */
                        if(strpos($qKey, '_sub_qus') != false){
                            continue;
                        }
                        $qusType = isset($data['qus_choice'][$qKey]) ? $data['qus_choice'][$qKey] : '';
                        /* if multiple answer then need to store with | separator */
                        $ans  = (isset($data['ans'][$qKey]) && is_array($data['ans'][$qKey]) && !empty($data['ans'][$qKey])) ? (implode('|', $data['ans'][$qKey])) : '';
                        $date = date('Y-m-d H:i:s');
                        $queryData = array(
                                        'question' => $qVal,
                                        'question_type' => $qusType,
                                        'answer' => $ans,
                                        'created_at' => $date
                                    );                    
                        $this->db->insert(TBL_QUS, $queryData);                    
                        $parentId = $this->db->insert_id();

                        /* save sub question data if have any sub question */
                        if(isset($data['qus'][$qKey.'_sub_qus']) && is_array($data['qus'][$qKey.'_sub_qus']) && !empty($data['ans'][$qKey.'_sub_qus'])){
                            foreach($data['qus'][$qKey.'_sub_qus'] as $subKey => $subQus){                            
                                /* if parent added successfully then only need to append sub question detail */
                                if($parentId > 0){
                                    $qusType = isset($data['qus_choice'][$qKey.'_sub_qus'][$subKey]) ? $data['qus_choice'][$qKey.'_sub_qus'][$subKey] : '';
                                    /* if multiple answer then need to store with | separator */
                                    $ans  = (isset($data['ans'][$qKey.'_sub_qus'][$subKey]) && is_array($data['ans'][$qKey.'_sub_qus'][$subKey]) && !empty($data['ans'][$qKey.'_sub_qus'][$subKey])) ? (implode('|', $data['ans'][$qKey.'_sub_qus'][$subKey])) : '';
                                    $queryData = array(
                                                        'parent_qus_id' => $parentId,
                                                        'question' => $subQus,
                                                        'question_type' => $qusType,
                                                        'answer' => $ans,
                                                        'created_at' => $date
                                                    );
                                    $this->db->insert(TBL_QUS, $queryData);
                                    $parentId = $this->db->insert_id(); /* change parent Id as need to append next sub question */
                                }
                            }                        
                        }
                    }
                    $this->db->trans_complete();
                }
                return true;
            }else{
                return false;
            }
        }catch(Exception $err){
            return false;
        }
    }
}

/* End of file qus_management.php
 * Location: ./application/model/qus_mngmnt_model.php
 * Purpose: Model to intract with question tables
 * Author: Anita V
 */