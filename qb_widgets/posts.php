<?php
//ini_set('display_errors',1);
//error_reporting(E_ALL); 

include_once($_SERVER['DOCUMENT_ROOT'] . '/qb_classes/qb_post.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/qb_classes/qb_member1.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/common/qb_security.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/common/qb_validation.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/qb_config.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/common/OpenGraph.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/common/qb_fetch.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/qb_widgets/post_extra.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/qb_widgets/post_fetchurl_result_from_table.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/qb_classes/qb_lookup.php');

class postWidget
{
    public $CountIntialPost = 0;

    function getCountIntialPost()
    {
        return $this->CountIntialPost;
    }

    function getPosts($wall, $item, $fileAction)
    { 
		
        include($_SERVER['DOCUMENT_ROOT'] . '/common/qb_session.php');
        include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/time_stamp.php');
        $QbSecurityPost = new QB_SqlInjection();
        $QbValidationPost = new QbValidation();
        $loggedin_member_id_for_post = $_SESSION['SESS_MEMBER_ID'];
        $objMember = new member1();
        /*$loggedinMember = $objMember->select_member_byID($loggedin_member_id_for_post);
        $logMem = '';
        foreach($loggedinMember as $log):
            $logMem[] = $log;
        endforeach;
        $loggedinMem = $logMem[0];*/
        $postLastID = 0;
        $topPostID = 0;
        $objPost = new posts();
        $postResult = '';
        $post_last_id_text = "last_wall_id_" . $wall;
        $top_post_id_text = "top_wall_id_" . $wall;

        $wallID = $QbSecurityPost->QB_AlphaID($wall, true);
        $objLookupClass = new lookup();
       $wallValue = $objLookupClass->getValueByKey($wallID);
	  //echo "<br>wallValue  : ". $wallValue."fileAction :".$fileAction;

        if ($wallValue == 'Member Wall') {
            $memberID2 = $QbSecurityPost->QB_AlphaID($item, true);
            if ($fileAction == 'getPrevious') {
                $postLastID = $_SESSION[$post_last_id_text];
                $postResult = $objPost->view_latest_post_by_last_id2($wall, $memberID2, $postLastID);
            } else if ($fileAction == 'getLatest') {
                $topPostID = $_SESSION[$top_post_id_text];
                $postResult = $objPost->view_latest_post_by_top_id2($wall, $memberID2, $topPostID);
            } else {
				
                $postResult = $objPost->view_latest_postByMember($memberID2);
            }

        } else if ($wallValue == 'My Wall') {

            $ResultRow = $objMember->get_memberFriends($loggedin_member_id_for_post);
            if ($fileAction == 'getPrevious') {
                $postLastID = $_SESSION[$post_last_id_text];
                $postResult = $objPost->view_latest_post_by_last_id2($wall, $ResultRow, $postLastID);
            } else if ($fileAction == 'getLatest') {
                $topPostID = $_SESSION[$top_post_id_text];
                $postResult = $objPost->view_latest_post_by_top_id2($wall, $ResultRow, $topPostID);
            } else {
                $postResult = $objPost->view_latest_postForMywall($loggedin_member_id_for_post, $ResultRow);
            }
        } else {
				
            if ($fileAction == 'getPrevious') {
			//echo "<pre>";
				//print_r($_SESSION);
                $postLastID = $_SESSION[$post_last_id_text];
                $postResult = $objPost->view_latest_post_by_last_id2($wall, $item, $postLastID);
            } else if ($fileAction == 'getLatest') {
                $topPostID = $_SESSION[$top_post_id_text];
                $postResult = $objPost->view_latest_post_by_top_id2($wall, $item, $topPostID);
            } else {
				
                $postResult = $objPost->view_latest_post2($wall, $item);
            }
        }


        $currentMemberResult = $objMember->select_member_byID($loggedin_member_id_for_post);
        $countofPostResult = count($postResult);
        $this->CountIntialPost = $countofPostResult;

        if ($countofPostResult > 0) {
            foreach ($postResult as $column => $value) {
				
                $postID = $value['messages_id'];
                $post_memberID = $value['member_id'];
                $postStatus = 1;
                $postCountryFlag = $value['country_flag'];
                $postContentID = $value['content_id'];
                $objPostExtra = new post_extra();


                $memberBlockStatusResult = $objMember->get_member_blocked_status($loggedin_member_id_for_post, $post_memberID);
                $countofMemberBlockStatusResult = count($memberBlockStatusResult);
                $check = false;
                if (isset($_SESSION[$top_post_id_text])) {
                    if ($postID > $_SESSION[$top_post_id_text]) {
                        $_SESSION[$top_post_id_text] = $postID;
                        $check = true;
                    }
                } else {
                    $_SESSION[$top_post_id_text] = $postID;
                }
                if (!$check) {
                    $_SESSION[$post_last_id_text] = $postID;
                }

                if ($countofMemberBlockStatusResult == 0 && $postStatus == 1) {

                    $encryptedMessageID = $QbSecurityPost->QB_AlphaID($postID);
                    $encryptedLoggedInMemberID = $QbSecurityPost->QB_AlphaID($loggedin_member_id_for_post);
                    $encryptedPostMemberID = $QbSecurityPost->QB_AlphaID($post_memberID);

                    $postMemberResult = $objMember->select_member_byID($post_memberID);
                    $countofpostMemberResult = count($postMemberResult);

                    $innerHTML = '';

                    foreach ($postMemberResult as $columnPostMember => $valuePostMember) {
                        $postMemberStatus = $valuePostMember['status'];

                        if ($postMemberStatus == 6) {
                            $postMemberProfileImage = '';
                            $PostMemberResultProfileImg = $objMember->select_member_meta_value($post_memberID, 'current_profile_image');
                            if ($PostMemberResultProfileImg) {
                                $postMemberProfileImage = SITE_URL . '/' . $PostMemberResultProfileImg;
                                if (isset($_REQUEST['refresh'])) {
                                    $postMemberProfileImage .= '?refresh=' . $_REQUEST['refresh'];
                                } else if (false !== strpos($_SERVER['REQUEST_URI'], 'refresh=')) {
                                    $postMemberProfileImage .= '?refresh=' . time();
                                }

                            } else {
                                $postMemberProfileImage = SITE_URL . '/images/default.png';
                            }
                            $postMemberUsername = $valuePostMember['username'];
                            $postMemberDisplayname = $valuePostMember['displayname'];
                            $postUserLink = SITE_URL;
                            $delPostText = '';
                            $sharedText = '';
                            $isPostShared = $value['share'];
                            $postType = $value['type'];
                            $postMessage = $value['messages'];

                            $postItemId = 'postItem' . $encryptedMessageID;
							$postDescription = (isset($value['description']) ? $value['description'] : "");
							                         
                                
                            $time = $value['date_created'];
                            if($postType=="1" || $postType=="2" ){
								$reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
								if(preg_match($reg_exUrl, $postDescription, $url)) {
								
									// make the urls hyper links
									$postDescription= preg_replace($reg_exUrl, "<a href=".$url[0].">".$url[0]."</a> ", $postDescription);
									

								}
                             if (strlen($postDescription) > 200) {
                                //$postDescription = strip_tags($postDescription);
								
                                $postDescription = substr($postDescription, 0, 200) . '<span id="' . $postItemId . '-more" style="display:none;">' . substr($postDescription, 300) . '</span> <span id="' . $postItemId . '-less">&hellip;<a href="javascript:;" onclick="document.getElementById(\'' . $postItemId . '-less\').style.display=\'none\';document.getElementById(\'' . $postItemId . '-more\').style.display=\'inline\';">Read more</a></span>';
                                $postDescription = nl2br($postDescription);
                            }    
                            }else{
                                if (strlen($postMessage) > 200) {
                                $postMessage = strip_tags($postMessage);
                                $postMessage = substr($postMessage, 0, 200) . '<span id="' . $postItemId . '-more" style="display:none;">' . substr($postMessage, 300) . '</span> <span id="' . $postItemId . '-less">&hellip;<a href="javascript:;" onclick="document.getElementById(\'' . $postItemId . '-less\').style.display=\'none\';document.getElementById(\'' . $postItemId . '-more\').style.display=\'inline\';">Read more</a></span>';
                                $postMessage = nl2br($postMessage);
                            }  
							}

                            if (!empty($postMessage)) {
                                $postMessage = $QbValidationPost->makeClickableLinks($postMessage);
                            }
                            


                            if ($post_memberID == $loggedin_member_id_for_post) {
                                $postUserLink = $postUserLink . '/i/' . $postMemberUsername;
                                $delPostText = '<div class="pull-right delPost"><a style="display:none;" id="' . $encryptedMessageID . '" class="delwallpost" href="javascript: void(0)" title="' . $lang['Delete update'] . '" ><span class="glyphicon glyphicon-trash" aria-hidden="true" data-toggle="tooltip" data-placement="left" title="" data-original-title="Delete this post.  "></span></a></div>';
                            } else {
                                $postUserLink = $postUserLink . '/' . $postMemberUsername;
                            }

                            $innerContent = '<div>';
                            $innerContentTop = '<div style="margin-bottom: 5px;"><a href="' . $postUserLink . '" title="' . $postMemberUsername . '" style="font-weight: bold; padding-right: 5px;">' . $postMemberUsername . '</a>';
                            if ($isPostShared == 1) {
									
                                if ($postType == 0) {
                                    $innerContentTop .= ' shared a status';
									
                                } else if ($postType == 1) {
                                    $innerContentTop .= ' shared a photo';
                                } else if ($postType == 2) {
                                    $innerContentTop .= ' shared a video';
                                } else {
                                    $innerContentTop .= ' shared a post';
                                }
							
								 $share_country_flag = $objPost->get_share_post_flag($value['share_id']);
								$rows2 = $objPost->getcountrycode($share_country_flag[0]['country_flag']);
								
								$innerContentTop .= ' From <a href="/country/'.$rows2[0]["code"].'" title="' . $rows2[0]["code"] . '">'.$rows2[0]['country_title'].'</a> <a href="/country/'.$rows2[0]["code"].'" title="' . $rows2[0]["code"] . '"><img src="/images/emblems/' . $rows2[0]['code'] . '.jpg" width="20" height="20" style="margin-left:3px; vertical-align:middle;"></a>';

                                $sharedText .= '<div class="shareDesc">';
                                $sharedText .= $value['share_msg'];
                                $sharedText .= '</div>';
                            } else {
                                //$innerContentTop .='<span class="glyphicon glyphicon-arrow-right" style="margin-right:5px;font-size: 11px;" ></span>';

                                if ($wallValue == 'Country') {
                                    //$wallName=$QbSecurityPost->Qbdecrypt(base64_decode($item), ENC_KEY);
                                    $innerContentTop .= '<img style="margin:0px 3px;" src="/images/arrow_png.jpg">';
                                    $uri = ''; //$_SERVER['REQUEST_URI'];
                                    $innerContentTop .= '<a href="' . $uri . '"><b style="color:#333;text-transform: uppercase;">' . $item . '</b></a>';
                                    $rows = $objPost->getcountrycode($item);
//var_dump($rows[0]['code']);
                                    $innerContentTop .= '<a href="/country/'.$rows2[0]["code"].'" title="' . $rows2[0]["code"] . '"><img src="/images/emblems/' . $rows[0]['code'] . '.jpg" width="20" height="20" style="margin-left:3px; vertical-align:middle;"></a>';
                                } else if ($wallValue == 'Group Wall') {
                                    $innerContentTop .= '<img style="margin:0px 3px;" src="/images/arrow_png.jpg">';
                                    $innerContentTop .= 'Group';
                                } else {

                                    if ($postContentID > 0) {
                                        $postContentMember = $objMember->select_member_byID($postContentID);
                                        foreach ($postContentMember as $valuePostContentMember) {
                                            $innerContentTop .= '<img style="margin:0px 3px;" src="/images/arrow_png.jpg">';
                                            $innerContentTop .= "<a href='" . $valuePostContentMember['displayname'] . "'><b style='color:#333;text-transform: uppercase;'>" . $valuePostContentMember['displayname'] . "</b></a>";
                                        }
                                    } else {

                                        if ($postCountryFlag == "world") {
												$PostMemberCountorymeta=$objMember->select_member_meta_value_for_GeoCountry($post_memberID);
                                      
                                        if ($PostMemberCountorymeta!='') {
											$PostMemberCountorycode=$objMember->select_GeoCountry_code($PostMemberCountorymeta);
                                            $postMembercountoryemblem = SITE_URL . '/images/emblems/' . $PostMemberCountorycode.".jpg";
											
                                        $innerContentTop .= '<a href="/country/'.$PostMemberCountorycode.'" title="' . $PostMemberCountorycode . '"><img src="' . $postMembercountoryemblem . '" width="20" height="20" style="margin-left:3px; vertical-align:middle;"></a>';
										
										} else {
                                           // $postMembercountoryemblem = SITE_URL . '/images/default.png';
                                        }
                                            $innerContentTop .= '<img style="margin:0px 3px;" src="/images/arrow_png.jpg">';
                                            $innerContentTop .= "<a href='home'><b style='color:#333;text-transform: uppercase;'>" . $postCountryFlag . "</b></a>";
											
										
										
										
										} else {
//                                            $innerContentTop .= $postCountryFlag;

                                        }
                                    }
                                }

                            }
                            $innerContent .= '<div>';
                            $quoteForMessageClass = "";
                            if ($sharedText != "") {
                                $quoteForMessageClass = "class='quotemessage'";
                            }

                            if ($postType == 0) {
                                $pattern = '/<iframe.+?src="(.+?)".+?<\/iframe>/i';
                                preg_match_all($pattern, $postMessage, $matches);

                                foreach ($matches[0] as $key => $match) {
                                    // wrap matched iframe with div
                                    $wrappedframe = '<div style="padding-bottom:5px;"><a href="' . $matches[1][$key] . '" target="_blank">' . $matches[1][$key] . '</a></div>';
                                    //$innerContentTop.='<div style="padding-bottom:5px;"><a href="'.$matches[1][$key].'" target="_blank">'.$matches[1][$key].'</a></div>';
                                    $wrappedframe .= '<div class="embed-responsive embed-responsive-4by3">' . $match . '</div>';

                                    //replace original iframe with new in content
                                    $postMessage = str_replace($match, $wrappedframe, $postMessage);
                                }

                                //$innerContent .='<div>'.$postMessage.'</div>';
                                $innerContentTop .= $sharedText;
                                $innerContentTop .= '<div  style="font-size:11px;" ' . $quoteForMessageClass . '>' . $postMessage . '</div>';
                                $getURL_insideMessage = 1;
                                if (!empty($postMessage)) {
                                    $getURL_insideMessage = $QbValidationPost->check_url($postMessage);
                                    
                                }
                                
                                if ($getURL_insideMessage != 1) {
                                    
                                    $fetch_url_result = $objPost->check_post_meta($postID, 'fetch_url');
                                    
                                    if ($fetch_url_result != 'qberror') {
                                    
                                        $objfetchURLpostmeta = new fetchURLpostmeta();
                                        $fetchURLpostmetaResult = $objfetchURLpostmeta->fetchURL($postID);
                                        $innerContent .= '<div style="padding: 5px; margin-top: 5px;border:1px solid #ddd;">' . $fetchURLpostmetaResult . '</div>';
                                    } else {
                                    
                                        $objFetchURL = new fetchURL();
                                        $postFetchResult = $objFetchURL->fetchgivenURL($getURL_insideMessage);
                                       
                                        $innerContent .= '<div style="padding: 5px; margin-top: 5px;border:1px solid #ddd;">' . $postFetchResult . '</div>';
                                    }
                                }else{
                                       $postMessage="http://".$postMessage;
                                       $objFetchURL = new fetchURL();
                                       $postFetchResult = $objFetchURL->fetchgivenURL($postMessage);
                                       $innerContent .= '<div style="padding: 5px; margin-top: 5px;border:1px solid #ddd;">' . $postFetchResult . '</div>';
                                  
                                }

                            } else if ($postType == 1) {
                                $innerContentTop .= $sharedText;
                                $innerContent .= '<a href="' . SITE_URL . '/albums.php?back_page=' . SITE_URL . '/i/' . $postMemberUsername . '&member_id=' . $post_memberID . '&album_id=' . $value['album_id'] . '&image_id=' . $value['upload_data_id'] . '" >';
                                $innerContent .= '<img style="max-width: 100%;" src="' . SITE_URL . '/' . $postMessage . '" />';
                                $innerContent .= '</a>';
                            } else if ($postType == 2) {
                                $postVideoID = $value['video_id'];
                                $postVideoTitle = $value['title'];
                                $mp4videopath = $value['location'];
                                $thumb = $value['thumburl'];
                                $adsmp4videopath = $value['adslocation'];
                                $ads = $value['ads'];
                                $click_url = $value['click_url'];

                                $oggvideopath = $value['location1'];
                                $webmvideopath = $value['location2'];

                                $adsoggvideopath = $value['adslocation1'];
                                $adswebmvideopath = $value['adslocation2'];


                                $videoid = "videoplayerid" . $postVideoID;
                                $mp4videopath1 = SITE_URL . '/' . $mp4videopath;
                                $thumwala = SITE_URL . '/' . "uploadedvideo/videothumb/p400x225" . $thumb;
                                $adsmp4 = SITE_URL . '/' . $adsmp4videopath;

                                $oggpath = SITE_URL . '/' . $oggvideopath;
                                $webmpath = SITE_URL . '/' . $webmvideopath;
                                $adsogg = SITE_URL . '/' . $adsoggvideopath;
                                $adswebm = SITE_URL . '/' . $adswebmvideopath;

                                $innerContentTop .= $sharedText;
                                $innerContentTop .= '<a href="' . SITE_URL . '/watch.php?video_id=' . $postVideoID . '" style="color:#993300;">';
                                $innerContentTop .= '<div class="video_title"  >' . $postVideoTitle . '</div></a>';
                                $innerContent .= '<div id="videoplayerid' . $postVideoID . '"> </div>';
                                $postDescription = preg_replace('/\v+|\\\[rn]/', '<br/>', $postDescription);

                                $pathToVideoFile = !empty($mp4videopath) ? __DIR__ . '/../' . $mp4videopath : '';
                                if (empty($pathToVideoFile) || !file_exists($pathToVideoFile)) {
                                    $innerContent .= '<p style="padding: 20px;">Video has been removed by user.</p>';
                                } else {
								
								$mobile = Detect_mobile();
								if ($mobile === true){			
								
                                 $innerContent .= "<video id='video' poster='".$thumwala."' preload='none' controls>
                                 	<source src='".$base_url."/".$mp4videopath."' type='video/mp4'>
									<source src='".$base_url."/".$oggvideopath."' type='video/ogg'>
                                    <source src='".$base_url."/".$webmvideopath."' type='video/webm'>
                                                                </video>";
							
                            }else{
								
								$innerContent .= '				
							<script type="text/javascript" charset="utf-8">
							    $(document).ready(function($)
							    {
							    	var videoidqw = "' . $videoid . '";
							    	var title1 = "' . $postVideoTitle . '";
								var desc1 = "' . $postDescription . '";
								var mp4videopath = "' . $mp4videopath1 . '";								
								var thumb = "' . $thumwala . '";
								var adsmp4videopath = "' . $adsmp4 . '";								
								var ads = "' . $ads . '";
								if(ads == 1){
									var adsFlag = true;
								}else {
									var adsFlag = false;
								}
								var click_url = "' . $click_url . '";
								
								
								var oggvideopath = "' . $oggpath . '";
								var webmvideopath = "' . $webmpath . '";
								var adsoggvideopath = "' . $adsogg . '";
								var adswebmvideopath = "' . $adswebm . '";							
								
									
							        videoPlayer = $("#"+videoidqw).Video({
							            autoplay:false,
							            autohideControls:4,	
										 
							            videoPlayerWidth:500,
            							    videoPlayerHeight:367,						           
							            posterImg:thumb,
							            fullscreen_native:false,
							            fullscreen_browser:true,
							            restartOnFinish:false,
							            spaceKeyActive:true,
							            rightClickMenu:true,						            
							            
							             embed:[{
							                show:true,
							                embedCode:\'<iframe src="' . SITE_URL . '" width="100%" height="420" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>\'
							            }],
							            
							            videos:[{
							                id:0,
							                title:"Oceans",
							                mp4:mp4videopath,
							                webm:webmvideopath,
                							ogv:oggvideopath,
							                info:desc1,
											
							                popupAdvertisementShow:false,
							                popupAdvertisementClickable:false,
							                popupAdvertisementPath:"images/advertisement_images/ad2.jpg",
							                popupAdvertisementGotoLink:"' . SITE_URL . '",
							                popupAdvertisementStartTime:"00:02",
							                popupAdvertisementEndTime:"00:10",
							
							                videoAdvertisementShow:adsFlag,
							                videoAdvertisementClickable:true,
							                videoAdvertisementGotoLink:click_url,
							                videoAdvertisement_mp4:adsmp4videopath,
							                videoAdvertisement_webm:adswebmvideopath,
							                videoAdvertisement_ogv:adsoggvideopath
							                
							            }]
							        });
							
							    });
							
							  </script>';
							  		
							  
							}
							  
                                }
                            } else {
                                $innerContentTop .= $sharedText;
                                $innerContent .= 'M 3' . $postMessage;
                            }
                            $innerContent .= '</div>';


                            if ($postDescription != '') {
                                $innerContentTop .= '<div>';
                                $innerContentTop .= $postDescription;
                                $innerContentTop .= '</div>';
                            }
                            $innerContentTop .= '</div>';
                            $innerContent .= '</div>';


                            $innerHTML = '<div class="postContents post' . $encryptedMessageID . '" style=" background: #fff;padding:5px;margin-bottom:5px;">';
                            $innerHTML .= '<div class="pull-left lp' . $encryptedMessageID . '" style="width: 13%;">';
                            if ($postMemberProfileImage != '') {
                                $innerHTML .= '<a href="' . $postUserLink . '" title="' . $postMemberUsername . '"><img class="img-thumbnail" style="width:80px;height:auto" src="' . $postMemberProfileImage .'?'.time(). '" /></a>';
                            
							 if ($postCountryFlag == "world") {
                                      
                                        
                                }

							
							
							}
                            $innerHTML .= '</div>';
                            $innerHTML .= '<div class="pull-left rpx' . $encryptedMessageID . '" style="width: 80%; padding: 5px 10px;">';
                            $innerHTML .= $delPostText;


                            $innerHTML .= $innerContentTop;
                            //$innerHTML .=$innerContent;
                            //$innerHTML .='<div style="color: gray; font-size: 11px;margin-top:5px;margin-bottom:5px;">'.time_stamp_vj($time).'</div>';
                            //$innerHTML .=$objPostExtra->extra_widget($wall,$postID,$encryptedMessageID,$postType);
                            $innerHTML .= '</div>';
                            $innerHTML .= '<div class="clearfix"></div>';


                            $innerHTML .= '<div class="pull-left rp' . $encryptedMessageID . '" style="width: 100%;">';

                            $innerHTML .= $innerContent;
                            $innerHTML .= '<div style="color: gray; font-size: 11px;margin-top:5px;margin-bottom:5px;">' . time_stamp_vj($time) . '</div>';
                            $innerHTML .= $objPostExtra->extra_widget($wall, $postID, $encryptedMessageID, $postType);
                            $innerHTML .= '</div>';
                            $innerHTML .= '<div class="clearfix"></div>';
                            $innerHTML .= '</div>';
                            print $innerHTML;


                        }

                    }

                }

            }

        } else {
            print "";
        }

    }


// Added By Yasser Hossam & Mushira Ahmad 17/2/2015
// It will need a lot of optimization but at least apply OOP in a good standard
    function getPostById($postId)
    {
        include($_SERVER['DOCUMENT_ROOT'] . '/common/qb_session.php');
        include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/time_stamp.php');
        $QbSecurityPost = new QB_SqlInjection();
        $QbValidationPost = new QbValidation();
        $loggedin_member_id_for_post = $_SESSION['SESS_MEMBER_ID'];
        $objMember = new member1();

        $objPost = new posts();
        $post = $objPost->view_post_by_id($postId);

        $postID = $post->messages_id;
        $post_memberID = $post->member_id;
        $postStatus = 1;
        $postCountryFlag = $post->country_flag;
        $postContentID = $post->content_id;
        $objPostExtra = new post_extra();

        //Get Wall Value
        $wallID = $QbSecurityPost->QB_AlphaID($post->wall_type, true);
        $objLookupClass = new lookup();
        $wallValue = $objLookupClass->getValueByKey($wallID);

        $memberBlockStatusResult = $objMember->get_member_blocked_status($loggedin_member_id_for_post, $post_memberID);
        $countofMemberBlockStatusResult = count($memberBlockStatusResult);


        if ($countofMemberBlockStatusResult == 0 && $postStatus == 1) {

            $encryptedMessageID = $QbSecurityPost->QB_AlphaID($postID);
            $encryptedLoggedInMemberID = $QbSecurityPost->QB_AlphaID($loggedin_member_id_for_post);
            $encryptedPostMemberID = $QbSecurityPost->QB_AlphaID($post_memberID);

            $postMemberResult = $objMember->select_member_byID($post_memberID);
            $countofpostMemberResult = count($postMemberResult);

            $innerHTML = '';

            foreach ($postMemberResult as $columnPostMember => $valuePostMember) {
                $postMemberStatus = $valuePostMember['status'];

                if ($postMemberStatus == 6) {
                    $postMemberProfileImage = '';
                    $PostMemberResultProfileImg = $objMember->select_member_meta_value($post_memberID, 'current_profile_image');
                    if ($PostMemberResultProfileImg) {
                        $postMemberProfileImage = SITE_URL . '/' . $PostMemberResultProfileImg;
                    } else {
                        $postMemberProfileImage = SITE_URL . '/images/default.png';
                    }
                    $postMemberUsername = $valuePostMember['username'];
                    $postMemberDisplayname = $valuePostMember['displayname'];
                    $postUserLink = SITE_URL;
                    $delPostText = '';
                    $sharedText = '';
                    $isPostShared = $post->share;
                    $postType = $post->type;
                    $postMessage = $post->messages;
                    if (!empty($postMessage)) {
                        $postMessage = $QbValidationPost->makeClickableLinks($postMessage);
                    }
                    $postDescription = (isset($post->description) ? $post->description : "");
                    $time = $post->date_created;


                    if ($post_memberID == $loggedin_member_id_for_post) {
                        $postUserLink = $postUserLink . '/i/' . $postMemberUsername;
                        $delPostText = '<div class="pull-right delPost"><a style="display:none;" id="' . $encryptedMessageID . '" class="delwallpost" href="javascript: void(0)" title="' . $lang['Delete update'] . '" ><span class="glyphicon glyphicon-trash" aria-hidden="true" data-toggle="tooltip" data-placement="left" title="" data-original-title="Delete this post.  "></span></a></div>';
                    } else {
                        $postUserLink = $postUserLink . '/' . $postMemberUsername;
                    }

                    $innerContent = '<div>';
                    $innerContentTop = '<div style="margin-bottom: 5px;"><a href="' . $postUserLink . '" title="' . $postMemberUsername . '" style="font-weight: bold; padding-right: 5px;">' . $postMemberUsername . '</a>';
                    if ($isPostShared == 1) {

                        if ($postType == 0) {
                            $innerContentTop .= ' shared a status';
                        } else if ($postType == 1) {
                            $innerContentTop .= ' shared a photo';
                        } else if ($postType == 2) {
                            $innerContentTop .= ' shared a video';
                        } else {
                            $innerContentTop .= ' shared a post';
                        }
                        $sharedText .= '<div class="shareDesc">';
                        $sharedText .= $post->share_msg;
                        $sharedText .= '</div>';

                    } else {
                        //$innerContentTop .='<span class="glyphicon glyphicon-arrow-right" style="margin-right:5px;font-size: 11px;" ></span>';

                        if ($wallValue == 'Country') {
                            //$wallName=$QbSecurityPost->Qbdecrypt(base64_decode($item), ENC_KEY);
                            $innerContentTop .= '<img style="margin:0px 3px;" src="/images/arrow_png.jpg">';
                            $uri = $_SERVER['REQUEST_URI'];

                            $innerContentTop .= '<a href="' . $uri . '"><b style="color:#333;text-transform: uppercase;">' . $item . '</b></a>';
                            $rows = $objPost->getcountrycode($item);
//var_dump($rows[0]['code']);
                            $innerContentTop .= '<img src="/images/emblems/' . $rows[0]['code'] . '.jpg" width="20" height="20" style="margin-left:3px; vertical-align:middle;">';
                        } else if ($wallValue == 'Group Wall') {
                            $innerContentTop .= '<img style="margin:0px 3px;" src="/images/arrow_png.jpg">';
                            $innerContentTop .= 'Group';
                        } else {

                            if ($postContentID > 0) {
                                $postContentMember = $objMember->select_member_byID($postContentID);
                                foreach ($postContentMember as $valuePostContentMember) {
                                    $innerContentTop .= '<img style="margin:0px 3px;" src="/images/arrow_png.jpg">';
                                    $innerContentTop .= "<a href='" . $valuePostContentMember['displayname'] . "'><b style='color:#333;text-transform: uppercase;'>" . $valuePostContentMember['displayname'] . "</b></a>";
                                }
                            } else {

                                if ($postCountryFlag == "world") {
                                    $innerContentTop .= '<img style="margin:0px 3px;" src="/images/arrow_png.jpg">';
                                    $innerContentTop .= "<a href='home'><b style='color:#333;text-transform: uppercase;'>" . $postCountryFlag . "</b></a>";
									
									
								} else {
                                    $innerContentTop .= $postCountryFlag;

                                }
                            }
                        }

                    }
                    $innerContent .= '<div>';
                    $quoteForMessageClass = "";
                    if ($sharedText != "") {
                        $quoteForMessageClass = "class='quotemessage'";
                    }

                    if ($postType == 0) {
                        $pattern = '/<iframe.+?src="(.+?)".+?<\/iframe>/i';
                        preg_match_all($pattern, $postMessage, $matches);

                        foreach ($matches[0] as $key => $match) {
                            // wrap matched iframe with div
                            $wrappedframe = '<div style="padding-bottom:5px;"><a href="' . $matches[1][$key] . '" target="_blank">' . $matches[1][$key] . '</a></div>';
                            //$innerContentTop.='<div style="padding-bottom:5px;"><a href="'.$matches[1][$key].'" target="_blank">'.$matches[1][$key].'</a></div>';
                            $wrappedframe .= '<div class="embed-responsive embed-responsive-4by3">' . $match . '</div>';

                            //replace original iframe with new in content
                            $postMessage = str_replace($match, $wrappedframe, $postMessage);
                        }

                        //$innerContent .='<div>'.$postMessage.'</div>';
                        $innerContentTop .= $sharedText;
                        $innerContentTop .= '<div  style="font-size:11px;" ' . $quoteForMessageClass . '>' . $postMessage . '</div>';
                        $getURL_insideMessage = 1;
                        if (!empty($postMessage)) {
                            $getURL_insideMessage = $QbValidationPost->check_url($postMessage);
                        }
                        if ($getURL_insideMessage != 1) {
                            $fetch_url_result = $objPost->check_post_meta($postID, 'fetch_url');
                            if ($fetch_url_result != 'qberror') {
                                $objfetchURLpostmeta = new fetchURLpostmeta();
                                $fetchURLpostmetaResult = $objfetchURLpostmeta->fetchURL($postID);
                                $innerContent .= '<div style="padding: 5px; margin-top: 5px;border:1px solid #ddd;">' . $fetchURLpostmetaResult . '</div>';
                            } else {
                                $objFetchURL = new fetchURL();
                                $postFetchResult = $objFetchURL->fetchgivenURL($getURL_insideMessage);
                                $innerContent .= '<div style="padding: 5px; margin-top: 5px;border:1px solid #ddd;">' . $postFetchResult . '</div>';
                            }
                        }

                    } else if ($postType == 1) {
                        $innerContentTop .= $sharedText;
                        $innerContent .= '<a href="' . SITE_URL . '/albums.php?back_page=' . SITE_URL . '/i/' . $postMemberUsername . '&member_id=' . $post_memberID . '&album_id=' . $post->album_id . '&image_id=' . $post->upload_data_id . '" >';
                        $innerContent .= '<img style="max-width: 100%;" src="' . SITE_URL . '/' . $postMessage . '" />';
                        $innerContent .= '</a>';
                    } else if ($postType == 2) {
						
						$postVideoID = $post->video_id;
                        $postVideoTitle = $post->title;
                        $mp4videopath = $post->location;
                        $thumb = $post->thumburl;
                        $adsmp4videopath = $post->adslocation;
                        $ads = $post->ads;
                        $click_url = $post->click_url;

                        $oggvideopath = $post->location1;
                        $webmvideopath = $post->location2;

                        $adsoggvideopath = $post->adslocation1;
                        $adswebmvideopath = $post->adslocation2;

                        $videoid = "videoplayerid" . $postVideoID;
                        $mp4videopath1 = SITE_URL . '/' . $mp4videopath;
                        $thumwala = SITE_URL . '/' . "uploadedvideo/videothumb/p400x225" . $thumb;
                        $adsmp4 = SITE_URL . '/' . $adsmp4videopath;

                        $oggpath = SITE_URL . '/' . $oggvideopath;
                        $webmpath = SITE_URL . '/' . $webmvideopath;
                        $adsogg = SITE_URL . '/' . $adsoggvideopath;
                        $adswebm = SITE_URL . '/' . $adswebmvideopath;

						
						
						
/*							
                        $postVideoID = $value['video_id'];
                        $postVideoTitle = $value['title'];
                        $mp4videopath = $value['location'];
                        $thumb = $value['thumburl'];
                        $adsmp4videopath = $value['adslocation'];
                        $ads = $value['ads'];
                        $click_url = $value['click_url'];

                        $oggvideopath = $value['location1'];
                        $webmvideopath = $value['location2'];

                        $adsoggvideopath = $value['adslocation1'];
                        $adswebmvideopath = $value['adslocation2'];

                        $videoid = "videoplayerid" . $postVideoID;
                        $mp4videopath1 = SITE_URL . '/' . $mp4videopath;
                        $thumwala = SITE_URL . '/' . "uploadedvideo/videothumb/p400x225" . $thumb;
                        $adsmp4 = SITE_URL . '/' . $adsmp4videopath;

                        $oggpath = SITE_URL . '/' . $oggvideopath;
                        $webmpath = SITE_URL . '/' . $webmvideopath;
                        $adsogg = SITE_URL . '/' . $adsoggvideopath;
                        $adswebm = SITE_URL . '/' . $adswebmvideopath;

						echo "postVideoID ".$postVideoID." <br>postVideoTitle ".$postVideoTitle." <br>mp4videopath ".$mp4videopath."<br>thumb ".$thumb.
								"<br>adsmp4videopath ".$adsmp4videopath." <br>ads ".$ads." <br>click_url ".$click_url."<br>oggvideopath ".$oggvideopath.
								"<br>webmvideopath ".$webmvideopath." <br>videoid ".$videoid." <br>mp4videopath1 ".$mp4videopath1."<br>thumwala ".$thumwala.
								"<br>adsmp4 ".$adsmp4."<br> videoid ".$videoid."<br> oggpath ".$oggpath."<br>webmpath ".$webmpath.
								"<br>adsogg ".$adsogg." <br>adswebm ".$adswebm;
								
								exit;
	*/								
						
                        $innerContentTop .= $sharedText;
                        $innerContentTop .= '<a href="' . SITE_URL . '/watch.php?video_id=' . $postVideoID . '" style="color:#993300;">';
                        $innerContentTop .= '<div class="video_title"  >' . $postVideoTitle . '</div></a>';
                        $innerContent .= '<div id="videoplayerid' . $postVideoID . '"> </div>';
                        $postDescription = preg_replace('/\v+|\\\[rn]/', '<br/>', $postDescription);
                        $innerContent .= ' <script type="text/javascript" charset="utf-8">
							    $(document).ready(function($)
							    {
							    	var videoidqw = "' . $videoid . '";
							    	var title1 = "' . $postVideoTitle . '";
								var desc1 = "' . $postDescription . '";
								var mp4videopath = "' . $mp4videopath1 . '";								
								var thumb = "' . $thumwala . '";
								var adsmp4videopath = "' . $adsmp4 . '";								
								var ads = "' . $ads . '";
								if(ads == 1){
									var adsFlag = true;
								}else {
									var adsFlag = false;
								}
								var click_url = "' . $click_url . '";
								
								
								var oggvideopath = "' . $oggpath . '";
								var webmvideopath = "' . $webmpath . '";
								var adsoggvideopath = "' . $adsogg . '";
								var adswebmvideopath = "' . $adswebm . '";							
								
									
							        videoPlayer = $("#"+videoidqw).Video({
							            autoplay:false,
							            autohideControls:4,	
							            videoPlayerWidth:500,
            							    videoPlayerHeight:367,						           
							            posterImg:thumb,
							            fullscreen_native:false,
							            fullscreen_browser:true,
							            restartOnFinish:false,
							            spaceKeyActive:true,
							            rightClickMenu:true,						            
							            
							             embed:[{
							                show:true,
							                embedCode:\'<iframe src="' . SITE_URL . '" width="100%" height="420" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>\'
							            }],
							            
							            videos:[{
							                id:0,
							                title:"Oceans",
							                mp4:mp4videopath,
							                webm:webmvideopath,
                							ogv:oggvideopath,
							                info:desc1,
							
							                popupAdvertisementShow:false,
							                popupAdvertisementClickable:false,
							                popupAdvertisementPath:"images/advertisement_images/ad2.jpg",
							                popupAdvertisementGotoLink:"' . SITE_URL . '",
							                popupAdvertisementStartTime:"00:02",
							                popupAdvertisementEndTime:"00:10",
							
							                videoAdvertisementShow:adsFlag,
							                videoAdvertisementClickable:true,
							                videoAdvertisementGotoLink:click_url,
							                videoAdvertisement_mp4:adsmp4videopath,
							                videoAdvertisement_webm:adswebmvideopath,
							                videoAdvertisement_ogv:adsoggvideopath
							                
							            }]
							        });
							
							    });
							
							  </script>';
						
									

                    } else {
                        $innerContentTop .= $sharedText;
                        $innerContent .= 'M 3' . $postMessage;
                    }
                    $innerContent .= '</div>';
                    if ($postDescription != '') {
                        $innerContentTop .= '<div>';
                        $innerContentTop .= $postDescription;
                        $innerContentTop .= '</div>';
                    }
                    $innerContentTop .= '</div>';
                    $innerContent .= '</div>';


                    $innerHTML = '<div class="postContents post' . $encryptedMessageID . '" style=" background: #fff;border:1px solid #ccc;padding:5px;margin-bottom:5px;border-radius:10px;">';
                    $innerHTML .= '<div class="pull-left lp' . $encryptedMessageID . '" style="width: 20%;">';
                    if ($postMemberProfileImage != '') {
                        $innerHTML .= '<a href="' . $postUserLink . '" title="' . $postMemberUsername . '"><img class="img-thumbnail" style="width:100%;" src="' . $postMemberProfileImage .'?'.time(). '" /></a>';
                    }
                    $innerHTML .= '</div>';
                    $innerHTML .= '<div class="pull-left rpx' . $encryptedMessageID . '" style="width: 80%; padding: 5px 10px;">';
                    $innerHTML .= $delPostText;
                    $innerHTML .= $innerContentTop;
                    //$innerHTML .=$innerContent;
                    //$innerHTML .='<div style="color: gray; font-size: 11px;margin-top:5px;margin-bottom:5px;">'.time_stamp_vj($time).'</div>';
                    //$innerHTML .=$objPostExtra->extra_widget($wall,$postID,$encryptedMessageID,$postType);
                    $innerHTML .= '</div>';
                    $innerHTML .= '<div class="clearfix"></div>';


                    $innerHTML .= '<div class="pull-left rp' . $encryptedMessageID . '" style="width: 100%;">';

                    $innerHTML .= $innerContent;
                    $innerHTML .= '<div style="color: gray; font-size: 11px;margin-top:5px;margin-bottom:5px;">' . time_stamp_vj($time) . '</div>';
                    $innerHTML .= $objPostExtra->extra_widget('', $postID, $encryptedMessageID, $postType);
                    $innerHTML .= '</div>';
                    $innerHTML .= '<div class="clearfix"></div>';
                    $innerHTML .= '</div>';
                    print $innerHTML;


                }

            }

        }
    }




