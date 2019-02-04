<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/qb_config.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_lookup.php');
class statusWidget
{

	function getStatusWidget($encryptedWallID,$lookupWallID){
	
		require_once($_SERVER['DOCUMENT_ROOT'].'/common/qb_session.php');
		$objLookupClass=new lookup();
		
		
		$innerhtml='<div class="wall_header" > ';
		$innerhtml .='	<div style="padding: 10px;line-height:46px;height:100%">';
		$innerhtml .='		<div class="pull-left"><span class="memohead memohead1234" style="color:#337AB7;font-size: 18px;font-weight: 700;margin-left: 5px;margin-right: 5px;">MEMO</span></div>';
		$innerhtml .='	        <div class="">';
		$innerhtml .='	         	<span class="flatButton flatButton1234" id="status_but"> ';
		$innerhtml .='	         		<a style="color: rgb(137, 0, 0); text-decoration:none;" href="javascript:void(0)"> ';
		$innerhtml .='	         			<img style="margin-right:4px;    padding-bottom: 7px;" src="'.SITE_URL.'/images/ImageStatus3.png"/> ';
		$innerhtml .='	         			<span class="inner">Status</span><!-- done by naresh shaw --> ';
		$innerhtml .='	         		</a> ';
		$innerhtml .='	         	</span> ';
		$innerhtml .='	         	<span class="flatButton flatButton1234" id="photo_but"> ';
		$innerhtml .='	         		<a style="color: rgb(137, 0, 0); text-decoration:none;" href="javascript:void(0)"> ';
		$innerhtml .='	         			<img style="margin-right:4px;    padding-bottom: 7px;" src="'.SITE_URL.'/images/ImageMyPhotos3.png"/> ';
		$innerhtml .='	         			<span class="inner">Photo</span> ';
		$innerhtml .='	         		</a> ';
		$innerhtml .='	         	</span>  ';
		$innerhtml .='	         	<span class="flatButton flatButton1234"  id="video_but" > ';
		$innerhtml .='         			<a style="color: rgb(137, 0, 0); text-decoration:none;" href="javascript:void(0)"> ';
		$innerhtml .='         				<img style="margin-right:4px;    padding-bottom: 7px;" src="'.SITE_URL.'/images/ImageMyVideos3.png"/> ';
		$innerhtml .='         				<span class="inner">Video</span> ';
		$innerhtml .='         			</a>';
		$innerhtml .='	         	</span> ';
		$innerhtml .='	         	<span class="flatButton flatButton1234"   id="live_but"  > ';
		$innerhtml .='         			<a style="color: rgb(137, 0, 0); text-decoration:none;" href="../golive.php"  > ';
		$innerhtml .='         				<img style="margin-right:4px;    padding-bottom: 7px;" src="'.SITE_URL.'/images/ImageMyVideos3.png"/> ';
		$innerhtml .='         				<span class="inner" id="liveTrigger" data-toggle="modal">Go Live</span> ';
		$innerhtml .='         			</a>';
		$innerhtml .='	         	</span> ';
		$innerhtml .='	        </div>';
		$innerhtml .='	        <div class="clearfix"></div>';
		$innerhtml .='  </div>';
		$innerhtml .='  <div class="clearfix"></div>';
		$innerhtml .='  <div id="updateContainer" style="background: #fff; position: relative; top: 15px; border-top: 1px solid #ccc;border-bottom: 1px solid #ccc;padding: 10px;display:none;">';
		$innerhtml .='	<div id="my_status" style="display:none;height: 105px;" > ';
		$innerhtml .='			<textarea placeholder="What are you thinking.." id="updateStatus" style="width: 100%; padding: 5px;"></textarea>';
		$innerhtml .='			<div style="margin-top: 5px;">';
		$innerhtml .='				<span><a id="btnSaveStatus" style="margin-right: 5px; background-color: #222; border: 1px solid #000; color: #fff; padding: 5px; cursor:pointer;text-decoration:none;" >Save</a></span>';
		$innerhtml .='				<span><a id="btnCancelStatus" style="margin-right: 5px; background-color: #222; border: 1px solid #000; color: #fff; padding: 5px; cursor:pointer;text-decoration:none;" >Cancel</a></span>';
		$innerhtml .='			</div>';
		$innerhtml .='		</div>	';
		$innerhtml .='		<div id="loader">';
		$innerhtml .='			<div align="center" id="load" style="display:none;"><img src="'.SITE_URL.'/images/ajax-loader.gif" id="loading_indicator"></div>	';
		$innerhtml .='		</div>  ';
		$innerhtml .='		<div id="myphoto" class="comment1" style="display:none;">  ';
		$innerhtml .='		    <form enctype="multipart/form-data" method="post" action="'.SITE_URL.'/ajax/qb_ajax_image.php" id="imageform" name="comment">            ';
		$innerhtml .='		    	<div id="preview"></div>  ';
		$innerhtml .='			<div id="imageloadstatus">';
		$innerhtml .='				<img src="'.SITE_URL.'/images/ajax-loader.gif"> Uploading Please Wait ....';
		$innerhtml .='			</div>';
		$innerhtml .='			<div id="imageloadbutton">   ';
		$innerhtml .='				<div class="cancel_update_image pull-right" style="cursor: pointer;"><i class="fa fa-remove"></i> Close</div>';
		$innerhtml .='		      		<input type="file"  value="" id="image" name="image" style="width: 100%;">';
		$innerhtml .='		      		<input type="hidden"  value="'.$lookupWallID.'" id="twn" name="twn" style="width: 100%;">';
		
		$innerhtml .='		      	</div> ';
		$innerhtml .='		     </form> ';
		$innerhtml .='		</div> ';
		$innerhtml .='		<div id="myvideo" class="comment1" style="display:none;">';
		$innerhtml .='		  <form method="post" action="'.SITE_URL.'/action/qb_video_process.php" id="video_form" name="comment" enctype="multipart/form-data">';
		$innerhtml .='		      <input type="text" style="height: 20px; margin-bottom: 10px; width:100%; padding:2px;" placeholder="Title" id="title" name="title">';
		$innerhtml .='			  <br/><textarea placeholder="What are you thinking.." id="video_description" name="desc" style="width: 100%; padding: 5px;"></textarea>';
		$innerhtml .='		      <div id="uploadPage"> ';
		$innerhtml .='				<input type="file" id="wall_video" name="uploadedvideofile">';
		$innerhtml .='		      		<input type="hidden"  value="'.$lookupWallID.'" id="twn" name="twn" style="width: 100%;">';
		$innerhtml .='		      </div>';
		$innerhtml .='		      <div style="display:none" id="ProcessPage">';
		$innerhtml .='		      	<div id="progress" class="progress">
							<div class="progress-bar progress-bar-success bar" role="progressbar" aria-valuemin="0" aria-valuemax="100">
	    						<span class="sr-only percent">1%</span>
	    						Uploading..
	  						</div> 
						</div>
						<div id="progress1" class="progress">  
							<div id="bar1"  class="progress-bar progress-bar-info" role="progressbar" aria-valuemin="0" aria-valuemax="100">
							<span id="percent1" class="sr-only">1%</span>
							Processing..
							</div>  
						</div>    
						<div id="status"></div> 
					      </div>
					      <input type="button" style="margin: 6px; background-color: #222; border: 1px solid #000; color: #fff; padding: 2px; cursor:pointer;border-radius: 4px;" id="update_video" class="update_video" name="Add" value="Upload" disabled="disabled">             
					    
					  </form>
					</div>
			          
			        </div>
			        
			      </div>';
		$innerhtml .='		<div id="mylive" class="comment1" style="display:none;">  <div class="modal fade full reveal" id="myModal" role="dialog"  data-reveal>';

		
		$innerhtml .='				<span><div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Modal Header</h4>
      </div>
      <div class="modal-body">
        <p>Work is in Progress</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div></span>';
		
		
		$innerhtml .='		</div> </div>';		  
		print $innerhtml;	      	
	
	}
}

?>
