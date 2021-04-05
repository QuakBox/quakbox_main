<?php ob_start();
	//Start session
	session_start();
	
	//Include database connection details
	require_once($_SERVER['DOCUMENT_ROOT'].'/config.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_lookup.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/qb_classes/qb_member1.php');
	$objMember = new member1(); 
	$lookupObject = new lookup(); 
	//Sanitize the POST values
	$member_id = $_SESSION['SESS_MEMBER_ID'];
	$session_member_id = $_SESSION['SESS_MEMBER_ID'];
	
	//Sanitize the POST values
	
	$message_body = mysqli_real_escape_string($con, f($_REQUEST['message'],'escapeAll'));	
	$country_code = mysqli_real_escape_string($con, f($_REQUEST['country'],'escapeAll'));
	$country_flag = str_replace('-', ' ', $country_code);
	$time = time();
	
	
	$cquery = mysqli_query($con, "select country_title,code from geo_country where country_title = '$country_code' OR code = '$country_code'");
	$cres  = mysqli_fetch_array($cquery);
	$country = $cres['country_title'];
		
	
	$member = mysqli_query($con, "select * from member where member_id='$session_member_id' order by member_id desc LIMIT 1");
	$member_res = mysqli_fetch_array($member);	
	$membusername=$member_res['username'];
	$displayname=$member_res['displayname'];
	$media = $objMember->select_member_meta_value($session_member_id,'current_profile_image');
	//$msql = mysqli_query($con, "select * from members where email_id = '$email_id'");
	//$mres = mysqli_fetch_array($msql);
	$genderKey= $objMember->select_member_meta_value_for_lookupID($session_member_id,"gender");
	$memGender= $lookupObject->getKeyByValue($genderKey);
	$gender = "His";
	if(trim($memGender)=='Female')
	{		
	   $gender = "Her";
	}
	
	if(!$media)
		$media = "images/default.png";
	$media=$base_url.$media;

