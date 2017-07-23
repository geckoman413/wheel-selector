<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Wheelset extends MY_Model{
    const DB_TABLE = 'wheelsets';
    const DB_TABLE_PK = 'id';
    
    //Need to list out all the db fields here
    public $id;
    public $wheel_name;
    public $weight;
    public $tubular;
    
    
    public function __construct(){
        parent::__construct();
       
    }
    public function density($alt="", $Tair="", $humidity=""){
	 	
		//This only takes into account altitude gain!!!!
		//Pressure dry 
		$P_dry =P_SEALEVEL*pow((1-(TEMP_LAPSE* feet2meters($alt))/T_SEALEVEL), (GRAVITY/(R_AIR*TEMP_LAPSE)));
		//THIS IS CORRECT (IDEAL GAS LAW)
		$t_rank = fariengheight2kelvin($Tair);
		$rho_dry = (($P_dry*1000)/(R_AIR*$t_rank));
		
		//Saturation pressure of wator vapor in air 
		////THIS IS GOOD
		$P_sat = exp((77.345+0.0057*$t_rank-7235/$t_rank))/pow($t_rank,8.2);
		
		$Pw = ($humidity/100)*$P_sat;
		
		$x = 0.62198*$Pw / (($P_dry*1000)-$Pw);
		
		$rho_actual = $rho_dry *((1+$x)/(1+1.609*$x));
		//This is some empherical ratio to determine actual density based on humidity ratio
		
		//populate output table:
		$data['P_sat']=$P_sat;
		$data['P_dry']=$P_dry;
		$data['$Pw']=$Pw;
		$data['x']=$x;
		$data['rho_dry']=$rho_dry;
		$data['rho_actual']=$rho_actual;
		
		return($data);
	 }
	 
	 
	 
	 
	 
	 
	 
	 public function getweather($zip_code=NULL){
	 	/*
	 	/  Key ID
		/
		/3b0387fbc9acfc15
		/Project Name
		/
		/Bike Wheel Selector
		*/
	 	
	 	$api_key = '3b0387fbc9acfc15';
		$url = 'http://api.wunderground.com/api/'.$api_key;
				
		//$this->form_validation->set_rules('zip_code', 'Zip Code', 'required|min_length[5]|max_length[5]');
	 			
	 //	if ($this->form_validation->run()==FALSE){
	 //		$this->session->set_flashdata('message', validation_errors('<p class = "error">','</p>'));
	 //		redirect('wheels');
	 		
	 //	}else{ 
	 		
				
				$url .='/conditions/q/'.$zip_code.'.json';
				
			 	$weather = file_get_contents($url);
			 	$weather = json_decode($weather);
				
				if(isset($weather->response->error->description)){
						$this->session->set_flashdata('message', 'Zip Code not found');
						return FALSE;
				}
				//preprint($weather);
				$data['zip_code']=$zip_code;
				$data['city_name'] = $weather->current_observation->display_location->full;
			 	$data['wind_degrees'] = $weather->current_observation->wind_degrees;
			 	$data['wind_speed'] = $weather->current_observation->wind_mph;
			 	$data['pressure_in'] = $weather->current_observation->pressure_in;
			 	$data['alt'] = $weather->current_observation->display_location->elevation;
			 	$data['temp_f']= $weather->current_observation->temp_f;
			 	$data['relative_humidity']= (int)trim($weather->current_observation->relative_humidity, "%");
			 	
			 	
			 	
			 	$data['density_data'] = $this->wheelset->density($data['alt'],$data['temp_f'],$data['relative_humidity']);
				
				return($data);
			
	 		}
}
