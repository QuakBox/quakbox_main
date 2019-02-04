(function (a) {
    a.fn.Video = function (a, k) {
        return new c(this, a)
    };
    var n = {
        autobuffer: !1,
        autoplay: !1,
        autohideControls: 4,
        videoPlayerWidth: 746,
        videoPlayerHeight: 420,
        posterImg: "",
        fullscreen_native: !1,
        fullscreen_browser: !0,
        restartOnFinish: !0,
        spaceKeyActive: !0,
        rightClickMenu: !0,
        share: [{
            show: !0,
            facebookLink: "https://quakbox.com/",
            twitterLink: "https://quakbox.com/",            
            pinterestLink: "https://quakbox.com/",
            linkedinLink: "https://quakbox.com/",
            googlePlusLink: "https://quakbox.com/",
            
            
        }],
        logo: [{
            show: !0,
            clickable: !0,
            path: "",
            goToLink: "https://quakbox.com/",
            position: "top-right"
        }],
        embed: [{
            show: !0,
            embedCode: '<iframe src="https://quakbox.com/player/index.html" width="100%" height="420" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>'
        }],
        videos: [{
            id: 0,
            title: "Logo reveal",
            mp4: "videos/video1.mp4",
            webm: "videos/video1.webm",
            ogv: "videos/video1.ogv",
            info: "Video info goes here",
            popupAdvertisementShow: !0,
            popupAdvertisementPath: "",
            popupAdvertisementGotoLink: "https://quakbox.com/",
            popupAdvertisementStartTime: "00:02",
            popupAdvertisementEndTime: "00:05",
            videoAdvertisementShow: !0,
            videoAdvertisementClickable: !0,
            videoAdvertisementGotoLink: "https://quakbox.com/",
            videoAdvertisement_mp4: "videos/video3.mp4",
            videoAdvertisement_webm: "videos/video3.webm",
            videoAdvertisement_ogv: "videos/video3.ogv"
        }]
    },
        p = /hp-tablet/gi.test(navigator.appVersion),
        f = "ontouchstart" in window && !p,
        q = "onorientationchange" in window ? "orientationchange" : "resize",
        r = f ? "touchend" : "click",
        s = f ? "touchstart" : "mousedown",
        l = f ? "touchmove" : "mousemove",
        t = f ? "touchend" : "mouseup",
        c = function (b, k) {
            this._class = c;
            this.parent = b;
            this.options = a.extend({}, n, k);
            this.sources = this.options.srcs || this.options.sources;
            this.useNative = this.options.useNative;
            this.options.useFullScreen = !! this.useNative;
            this.state = null;
            this.embedOn = this.shareOn = this.adOn = this.infoOn = this.stretching = this.realFullscreenActive = this.inFullScreen = !1;
            pw = !0;
            this.loaded = !1;
            this.readyList = [];
            this.hasTouch = f;
            this.RESIZE_EV = q;
            this.CLICK_EV = r;
            this.START_EV = s;
            this.MOVE_EV = l;
            this.END_EV = t;
            this.maximumWidth = 930;
            this.canPlay = !1;
            myVideo = document.createElement("video");
            this.options.rightClickMenu || a("#video").bind("contextmenu", function () {
                return !1
            });
            this.setupElement();
            this.init()
        };
    c.fn = c.prototype;
    c.fn.init = function () {
        //console.log("video player js is running");
        this.preloader = a("<div />");
        this.preloader.addClass("preloader");
        this._playlist = new PLAYER.Playlist(this.options, this.options.videos, this, this.element, this.preloader, myVideo, this.canPlay, this.CLICK_EV, pw);
        this.videos_array = [];
        this.item_array = [];
        this.playerWidth = this.options.videoPlayerWidth - this._playlist.playlistW;
        this.playerHeight = this.options.videoPlayerHeight;
        this.playlistWidth = this._playlist.playlistW;
        this.initPlayer();
        this.resize()
    };
    c.fn.initPlayer = function () {
        this.setupHTML5Video();
        this.ready(a.proxy(function () {
            this.setupEvents();
            this.change("initial");
            this.setupControls();
            this.load();
            this.setupAutoplay();
            this.element.bind("idle", a.proxy(this.idle, this));
            this.element.bind("state.videoPlayer", a.proxy(function () {
                this.element.trigger("reset.idle")
            }, this))
        }, this));
        this.secondsFormat = function (a) {
            /*isNaN(a) && (a = 0);
            var b = [],
                c = Math.floor(a / 60),
                e = Math.floor(a / 3600);
            a = Math.round(0 == a ? 0 : a % 60);
            0 < e && b.push(10 > e ? "0" + e : e);
            b.push(10 > c ? "0" + c : c);
            b.push(10 > a ? "0" + a : a);
            return b.join(":")*/
			var time = a; 
			 var hrs = ~~(time / 3600);
    var mins = ~~((time % 3600) / 60);
    var secs = ~~time % 60;

    // Output like "1:01" or "4:03:59" or "123:03:59"
    var ret = "";

    if (hrs > 0) {
        ret += "" + hrs + ":" + (mins < 10 ? "0" : "");
    }

    ret += "" + mins + ":" + (secs < 10 ? "0" : "");
    ret += "" + secs;
	return ret;
        };
        var b = this;
        a(window).resize(function () {
            b.inFullScreen || b.realFullscreenActive || b.resizeAll()
        });
        a(document).bind("webkitfullscreenchange mozfullscreenchange fullscreenchange", function (a) {
            b.resize(a)
        });
        this.resize = function (c) {
            document.webkitIsFullScreen || document.fullscreenElement || document.mozFullScreen ? (this._playlist.hidePlaylist(), this.element.addClass("fullScreen"), a(this.controls).find(".icon-expand").removeClass("icon-expand").addClass("icon-contract"), b.element.width(a(document).width()), b.element.height(a(document).height()), this.infoWindow.css({
                bottom: b.controls.height() + 30,
                left: a(window).width / 2 - this.infoWindow.width() / 2
            }), b.realFullscreenActive = !0) : (this._playlist.showPlaylist(), this.element.removeClass("fullScreen"), a(this.controls).find(".icon-contract").removeClass("icon-contract").addClass("icon-expand"), b.element.width(b.playerWidth), b.element.height(b.playerHeight),  this.infoWindow.css({
                bottom: b.controls.height() + 30,
                left: b.playerWidth / 2 - this.infoWindow.width() / 2
            }), this.stretching && (this.stretching = !1, this.toggleStretch()), b.realFullscreenActive = !1, b.resizeAll());
            this.resizeVideoTrack();
            this.positionInfoWindow();
            this.positionShareWindow();
            this.positionEmbedWindow();
            this.positionLogo();
            this.positionAds();
            this.positionVideoAdBox();
            this.resizeBars();
            this.resizeControls();
            this.autohideControls()
        }
    };
    c.fn.autohideControls = function () {
        var b = a(this.element),
            c = !1,
            d = 1E3 * this.options.autohideControls,
            g = 0,
            e = function () {
                c && b.trigger("idle", !1);
                c = !1;
                g = 0
            };
        b.bind("mousemove keydown DOMMouseScroll mousewheel mousedown reset.idle", e);
        var f = setInterval(function () {
            g >= d ? (e(), c = !0, b.trigger("idle", !0)) : g += 1E3
        }, 1E3);
        b.unload(function () {
            clearInterval(f)
        })
    };
    c.fn.resizeAll = function () {
        a(window).width() < this.options.videoPlayerWidth ? 400 > a(window).width() ? (this.newPlayerWidth = a(window).width(), this.controls.css({
            width: a(window).width()
        }), this.infoWindow.css({
            width: a(window).width()
        }), this.embedWindow.css({
            width: a(window).width()
        }), this.resizeControls(), 280 > a(window).width() ? this.rewindBtn.hide() : this.rewindBtn.show(), 255 > a(window).width() ? this.infoBtn.hide() : this.infoBtn.show(), 235 > a(window).width() ? this.embedBtn.hide() : this.embedBtn.show(), 210 > a(window).width() ? this.shareBtn.hide() : this.shareBtn.show()) : (this.newPlayerWidth = a(window).width(), this.positionInfoWindow(), this.positionEmbedWindow()) : this.newPlayerWidth = this.options.videoPlayerWidth;
        this.newPlayerHeight = this.newPlayerWidth * this.playerHeight / this.playerWidth;
        this.element.width(this.newPlayerWidth);
        this.element.height(this.newPlayerHeight);
        this.positionEmbedWindow();
        this.positionAds();
        this.positionVideoAdBox();
        this.positionInfoWindow();
        this.resizeVideoTrack();
        this.positionShareWindow();
        this.positionLogo();
        this.resizeBars();
        this.resizeControls()
    };
    c.fn.resizeControls = function () {
        this.controls.css({
            left: this.element.width() / 2 - this.controls.width() / 2
        })
    };
    c.fn.resizeBars = function () {
        this.downloadWidth = this.buffered / this.video.duration * this.videoTrack.width();
        this.videoTrackDownload.css("width", this.downloadWidth);
        this.progressWidth = this.video.currentTime / this.video.duration * this.videoTrack.width();
        this.videoTrackProgress.css("width", this.progressWidth)
    };
    c.fn.createLogo = function () {
        var b = this;
        this.logoImg = a("<div/>");
        this.logoImg.addClass("logo");
        this.img = new Image;
        this.img.src = b.options.logo[0].path;
        a(this.img).load(function () {
            b.logoImg.append(b.img);
            b.positionLogo()
        });
        b.options.logo[0].show && this.element.append(this.logoImg);
        b.options.logo[0].clickable && (this.logoImg.bind(this.START_EV, a.proxy(function () {
            window.open(b.options.logo[0].goToLink)
        }, this)), this.logoImg.mouseover(function () {
            a(this).stop().animate({
                opacity: 0.5
            }, 200)
        }), this.logoImg.mouseout(function () {
            a(this).stop().animate({
                opacity: 1
            }, 200)
        }), a(".logo").css("cursor", "pointer"))
    };
    c.fn.positionLogo = function () {
        "bottom-right" == this.options.logo[0].position ? this.logoImg.css({
            bottom: this.controls.height() + this.toolTip.height() + 8,
            left: this.element.width() - this.logoImg.width() - buttonsMargin
        }) : "bottom-left" == this.options.logo[0].position ? this.logoImg.css({
            bottom: this.controls.height() + this.toolTip.height() + 8,
            left: buttonsMargin
        }) : "top-right" == this.options.logo[0].position && this.logoImg.css({
            top: 30,
            right: 30
        })
    };
    c.fn.createAds = function () {
        var b = this;
        this.adImg = a("<div/>");
        this.adImg.addClass("ads");
        b.image = new Image;
        b.image.src = b._playlist.videos_array[0].adPath;
        a(b.image).load(function () {
            b.adImg.append(b.image);
            b.positionAds()
        });
        this.element.append(this.adImg);
        this.adImg.hide();
        this.adImg.css({
            opacity: 0
        });
        this.adClose = a("<div />");
        this.adClose.addClass("adClose");
        this.adImg.append(this.adClose);
        this.adClose.css({
            bottom: 0
        });
        this.adClose.bind(this.START_EV, a.proxy(function () {
            b.adOn = !0;
            b.toggleAdWindow()
        }, this));
        this.adClose.mouseover(function () {
            a(this).stop().animate({
                opacity: 0.5
            }, 200)
        });
        this.adClose.mouseout(function () {
            a(this).stop().animate({
                opacity: 1
            }, 200)
        })
    };
    c.fn.positionAds = function () {
        this.adImg.css({
            bottom: this.controls.height() + 40,
            left: this.element.width() / 2 - this.adImg.width() / 2
        })
    };
    c.fn.newAd = function (b, c) {
        var d = this;
        this.adImg.hide();
        d.image.src = "";
        d.image.src = d._playlist.videos_array[0].adPath;
        a(d.image).bind(this.START_EV, a.proxy(function () {
            d.options.videos[0].popupAdvertisementClickable && (window.open(d._playlist.videos_array[0].adGotoLink), d.pause())
        }, this));
        d.options.videos[0].popupAdvertisementClickable && a(".ads").css("cursor", "pointer")
    };
    c.fn.setupAutoplay = function () {
        this.options.autoplay ? this.play() : this.options.autoplay || (this.pause(), this.preloader.hide())
    };
    c.fn.createNowPlayingText = function () {
        this.element.append('<p class="nowPlayingText">' + this._playlist.videos_array[0].title + "</p>")
    };
    c.fn.createInfoWindowContent = function () {
        this.infoWindow.append('<p class="infoTitle">' + this._playlist.videos_array[0].title + "</p>");
        this.infoWindow.append('<p class="infoText">' + this._playlist.videos_array[0].info_text + "</p>");
        this.infoWindow.hide();
        this.positionInfoWindow()
    };
    c.fn.createVideoAdTitle = function () {
        this.videoAdBox = a("<div />");
        this.videoAdBox.addClass("videoAdBox");
        this.element.append(this.videoAdBox);
        this.videoAdBox.append('<p class="adsTitle">Your video will begin in</p>');
        this.videoAdBox.append(this.timeLeft);
        this.videoAdBox.hide();
        this.positionVideoAdBox()
    };
    c.fn.createEmbedWindowContent = function () {
        a(this.embedWindow).append('<p class="embedTitle">EMBED CODE:</p>');
        a(this.embedWindow).append('<p class="embedText">' + this.options.embed[0].embedCode + "</p>");
        a(this.embedWindow).find(".embedText").css({
            opacity: 0.5
        });
        a(this.embedWindow).find(".embedText").text(this.options.embed[0].embedCode);
        a(this.embedWindow).hide();
        this.positionEmbedWindow();
        a(this.embedWindow).mouseover(function () {
            a(this).find(".embedText").stop().animate({
                opacity: 1
            }, 300)
        });
        a(this.embedWindow).mouseout(function () {
            a(this).find(".embedText").stop().animate({
                opacity: 0.5
            }, 300)
        })
    };
    c.fn.ready = function (a) {
        this.readyList.push(a);
        this.loaded && a.call(this)
    };
    c.fn.load = function (b) {
        b && (this.sources = b);
        "string" == typeof this.sources && (this.sources = {
            src: this.sources
        });
        a.isArray(this.sources) || (this.sources = [this.sources]);
        this.ready(function () {
            this.change("loading");
            this.video.loadSources(this.sources)
        })
    };
    c.fn.play = function () {
        this._playlist.videoAdPlaying ? (this.videoAdBox.show(), a(this.element).find(".nowPlayingText").html("Advertisement")) : this.videoAdBox.hide();
        this.playButtonScreen.stop().animate({
            opacity: 0
        }, 0, function () {
            a(this).hide()
        });
        this.playBtn.removeClass("icon-play").addClass("icon-pause");
        this.video.play()
    };
    c.fn.pause = function () {
        this.playButtonScreen.stop().animate({
            opacity: 1
        }, 0, function () {
            a(this).show()
        });
        this.playBtn.removeClass("icon-pause").addClass("icon-play");
        this.video.pause()
    };
    c.fn.stop = function () {
        this.seek(0);
        this.pause()
    };
    c.fn.togglePlay = function () {
        "playing" == this.state ? this.pause() : this.play()
    };
    c.fn.toggleInfoWindow = function () {
        this.infoOn ? (this.infoWindow.animate({
            opacity: 0
        }, 200, function () {
            a(this).hide()
        }), this.infoOn = !1) : (this.infoWindow.show(), this.infoWindow.animate({
            opacity: 1
        }, 600), this.infoOn = !0)
    };
    c.fn.toggleAdWindow = function () {
        this.adOn ? (this.adImg.animate({
            opacity: 0
        }, 0, function () {
            a(this).hide()
        }), this.adOn = !1) : this.adOn || (this.adImg.show(), this.adImg.animate({
            opacity: 1
        }, 500), this.adOn = !0)
    };
    c.fn.toggleShareWindow = function () {
        self = this;
        this.shareOn ? (a(this.shareWindow).animate({
            opacity: 0
        }, 500, function () {
            a(this).hide()
        }), this.shareOn = !1) : (this.shareWindow.show(), a(this.shareWindow).animate({
            opacity: 1
        }, 500), this.shareOn = !0)
    };
    c.fn.toggleEmbedWindow = function () {
        self = this;
        this.embedOn ? (a(this.embedWindow).animate({
            opacity: 0
        }, 500, function () {
            a(this).hide()
        }), this.embedOn = !1) : (a(this.embedWindow).show(), a(this.embedWindow).animate({
            opacity: 1
        }, 500), this.embedOn = !0)
    };
    c.fn.fullScreen = function (b) {
        b ? (this._playlist.hidePlaylist(), this.element.addClass("fullScreen"), a(this.controls).find(".icon-expand").removeClass("icon-expand").addClass("icon-contract"), this.infoWindow.css({
            bottom: this.controls.height() + 30,
            left: a(window).width / 2 - this.infoWindow.width() / 2
        })) : (this._playlist.showPlaylist(), this.element.removeClass("fullScreen"), a(this.controls).find(".icon-contract").removeClass("icon-contract").addClass("icon-expand"), this.element.width(this.playerWidth), this.element.height(this.playerHeight), this.infoWindow.css({
            bottom: this.controls.height() + 30,
            left: this.playerWidth / 2 - this.infoWindow.width() / 2
        }), this.stretching && (this.stretching = !1, this.toggleStretch()), this.resizeAll());
        this.resizeVideoTrack();
        this.positionInfoWindow();
        this.positionEmbedWindow();
        this.positionShareWindow();
        this.positionLogo();
        this.positionAds();
        this.positionVideoAdBox();
        this.resizeBars();
        this.resizeControls();
        "undefined" == typeof b && (b = !0);
        this.inFullScreen = b
    };
    c.fn.toggleFullScreen = function () {
        THREEx.FullScreen.available() ? THREEx.FullScreen.activated() ? (this.options.fullscreen_native && THREEx.FullScreen.cancel(), this.options.fullscreen_browser && this.fullScreen(!this.inFullScreen)) : (this.options.fullscreen_native && (THREEx.FullScreen.request(), this.element.css({
            zIndex: 999999
        })), this.options.fullscreen_browser && this.fullScreen(!this.inFullScreen)) : THREEx.FullScreen.available() || this.fullScreen(!this.inFullScreen)
    };
    c.fn.seek = function (a) {
        this.video.setCurrentTime(a)
    };
    c.fn.setVolume = function (a) {
        this.video.setVolume(a)
    };
    c.fn.getVolume = function () {
        return this.video.getVolume()
    };
    c.fn.mute = function (a) {
        "undefined" == typeof a && (a = !0);
        this.setVolume(a ? 1 : 0)
    };
    c.fn.remove = function () {
        this.element.remove()
    };
    c.fn.bind = function () {
        this.videoElement.bind.apply(this.videoElement, arguments)
    };
    c.fn.one = function () {
        this.videoElement.one.apply(this.videoElement, arguments)
    };
    c.fn.trigger = function () {
        this.videoElement.trigger.apply(this.videoElement, arguments)
    };
    for (var m = "click dblclick onerror onloadeddata oncanplay ondurationchange ontimeupdate onprogress onpause onplay onended onvolumechange".split(" "), h = 0; h < m.length; h++)(function () {
        var b = m[h],
            k = b.replace(/^(on)/, "");
        c.fn[b] = function () {
            var b = a.makeArray(arguments);
            b.unshift(k);
            this.bind.apply(this, b)
        }
    })();
    c.fn.triggerReady = function () {
        for (var a in this.readyList) this.readyList[a].call(this);
        this.loaded = !0
    };
    c.fn.setupElement = function () {
        this.element = a("<div />");
        this.element.addClass("videoPlayer");
        this.parent.append(this.element)
    };
    c.fn.idle = function (a, c) {
        c ? "playing" == this.state && (this.controls.stop().animate({
            opacity: 0
        }, 300), this.shareBtn.stop().animate({
            opacity: 0
        }, 300), this.playlistBtn.stop().animate({
            opacity: 0
        }, 300), this.embedBtn.stop().animate({
            opacity: 0
        }, 300), this.logoImg.stop().animate({
            opacity: 0
        }, 300), this.element.find(".nowPlayingText").stop().animate({
            opacity: 0
        }, 300)) : (this.controls.stop().animate({
            opacity: 1
        }, 300), this.shareBtn.stop().animate({
            opacity: 1
        }, 300), this.playlistBtn.stop().animate({
            opacity: 1
        }, 300), this.embedBtn.stop().animate({
            opacity: 1
        }, 300), this.logoImg.stop().animate({
            opacity: 1
        }, 300), this.element.find(".nowPlayingText").stop().animate({
            opacity: 1
        }, 300))
    };
    c.fn.change = function (a) {
        this.state = a;
        this.element && (this.element.attr("data-state", this.state), this.element.trigger("state.videoPlayer", this.state))
    };
    c.fn.setupHTML5Video = function () {
        this.videoElement = a("<video />");
        this.videoElement.addClass("videoPlayer");
        this.videoElement.attr({
            width: this.options.width,
            height: this.options.height,
            poster: this.options.poster,
            autoplay: this.options.autoplay,
            preload: this.options.preload,
            controls: this.options.controls,
            autobuffer: this.options.autobuffer
        });
        this.element && (this.element.append(this.videoElement), this.element.append(this.preloader));
        this.video = this.videoElement[0];
        this.options.autoplay || (this.video.poster = this.options.posterImg);
        this.element && (this.element.width(this.playerWidth), this.element.height(this.playerHeight));
        var b = this;
        this.video.loadSources = function (c) {
            b.videoElement.empty();
            for (var d in c) {
                var g = a("<source type='video/mp4' />");
                g.attr(c[d]);
                b.videoElement.append(g)
            }
            b.video.load()
        };
        this.video.getStartTime = function () {
            return this.startTime || 0
        };
        this.video.getEndTime = function () {
            if (isNaN(this.duration)) b.timeTotal.text("--:--");
            else return Infinity == this.duration && this.buffered ? this.buffered.end(this.buffered.length - 1) : (this.startTime || 0) +  this.duration
        };
        this.video.getCurrentTime = function () {
            try {
                return this.currentTime
            } catch (a) {
                return 0
            }
        };
        b = this;
        this.video.setCurrentTime = function (a) {
            this.currentTime = a
        };
        this.video.getVolume = function () {
            return this.volume
        };
        this.video.setVolume = function (a) {
            this.volume = a
        };
        this.videoElement.dblclick(a.proxy(function () {
            this.toggleFullScreen()
        }, this));
        this.videoElement.bind(this.START_EV, a.proxy(function () {
            this.togglePlay();
            ("playing" == this.state || "paused" == this.state) && b._playlist.videoAdPlaying && b.options.videos[0].videoAdvertisementClickable && (window.open(this._playlist.videos_array[0].videoAdGotoLink), b.pause())
        }, this));
        this.triggerReady()
    };
    c.fn.setupButtonsOnScreen = function () {};
    c.fn.toggleStretch = function () {
        this.stretching ? (this.shrinkPlayer(), this.stretching = !1) : (this.stretchPlayer(), this.stretching = !0);
        this.resizeVideoTrack();
        this.positionInfoWindow();
        this.positionEmbedWindow();
        this.positionShareWindow();
        this.positionLogo();
        this.positionAds();
        this.positionVideoAdBox();
        this.resizeBars();
        this.resizeControls();
        this.resizeAll()
    };
    c.fn.stretchPlayer = function () {
        a(window).width() < this.totalWidth ? this.newPlayerWidth = a(window).width() : this.newPlayerWidth = this.maximumWidth;
        this.newPlayerHeight = this.newPlayerWidth * this.playerHeight / this.playerWidth;
        this.element.width(this.newPlayerWidth);
        this._playlist.hidePlaylist()
    };
    c.fn.shrinkPlayer = function () {
        a(window).width() < this.totalWidth ? this.newPlayerWidth = a(window).width() - this.playlistWidth : this.newPlayerWidth = this.maximumWidth - this.playlistWidth;
        this.newPlayerHeight = this.newPlayerWidth * this.playerHeight / this.playerWidth;
        this.element.width(this.newPlayerWidth);
        this._playlist.showPlaylist()
    };
    c.fn.positionOverScreenButtons = function (a) {
        this.element && (document.webkitIsFullScreen || document.fullscreenElement || document.mozFullScreen || a) && (this.shareBtn.css({
            left: this.element.width() - this.shareBtn.width() - buttonsMargin,
            top: buttonsMargin
        }), this.embedBtn.css({
            left: this.element.width() - this.embedBtn.width() - buttonsMargin,
            top: this.shareBtn.position().top + this.shareBtn.height() + buttonsMargin
        }), this.playlistBtn.hide())
    };
    c.fn.positionInfoWindow = function () {
        this.infoWindow.css({
            bottom: this.controls.height() + 45,
            left: this.element.width() / 2 - this.infoWindow.width() / 2
        })
    };
    c.fn.positionShareWindow = function () {
        this.shareWindow.css({
            top: buttonsMargin,
            left: this.element.width() - this.shareWindow.width() - 2 * buttonsMargin - this.shareBtn.width()
        })
    };
    c.fn.positionEmbedWindow = function () {
        this.embedWindow.css({
            bottom: this.element.height() / 2 - this.embedWindow.height() / 2,
            left: this.element.width() / 2 - this.embedWindow.width() / 2
        })
    };
    c.fn.positionVideoAdBox = function () {
        this.videoAdBox.css({
            left: this.element.width() / 2 - this.videoAdBox.width() / 2,
            bottom: this.controls.height() + 45
        })
    };
    c.fn.setupButtons = function () {
        var b = this;
        this.playBtn = a("<span />").attr("aria-hidden", "true").addClass("icon-play").bind(this.START_EV, function () {
            b.togglePlay()
        });
        this.controls.append(this.playBtn);
        a("<div />").addClass("playBg");
        this.playButtonScreen = a("<div />");
        this.playButtonScreen.addClass("playButtonScreen");
        this.playButtonScreen.bind(this.START_EV, a.proxy(function () {
            this.play()
        }, this));
        this.element && this.element.append(this.playButtonScreen);
        this.infoBtn = a("<span />").attr("aria-hidden", "true").addClass("icon-info-2");
        this.controls.append(this.infoBtn);
		this.globeBtn = a("<span />").addClass("icon-globe");        
		this.controls.append(this.globeBtn);
        this.rewindBtn = a("<span />").attr("aria-hidden", "true").addClass("icon-spinner");
        this.rewindBtn.bind(this.START_EV, a.proxy(function () {
            this.seek(0);
            this.play()
        }, this));
        this.controls.append(this.rewindBtn);
        this.playlistBtn = a("<span />").attr("aria-hidden", "true").addClass("icon-list");
        this.shareBtn = a("<span />").attr("aria-hidden", "true").addClass("icon-share");
        this.controls.append(this.shareBtn);
        this.embedBtn = a("<span />").attr("aria-hidden", "true").addClass("icon-code");
        this.controls.append(this.embedBtn);
        b.options.share[0].show || this.shareBtn.css({
            width: 0,
            height: 0,
            display: "none"
        });
        b.options.embed[0].show || this.embedBtn.css({
            width: 0,
            height: 0,
            display: "none"
        });
        buttonsMargin = 5;
        this.playlistBtn.bind(this.START_EV, function () {});
        this.fsEnter = a("<span />");
        this.fsEnter.attr("aria-hidden", "true");
        this.fsEnter.addClass("icon-expand");
        this.fsEnter.bind(this.START_EV, a.proxy(function () {
            this.toggleFullScreen()
        }, this));
        this.controls.append(this.fsEnter);
        this.fsExit = a("<span />");
        this.fsExit.attr("aria-hidden", "true");
        this.fsExit.addClass("icon-contract");
        this.fsExit.bind(this.START_EV, a.proxy(function () {
            this.toggleFullScreen()
        }, this));
        this.playButtonScreen.mouseover(function () {
            a(this).stop().animate({
                opacity: 0.5
            }, 300)
        });
        this.playButtonScreen.mouseout(function () {
            a(this).stop().animate({
                opacity: 1
            }, 300)
        });
        this.playBtn.mouseover(function () {
            a(this).stop().animate({
                opacity: 0.5
            }, 200);
            a(b.pauseBtn).stop().animate({
                opacity: 0.5
            }, 200)
        });
        this.playBtn.mouseout(function () {
            a(this).stop().animate({
                opacity: 1
            }, 200);
            a(b.pauseBtn).stop().animate({
                opacity: 1
            }, 200)
        });
        this.infoBtn.mouseover(function () {
            a(this).stop().animate({
                opacity: 0.5
            }, 200)
        });
        this.infoBtn.mouseout(function () {
            a(this).stop().animate({
                opacity: 1
            }, 200)
        });
		this.globeBtn.mouseover(function () {
            a(this).stop().animate({
                opacity: 0.5
            }, 200)
        });
		this.globeBtn.mouseout(function () {
            a(this).stop().animate({
                opacity: 1
            }, 200)
        });
        this.rewindBtn.mouseover(function () {
            a(this).stop().animate({
                opacity: 0.5
            }, 200)
        });
        this.rewindBtn.mouseout(function () {
            a(this).stop().animate({
                opacity: 1
            }, 200)
        });
        this.shareBtn.mouseover(function () {
            a(this).stop().animate({
                opacity: 0.5
            }, 200)
        });
        this.shareBtn.mouseout(function () {
            a(this).stop().animate({
                opacity: 1
            }, 200)
        });
		
        this.playlistBtn.mouseover(function () {
            a(this).stop().animate({
                opacity: 0.5
            }, 200)
        });
        this.playlistBtn.mouseout(function () {
            a(this).stop().animate({
                opacity: 1
            }, 200)
        });
        this.embedBtn.mouseover(function () {
            a(this).stop().animate({
                opacity: 0.5
            }, 200)
        });
        this.embedBtn.mouseout(function () {
            a(this).stop().animate({
                opacity: 1
            }, 200)
        });
        this.fsEnter.mouseover(function () {
            a(this).stop().animate({
                opacity: 0.5
            }, 200);
            a(b.fsExit).stop().animate({
                opacity: 0.5
            }, 200)
        });
        this.fsExit.mouseover(function () {
            a(b.fsEnter).stop().animate({
                opacity: 0.5
            }, 200);
            a(this).stop().animate({
                opacity: 0.5
            }, 200)
        });
        this.fsEnter.mouseout(function () {
            a(this).stop().animate({
                opacity: 1
            }, 200);
            a(b.fsExit).stop().animate({
                opacity: 1
            }, 200)
        });
        this.fsExit.mouseout(function () {
            a(b.fsEnter).stop().animate({
                opacity: 1
            }, 200);
            a(this).stop().animate({
                opacity: 1
            }, 200)
        })
    };
    c.fn.createInfoWindow = function () {
        this.infoWindow = a("<div />");
        this.infoWindow.addClass("infoWindow");
        this.infoWindow.css({
            opacity: 0
        });
        this.element && this.element.append(this.infoWindow);
        this.infoBtnClose = a("<div />");
        this.infoBtnClose.addClass("infoBtnClose");
        this.infoWindow.append(this.infoBtnClose);
        this.infoBtnClose.css({
            bottom: 0
        });
        this.infoBtn.bind(this.START_EV, a.proxy(function () {
            this.toggleInfoWindow()
        }, this));
        this.infoBtnClose.bind(this.START_EV, a.proxy(function () {
            this.toggleInfoWindow()
        }, this));
        this.infoBtnClose.mouseover(function () {
            a(this).stop().animate({
                opacity: 0.5
            }, 200)
        });
        this.infoBtnClose.mouseout(function () {
            a(this).stop().animate({
                opacity: 1
            }, 200)
        })
    };
    c.fn.createShareWindow = function () {
        this.shareWindow = a("<div></div>");
        this.shareWindow.addClass("shareWindow");
        this.shareWindow.hide();
        this.shareWindow.css({
            opacity: 0
        });
        this.element && this.element.append(this.shareWindow);
        this.shareBtn.bind(this.START_EV, a.proxy(function () {
            this.toggleShareWindow()
        }, this));
        this.shareWindow.facebook = a("<div />");
        this.shareWindow.facebook.addClass("facebook");
        this.shareWindow.append(this.shareWindow.facebook);
        this.shareWindow.twitter = a("<div />");
        this.shareWindow.twitter.addClass("twitter");
        this.shareWindow.append(this.shareWindow.twitter);        
        this.shareWindow.pinterest = a("<div />");
        this.shareWindow.pinterest.addClass("pinterest");
        this.shareWindow.append(this.shareWindow.pinterest);
        this.shareWindow.linkedin = a("<div />");
        this.shareWindow.linkedin.addClass("linkedin");
        this.shareWindow.append(this.shareWindow.linkedin);
        this.shareWindow.googlePlus = a("<div />");
        this.shareWindow.googlePlus.addClass("googlePlus");
        this.shareWindow.append(this.shareWindow.googlePlus);
        
        
        var b = this.shareWindow.width();
        this.shareWindow.css({
            width: b
        });
        this.shareWindow.facebook.mouseover(function () {
            a(this).stop().animate({
                opacity: 0.6
            }, 200)
        });
        this.shareWindow.facebook.mouseout(function () {
            a(this).stop().animate({
                opacity: 1
            }, 200)
        });
        this.shareWindow.twitter.mouseover(function () {
            a(this).stop().animate({
                opacity: 0.6
            }, 200)
        });
        this.shareWindow.twitter.mouseout(function () {
            a(this).stop().animate({
                opacity: 1
            }, 200)
        });
       
        
        this.shareWindow.pinterest.mouseover(function () {
            a(this).stop().animate({
                opacity: 0.6
            }, 200)
        });
        this.shareWindow.pinterest.mouseout(function () {
            a(this).stop().animate({
                opacity: 1
            }, 200)
        });
        this.shareWindow.linkedin.mouseover(function () {
            a(this).stop().animate({
                opacity: 0.6
            }, 200)
        });
        this.shareWindow.linkedin.mouseout(function () {
            a(this).stop().animate({
                opacity: 1
            }, 200)
        });
        this.shareWindow.googlePlus.mouseover(function () {
            a(this).stop().animate({
                opacity: 0.6
            }, 200)
        });
        this.shareWindow.googlePlus.mouseout(function () {
            a(this).stop().animate({
                opacity: 1
            }, 200)
        });
        
        
       
        this.shareWindow.facebook.bind(this.START_EV, a.proxy(function () {
            window.open(this.options.share[0].facebookLink)
        }, this));
        this.shareWindow.twitter.bind(this.START_EV, a.proxy(function () {
            window.open(this.options.share[0].twitterLink)
        }, this));
        
        this.shareWindow.pinterest.bind(this.START_EV, a.proxy(function () {
            window.open(this.options.share[0].pinterestLink)
        }, this));
        this.shareWindow.linkedin.bind(this.START_EV, a.proxy(function () {
            window.open(this.options.share[0].linkedinLink)
        }, this));
        this.shareWindow.googlePlus.bind(this.START_EV, a.proxy(function () {
            window.open(this.options.share[0].googlePlusLink)
        }, this));
        
        
    };
    c.fn.createEmbedWindow = function () {
        this.embedWindow = a("<div />");
        this.embedWindow.addClass("embedWindow");
        this.embedWindow.css({
            opacity: 0
        });
        this.element && this.element.append(this.embedWindow);
        this.embedBtnClose = a("<div />");
        this.embedBtnClose.addClass("embedBtnClose");
        this.embedWindow.append(this.embedBtnClose);
        this.embedBtnClose.css({
            bottom: 0
        });
        this.embedBtn.bind(this.START_EV, a.proxy(function () {
            this.toggleEmbedWindow()
        }, this));
        this.embedBtnClose.bind(this.START_EV, a.proxy(function () {
            this.toggleEmbedWindow()
        }, this));
        this.embedBtnClose.mouseover(function () {
            a(this).stop().animate({
                opacity: 0.5
            }, 200)
        });
        this.embedBtnClose.mouseout(function () {
            a(this).stop().animate({
                opacity: 1
            }, 200)
        })
    };
    c.fn.setupVideoTrack = function () {
        var b = this;
        this.videoTrack = a("<div />");
        this.videoTrack.addClass("videoTrack");
        this.controls.append(this.videoTrack);
        this.videoTrackDownload = a("<div />");
        this.videoTrackDownload.addClass("videoTrackDownload");
        this.videoTrackDownload.css("width", 0);
        this.videoTrack.append(this.videoTrackDownload);
        this.videoTrackProgress = a("<div />");
        this.videoTrackProgress.addClass("videoTrackProgress");
        this.videoTrackProgress.css("width", 0);
        this.videoTrack.append(this.videoTrackProgress);
        this.toolTip = a("<div />");
        this.toolTip.addClass("toolTip");
        this.toolTip.hide();
        this.toolTip.css({
            opacity: 0,
            bottom: b.controls.height() + this.toolTip.height() + 3
        });
        this.controls.append(this.toolTip);
        var c = a("<div />");
        c.addClass("toolTipText");
        this.toolTip.append(c);
        var d = a("<div />");
        d.addClass("toolTipTriangle");
        this.toolTip.append(d);
        this.videoTrack.bind(l, function (a) {
            var e = a.pageX - b.videoTrack.offset().left - b.toolTip.width() / 2;
            a = (a.pageX - b.videoTrack.offset().left) / b.videoTrack.width();
            d.css({
                left: 19,
                top: 18
            });
            c.text(b.secondsFormat(b.video.duration * a));
            b.toolTip.css("left", e + b.videoTrack.position().left);
            b.toolTip.show();
            b.toolTip.stop().animate({
                opacity: 1
            }, 100)
        });
        this.videoTrack.bind("mouseout", function (c) {
            a(b.toolTip).stop().animate({
                opacity: 0
            }, 50, function () {
                b.toolTip.hide()
            })
        });
        this.videoTrack.bind("click", function (a) {
            a = a.pageX - b.videoTrack.offset().left;
            b.videoTrackProgress.css("width", a);
            a /= b.videoTrack.width();
            b.video.setCurrentTime(b.video.duration * a)
        });
        this.onloadeddata(a.proxy(function () {
            pw && "Oceans" != b.options.videos[0].title && (this.element.css({
                width: 0,
                height: 0
            }), this.playButtonScreen.hide(), a(this.element).find(".nowPlayingText").hide(), a(this.element).find(".controls").hide(), a(this.element).find(".logo").hide());
            this.timeElapsed.text(this.secondsFormat(this.video.getCurrentTime()));
            this.timeTotal.text(this.secondsFormat(this.video.getEndTime()));
            this.loaded = !1;
            this.preloader.stop().animate({
                opacity: 0
            }, 300, function () {
                a(this).hide()
            });
            b.onprogress(a.proxy(function (a) {
                b.buffered = b.video.buffered.end(b.video.buffered.length - 1);
                b.downloadWidth = b.buffered / b.video.duration * b.videoTrack.width();
                b.videoTrackDownload.css("width", b.downloadWidth)
            }, b))
        }, this));
        this.ontimeupdate(a.proxy(function () {
            pw && "Oceans" != b.options.videos[0].title && (this.element.css({
                width: 0,
                height: 0
            }), this.playButtonScreen.hide(), a(this.element).find(".nowPlayingText").hide(), a(this.element).find(".controls").hide(), a(this.element).find(".logo").hide());
            this.progressWidth = this.video.currentTime / this.video.duration * this.videoTrack.width();
            this.videoTrackProgress.css("width", this.progressWidth);
            this.timeElapsed.text(b.secondsFormat(this.video.getCurrentTime()));
            this.timeTotal.text(b.secondsFormat(this.video.getEndTime()));
            b._playlist.videoAdPlaying ? b.timeLeft.text(this.secondsFormat(this.video.getEndTime() - this.video.getCurrentTime())) : b._playlist.videos_array[0].adShow && (this.secondsFormat(this.video.getCurrentTime()) == b._playlist.videos_array[0].adStartTime ? (b.adOn = !1, b.toggleAdWindow()) : this.secondsFormat(this.video.getCurrentTime()) >= b._playlist.videos_array[0].adEndTime && (b.adOn = !0, b.toggleAdWindow()))
        }, this))
    };
    c.fn.resetPlayer = function () {
        this.videoTrackDownload.css("width", 0);
        this.videoTrackProgress.css("width", 0);
        this.timeElapsed.text("00:00");
        this.timeTotal.text("00:00");
        
    };
    c.fn.enterFrameProgress = function () {};
    c.fn.setupVolumeTrack = function () {
        var b = this,
            c = a("<div />");
        c.addClass("volumeTrack");
        this.controls.append(c);
        c.css({});
        var d = a("<div />");
        d.addClass("volumeTrackProgress");
        c.append(d);
        b.video.setVolume(1);
        this.toolTipVolume = a("<div />");
        this.toolTipVolume.addClass("toolTipVolume");
        this.toolTipVolume.hide();
        this.toolTipVolume.css({
            opacity: 0,
            bottom: 20
        });
        this.controls.append(this.toolTipVolume);
        var g = a("<div />");
        g.addClass("toolTipVolumeText");
        this.toolTipVolume.append(g);
        var e = a("<div />");
        e.addClass("toolTipTriangle");
        this.toolTipVolume.append(e);
        this.muteBtn = a("<span />").attr("aria-hidden", "true").addClass("icon-volume-medium");
        this.unmuteBtn = a("<span />").attr("aria-hidden", "true").addClass("icon-volume-mute");
        this.unmuteBtn.hide();
        this.controls.append(this.muteBtn);
        this.controls.append(this.unmuteBtn);
        var f, h;
        this.muteBtn.bind(this.START_EV, a.proxy(function () {
            f = d.width();
            a(b.unmuteBtn).show();
            a(this.muteBtn).hide();
            d.stop().animate({
                width: 0
            }, 200);
            this.setVolume(0)
        }, this));
        this.unmuteBtn.bind(this.START_EV, a.proxy(function () {
            a(this.unmuteBtn).hide();
            a(b.muteBtn).show();
            d.stop().animate({
                width: f
            }, 200);
            h = f / c.width();
            b.video.setVolume(h)
        }, this));
        c.bind("mousedown", function (e) {
            a(b.unmuteBtn).hide();
            a(b.muteBtn).show();
            e = e.pageX - c.offset().left;
            var f = e / (c.width() + 2);
            b.video.setVolume(f);
            d.stop().animate({
                width: e
            }, 200);
            a(document).mousemove(function (a) {
                d.stop().animate({
                    width: a.pageX - c.offset().left
                }, 0);
                d.width() >= c.width() ? d.stop().animate({
                    width: c.width()
                }, 0) : 0 >= d.width() && d.stop().animate({
                    width: 0
                }, 0);
                b.video.setVolume(d.width() / c.width())
            })
        });
        a(document).mouseup(function (b) {
            a(document).unbind(l)
        });
        c.bind(l, function (a) {
            var d = a.pageX - c.offset().left - b.toolTipVolume.width() / 2;
            a = a.pageX - c.offset().left;
            var f = a / c.width();
            0 <= a && a <= c.width() && g.text("Volume " + String(Math.ceil(100 * f)) + "%");
            e.css({
                left: 39,
                top: 18
            });
            b.toolTipVolume.css("left", d + c.position().left);
            b.toolTipVolume.show();
            b.toolTipVolume.stop().animate({
                opacity: 1
            }, 100)
        });
        c.bind("mouseout", function (a) {
            b.toolTipVolume.stop().animate({
                opacity: 0
            }, 50, function () {
                b.toolTipVolume.hide()
            })
        });
        this.muteBtn.mouseover(function () {
            a(this).stop().animate({
                opacity: 0.5
            }, 200);
            a(b.unmuteBtn).stop().animate({
                opacity: 0.5
            }, 200)
        });
        this.unmuteBtn.mouseover(function () {
            a(b.muteBtn).stop().animate({
                opacity: 0.5
            }, 200);
            a(this).stop().animate({
                opacity: 0.5
            }, 200)
        });
        this.muteBtn.mouseout(function () {
            a(this).stop().animate({
                opacity: 1
            }, 200);
            a(b.unmuteBtn).stop().animate({
                opacity: 1
            }, 200)
        });
        this.unmuteBtn.mouseout(function () {
            a(b.muteBtn).stop().animate({
                opacity: 1
            }, 200);
            a(this).stop().animate({
                opacity: 1
            }, 200)
        })
    };
    c.fn.setupTiming = function () {
        this.timeElapsed = a("<div />");
        this.timeTotal = a("<div />");
        this.timeLeft = a("<div />");
        this.timeElapsed.text("00:00");
        this.timeTotal.text("--:--");
        this.timeLeft.text("00:00");
        this.timeElapsed.addClass("timeElapsed");
        this.timeTotal.addClass("timeTotal");
        this.timeLeft.addClass("timeLeft");
        this.videoElement.one("canplay", a.proxy(function () {
            this.videoElement.trigger("timeupdate")
        }, this));
        this.controls.append(this.timeElapsed);
        this.controls.append(this.timeTotal)
    };
    c.fn.setupControls = function () {
        this.options.controls || (this.controls = a("<div />"), this.controls.addClass("controls"), this.controls.addClass("disabled"), this.element && this.element.append(this.controls), this.setupVolumeTrack(), this.setupTiming(), this.setupButtons(), this.setupButtonsOnScreen(), this.createInfoWindow(), this.createInfoWindowContent(), this.createNowPlayingText(), this.createShareWindow(), this.createEmbedWindow(), this.createEmbedWindowContent(), this.setupVideoTrack(), this.resizeVideoTrack(), this.createLogo(), this.createVideoAdTitle(), this.createAds(), this.resizeControls(), this.resizeAll())
    };
    c.fn.resizeVideoTrack = function () {
        this.videoTrack.css({
            width: this.controls.width() - 90
        });
        this.videoTrack.css({
            left: this.controls.width() / 2 - this.videoTrack.width() / 2
        });
        this.videoTrack.css({})
    };
    c.fn.setupEvents = function () {
        var b = this;
        this.onpause(a.proxy(function () {
            this.element.addClass("paused");
            this.element.removeClass("playing");
            this.change("paused")
        }, this));
        this.onplay(a.proxy(function () {
            this.element.removeClass("paused");
            this.element.addClass("playing");
            this.change("playing")
        }, this));
        this.onended(a.proxy(function () {
            this.resetPlayer();
            
            b.preloader && b.preloader.stop().animate({
                opacity: 1
            }, 0, function () {
                a(this).show()
            });
            myVideo.canPlayType && myVideo.canPlayType("video/mp4").replace(/no/, "") ? (this.canPlay = !0, videoMain_path = b._playlist.videos_array[0].video_path_mp4) : myVideo.canPlayType && myVideo.canPlayType("video/ogg").replace(/no/, "") ? (this.canPlay = !0, videoMain_path = b._playlist.videos_array[0].video_path_ogg) : myVideo.canPlayType && myVideo.canPlayType("video/webm").replace(/no/, "") && (this.canPlay = !0, videoMain_path = b._playlist.videos_array[0].video_path_webm);
            this.load(videoMain_path);
            this._playlist.videoAdPlaying ? (this._playlist.videoAdPlaying = !1, this.play()) : this._playlist.videoAdPlaying || (this.options.restartOnFinish ? this.play() : this.pause());
            a(b.element).find(".infoTitle").html(b._playlist.videos_array[0].title);
            a(b.element).find(".infoText").html(b._playlist.videos_array[0].info_text);
            a(b.element).find(".nowPlayingText").html(b._playlist.videos_array[0].title);
            this.loaded = !1;
            this.newAd(b._playlist.videos_array[0].adPath, b._playlist.videos_array[0].adGotoLink)
        }, this));
        this.onerror(a.proxy(function (a) {
            this.useNative && (this.video.error && 4 == this.video.error.code || console.error("Error - " + this.video.error))
        }, this));
        this.oncanplay(a.proxy(function () {
            this.canPlay = !0;
            this.controls.removeClass("disabled")
        }, this));
       
    };
    window.Video = c
})(jQuery);