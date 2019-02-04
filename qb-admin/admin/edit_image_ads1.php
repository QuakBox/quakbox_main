<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("location:login.php");
}
$id = $_SESSION['id'];

include("config.php");
include('../../Languages/en.php');
$query = "SELECT * FROM admins WHERE id = '$id'";
$sql = mysqli_query($conn, $query);
$res = mysqli_fetch_array($sql);
$res1 = $res['email'];
?>


<!DOCTYPE html>
<html lang="en">
    <head>

        <meta charset="utf-8">
        <title>Quakbox</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Charisma, a fully featured, responsive, HTML5, Bootstrap admin template.">
        <meta name="author" content="Muhammad Usman">

        <!-- The styles -->
        <link id="bs-css" href="css/bootstrap-cerulean.css" rel="stylesheet">
        <style type="text/css">
            body {
                padding-bottom: 40px;
            }
            .sidebar-nav {
                padding: 9px 0;
            }
        </style>
        <link href="css/bootstrap-responsive.css" rel="stylesheet">
        <link href="css/charisma-app.css" rel="stylesheet">
        <link href="css/jquery-ui-1.8.21.custom.css" rel="stylesheet">
        <link href='css/fullcalendar.css' rel='stylesheet'>
        <link href='css/fullcalendar.print.css' rel='stylesheet'  media='print'>
        <link href='css/chosen.css' rel='stylesheet'>
        <!---
        <link href='css/uniform.default.css' rel='stylesheet'>
        --->
        <link href='css/colorbox.css' rel='stylesheet'>
        <link href='css/jquery.cleditor.css' rel='stylesheet'>
        <link href='css/jquery.noty.css' rel='stylesheet'>
        <link href='css/noty_theme_default.css' rel='stylesheet'>
        <link href='css/elfinder.min.css' rel='stylesheet'>
        <link href='css/elfinder.theme.css' rel='stylesheet'>
        <link href='css/jquery.iphone.toggle.css' rel='stylesheet'>
        <link href='css/opa-icons.css' rel='stylesheet'>
        <link href='css/uploadify.css' rel='stylesheet'>

        <!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

        <!-- The fav icon -->
        <link rel="shortcut icon" href="../../images/favicon.ico">

    </head>

    <body>

<?php
include("include/header.php");
include("include/sidebar.php");
?>

        <div id="content" class="span10">
            <!-- content starts -->


            <div>
                <ul class="breadcrumb">
                    <li>
                        <a href="#">Home</a> 
                    </li>
                    <li>
                        <!--	<a href="#">Dashboard</a>-->
                    </li>
                </ul>
            </div>


            <div class="row-fluid">
                <div class="box span12">
                    <div class="box-header well">
                        <h2><i class="icon-info-sign"></i> Image ads</h2>
                        <div class="box-icon">
                            <a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
                            <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
                            <a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>
                        </div>
                    </div>
                    <div class="box-content">

                        <table class="table table-striped table-bordered bootstrap-datatable datatable">
                            <thead>
                                <tr colspan="2">
                                    <th>Ad name</th>

                                </tr>

                            <div class="column_internal_ads" >
<?php echo $lang['Manage Ads']; ?>
                                <div id="preview1" class="preview1" >
                                    <div id="adtitle">
                                    </div>	
                                    <div id='preview'>
                                    </div>
                                    <div id="adbody">
                                    </div>

                                </div>

                            </div>	
                            <tbody>
<?php
//require_once('config.php');
require_once('../../includes/time_stamp.php');
$member_id = $_SESSION['id'];
$sql = mysqli_query($con, "select * from admins where id='" . $member_id . "'") or die(mysqli_error($con));
$res = mysqli_fetch_array($sql);

$sql = "SELECT * FROM `ads` where ads_id=" . $_GET["id"];
// echo $sql;
$ads_sql = mysqli_query($conn, $sql);