    // Added By Yasser Hossam & Mushira Ahmad 21/2/2015
// It will need a lot of optimization but at least apply OOP in a good standard
    function getPostCommentsById($postId)
    {
        include($_SERVER['DOCUMENT_ROOT'] . '/common/qb_session.php');
        include_once($_SERVER['DOCUMENT_ROOT'] . '/includes/time_stamp.php');
        $QbSecurityPost = new QB_SqlInjection();
        $QbValidationPost = new QbValidation();
        $loggedin_member_id_for_post = $_SESSION['SESS_MEMBER_ID'];
        $objMember = new member1();

        $objPost = new posts();
        $post = $objPost->view_post_by_id($postId);

        $postID = $post->messages_id;
        $post_memberID = $post->member_id;
        $postStatus = 1;
        $postCountryFlag = $post->country_flag;
        $postContentID = $post->content_id;
        $objPostExtra = new post_extra();

        //Get Wall Value
        $wallID = $QbSecurityPost->QB_AlphaID($post->wall_type, true);
        $objLookupClass = new lookup();
        $wallValue = $objLookupClass->getValueByKey($wallID);

        $memberBlockStatusResult = $objMember->get_member_blocked_status($loggedin_member_id_for_post, $post_memberID);
        $countofMemberBlockStatusResult = count($memberBlockStatusResult);


        if ($countofMemberBlockStatusResult == 0 && $postStatus == 1) {

            $encryptedMessageID = $QbSecurityPost->QB_AlphaID($postID);
            $encryptedLoggedInMemberID = $QbSecurityPost->QB_AlphaID($loggedin_member_id_for_post);
            $encryptedPostMemberID = $QbSecurityPost->QB_AlphaID($post_memberID);

            $postMemberResult = $objMember->select_member_byID($post_memberID);
            $countofpostMemberResult = count($postMemberResult);

            $innerHTML = '';

            foreach ($postMemberResult as $columnPostMember => $valuePostMember) {
                $postMemberStatus = $valuePostMember['status'];

                if ($postMemberStatus == 6) {
                    $postMemberProfileImage = '';
                    $PostMemberResultProfileImg = $objMember->select_member_meta_value($post_memberID, 'current_profile_image');
                    if ($PostMemberResultProfileImg) {
                        $postMemberProfileImage = SITE_URL . '/' . $PostMemberResultProfileImg;
                    } else {
                        $postMemberProfileImage = SITE_URL . '/images/default.png';
                    }
                    $postMemberUsername = $valuePostMember['username'];
                    $postMemberDisplayname = $valuePostMember['displayname'];
                    $postUserLink = SITE_URL;
                    $delPostText = '';
                    $sharedText = '';
                    $isPostShared = $post->share;
                    $postType = $post->type;
                    $postMessage = $post->messages;
                    if (!empty($postMessage)) {
                        $postMessage = $QbValidationPost->makeClickableLinks($postMessage);
                    }
                    $postDescription = (isset($post->description) ? $post->description : "");
                    $time = $post->date_created;


                    if ($post_memberID == $loggedin_member_id_for_post) {
                        $postUserLink = $postUserLink . '/i/' . $postMemberUsername;
                        $delPostText = '<div class="pull-right delPost"><a style="display:none;" id="' . $encryptedMessageID . '" class="delwallpost" href="javascript: void(0)" title="' . $lang['Delete update'] . '" ><span class="glyphicon glyphicon-trash" aria-hidden="true" data-toggle="tooltip" data-placement="left" title="" data-original-title="Delete this post.  "></span></a></div>';
                    } else {
                        $postUserLink = $postUserLink . '/' . $postMemberUsername;
                    }

                    $innerContent = '<div>';
                    $innerContentTop = '<div style="margin-bottom: 5px;"><a href="' . $postUserLink . '" title="' . $postMemberUsername . '" style="font-weight: bold; padding-right: 5px;">' . $postMemberUsername . '</a>';
                    if ($isPostShared == 1) {

                        if ($postType == 0) {
                            $innerContentTop .= ' shared a status';
                        } else if ($postType == 1) {
                            $innerContentTop .= ' shared a photo';
                        } else if ($postType == 2) {
                            $innerContentTop .= ' shared a video';
                        } else {
                            $innerContentTop .= ' shared a post';
                        }
                        $sharedText .= '<div class="shareDesc">';
                        $sharedText .= $post->share_msg;
                        $sharedText .= '</div>';

                    } else {
                        //$innerContentTop .='<span class="glyphicon glyphicon-arrow-right" style="margin-right:5px;font-size: 11px;" ></span>';

                        if ($wallValue == 'Country') {
                            //$wallName=$QbSecurityPost->Qbdecrypt(base64_decode($item), ENC_KEY);
                            $innerContentTop .= '<img style="margin:0px 3px;" src="/images/arrow_png.jpg">';
                            $uri = $_SERVER['REQUEST_URI'];
                            $innerContentTop .= '<a href="' . $uri . '"><b style="color:#333;text-transform: uppercase;">' . $item . '</b></a>';
                            $rows = $objPost->getcountrycode($item);
//var_dump($rows[0]['code']);
                            $innerContentTop .= '<img src="/images/emblems/' . $rows[0]['code'] . '.jpg" width="20" height="20" style="margin-left:3px; vertical-align:middle;">';
                        } else if ($wallValue == 'Group Wall') {
                            $innerContentTop .= '<img style="margin:0px 3px;" src="/images/arrow_png.jpg">';
                            $innerContentTop .= 'Group';
                        } else {

                            if ($postContentID > 0) {
                                $postContentMember = $objMember->select_member_byID($postContentID);
                                foreach ($postContentMember as $valuePostContentMember) {
                                    $innerContentTop .= '<img style="margin:0px 3px;" src="/images/arrow_png.jpg">';
                                    $innerContentTop .= "<a href='" . $valuePostContentMember['displayname'] . "'><b style='color:#333;text-transform: uppercase;'>" . $valuePostContentMember['displayname'] . "</b></a>";
                                }
                            } else {

                                if ($postCountryFlag == "world") {
                                    $innerContentTop .= '<img style="margin:0px 3px;" src="/images/arrow_png.jpg">';
                                    $innerContentTop .= "<a href='home'><b style='color:#333;text-transform: uppercase;'>" . $postCountryFlag . "</b></a>";
                                } else {
                                    $innerContentTop .= $postCountryFlag;

                                }
                            }
                        }

                    }
                    $innerContent .= '<div>';
                    $quoteForMessageClass = "";
                    if ($sharedText != "") {
                        $quoteForMessageClass = "class='quotemessage'";
                    }

                    if ($postType == 0) {
                        $pattern = '/<iframe.+?src="(.+?)".+?<\/iframe>/i';
                        preg_match_all($pattern, $postMessage, $matches);

                        foreach ($matches[0] as $key => $match) {
                            // wrap matched iframe with div
                            $wrappedframe = '<div style="padding-bottom:5px;"><a href="' . $matches[1][$key] . '" target="_blank">' . $matches[1][$key] . '</a></div>';
                            //$innerContentTop.='<div style="padding-bottom:5px;"><a href="'.$matches[1][$key].'" target="_blank">'.$matches[1][$key].'</a></div>';
                            $wrappedframe .= '<div class="embed-responsive embed-responsive-4by3">' . $match . '</div>';

                            //replace original iframe with new in content
                            $postMessage = str_replace($match, $wrappedframe, $postMessage);
                        }

                        //$innerContent .='<div>'.$postMessage.'</div>';
                        $innerContentTop .= $sharedText;
                        $innerContentTop .= '<div  style="font-size:11px;" ' . $quoteForMessageClass . '>' . $postMessage . '</div>';
                        $getURL_insideMessage = 1;
                        if (!empty($postMessage)) {
                            $getURL_insideMessage = $QbValidationPost->check_url($postMessage);
                        }
                        if ($getURL_insideMessage != 1) {
                            $fetch_url_result = $objPost->check_post_meta($postID, 'fetch_url');
                            if ($fetch_url_result != 'qberror') {
                                $objfetchURLpostmeta = new fetchURLpostmeta();
                                $fetchURLpostmetaResult = $objfetchURLpostmeta->fetchURL($postID);
                                $innerContent .= '<div style="padding: 5px; margin-top: 5px;border:1px solid #ddd;">' . $fetchURLpostmetaResult . '</div>';
                            } else {
                                $objFetchURL = new fetchURL();
                                $postFetchResult = $objFetchURL->fetchgivenURL($getURL_insideMessage);
                                $innerContent .= '<div style="padding: 5px; margin-top: 5px;border:1px solid #ddd;">' . $postFetchResult . '</div>';
                            }
                        }

                    } else if ($postType == 1) {
                        $innerContentTop .= $sharedText;
                        $innerContent .= '<a href="' . SITE_URL . '/albums.php?back_page=' . SITE_URL . '/i/' . $postMemberUsername . '&member_id=' . $post_memberID . '&album_id=' . $post->album_id . '&image_id=' . $post->upload_data_id . '" >';
                        $innerContent .= '<img style="max-width: 100%;" src="' . SITE_URL . '/' . $postMessage . '" />';
                        $innerContent .= '</a>';
                    } else if ($postType == 2) {
                        $postVideoID = $value['video_id'];
                        $postVideoTitle = $value['title'];
                        $mp4videopath = $value['location'];
                        $thumb = $value['thumburl'];
                        $adsmp4videopath = $value['adslocation'];
                        $ads = $value['ads'];
                        $click_url = $value['click_url'];

                        $oggvideopath = $value['location1'];
                        $webmvideopath = $value['location2'];

                        $adsoggvideopath = $value['adslocation1'];
                        $adswebmvideopath = $value['adslocation2'];

                        $videoid = "videoplayerid" . $postVideoID;
                        $mp4videopath1 = SITE_URL . '/' . $mp4videopath;
                        $thumwala = SITE_URL . '/' . "uploadedvideo/videothumb/p400x225" . $thumb;
                        $adsmp4 = SITE_URL . '/' . $adsmp4videopath;

                        $oggpath = SITE_URL . '/' . $oggvideopath;
                        $webmpath = SITE_URL . '/' . $webmvideopath;
                        $adsogg = SITE_URL . '/' . $adsoggvideopath;
                        $adswebm = SITE_URL . '/' . $adswebmvideopath;

                        $innerContentTop .= $sharedText;
                        $innerContentTop .= '<a href="' . SITE_URL . '/watch.php?video_id=' . $postVideoID . '" style="color:#993300;">';
                        $innerContentTop .= '<div class="video_title"  >' . $postVideoTitle . '</div></a>';
                        $innerContent .= '<div id="videoplayerid' . $postVideoID . '"> </div>';
                        $postDescription = preg_replace('/\v+|\\\[rn]/', '<br/>', $postDescription);
                        $innerContent .= '				
                                                <script type="text/javascript" charset="utf-8">
                                                    $(document).ready(function($)
                                                    {
                                                        var videoidqw = "' . $videoid . '";
                                                        var title1 = "' . $postVideoTitle . '";
                                                        var desc1 = "' . $postDescription . '";
                                                        var mp4videopath = "' . $mp4videopath1 . '";								
                                                        var thumb = "' . $thumwala . '";
                                                        var adsmp4videopath = "' . $adsmp4 . '";								
                                                        var ads = "' . $ads . '";
                                                        if(ads == 1){
                                                                var adsFlag = true;
                                                        }else {
                                                                var adsFlag = false;
                                                        }
                                                        var click_url = "' . $click_url . '";


                                                        var oggvideopath = "' . $oggpath . '";
                                                        var webmvideopath = "' . $webmpath . '";
                                                        var adsoggvideopath = "' . $adsogg . '";
                                                        var adswebmvideopath = "' . $adswebm . '";							


                                                        videoPlayer = $("#"+videoidqw).Video({
                                                            autoplay:false,
                                                            autohideControls:4,	
                                                            videoPlayerWidth:500,
                                                            videoPlayerHeight:367,						           
                                                            posterImg:thumb,
                                                            fullscreen_native:false,
                                                            fullscreen_browser:true,
                                                            restartOnFinish:false,
                                                            spaceKeyActive:true,
                                                            rightClickMenu:true,						            

                                                             embed:[{
                                                                show:true,
                                                                embedCode:\'<iframe src="' . SITE_URL . '" width="100%" height="420" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>\'
                                                            }],

                                                            videos:[{
                                                                id:0,
                                                                title:"Oceans",
                                                                mp4:mp4videopath,
                                                                webm:webmvideopath,
                                                                ogv:oggvideopath,
                                                                info:desc1,

                                                                popupAdvertisementShow:false,
                                                                popupAdvertisementClickable:false,
                                                                popupAdvertisementPath:"images/advertisement_images/ad2.jpg",
                                                                popupAdvertisementGotoLink:"' . SITE_URL . '",
                                                                popupAdvertisementStartTime:"00:02",
                                                                popupAdvertisementEndTime:"00:10",

                                                                videoAdvertisementShow:adsFlag,
                                                                videoAdvertisementClickable:true,
                                                                videoAdvertisementGotoLink:click_url,
                                                                videoAdvertisement_mp4:adsmp4videopath,
                                                                videoAdvertisement_webm:adswebmvideopath,
                                                                videoAdvertisement_ogv:adsoggvideopath

                                                            }]
                                                        });

                                                    });

                                                  </script>';


                    } else {
                        $innerContentTop .= $sharedText;
                        $innerContent .= 'M 3' . $postMessage;
                    }
                    $innerContent .= '</div>';
                    if ($postDescription != '') {
                        $innerContentTop .= '<div>';
                        $innerContentTop .= $postDescription;
                        $innerContentTop .= '</div>';
                    }
                    $innerContentTop .= '</div>';
                    $innerContent .= '</div>';


                    $innerHTML = '<div class="postContents post' . $encryptedMessageID . '" style=" background: #fff;border:1px solid #ccc;padding:5px;margin-bottom:5px;border-radius:10px;">';
                    $innerHTML .= '<div class="pull-left lp' . $encryptedMessageID . '" style="width: 20%;">';
                    if ($postMemberProfileImage != '') {
                        $innerHTML .= '<a href="' . $postUserLink . '" title="' . $postMemberUsername . '"><img class="img-thumbnail" style="width:100%;" src="' . $postMemberProfileImage .'?'.time(). '" /></a>';
                    }
                    $innerHTML .= '</div>';
                    $innerHTML .= '<div class="pull-left rpx' . $encryptedMessageID . '" style="width: 80%; padding: 5px 10px;">';
                    $innerHTML .= $delPostText;
                    $innerHTML .= $innerContentTop;
                    //$innerHTML .=$innerContent;
                    //$innerHTML .='<div style="color: gray; font-size: 11px;margin-top:5px;margin-bottom:5px;">'.time_stamp_vj($time).'</div>';
                    //$innerHTML .=$objPostExtra->extra_widget($wall,$postID,$encryptedMessageID,$postType);
                    $innerHTML .= '</div>';
                    $innerHTML .= '<div class="clearfix"></div>';


                    $innerHTML .= '<div class="pull-left rp' . $encryptedMessageID . '" style="width: 100%;">';

                    $innerHTML .= $innerContent;
                    $innerHTML .= '<div style="color: gray; font-size: 11px;margin-top:5px;margin-bottom:5px;">' . time_stamp_vj($time) . '</div>';
                    $innerHTML .= $objPostExtra->extra_widget('', $postID, $encryptedMessageID, $postType);
                    $innerHTML .= '</div>';
                    $innerHTML .= '<div class="clearfix"></div>';
                    $innerHTML .= '</div>';
                    return $innerHTML;


                }

            }

        }
    }


}

?>