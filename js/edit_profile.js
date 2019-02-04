$(document).ready(function()
{
$(".edit_tr").click(function()
{
var ID=$(this).attr('id');
$("#gender_"+ID).hide();
$("#birthdate_"+ID).hide();
$("#interested_"+ID).hide();
$("#relationship_"+ID).hide();
$("#language_"+ID).hide();
$("#religion_"+ID).hide();
$("#political_views_"+ID).hide();
$("#gender_input_"+ID).show();
$("#birthdate_input_"+ID).show();
$("#interested_input_"+ID).show();
$("#relationship_input_"+ID).show();
$("#language_input_"+ID).show();
$("#religion_input_"+ID).show();
$("#political_views_input_"+ID).show();
}).change(function()
{
var ID=$(this).attr('id');
var gender=$("#gender_input_"+ID).val();
var birthdate=$("#birthdate_input_"+ID).val();
var interested=$("#interested_input_"+ID).val();
var relationship=$("#relationship_input_"+ID).val();
var language=$("#language_input_"+ID).val();
var religion=$("#religion_input_"+ID).val();
var political_views=$("#political_views_input_"+ID).val();
var dataString = 'id='+ ID +'&gender='+gender+'&birthdate='+birthdate+'&interested='+interested+'&relationship='+relationship+'&language='+language+'&religion='+religion+'&political_views='+political_views;
$("#gender"+ID).html('<img src="load.gif" />');


if(gender.length>0)
{
$.ajax({
type: "POST",
url: base_url + "action/table_edit_ajax.php",
data: dataString,
cache: false,
success: function(html)
{

$("#gender_"+ID).html(gender);
$("#birthdate_"+ID).html(birthdate);
$("#interested_"+ID).html(interested);
$("#relationship_"+ID).html(relationship);
$("#language_"+ID).html(language);
$("#religion_"+ID).html(religion);
$("#political_views_"+ID).html(political_views);
}
});
}
else
{
alert('Enter something.');
}

});

$(".editbox").mouseup(function() 
{
return false
});

$(document).mouseup(function()
{
$(".editbox").hide();
$(".text").show();
});

});






$(document).ready(function()
{
$(".edit_tr_contact").click(function()
{
var ID=$(this).attr('id');
$("#email_id_"+ID).hide();
$("#mobile_no_"+ID).hide();
$("#landline_no_"+ID).hide();
$("#address_"+ID).hide();
$("#country_title_"+ID).hide();
$("#state_title_"+ID).hide();
$("#city_title_"+ID).hide();
$("#zip_"+ID).hide();
$("#email_id_input_"+ID).show();
$("#mobile_no_input_"+ID).show();
$("#landline_no_input_"+ID).show();
$("#address_input_"+ID).show();
$("#country_title_input_"+ID).show();
$("#state_title_input_"+ID).show();
$("#city_title_input_"+ID).show();
$("#zip_input_"+ID).show();

}).change(function()
{
var ID=$(this).attr('id');
var email_id=$("#email_id_input_"+ID).val();
var mobile_no=$("#mobile_no_input_"+ID).val();
var landline_no=$("#landline_no_input_"+ID).val();
var address=$("#address_input_"+ID).val();
var country_title=$("#country_title_input_"+ID).val();
var state_title=$("#state_title_input_"+ID).val();
var city_title=$("#city_title_input_"+ID).val();
var zip=$("#zip_input_"+ID).val();
var dataString = 'id='+ ID +'&email_id='+email_id+'&mobile_no='+mobile_no+'&landline_no='+landline_no+'&address='+address+'&country_title='+country_title+'&state_title='+state_title+'&city_title='+city_title+'&zip='+zip;
$("#gender"+ID).html('<img src="load.gif" />');



if(email_id.length>0)
{
$.ajax({
type: "POST",
url: base_url + "action/table_edit_ajax.php",
data: dataString,
cache: false,
success: function(html)
{

$("#email_id_"+ID).html(email_id);
$("#mobile_no_"+ID).html(mobile_no);
$("#landline_no_"+ID).html(landline_no);
$("#address_"+ID).html(address);
$("#country_title_"+ID).html(country_title);
$("#state_title_"+ID).html(state_title);
$("#city_title_"+ID).html(city_title);
$("#zip_"+ID).html(zip);
}
});
}
else
{
alert('Enter something.');
}

});

$(".editbox").mouseup(function() 
{
return false
});

$(document).mouseup(function()
{
$(".editbox").hide();
$(".text").show();
});

});

$(document).ready(function()
{
$(".edit_tr_work").click(function()
{
var ID=$(this).attr('id');
$("#company_"+ID).hide();
$("#designation_"+ID).hide();
$("#college_"+ID).hide();
$("#college_year_"+ID).hide();
$("#highschool_"+ID).hide();
$("#school_year_"+ID).hide();
$("#company_input_"+ID).show();
$("#designation_input_"+ID).show();
$("#college_input_"+ID).show();
$("#college_year_input_"+ID).show();
$("#highschool_input_"+ID).show();
$("#school_year_input_"+ID).show();

}).change(function()
{
var ID=$(this).attr('id');
var company=$("#company_input_"+ID).val();

var designation=$("#designation_input_"+ID).val();

var college=$("#college_input_"+ID).val();
var college_year=$("#college_year_input_"+ID).val();
var highschool=$("#highschool_input_"+ID).val();
var school_year=$("#school_year_input_"+ID).val();
var dataString = 'id='+ ID +'&company='+company+'&designation='+designation+'&college='+college+'&college_year='+college_year+'&highschool='+highschool+'&school_year='+school_year;
$("#company"+ID).html('<img src="load.gif" />');



if(company.length>0)
{
$.ajax({
type: "POST",
url: base_url + "action/table_edit_ajax.php",
data: dataString,
cache: false,
success: function(html)
{

$("#company_"+ID).html(company);
$("#designation_"+ID).html(designation);
$("#college_"+ID).html(college);
$("#college_year_"+ID).html(college_year);
$("#highschool_"+ID).html(highschool);
$("#school_year_"+ID).html(school_year);
}
});
}
else
{
alert('Enter something.');
}

});

$(".editbox").mouseup(function() 
{
return false
});

$(document).mouseup(function()
{
$(".editbox").hide();
$(".text").show();
});

});

	
$(document).ready(function()
{
$(".edit_tr_living").click(function()
{
var ID=$(this).attr('id');
$("#country_"+ID).hide();
$("#origion_country_"+ID).hide();
$("#country_input_"+ID).show();
$("#origion_country_input_"+ID).show();
}).change(function()
{
var ID=$(this).attr('id');
var country=$("#country_input_"+ID).val();
var origion_country=$("#origion_country_input_"+ID).val();

var dataString = 'id='+ ID +'&country='+country+'&origion_country='+origion_country;
$("#country"+ID).html('<img src="load.gif" />');



if(country.length>0)
{
$.ajax({
type: "POST",
url: base_url + "action/table_edit_ajax.php",
data: dataString,
cache: false,
success: function(html)
{

$("#country_"+ID).html(country);
$("#origion_country_"+ID).html(origion_country);
}
});
}
else
{
alert('Enter something.');
}

});

$(".editbox").mouseup(function() 
{
return false
});

$(document).mouseup(function()
{
$(".editbox").hide();
$(".text").show();
});

});
