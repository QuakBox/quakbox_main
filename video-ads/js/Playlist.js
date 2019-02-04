var PLAYER= PLAYER || {};


PLAYER.Playlist = function (options, videos, video, element, preloader, myVideo, canPlay, click_ev, pw, el) {
    //constructor
    var self = this;
//    console.log(options)

    this.VIDEO = video;
    this.element = element;
    this.canPlay = canPlay;
    this.CLICK_EV = click_ev;
    this.preloader = preloader;
    this.videoid = "VIDEOID";
    this.adStartTime = "ADSTARTTIME";
    this.videoAdPlaying = false;

    this.playlist = $("<div />");
    this.playlist.attr('id', 'playlist');

    this.playlistContent= $("<dl />");
    this.playlistContent.attr('id', 'playlistContent');

    self.videos_array=new Array();
    self.item_array=new Array();

    $(videos).each(function loopingItems()
    {
        var obj=
        {
            id: this.id,
            title:this.title,
            video_path_mp4:this.mp4,
            video_path_webm:this.webm,
            video_path_ogg:this.ogv,
            info_text: this.info,

            adPath:this.popupAdvertisementPath,
            adGotoLink:this.popupAdvertisementGotoLink,
            adStartTime:this.popupAdvertisementStartTime,
            adEndTime:this.popupAdvertisementEndTime,
            adShow:this.popupAdvertisementShow,
            videoAdShow:this.videoAdvertisementShow,
            videoAd_path_mp4:this.videoAdvertisement_mp4,
            videoAd_path_ogg:this.videoAdvertisement_ogv,
            videoAd_path_webm:this.videoAdvertisement_webm,
            videoAdGotoLink:this.videoAdvertisementGotoLink
        };
//        console.log(obj.videoAdShow, obj.videoAd_path_mp4, obj.videoAd_path_ogg, obj.videoAd_path_webm)
        self.videos_array.push(obj);

        self.item = $("<div />");
        self.item.addClass("item");
        self.playlistContent.append(self.item);

        self.item_array.push(self.item);

        if(myVideo.canPlayType && myVideo.canPlayType('video/mp4').replace(/no/, ''))
        {
            this.canPlay = true;
            if(self.videos_array[0].videoAdShow)
            {
                self.videoAdPlaying = true;
                video_path = self.videos_array[0].videoAd_path_mp4;
            }
            else if(!self.videos_array[0].videoAdShow)
                video_path = self.videos_array[0].video_path_mp4;
        }
        else if(myVideo.canPlayType && myVideo.canPlayType('video/ogg').replace(/no/, ''))
        {
            this.canPlay = true;
            if(self.videos_array[0].videoAdShow)
            {
                self.videoAdPlaying = true;
                video_path = self.videos_array[0].videoAd_path_ogg;
            }
            else if(!self.videos_array[0].videoAdShow)
                video_path = self.videos_array[0].video_path_ogg;
        }
        else if(myVideo.canPlayType && myVideo.canPlayType('video/webm').replace(/no/, ''))
        {
            this.canPlay = true;
            if(self.videos_array[0].videoAdShow)
            {
                self.videoAdPlaying = true;
                video_path = self.videos_array[0].videoAd_path_webm;
            }
            else if(!self.videos_array[0].videoAdShow)
                video_path = self.videos_array[0].video_path_webm;
        }
        self.VIDEO.load(video_path);

    });

    self.totalWidth = options.videoPlayerWidth;
    self.totalHeight = options.vieoPlayerHeight;

    self.playerWidth = self.totalWidth - self.playlist.width();
    self.playerHeight = self.totalHeight - self.playlist.height();

    self.playlist.css({
        left:self.playerWidth,
        height:self.playerHeight
    });

    if(this.show_playlist == "on")
    {
        self.scroll = new iScroll(self.playlist[0], {bounce:false, scrollbarClass: 'myScrollbar'});
    }

    this.playlistW = this.playlist.width();
    this.playlistH = this.playlist.height();

    $(window).resize(function() {
        self.playlist.css({
            left:self.element.width(),
            height:self.element.height()
        });
    });
};


//prototype object, here goes public functions
PLAYER.Playlist.prototype = {

   hidePlaylist:function(){
       this.playlist.hide();
    },
   showPlaylist:function(){
       this.playlist.show();
    }


};

