<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inmarsat extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->model(array('kapal_model','tracking_model','event_model','detail_event_model'));
    }
    private function _IDPRest($data){
        $data_string = json_encode($data);                                                                                                                                                                                                   
        $ch = curl_init('http://35.198.220.23/idp2/api.php');                                                                      
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
            'Content-Type: application/json',                                                                                
            'Content-Length: ' . strlen($data_string))                                                                       
        );                                                                                                                   
        $result = curl_exec($ch);
        return json_decode($result,true);
    }
    public function track(){
        date_default_timezone_set('GMT');
        $lokal_time = date("Y-m-d H:i:s");
        $utc_start_time = date('Y-m-d H:i:s',strtotime('-1 hour',strtotime($lokal_time)));
        $data=$this->kapal_model->getAll();
        foreach($data as $item){
            $id_kapal = $item->id_kapal;
            $id_idp = $item->id_idp;
            $data = array("token" => "1609c743dbd0e94ef07895733c3844dd", "scope" => "location", "start_time"=>$utc_start_time,"end_time"=>$lokal_time); 
            $result = $this->_IDPRest($data);
            $mydata=$result['data'];
            foreach($mydata as $item){
                if($item['device_id']==$id_idp){
                    $kapal=array(
                        'id_kapal' => $id_kapal,
                        'utc_time_tracking' => $item['ts']
                    );
                    if($this->tracking_model->cekLastTracking($kapal)->num_rows()==0){
                        $utc=$item['ts'];
                        $gmt=date('Y-m-d H:i:s',strtotime('+7 hour',strtotime($utc)));
                        $tracking=array(
                            'id_kapal' => $id_kapal,
                            'latitude' => $item['lat'],
                            'longitude' => $item['lon'],
                            'heading' => $item['heading'],
                            'speed' => $item['speed'],
                            'altitude' => $item['alt'],
                            'cton' => $item['cno'],
                            'utc_time_tracking'   => $item['ts'],
                            'gmt_time_tracking' => $gmt
                        );
                        $this->tracking_model->addTracking($tracking);
                    }
                }
            }
        }
    }

    public function event(){
        date_default_timezone_set('GMT');
        $lokal_time = date("Y-m-d H:i:s");
        $utc_start_time = date('Y-m-d H:i:s',strtotime('-1 hour',strtotime($lokal_time)));
        $data=$this->kapal_model->getAll();
        foreach($data as $item){
            $id_kapal = $item->id_kapal;
            $id_idp = $item->id_idp;
            $data = array("token" => "1609c743dbd0e94ef07895733c3844dd", "scope" => "event", "start_time"=>$utc_start_time,"end_time"=>$lokal_time); 
            $result = $this->_IDPRest($data);
            $mydata=$result['data'];
            foreach($mydata as $item){
              if($item['device_id']==$id_idp){
                $kapal = array(
                    'id_kapal' => $id_kapal,
                    'nama_event' => $item['keys'],
                    'utc_time_event' => $item['ts']
                );
                if($this->event_model->cekLastEvent($kapal)->num_rows()==0){
                    $utc=$item['ts'];
                    $gmt=date('Y-m-d H:i:s',strtotime('+7 hour',strtotime($utc)));
                    $event=array(
                        'id_kapal' => $id_kapal,
                        'nama_event' => $item['keys'],
                        'utc_time_event' => $item['ts'],
                        'gmt_time_event' => $gmt
                    );
                    $insert = $this->event_model->addEvent($event);
                    if($insert){
                        $data_detail = $item['message'];
                        foreach($data_detail as $new_item => $value){
                            $detail_event = array(
                                'id_event' => $insert,
                                'nama_event' => $new_item,
                                'value_event' => $value
                            );
                            $this->detail_event_model->addDetailEvent($detail_event);
                        }
                    }
                }
              }
            }
        }
    }
}