while ($res = mysqli_fetch_array($ads_sql)) {
    ?>

                                    <tr>

                                        <td colspan="2">
                                            <form id="imageform" method="post" enctype="multipart/form-data" action='action/ajaximage1.php'>

                                    <?php echo $lang['Image']; ?>(<?php echo $lang['opitional']; ?>)
                                                <input type="file" name="image" id="photoimg" /> <input type="hidden" name="member_id" id="member_id" value="<?php echo $member_id; ?>" /><input type="hidden" name="sizeofimage" id="sizeofimage" value="3" >
                                            </form>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <form  id="adsform" method="post" action='action/ads-exec2.php'>
                                                <input type="hidden" name="member_id" id="member_id" value="<?php echo $member_id; ?>" />
                                                Ads &nbsp;&nbsp; <input name="typeofadd" id="rad" value="<?php echo $lang['Social Ads']; ?>" type="radio"  <?php echo ($res['typeofadd'] == 'Social Ads') ? 'checked' : '' ?> />&nbsp;<?php echo $lang['Social Ads']; ?> 
                                                <input name="typeofadd" id="rad" value="<?php echo $lang['Partners']; ?>"  <?php echo ($res['typeofadd'] == 'Partners') ? 'checked' : '' ?> type="radio"/>&nbsp;<?php echo $lang['Partners']; ?>
                                        </td>
                                    </tr>      


                                    <tr>
                                        <td colspan="2"><br><h4><?php echo $lang['Destination URL, Example']; ?>: http://www.yourwebsite.com</h4></td>
                                    </tr>
                                    <tr>

                                        <td class="center" >
                                            <select id="http" name="http" >
                                                <option>http://</option>
                                                <option>https://</option>
                                            </select>
                                        </td>
                                        <td class="center" >
                                            <input id="title2" class="required inputbox" type="text" value="<?php  $url=explode ("//", $res['url']); echo $url[1]; ?>" size="40" name="url" />        
                                        </td>

                                    </tr>
                                    <tr>

                                    <tr>


                                        <td class="center" >
                                            <label>* <?php echo $lang['Title']; ?></label>
                                        </td>
                                        <td class="center" >
                                            <input id="title" class="required inputbox" type="text" value="<?php echo $res['ads_title']; ?>" size="40" name="title"  required="required">
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <label>* <?php echo $lang['Ad Start Date']; ?></label>
                                        </td>
                                        <td>
                                            <input id="MyDate1"  name="start_date" type="text"  required="required">
                                        </td>
                                    </tr>


                                    <tr>
                                        <td class="center" >
                                            <label>* <?php echo $lang['Ad End Date']; ?></label>
                                        </td>
                                        <td>
                                            <input id="MyDate2" type="text"  name="end_date" required="required">
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="center" >
                                            <label>*<?php echo $lang['Body Text']; ?></label>
                                        </td>
                                        <td class="center" >
                                            <textarea id="description" class="required inputbox" type="text" value="" size="45"  name="description" required="required"><?php echo $res['ads_content']; ?></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <div class="adsheading"><?php echo $lang['Targeting']; ?></div>
                                        </td> 
                                    </tr>

                              
                                <tr>
                                    <td colspan="2">

                                        <h4><?php echo $lang['Please fill the form details to reach the right audience']; ?>.</h4></td>

                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <label><?php echo $lang['Gender']; ?></label>
                                        <input type="checkbox" name="gender" value="male"<?php echo ($res['targetgender'] == 'male' ? 'checked' : ''); ?>> <?php echo $lang['male']; ?>&nbsp;&nbsp;&nbsp;
                                        <input type="checkbox" name="gender" value="female"<?php echo ($res['targetgender'] == 'female' ? 'checked' : ''); ?>><?php echo $lang['Female']; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><label ><?php echo $lang['Select country']; ?>:</label></td>
                                    <td>
                                        <select class="adsselect" id="country" onchange="load_options(this.value, 'state'); pot_user()" name="countries">
                                            <option value="" ><?php echo $lang['Select country']; ?></option>
                                        </select>
                                    </td>

                                </tr>
                                <tr>
                                    <td><label ><?php echo $lang['Select state']; ?>:</label></td>
                                    <td>
                                        <select class="adsselect" id="state" onchange="load_options(this.value, 'city');" name="state">
                                            <option value="" ><?php echo $lang['Select state']; ?></option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td><label ><?php echo $lang['Select City']; ?>:</label></td>
                                    <td >
                                        <select class="adsselect" id="city" name="city">
                                            <option value=""><?php echo $lang['Select City']; ?></option>
                                        </select>
                                    </td>
                                </tr>

                                <tr>
                                    <td><label ><?php echo $lang['AGE LIMIT']; ?>:</label></td>
                                    <td >
                                        <select id="agelimit" name="agelimit">
                                          <option value=""><?php echo $lang['Select Age Limit'];?></option>
                                          <option value="<10" <?php echo($res['agelimit']=='<10' ? 'selected':''); ?>><?php echo $lang['Less Than 10 Years'];?></option>
                                          <option value=">10 && <21" <?php echo($res['agelimit']=='>10 && <21' ? 'selected':''); ?>> <?php echo $lang['Greater Than 10 And'];?> <br /><?php echo $lang['Less Than Or Equal To 20 Years'];?></option>
                                          <option value=">20&& <31" <?php echo($res['agelimit']=='>20&& <31' ? 'selected':''); ?>> <?php echo $lang['Greater Than 20 And'];?> <br /><?php echo $lang['Less Than Or Equal To 30 Years'];?></option>
                                          <option value=">30" <?php echo($res['agelimit']=='>30' ? 'selected':''); ?>><?php echo $lang['Greater Than 30 Years'];?></option>
   
                                        </select>
                                    </td>
                                <tr>
                                    <td colspan="2">
                                        <h4><?php echo $lang['Pricing']; ?></h4>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label ><?php echo $lang['How do you want the ads to be charged']; ?>?</label>
                                    </td>
                                    <td>
                                        <select id="per" name="per">
                                            <option <?php echo($res['pricingperclick'] == 'Per Click' ? 'selected' : ''); ?>><?php echo $lang['Per Click']; ?></option>
                                            <option <?php echo($res['pricingperclick'] == 'Per Like' ? 'selected' : ''); ?>><?php echo $lang['Per Like']; ?></option>
                                        </select>
                                    </td>       
                                </tr> 

                                <tr>
                                    <td>
                                        <label ><br><?php echo $lang['How many clicks/impressions do you want to buy']; ?>?</label>
                                    </td>

                                    <td ><input name="click_payment" class="adsselect"  size="10" id="click_payment" type="text" value="<?php echo $res['pricingbuy']; ?>"/><span id="errmsg"></span></td>
                                </tr>
                                <tr>
                                    <td colspan="4"><br><h4><?php echo $lang['Total Amount you need to pay']; ?>:</h4></td>

                                </tr>
                                <tr>
                                    <td>
                                        <label ><?php echo $lang['Select Payment Gateway']; ?></label>
                                    </td>
                                    <td>
                                        <select class="adsselect" name="paypal" id="paypal">
                                            <option><?php echo $lang['paypal']; ?></option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <h4>** <?php echo $lang['Please note that you cannot change from Like pricing to click pricing or viceversa later for this add']; ?></h4> 
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <div align="center">
                                            <input id="flag-img" value="update" type="hidden" name="flag_img">
                                            <input  value="<?php echo $res['ads_id']; ?>" type="hidden" name="ads_id">
                                            <input class="button validateSubmit" type="submit" value="<?php echo $lang['Save']; ?>" align="center" height="50px" width="50px"/>
                                        </div>
                                    </td>
                                </tr>    

                                </form>




                                </tbody>
                            </table>		


                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>

                <!--/span-->





                <!-- content ends -->
            </div><!--/#content.span10-->
        </div><!--/fluid-row-->

        <hr>

        <div class="modal hide fade" id="myModal">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3>Settings</h3>
            </div>
            <div class="modal-body">
                <p>Here settings can be configured...</p>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn" data-dismiss="modal">Close</a>
                <a href="#" class="btn btn-primary">Save changes</a>
            </div>
        </div>
    

    <!--<footer>
            <p class="pull-left">&copy; <a href="http://usman.it" target="_blank">Muhammad Usman</a> 2012</p>
            <p class="pull-right">Powered by: <a href="http://usman.it/free-responsive-admin-template">Charisma</a></p>
    </footer>  -->

</div><!--/.fluid-container-->
<script src="https://quakbox.com/js/jquery-1.7.2.min.js" type="text/javascript"></script>        


<script type="text/javascript" src="../../js/jquery.form.js"></script>

<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js" type="text/javascript"></script>
<script type="text/javascript">

            $(document).ready(function () {

               load_options('','country','<?php echo $res['targetcountry'];?>');
                load_options('<?php echo $res['targetcountry'];?>','state','<?php echo $res['targetstate'];?>');
                load_options('<?php echo $res['targetstate'];?>','city','<?php echo $res['targetcity'];?>');
	

                $('#photoimg').on('change', function ()

                {
                    alert("hih");
                    $("#preview").html('');
                    $("#preview").html('<?php echo $res['ads_pic']; ?>" alt="Uploading...."/>');
                    $("#imageform").ajaxForm({
                        target: '#preview',
                        success: function (data) {
                            alert(data);

                        }
                    }).submit();

                });

                $('.validateSubmit').on('click', function ()
                {
                    $("#adsform").ajaxForm({
                        success: function (data) {
                            resData = data;
                            res = resData.indexOf("<script");
                            if (res > -1) {
                                $(data).find('script').each(function () {
                                    eval($(this).text());
                                });
                            } else {
                                alert(data);
                                var str2 = "update";
                            if(data.indexOf(str2) != -1){
                         
                          $('#adsform').find('input:text,select,textarea').val('');
                           $('#adsform').find('input:radio,input:checkbox').prop('checked', false);
                           $('#country').val('');
                           $('#state').val('');
                           $('#city').val('');
                           $('#agelimit').val('');
                           $('#per').val('');
                           $('#click_payment').val('');
                            }
                        }
                        }
                    });
                });

                //Advertise title
                $('#title').keyup(function () {
                    $('#adtitle').html($(this).val());
                    //$("#adtitle").css("width", "180px");
                });
//Advertise Body
                $('#description').keyup(function () {

                    $('#adbody').html($(this).val());
                });

//image size
                $(".radi").change(function () {

                    var val = $('.radi:checked').val();
                    document.getElementById('sizeofimage').value = val;

                    //alert(document.getElementById('sizeofimage').value);
                });

            });


            function load_options(id,index,selectedid){


                $("#loading").show();

                if (index == "state") {
                    $("#city").html('<option value=""><?php echo $lang['Select City']; ?></option>');
                }
                
                $.ajax({
                    url: "../../load_data/ajax_edit.php?index=" + index + "&id=" + id + "&selectedid=" + selectedid,
                    complete: function () {
                        $("#loading").hide();
                    },
                    success: function (data) {

                        $("#" + index).html(data);


                    }
                });
            }

</script>


<script>
    $(document).ready(function (e) {

        jQuery('#MyDate2').datepicker({
            dateFormat: 'mm/dd/yy',
            changeMonth: true,
        });
        jQuery("#MyDate1").datepicker({
            dateFormat: 'mm/dd/yy',
            changeMonth: true,
            minDate: 0,
            onSelect: function (date) {
                var date1 = jQuery('#MyDate1').datepicker('getDate');
                var date = new Date(Date.parse(date1));
                date.setDate(date.getDate() + 1);
                var newDate = date.toDateString();
                newDate = new Date(Date.parse(newDate));
                jQuery('#MyDate2').datepicker("option", "minDate", newDate);
            }
        });


        $("#click_payment").keypress(function (e) {
            //if the letter is not digit then display error and don't type anything
            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                //display error message
                $("#errmsg").html("<?php echo $lang['Digits Only']; ?>").show().fadeOut("slow");
                return false;
            }
        });




    });

    function pot_user()
    {
        //alert('hi');
        var country = $("#country").val();
        //alert(country)
        $("#target").fadeIn();
        $.ajax({
            type: "POST",
            url: "../../pot_user.php",
            data: {country: country},
            cache: false,
            success: function (html) {
                $("#target").html(html);
            }
        });

    }
