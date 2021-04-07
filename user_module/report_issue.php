<?php

 	require_once($_SERVER['DOCUMENT_ROOT'].'/common/qb_session.php'); 	 
 	require_once($_SERVER['DOCUMENT_ROOT'].'/common/common.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/qb_header.php');
?>	
	
<div class="container" style="padding-top:10px;">
    <div class="row">
        <div class="col-md-12">
            <div class="well well-sm">
                <form class="form-horizontal" method="post" action="action/report_an_issue.php">
                    <fieldset>
                        <legend class="well-legend-header">Report an Issue</legend>

                        <div class="form-group">
                            <div class="col-md-8">
                                <input id="url" name="url" type="text" placeholder="Page URL" class="form-control">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-md-8">
                                <select class="form-control" name="platform">
                                    <option value="" selected disabled>Your Platform</option>
                                    <option value="PC-Linux">PC-Linux</option>
                                    <option value="PC-MAC">PC-MAC</option>
                                    <option value="PC-Windows">PC-Windows</option>
                                    <option value="Phone/Tablet-Android">Phone/Tablet-Android</option>
                                    <option value="Phone/Tablet-Apple">Phone/Tablet-Apple</option>
                                    <option value="Phone-Windows">Phone-Windows</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8">
                                <textarea class="form-control" id="issue" name="issue" placeholder="Enter the issue description here." rows="7"></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary btn-lg" >Submit</button>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .well-legend-header {
        color: #36A0FF;
        font-size: 27px;
        padding: 10px;
    }
</style>
    
<?php        
	include($_SERVER['DOCUMENT_ROOT'].'/includes/qb_footer.php');
?>