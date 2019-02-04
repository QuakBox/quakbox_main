<?php ob_start();
include '../config.php';
$member_id = mysqli_real_escape_string($con, f($_POST['member_id'],'escapeAll'));

			$query = "SELECT cf.favourite_country_id, gc.code, cf.favourite_country ";
			$query.= "FROM favourite_country AS cf, geo_country AS gc ";
			$query.= "WHERE member_id='$member_id' AND cf.code=gc.code ";
			$query.= "AND cf.code<>'ww' ";			
			$res = mysqli_query($con, $query) or die(mysqli_error($con));
						
			$vecFCF = mysqli_num_rows($res);
			while($result = mysqli_fetch_array($res))
			{				
				$cf_id = $result['favourite_country_id'];
				$cf_code = $result['code'];				
				if (isset($_POST['chkCF'.$cf_code]))
				{					
					if ($result['favourite_country'])
					{
						if (!isset( $_POST['chkfav'.$cf_code] ) )
						{							
							$sql = mysqli_query($con, "UPDATE favourite_country SET favourite_country=0 WHERE favourite_country_id=$cf_id") or die(mysqli_error($con));	
						}
					}
					else
					{
						if (isset($_POST['chkfav'.$cf_code] ) )
						{							
							$sql = mysqli_query($con, "UPDATE favourite_country SET favourite_country=1 WHERE favourite_country_id=$cf_id");												
						}
					}
				}
				else
				{
					$sql = mysqli_query($con, "DELETE FROM favourite_country WHERE favourite_country_id=$cf_id");		
				}
				
			}

			$query1 =  mysqli_query($con, "SELECT country_title,code FROM geo_country WHERE code NOT IN 
(SELECT DISTINCT code FROM favourite_country WHERE member_id=$member_id)") or die(mysqli_error($con));
			//echo mysqli_num_rows($query);
			while($vecC = mysqli_fetch_array($query1))
			{				
				$code = $vecC['code'];				
				if (isset($_POST['chkC'.$code]) ){
					$is_fav=0;
					if ( isset( $_POST['chkfav'.$code] ) ){ $is_fav=1; }
					$sql = mysqli_query($con, "SELECT favourite_country_id FROM favourite_country WHERE member_id='$member_id' AND code='$code'");
					$vecDup = mysqli_fetch_array($sql);
					if ( mysqli_num_rows($sql) == 0){
						$sql1 = "INSERT INTO favourite_country(member_id, code, favourite_country) VALUES ('$member_id', '$code', $is_fav)";
						mysqli_query($con, $sql1);
					}
				}
			}

	
		header('location: ' . $_SERVER['HTTP_REFERER']);
exit();
?>