</script>



<!-- external javascript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->

<!-- jQuery -->

<!-- jQuery UI -->

<!-- transition / effect library -->
<script src="js/bootstrap-transition.js"></script>
<!-- alert enhancer library -->
<script src="js/bootstrap-alert.js"></script>
<!-- modal / dialog library -->
<script src="js/bootstrap-modal.js"></script>
<!-- custom dropdown library -->
<script src="js/bootstrap-dropdown.js"></script>
<!-- scrolspy library -->
<script src="js/bootstrap-scrollspy.js"></script>
<!-- library for creating tabs -->
<script src="js/bootstrap-tab.js"></script>
<!-- library for advanced tooltip -->
<script src="js/bootstrap-tooltip.js"></script>
<!-- popover effect library -->
<script src="js/bootstrap-popover.js"></script>
<!-- button enhancer library -->
<script src="js/bootstrap-button.js"></script>
<!-- accordion library (optional, not used in demo) -->
<script src="js/bootstrap-collapse.js"></script>
<!-- carousel slideshow library (optional, not used in demo) -->
<script src="js/bootstrap-carousel.js"></script>
<!-- autocomplete library -->
<script src="js/bootstrap-typeahead.js"></script>
<!-- tour library -->
<script src="js/bootstrap-tour.js"></script>
<!-- library for cookie management -->
<script src="js/jquery.cookie.js"></script>
<!-- calander plugin -->
<script src='js/fullcalendar.min.js'></script>
<!-- data table plugin -->
<script src='js/jquery.dataTables.min.js'></script>

