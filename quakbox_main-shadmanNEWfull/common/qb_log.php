<?php
/**
   * Log Class
   * Log writing functions will be decalared here
   * 
   * @package    common
   * @subpackage 
   * @author     Vishnu
   * Created date  02/11/2015 04:40:05
   * Updated date  02/11/2015 05:00:05
   * Updated by    Vishnu
 **/	
	
	//class QB_Log
	//{
	
		/*$current_year=date("Y");
		$current_month=date("m");
		$current_date=date("d");
		$log_file_path=$root_folder_path.'public_html/qb_logs/'.$current_year.'/'.$current_month;
		$log_file_name=$current_month.'_'.$current_date.'_'.$current_year.'_log.log';
		$full_file_path=$log_file_path.'/'.$log_file_name;	
		
		if (!file_exists($log_file_path)) {
		    	mkdir($log_file_path, 0777, true);	    
		}*/
		
		/**
		  *Function for writing message to a log file
		  *Parameters
		  *$message-Message string
		  *$level - will be integer of values 1[Info],2[Warning],3[Error]
		  *$destination - From where the message is been send function with full file path
		  *$member_id- If logged in pass the member_id for reference default is 'Anonymous'	
		  *
		  *Written message will have parameters seperated by two pipe symbol '||'
		  *
		 **/
		function write_log($message,$level='1',$destination,$member_id='Anonymous'){
			
			$current_year=date("Y");
			$current_month=date("m");
			$current_date=date("d");
			$log_file_path=$root_folder_path.'public_html/qb_logs/'.$current_year.'/'.$current_month;
			$log_file_name=$current_month.'_'.$current_date.'_'.$current_year.'_log.log';
			$full_file_path=$log_file_path.'/'.$log_file_name;	
			
			if (!file_exists($log_file_path)) {
			    	mkdir($log_file_path, 0777, true);	    
			}
			$current_time= date('m.d.Y h:i:s'); 			
			$log ='Time: '.$current_time.'||Level:'.$level.'||Member:'.$member_id.'||Source:'.$destination.'||Message:'.$message."\n";					
			if (($handle = fopen($log_file_path.'/'.$log_file_name, "a")) !== false) { 			 
			  	fwrite($handle , $log);   
			  	fclose($handle ); 
			}		
		}
		
	//}
	//$log= new QB_Log();