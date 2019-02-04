<?php
	
	class AJAX {			
		public function __construct(){					
			$this->process_data();
		}
			
		private function process_data(){										
			$this->_index = ($_REQUEST['index'])?$_REQUEST['index']:NULL;
			$id = ($_REQUEST['id'])?$_REQUEST['id']:NULL;
			switch($this->_index){
				case 'country':
					$this->_query = "SELECT * FROM geo_country WHERE country_id != 207";
					$this->_fields = array('country_id','country_title');
					break;
				case 'state':
					$this->_query = "SELECT * FROM geo_state WHERE country_id=$id";
					$this->_fields = array('state_id','state_title');
					break;
				case 'city':
					$this->_query = "SELECT * FROM geo_city WHERE state_id=$id";
					$this->_fields = array('city_id','city_title');
					break;
				default:
					break;
			}
			$this->show_result();
		}
		
		public function show_result(){
			include_once '../config.php';			
			echo '<option value="">Select '.$this->_index.'</option>';
			$query = mysqli_query( $con, $this->_query) or die(mysqli_error( $con));
			while($result = mysqli_fetch_array($query)){
				$entity_id = $result[$this->_fields[0]];
				$enity_name = iconv("ISO-8859-1", "UTF-8", $result[$this->_fields[1]]);
				echo "<option value='$entity_id'>$enity_name</option>";
			}
		}
	}
	
	$obj = new AJAX;
	
?>