<!-- chart libraries start -->
<script src="js/excanvas.js"></script>
<script src="js/jquery.flot.min.js"></script>
<script src="js/jquery.flot.pie.min.js"></script>
<script src="js/jquery.flot.stack.js"></script>
<script src="js/jquery.flot.resize.min.js"></script>
<!-- chart libraries end -->

<!-- select or dropdown enhancer -->
<script src="js/jquery.chosen.min.js"></script>
<!-- checkbox, radio, and file input styler -->
<!---
<script src="js/jquery.uniform.min.js"></script>
--->
<!-- plugin for gallery image view -->
<script src="js/jquery.colorbox.min.js"></script>
<!-- rich text editor library -->
<script src="js/jquery.cleditor.min.js"></script>
<!-- notification plugin -->
<script src="js/jquery.noty.js"></script>
<!-- file manager library -->
<script src="js/jquery.elfinder.min.js"></script>
<!-- star rating plugin -->
<script src="js/jquery.raty.min.js"></script>
<!-- for iOS style toggle switch -->
<script src="js/jquery.iphone.toggle.js"></script>
<!-- autogrowing textarea plugin -->
<script src="js/jquery.autogrow-textarea.js"></script>
<!-- multiple file upload plugin -->
<script src="js/jquery.uploadify-3.1.min.js"></script>
<!-- history.js for cross-browser state change on ajax -->
<script src="js/jquery.history.js"></script>
<!-- application script for Charisma demo -->
<script src="js/charisma.js"></script>


</body>
</html>
<?php
}
?>