if(!empty($country_code)){	
$countryStyle = 'background-image: url("'.$base_url.'css/country_flag_50_sprite.png");background-repeat:no-repeat;display:block;width:50px;height:50px;';
$c_ad = 'background-position: -5px -5px';
$c_ae = 'background-position: -65px -5px';
$c_af = 'background-position: -125px -5px';
$c_ag = 'background-position: -185px -5px';
$c_ai = 'background-position: -245px -5px';
$c_al = 'background-position: -305px -5px';
$c_am = 'background-position: -365px -5px';
$c_an = 'background-position: -425px -5px';
$c_ao = 'background-position: -485px -5px';
$c_ar = 'background-position: -545px -5px';
$c_as = 'background-position: -605px -5px';
$c_at = 'background-position: -665px -5px';
$c_au = 'background-position: -725px -5px';
$c_aw = 'background-position: -785px -5px';
$c_ax = 'background-position: -845px -5px';
$c_az = 'background-position: -5px -65px';
$c_ba = 'background-position: -65px -65px';
$c_bb = 'background-position: -125px -65px';
$c_bd = 'background-position: -185px -65px';
$c_be = 'background-position: -245px -65px';
$c_bf = 'background-position: -305px -65px';
$c_bg = 'background-position: -365px -65px';
$c_bh = 'background-position: -425px -65px';
$c_bi = 'background-position: -485px -65px';
$c_bj = 'background-position: -545px -65px';
$c_bm = 'background-position: -605px -65px';
$c_bn = 'background-position: -665px -65px';
$c_bo = 'background-position: -725px -65px';
$c_br = 'background-position: -785px -65px';
$c_bs = 'background-position: -845px -65px';
$c_bt = 'background-position: -5px -125px';
$c_bw = 'background-position: -65px -125px';
$c_by = 'background-position: -125px -125px';
$c_bz = 'background-position: -185px -125px';
$c_ca = 'background-position: -245px -125px';
$c_cd = 'background-position: -305px -125px';
$c_cf = 'background-position: -365px -125px';
$c_cg = 'background-position: -425px -125px';
$c_ch = 'background-position: -485px -125px';
$c_ci = 'background-position: -545px -125px';
$c_ck = 'background-position: -605px -125px';
$c_cl = 'background-position: -665px -125px';
$c_cm = 'background-position: -725px -125px';
$c_cn = 'background-position: -785px -125px';
$c_co = 'background-position: -845px -125px';
$c_cr = 'background-position: -5px -185px';
$c_cu = 'background-position: -65px -185px';
$c_cv = 'background-position: -125px -185px';
$c_cx = 'background-position: -185px -185px';
$c_cy = 'background-position: -245px -185px';
$c_cz = 'background-position: -305px -185px';
$c_de = 'background-position: -365px -185px';
$c_dj = 'background-position: -425px -185px';
$c_dk = 'background-position: -485px -185px';
$c_dm = 'background-position: -545px -185px';
$c_do = 'background-position: -605px -185px';
$c_dz = 'background-position: -665px -185px';
$c_ec = 'background-position: -725px -185px';
$c_ee = 'background-position: -785px -185px';
$c_eg = 'background-position: -845px -185px';
$c_er = 'background-position: -5px -245px';
$c_es = 'background-position: -65px -245px';
$c_et = 'background-position: -125px -245px';
$c_eu = 'background-position: -185px -245px';
$c_fi = 'background-position: -245px -245px';
$c_fj = 'background-position: -305px -245px';
$c_fk = 'background-position: -365px -245px';
$c_fm = 'background-position: -425px -245px';
$c_fo = 'background-position: -485px -245px';
$c_fr = 'background-position: -545px -245px';
$c_ga = 'background-position: -605px -245px';
$c_gb = 'background-position: -665px -245px';
$c_gd = 'background-position: -725px -245px';
$c_ge = 'background-position: -785px -245px';
$c_gf = 'background-position: -845px -245px';
$c_gg = 'background-position: -5px -305px';
$c_gh = 'background-position: -65px -305px';
$c_gi = 'background-position: -125px -305px';
$c_gl = 'background-position: -185px -305px';
$c_gm = 'background-position: -245px -305px';
$c_gn = 'background-position: -305px -305px';
$c_gp = 'background-position: -365px -305px';
$c_gq = 'background-position: -425px -305px';
$c_gr = 'background-position: -485px -305px';
$c_gs = 'background-position: -545px -305px';
$c_gt = 'background-position: -605px -305px';
$c_gu = 'background-position: -665px -305px';
$c_gw = 'background-position: -725px -305px';
$c_gy = 'background-position: -785px -305px';
$c_hk = 'background-position: -845px -305px';
$c_hn = 'background-position: -5px -365px';
$c_hr = 'background-position: -65px -365px';
$c_ht = 'background-position: -125px -365px';
$c_hu = 'background-position: -185px -365px';
$c_id = 'background-position: -245px -365px';
$c_ie = 'background-position: -305px -365px';
$c_il = 'background-position: -365px -365px';
$c_im = 'background-position: -425px -365px';
$c_in = 'background-position: -485px -365px';
$c_io = 'background-position: -545px -365px';
$c_iq = 'background-position: -605px -365px';
$c_ir = 'background-position: -665px -365px';
$c_is = 'background-position: -725px -365px';
$c_it = 'background-position: -785px -365px';
$c_je = 'background-position: -845px -365px';
$c_jm = 'background-position: -5px -425px';
$c_jo = 'background-position: -65px -425px';
$c_jp = 'background-position: -125px -425px';
$c_ke = 'background-position: -185px -425px';
$c_kg = 'background-position: -245px -425px';
$c_kh = 'background-position: -305px -425px';
$c_ki = 'background-position: -365px -425px';
$c_km = 'background-position: -425px -425px';
$c_kn = 'background-position: -485px -425px';
$c_kp = 'background-position: -545px -425px';
$c_kr = 'background-position: -605px -425px';
$c_kw = 'background-position: -665px -425px';
$c_ky = 'background-position: -725px -425px';
$c_kz = 'background-position: -785px -425px';
$c_la = 'background-position: -845px -425px';
$c_lb = 'background-position: -5px -485px';
$c_lc = 'background-position: -65px -485px';
$c_li = 'background-position: -125px -485px';
$c_lk = 'background-position: -185px -485px';
$c_lr = 'background-position: -245px -485px';
$c_ls = 'background-position: -305px -485px';
$c_lt = 'background-position: -365px -485px';
$c_lu = 'background-position: -425px -485px';
$c_lv = 'background-position: -485px -485px';
$c_ly = 'background-position: -545px -485px';
$c_ma = 'background-position: -605px -485px';
$c_mc = 'background-position: -665px -485px';
$c_md = 'background-position: -725px -485px';
$c_me = 'background-position: -785px -485px';
$c_mg = 'background-position: -845px -485px';
$c_mh = 'background-position: -5px -545px';
$c_mk = 'background-position: -65px -545px';
$c_ml = 'background-position: -125px -545px';
$c_mm = 'background-position: -185px -545px';
$c_mn = 'background-position: -245px -545px';
$c_mo = 'background-position: -305px -545px';
$c_mp = 'background-position: -365px -545px';
$c_mq = 'background-position: -425px -545px';
$c_mr = 'background-position: -485px -545px';
$c_ms = 'background-position: -545px -545px';
$c_mt = 'background-position: -605px -545px';
$c_mu = 'background-position: -665px -545px';
$c_mv = 'background-position: -725px -545px';
$c_mw = 'background-position: -785px -545px';
$c_mx = 'background-position: -845px -545px';
$c_my = 'background-position: -5px -605px';
$c_mz = 'background-position: -65px -605px';
$c_na = 'background-position: -125px -605px';
$c_nc = 'background-position: -185px -605px';
$c_ne = 'background-position: -245px -605px';
$c_nf = 'background-position: -305px -605px';
$c_ng = 'background-position: -365px -605px';
$c_ni = 'background-position: -425px -605px';
$c_nl = 'background-position: -485px -605px';
$c_no = 'background-position: -545px -605px';
$c_np = 'background-position: -605px -605px';
$c_nr = 'background-position: -665px -605px';
$c_nu = 'background-position: -725px -605px';
$c_nz = 'background-position: -785px -605px';
$c_om = 'background-position: -845px -605px';
$c_pa = 'background-position: -5px -665px';
$c_pe = 'background-position: -65px -665px';
$c_pf = 'background-position: -125px -665px';
$c_pg = 'background-position: -185px -665px';
$c_ph = 'background-position: -245px -665px';
$c_pk = 'background-position: -305px -665px';
$c_pl = 'background-position: -365px -665px';
$c_pm = 'background-position: -425px -665px';
$c_pn = 'background-position: -485px -665px';
$c_ps = 'background-position: -545px -665px';
$c_pt = 'background-position: -605px -665px';
$c_pw = 'background-position: -665px -665px';
$c_py = 'background-position: -725px -665px';
$c_qa = 'background-position: -785px -665px';
$c_ro = 'background-position: -845px -665px';
$c_rq = 'background-position: -5px -725px';
$c_rs = 'background-position: -65px -725px';
$c_ru = 'background-position: -125px -725px';
$c_rw = 'background-position: -185px -725px';
$c_sa = 'background-position: -245px -725px';
$c_sb = ' background-position: -305px -725px';
$c_sc = 'background-position: -365px -725px';
$c_sd = 'background-position: -425px -725px';
$c_se = 'background-position: -485px -725px';
$c_sg = 'background-position: -545px -725px';
$c_sh = 'background-position: -605px -725px';
$c_si = 'background-position: -665px -725px';
$c_sj = 'background-position: -725px -725px';
$c_sk = 'background-position: -785px -725px';
$c_sl = 'background-position: -845px -725px';
$c_sm = 'background-position: -5px -785px';
$c_sn = 'background-position: -65px -785px';
$c_so = 'background-position: -125px -785px';
$c_sr = 'background-position: -185px -785px';
$c_st = 'background-position: -245px -785px';
$c_sv = 'background-position: -305px -785px';
$c_sy = 'background-position: -365px -785px';
$c_sz = 'background-position: -425px -785px';
$c_tc = 'background-position: -485px -785px';
$c_td = 'background-position: -545px -785px';
$c_tf = 'background-position: -605px -785px';
$c_tg = 'background-position: -665px -785px';
$c_th = 'background-position: -725px -785px';
$c_tj = 'background-position: -785px -785px';
$c_tl = 'background-position: -845px -785px';
$c_tm = 'background-position: -5px -845px';
$c_tn = 'background-position: -65px -845px';
$c_to = 'background-position: -125px -845px';
$c_tr = 'background-position: -185px -845px';
$c_tt = 'background-position: -245px -845px';
$c_tv = 'background-position: -305px -845px';
$c_tw = 'background-position: -365px -845px';
$c_tz = 'background-position: -425px -845px';
$c_ua = 'background-position: -485px -845px';
$c_ug = 'background-position: -545px -845px';
$c_us = 'background-position: -605px -845px';
$c_uy = 'background-position: -665px -845px';
$c_uz = 'background-position: -725px -845px';
$c_va = 'background-position: -785px -845px';
$c_vc = 'background-position: -845px -845px';
$c_ve = 'background-position: -905px -5px';
$c_vg = 'background-position: -905px -65px';
$c_vi = 'background-position: -905px -125px';
$c_vn = 'background-position: -905px -185px';
$c_vu = 'background-position: -905px -245px';
$c_wf = 'background-position: -905px -305px';
$c_ws = 'background-position: -905px -365px';
$c_xk = 'background-position: -905px -425px';
$c_ye = 'background-position: -905px -485px';
$c_yt = 'background-position: -905px -545px';
$c_za = 'background-position: -905px -605px';
$c_zm = 'background-position: -905px -665px';
$c_zw = 'background-position:-905px -725px';

$cPos = 'c_';
$countryMedia = $countryStyle.${$cPos.$country_code};
	//mail function
$to = $email_id;
$subject = "".$displayname." invited you to like ".$gender." country ".$cres['country_title']."";
$message = "
<html>
<head>

<body style='font-family:Verdana, Geneva, sans-serif; font-size:14px;'>

<table width='100%' cellpadding='0' cellspacing='0' style='border-collapse:collapse; width:100%;'>
<tbody>
<tr>
<td style='font-family:lucida grande,tahoma,verdana,arial,sans-serif;font-size:12px;'>

<table width='100%' cellpadding='0' cellspacing='0' style='border-collapse:collapse;width:100%;'>
<tbody>
<tr>
<td style='font-size:16px;font-family:lucida grande,tahoma,verdana,arial,sans-serif;background:#4F70D1;color:#ffffff;font-weight:bold;vertical-align:baseline;letter-spacing:-0.03em;text-align:left;padding:5px 20px;'>
<a href='".$base_url."' style='text-decoration:none'>
<span style='background:#4F70D1;color:#ffffff;font-weight:bold;font-family:lucida grande,tahoma,verdana,arial,sans-serif;vertical-align:middle;font-size:16px;letter-spacing:-0.03em;text-align:left;vertical-align:baseline;'>
<img src='".$base_url."images/qb-email.png' height='30' style='margin-right:3px;'><img src='".$base_url."images/qb-quack.png' width='75' height='30'>
<span>
</a>
</td>
</tr>
</tbody>
</table>

<table width='100%' cellpadding='0' cellspacing='0' style='border-collapse:collapse;width:100%;' border='0'>
<tbody>
<tr>
<td style='font-size:11px;font-family:LucidaGrande,tahoma,verdana,arial,sans-serif;padding:0px;background-color:#f2f2f2;border-left:none;border-right:none;border-top:none;border-bottom:none'>

<table cellpadding='0' cellspacing='0' style='border-collapse:collapse;width:100%;'>
<tbody>
<tr>
<td style='font-size:11px;font-family:LucidaGrande,tahoma,verdana,arial,sans-serif;padding:0px;width:100%;'>

<table width='100%' cellpadding='0' cellspacing='0' style='border-collapse:collapse;width:100%;'>
<tbody>
<tr>

<td style='font-size:11px;font-family:LucidaGrande,tahoma,verdana,arial,sans-serif;padding:20px;background-color:#fff;border-left:none;border-right:none;border-top:none;border-bottom:none'>

<table cellpadding='0' cellspacing='0' style='border-collapse:collapse;'>
<tbody>
<tr>

<td valign='top' style='font-size:11px;font-family:LucidaGrande,tahoma,verdana,arial,sans-serif;padding-right:15px;text-align:left'>
<a href='".$base_url."' style='color:#3b5998;text-decoration:none'><span style='".$countryMedia."'></span></a>
</td>

<td valign='top' style='font-size:11px;font-family:LucidaGrande,tahoma,verdana,arial,sans-serif;width:100%;text-align:left'>
<table cellpadding='0' cellspacing='0' style='border-collapse:collapse;width:100%;'>
<tbody>
<tr>
<td style='font-size:11px;font-family:LucidaGrande,tahoma,verdana,arial,sans-serif;padding-bottom:2px'>
<span style='color:#111111;font-size:14px;font-weight:bold'>
".$cres['country_title']." on quakbox
</span>
</td>
</tr>

<tr>
<td style='font-size:11px;font-family:LucidaGrande,tahoma,verdana,arial,sans-serif;padding-top:1px;padding-bottom:2px'>
<span style='color:#808080'>
".$displayname." invite you to the ".$cres['country_title']." on quakbox. Join ".$displayname." in the ".$cres['country_title']." on quakbox to Connect with your people in your country and other Countries. Get The Raw News from your Country, City or Province. Text, Chat, Post Status, Photos, Videos or become a news contributor. Make friends world wide and Explore the World on quakbox. <a href='".$base_url."' target='_blank' style='color:#3b5998;text-decoration:none'>".$cres['country_title']."</a> 

<br><br>
".nl2br($message_body)."
</span>
</td>
</tr>

</tbody>
</table>

</td>
</tr>
</tbody>
</table>

</td>
</tr>
</tbody>
</table>

</td>
</tr>

<tr>
<td style='font-size:11px;font-family:LucidaGrande,tahoma,verdana,arial,sans-serif;padding:0px;width:620px'>
<a href='".$base_url."' target='_blank' style='text-decoration:none'>
Sign up
</a>
</td>
</tr>

<tbody>
<table>

</td>
</tr>

</tbody>
</table>
</body>
</html>
";
/*<p><a href='".$base_url."'>".$site_name."</a></p>".$displayname." invited you to ".$gender." country ".$cres['country_title'].". Please join ".$gender." in ".$cres['country_title']." On  Quakbox. Connect,Text, Chat, Post Photos, Videos and Status in any Country. Make the NEWS, Keep Up With the NEWS and Instant NEWS Updates. Visit Other Countries and make friends World Wide.*/
// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";


$headers .= "From: ".$site_email."";

	$emailIds = explode(",", $_POST['emails']);
	foreach( $emailIds as $email_id ){
		$email_id = mysqli_real_escape_string($con, f($email_id,'escapeAll'));
		$mail = mail($email_id, $subject, $message, $headers);
	
	}
 
} else {
	
	//mail function
$to = $email_id;
$subject = $displayname." invites you to join  quakbox";
$message = "
<html>

<body style='font-family:Verdana, Geneva, sans-serif; font-size:14px;'>

<table width='100%' cellpadding='0' cellspacing='0' style='border-collapse:collapse;width:100%;'>
<tbody>
<tr>
<td style='font-family:lucida grande,tahoma,verdana,arial,sans-serif;font-size:12px;'>

<table width='100%' cellpadding='0' cellspacing='0' style='border-collapse:collapse;width:100%;'>
<tbody>
<tr>
<td style='font-size:16px;font-family:lucida grande,tahoma,verdana,arial,sans-serif;background:#4F70D1;color:#ffffff;font-weight:bold;vertical-align:baseline;letter-spacing:-0.03em;text-align:left;padding:5px 20px;'>
<a href='".$base_url."' style='text-decoration:none'>
<span style='background:#4F70D1;color:#ffffff;font-weight:bold;font-family:lucida grande,tahoma,verdana,arial,sans-serif;vertical-align:middle;font-size:16px;letter-spacing:-0.03em;text-align:left;vertical-align:baseline;'>
<img src='".$base_url."images/qb-email.png' height='30' style='margin-right:3px;'><img src='".$base_url."images/qb-quack.png' width='75' height='30'>
<span>
</a>
</td>
</tr>
</tbody>
</table>

<table width='100%' cellpadding='0' cellspacing='0' style='border-collapse:collapse;width:100%;' border='0'>
<tbody>
<tr>
<td style='font-size:11px;font-family:LucidaGrande,tahoma,verdana,arial,sans-serif;padding:0px;background-color:#f2f2f2;border-left:none;border-right:none;border-top:none;border-bottom:none'>

<table cellpadding='0' cellspacing='0' style='border-collapse:collapse;width:100%;'>
<tbody>
<tr>
<td style='font-size:11px;font-family:LucidaGrande,tahoma,verdana,arial,sans-serif;padding:0px;width:100%;'>

<table width='100%' cellpadding='0' cellspacing='0' style='border-collapse:collapse;width:100%;'>
<tbody>
<tr>

<td style='font-size:11px;font-family:LucidaGrande,tahoma,verdana,arial,sans-serif;padding:20px;background-color:#fff;border-left:none;border-right:none;border-top:none;border-bottom:none'>

<table cellpadding='0' cellspacing='0' style='border-collapse:collapse;'>
<tbody>
<tr>

<td valign='top' style='font-size:11px;font-family:LucidaGrande,tahoma,verdana,arial,sans-serif;padding-right:15px;text-align:left'>
<a href='".$base_url."' style='color:#3b5998;text-decoration:none'>
<img style='border:0' height='50' width='50' src='".$media."' />
</a>
</td>

<td valign='top' style='font-size:11px;font-family:LucidaGrande,tahoma,verdana,arial,sans-serif;width:100%;text-align:left'>
<table cellpadding='0' cellspacing='0' style='border-collapse:collapse;width:100%;'>
<tbody>
<tr>
<td style='font-size:11px;font-family:LucidaGrande,tahoma,verdana,arial,sans-serif;padding-bottom:2px'>
<span style='color:#111111;font-size:14px;font-weight:bold'>
<a href='".$base_url."' target='_blank' style='color:#3b5998;text-decoration:none'>
".$displayname."
</a>
invites you to join  quakbox
</span>
</td>
</tr>

<tr>
<td style='font-size:11px;font-family:LucidaGrande,tahoma,verdana,arial,sans-serif;padding-top:1px;padding-bottom:2px'>
<span style='color:#808080'>
".$res_origin['country_title']."
</span>
</td>
</tr>

<tr>
<td style='font-size:11px;font-family:LucidaGrande,tahoma,verdana,arial,sans-serif;padding-top:1px'>
<span style='color:#333333'>
<span>
".$fcount." friends

<br><br>
".nl2br( $message_body )."
</span>
</span>
</td>
</tr>
</tbody>
</table>

</td>
</tr>
</tbody>
</table>

</td>
</tr>
</tbody>
</table>

</td>
</tr>

<tr>
<td style='font-size:11px;font-family:LucidaGrande,tahoma,verdana,arial,sans-serif;padding:0px;width:100%;'>
<a href='".$base_url."' target='_blank' style='text-decoration:none'>
Sign up
</a>
</td>
</tr>

<tbody>
<table>

</td>
</tr>

</tbody>
</table>

</body>
</html>
";

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";

$headers .= "From: ".$site_email."";

	$emailIds = explode(",", $_POST['emails']);
	foreach( $emailIds as $email_id ){
	
		$email_id = mysqli_real_escape_string($con, f($email_id,'escapeAll'));
		$mail = mail($email_id, $subject, $message, $headers);
	
	}
	
}
//echo $country;
$url = '';
$url = $_SERVER['HTTP_REFERER'];

	
//echo $url;
$_SESSION['err_count_country']=0;
header("location: ".$base_url."invite_friends_for_country.php?country=".$country_code."&err=".mysqli_error($con));
exit();	
	
?>