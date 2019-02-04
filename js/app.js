var videoname = "";   //Container For Storing actual trimmed video name with time stamp with Extension.
var logfileoutput = ""; //logfile of ffmpe conversion
var logRunningConditionStatus = false;//for preventing set interval jquery post
var nameWithoutExt = ""; //video name without extension
var uploadBoolCheck = false;//for preventing page refresh while processing by window unload function
var DefaultImageThumbnailName = "";//for storing default thumbnail name

$(function ($) {
    var menuVisible = false;
    jQuery('.qbheader .show-menu').click(function(){
        menuVisible = !menuVisible;
        if(menuVisible) {
            // Show
            $('.qbheader .profile-picture').show();
            $('.qbheader .services-list').show();
        } else {
            $('.qbheader .profile-picture').hide();
            $('.qbheader .services-list').hide();
        }
        return false;
    });
    jQuery('.qbheader .search-icon').click(function(){
        var $block = jQuery('.qbheader .search-block');
        if($block.is(':hidden')){
            $block.show();
            $block.find('input').focus();
        } else {
            $block.hide();
        }
        return false;
    });

    var touch = window.ontouchstart
        || (navigator.MaxTouchPoints > 0)
        || (navigator.msMaxTouchPoints > 0);

    if (touch) { // remove all :hover stylesheets
        try { // prevent exception on browsers not supporting DOM styleSheets properly
            for (var si in document.styleSheets) {
                var styleSheet = document.styleSheets[si];
                if (!styleSheet.rules) continue;

                for (var ri = styleSheet.rules.length - 1; ri >= 0; ri--) {
                    if (!styleSheet.rules[ri].selectorText) continue;

                    if (styleSheet.rules[ri].selectorText.match(':hover')) {
                        styleSheet.deleteRule(ri);
                    }
                }
            }
        } catch (ex) {}
    }

    $(window).scroll(function () {
        var WindowHeight = $(window).height();
        if ($(window).scrollTop() + 1 >= $(document).height() - WindowHeight) {
            if ($("#twn").length != 0) {
                $("#wall_loader").show();
                var ajaxurl = window.location.origin + "/ajax/acccept.php";
                var twn = $("#twn").val();
                var twnECLength = $("#twnEC").length;
                var twnEC = '';
                if (twnECLength != 0) {
                    twnEC = $("#twnEC").val();
                }
                var data = {item: "post", action: "getPrevious", c: twn, d: twnEC};
                $.post(ajaxurl, data, function (response) {
                    $(".wallvwe").append(response);
                    $("#wall_loader").hide();
                });
            }
        }
        return false;
    });

    $(document).on('click', '#next', function (e) {
        var firstimage = $('#cur_image').val();
        var total = $('#total_images').val();
        if (parseInt(firstimage) != parseInt(total)) {
            $('#cur_image').val(1);
            $('img#' + firstimage).hide();
        }

        if (parseInt(firstimage) < parseInt(total)) {
            firstimage = parseInt(firstimage) + parseInt(1);
            $('#cur_image').val(firstimage);
            $('img#' + firstimage).show();

        }
    });
    // prev image
    $(document).on('click', '#prev', function (e) {
        var firstimage = $('#cur_image').val();
        if (parseInt(firstimage) != 1) {
            $('img#' + firstimage).hide();
        }
        if (parseInt(firstimage) > 1) {
            firstimage = parseInt(firstimage) - parseInt(1);
            $('#cur_image').val(firstimage);
            $('img#' + firstimage).show();
        }
    });
    $(document).on('click', '#fetch_close', function (e) {
        $('#loader').css({"border": "none", "padding": "0px"});
        $('#loader').html('<div align="center" id="load" style="display:none;"><img src="https://qbdev.quakbox.com/images/ajax-loader.gif" id="loading_indicator"></div>');
    });

    $("#status_but").click(function () {
        $("#updateStatus").val('');
        var loadedcontent = $("#loader").find(".info").length;
        if (loadedcontent != 0) {
            $('#loader').css({"border": "none", "padding": "0px"});
            $('#loader').html('<div align="center" id="load" style="display:none;"><img src="https://qbdev.quakbox.com/images/ajax-loader.gif" id="loading_indicator"></div>');
        }
        $("#myphoto").hide();
        $("#updateContainer").toggle();
        $("#my_status").toggle();
    });
    $("#photo_but").click(function () {
        $("#my_status").hide();
        $("#updateContainer").toggle();
        $("#myphoto").toggle();
        var loadedcontent = $("#myphoto").find("#image_preview_wall").length;
        if (loadedcontent != 0) {
            $("#myphoto #image_preview_wall").remove();
        }
        $("#imageloadstatus").hide();
        $("#imageloadbutton").show();


    });
    $("#video_but").click(function () {
        $("#updateContainer").toggle();
        $("#myvideo").toggle();
    });

    $("#btnCancelStatus").click(function (e) {
        e.preventDefault();
        $("#updateStatus").val('');
        var loadedcontent = $("#loader").find(".info").length;
        if (loadedcontent != 0) {
            $('#loader').css({"border": "none", "padding": "0px"});
            $('#loader').html('<div align="center" id="load" style="display:none;"><img src="https://qbdev.quakbox.com/images/ajax-loader.gif" id="loading_indicator"></div>');
        }
        $("#updateContainer").toggle();
        $("#my_status").toggle();

    });
    $(document).on('click', '.cancel_update_image', function (e) {
        e.preventDefault();
        var loadedcontent = $("#myphoto").find("#image_preview_wall").length;
        if (loadedcontent != 0) {
            $("#myphoto #image_preview_wall").remove();
        }
        $("#imageloadstatus").hide();
        $("#imageloadbutton").hide();
        $("#myphoto").toggle();
        $("#updateContainer").toggle();
    });


    $(document).on('click', '#btnSaveStatus', function (e) {
        e.preventDefault();
        var postStatus = $("#updateStatus").val();
        var urlRegex = /(\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/ig;
        var url = postStatus.match(urlRegex);
        if (postStatus != '') {
            var ajaxurl = window.location.origin + "/ajax/acccept.php";
            var twn = $("#twn").val();
            var twnECLength = $("#twnEC").length;
            var twnEC = '';
            if (twnECLength != 0) {
                twnEC = $("#twnEC").val();
            }
            var data = '';
            var data = {item: "post", action: "updateStatus", status: postStatus, c: twn, d: twnEC};
            $.post(ajaxurl, data, function (response) {
                var result = $.parseJSON(response);
                if (result.msg == 'done') {
                    $("#updateContainer").toggle();
                    $("#my_status").toggle(300);
                    var twn = $("#twn").val();
                    $(".wall_header").append("<div class='wpsUp' style='color:green;text-align:center;'>You posted a new status</div>");

                    var data = {item: "post", action: "getLatest", c: twn, d: twnEC,};
                    $.post(ajaxurl, data, function (response) {
                        $(".wallvwe").prepend(response);
                    });

                }
                else {
                    $("#my_status").append("<div class='wpsUp' style='color:red;text-align:center;'>Error</div>");
                }

                window.setTimeout(function () {
                    $(".wpsUp").fadeTo(300, 0).slideUp(300, function () {
                        $(this).remove();

                    });
                }, 3000);
            });

        }
        else {
            $("#my_status").append("<div style='color:red;text-align:center;'>Please fill the status text..</div>");
        }

    });
    $(document).on('click', '.update_image', function (e) {
        e.preventDefault();
        var postDescription = $("#photo_description").val();
        var upID = $(".update_image").attr('id');
        var ajaxurl = window.location.origin + "/ajax/acccept.php";
        var twn = $("#twn").val();
        var twnECLength = $("#twnEC").length;
        var twnEC = '';
        if (twnECLength != 0) {
            twnEC = $("#twnEC").val();
        }
        var data = {item: "post", action: "updateImage", status: postDescription, c: twn, d: twnEC, u: upID};
        $.post(ajaxurl, data, function (response) {
            var result = $.parseJSON(response);
            if (result.msg == 'done') {
                $("#updateContainer").toggle();
                $("#myphoto").toggle(300);
                $(".wall_header").append("<div class='wpsUp' style='color:green;text-align:center;'>You posted a new image</div>");
                var data = {item: "post", action: "getLatest", c: twn, d: twnEC,};
                $.post(ajaxurl, data, function (response) {
                    $(".wallvwe").prepend(response);
                });
            } else {
                $("#my_status").append("<div class='wpsUp' style='color:red;text-align:center;'>Error</div>");
            }
            window.setTimeout(function () {
                $(".wpsUp").fadeTo(300, 0).slideUp(300, function () {
                    $(this).remove();
                });
            }, 3000);
        });
    });


    $(document).on('click', '.accept_request', function (e) {
        e.preventDefault();
        var illahi = $(this).attr("id");
        var twnECLength = illahi.length;
        var twnEC = '';
        if (twnECLength != 0) {
            twnEC = illahi;
        }
        var ajaxurl = window.location.origin + "/ajax/acccept.php";
        var data = {item: "user", action: "acceptRequest", d: twnEC};
        $.post(ajaxurl, data, function (response) {
            var result = $.parseJSON(response);
            if (result.msg == 'done') {
                $("#friends1" + twnEC).hide();
                $("#friends" + twnEC).show();
                if ($("#fri" + twnEC).length != 0) {
                    $("#fri" + twnEC).hide();
                }
                if ($("#friend" + twnEC).length != 0) {
                    $("#friend" + twnEC).show();
                }
                //
                //

            }
            else {
                //$("#my_status").append("<div class='wpsUp' style='color:red;text-align:center;'>Error</div>");
                alert(result.msg);
            }

        });

    });
    $('.cancel_request').click(function (e) {
        e.preventDefault();
        var illahi = $(this).attr("custoMid");
        var twnECLength = illahi.length;
        var twnEC = '';
        if (twnECLength != 0) {
            twnEC = illahi;
        }

        var ajaxurl = window.location.origin + "/ajax/acccept.php";
        var data = {item: "user", action: "cancelRequest", d: twnEC};
        $.post(ajaxurl, data, function (response) {
            var result = $.parseJSON(response);
            if (result.msg == 'done') {
                $("#friends1" + twnEC).hide();
                $("#mini_prof" + twnEC).remove();
                if ($("#fri" + twnEC).length != 0) {
                    $("#fri" + twnEC).hide();
                }
            } else {
                alert(result.msg);
            }

        });


    });


    $(document).on('change', '#wall_video', function (e) {
        var fsize = $('#wall_video')[0].files[0].size; //get file size
        var ftype = $('#wall_video')[0].files[0].type; // get file type
        console.log(fsize);
        console.log(ftype);
        switch (ftype) {
            case 'video/avi':
            case 'video/mpeg':
            case 'video/quicktime':
            case 'video/webm':
            case 'video/ogg':
            case 'video/x-matroska':
            case 'video/x-ms-wmv':
            case 'video/x-flv':
            case 'video/flv':
            case 'video/mp4':
            case 'video/3gpp':
                break;
            default:
                alert(ftype + " Unsupported file type!");
                return false

        }

        //Allowed file size is less than 1000 MB (1048576 = 1 mb)
        if (fsize > 1048576000) {
            alert(fsize + "Too big file! <br />File is too big, it should be less than 1000 MB");
            return false

        }
        $('#update_video').attr('disabled', 'disabled');
        $(this).closest('form').trigger('submit');

        $('#ProcessPage').show();//showing process page
        $('#progress').show();
        $('#progress1').hide();


    });
    var bar = $('.bar');
    var percent = $('.percent');
    var progress = $('.progress');
    var status = $('#status');


    var bar1 = $('#bar1');
    var percent1 = $('#percent1');

    function setCorrectingInterval(func, delay) {
        if (!(this instanceof setCorrectingInterval)) {
            return new setCorrectingInterval(func, delay);
        }

        var target = (new Date().valueOf()) + delay;
        var that = this;

        function tick() {
            if (that.stopped) return;

            target += delay;
            func();

            setTimeout(tick, target - (new Date().valueOf()));
        };

        setTimeout(tick, delay);
    };

    function clearCorrectingInterval(interval) {
        if (typeof(interval) == "object" && "stopped" in interval) {
            interval.stopped = true;
        }
    }

    var startTime = Date.now();
    setCorrectingInterval(function () {
        if (logRunningConditionStatus) {
            $.post(window.location.origin + '/action/ffmpegProgRes.php', {logfilepath: logfileoutput}, function (data) {

                bar1.width(data);
                percent1.html(data);
                if (data == "100%") {
                    clearCorrectingInterval();
                }

            });
        }

    }, 1000);


    $('#video_form').ajaxForm({
        beforeSend: function () {
            progress.show();
            status.empty();
            var percentVal = '0%';
            bar.width(percentVal);
            percent.html(percentVal);
        },
        uploadProgress: function (event, position, total, percentComplete) {
            console.log('percentage: ' + percentComplete);
            var percentVal = percentComplete + '%';
            bar.width(percentVal)
            percent.html(percentVal);

        },
        complete: function (xhr) {
            console.log(xhr);

            bar.width("100%");
            percent.html("100%");
            if (xhr.responseText !== 'error') {
                videoname = xhr.responseText;
                nameWithoutExt = videoname.substr(0, videoname.lastIndexOf("."));
                logfileoutput = nameWithoutExt + ".txt";
                progress.hide();
                logRunningConditionStatus = true;
                setTimeout(checkFfmpegProgress(), 200);
                $('#bar1').width('1%');
                $('#percent1').html('1%');
                $('#progress1').show();
                $("#flash").show();
                $("#flash").fadeIn(400).html('Loading Update...');
                var ajaxurl34 = window.location.origin + "/action/qb_video_convert.php";

                $.post(ajaxurl34, {
                    video_name: videoname,
                    logFile: logfileoutput
                }, function (result, textStatus, jqXHR) {
                    var res = $.parseJSON(result);
                    $('#progress1').hide();
                    logRunningConditionStatus = false;
                    status.html(res.msg);
                    $('#update_video').removeAttr('disabled');
                    $('#update_video').data('vname', res.vname);
                });

            }
            else {
                alert("sorry some error occurred");
            }

        }
    });
    $(document).on('click', '#update_video', function (e) {
        e.preventDefault();
        var title = $("#title").val();
        var vname = $('#update_video').data('vname');
        vname = (vname !== '' && vname !== null && vname !== 'undefined') ? vname : '';
        var postDescription = $("#video_description").val();
        var ajaxurl = window.location.origin + "/ajax/acccept.php";
        var twn = $("#twn").val();
        var twnECLength = $("#twnEC").length;
        var twnEC = '';
        if (twnECLength !== 0) {
            twnEC = $("#twnEC").val();
        }
        var data = {
            item: "post",
            action: "updateVideo",
            videoname: vname,
            title: title,
            c: twn,
            d: twnEC,
            desc: postDescription
        };

        $.post(ajaxurl, data, function (response) {
            var result = $.parseJSON(response);
            if (result.msg == 'done') {
                $("#updateContainer").toggle();
                $("#myvideo").toggle(300);
                $(".wall_header").append("<div class='wpsUp' style='color:green;text-align:center;'>You posted a new video</div>");

                var data = {item: "post", action: "getLatest", c: twn, d: twnEC,};
                $.post(ajaxurl, data, function (response) {
                    $(".wallvwe").prepend(response);
                    $(".wallvwe >div:first-child").find('script').each(function () {
                        eval($(this).text());
                    });
                });
                $('#video_form')[0].reset();
            }
            else {
                $("#my_status").append("<div class='wpsUp' style='color:red;text-align:center;'>Error</div>");
            }

            window.setTimeout(function () {
                $(".wpsUp").fadeTo(300, 0).slideUp(300, function () {
                    $(this).remove();

                });
            }, 3000);
        });
    });


    $(document).on('change', '#image', function (e) {
        var values = $("#uploadvalues").val();
        $("#previeww").html('<img src="wall_icons/loader.gif"/>');
        $("#imageform").ajaxForm({
            target: '#preview',
            beforeSubmit: function () {
                $("#imageloadstatus").show();
                $("#imageloadbutton").hide();
            },
            success: function () {
                $("#imageloadstatus").hide();
                $("#imageloadbutton").hide();
                $('#image').val('');
            },
            error: function () {
                $("#imageloadstatus").hide();
                $("#imageloadbutton").show();
            }
        }).submit();
        var X = $('.preview').attr('id');
        if (X != 'undefined') {
            $("#uploadvalues").val(X);
        }
    });

    $(document).on('click', '.walls_share', function (e) {
        // Your code on successful click
        //for resetting form and values
        $("#shareSubmitButtonID").removeAttr('disabled');
        $('#shareform')[0].reset();
        $('#countries').val('').trigger('chosen:updated');
        $("#group_name").tokenInput("clear");
        $("#friend_name").tokenInput("clear");
        $(".share_body").empty();
        $('#mydiv3').empty();

        $("#mvm").show();
        $("#hiddenIDForSelection").attr("value", "0");
        $("#mvm1").hide();
        $("#mvm2").hide();
        var ID = $(this).attr("id");
        var rowtype = $(this).data("type");
        var rowTypeValue = null;
        if (rowtype == "0") {
            rowTypeValue = 'Share';
        }
        else if (rowtype == "1") {
            rowTypeValue = 'Share Photo';
        }
        else if (rowtype == "2") {
            rowTypeValue = 'Share Video';
        }
        else if (rowtype == "3") {
            rowTypeValue = 'Share Video';
        }
        var dataString = 'msg_id=' + ID;
        $.ajax({
            type: "POST",
            url: "/load_data/share_info.php",
            data: dataString,
            cache: false,
            success: function (html) {
                $("#shareSubmitButtonID").attr("value", rowTypeValue);
                $(".share_popup").show();
                $(".share_body").append(html);
                $('#mydiv3').share({
                    networks: ['facebook', 'pinterest', 'googleplus', 'twitter', 'linkedin', 'tumblr', 'in1', 'stumbleupon', 'digg'],
                    urlToShare: '/fetch_posts.php?id=' + ID

                });
                $('#mydiv3').append("<img id='email' src='/images/sendemail.png' height='40' width='40' alt='Send Email' title='Send Email' onclick='showform()' class='pop share-icon'>");
                $('#email').css('cursor', 'pointer');
            }
        });
        return false;
    });
    $("#addTabsC").niceScroll();


    /* walls */

    //common
    $('[data-toggle="tooltip"]').tooltip();

    //add share using jquery
    $('#shareSubmitButtonID').on('click', function () {
        //alert('hii');
        var friend_name = $("#friend_name").val();
        var group_name = $("#group_name").val();
        var countries = $("#countries").val();
        var privacy = $("#privacy")[0].selectedIndex;
        if (privacy == 0) {
            if (friend_name == '') {
                /*jAlert('You must provide a recipient for your shared item.', 'No Recipient');*/
                alert('You must provide a recipient for your shared item.', 'No Recipient');
                return false;
            }
        } else if (privacy == 1) {
            if (group_name == '') {
                alert('You must provide a recipient for your shared item.', 'No Recipient');
                return false;
            }
        } else if (privacy == 2) {
            if (countries == null) {
                alert('You must provide a recipient for your shared item.', 'No Recipient');
                return false;
            }
        }
        $('#shareSubmitButtonID').attr('disabled', 'disabled');
        //$("#previeww").html('<img src="wall_icons/loader.gif"/>');
        $("#shareform").ajaxForm({
            success: function () {
                $(".share_popup").hide();
                alert('Share successfully.', 'Share');
            },
            error: function () {
                $("#imageloadstatus").hide();
            }
        }).submit();

    });
});
function checkFfmpegProgress() {
    console.log(logRunningConditionStatus);
    var bar1 = $('#bar1');
    var percent1 = $('#percent1');
    if (logRunningConditionStatus) {
        $.post('/action/ffmpegProgRes.php', {logfilepath: logfileoutput}, function (data) {
            bar1.width(data);
            percent1.html(data);
            intPercentage = data.replace("%", "");
            intPercentage = parseInt(intPercentage);
            if (intPercentage < 100) {
                checkFfmpegProgress();
            } else {
                console.log("Continue to the video execution");

            }

            $('#update_video').removeAttr('disabled'); // .data('vname', res.vname);
        });
    }
}

$(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip();
});
