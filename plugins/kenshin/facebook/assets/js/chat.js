window.jQuery || document.write('<script src="http://jquery.com/jquery-wp-content/themes/jquery/js/jquery-1.11.2.min.js"><\/script>');
(function(d, s, a) {
    var b, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(a)) return;
    b = d.createElement(s);
    b.id = a;
    b.src = '//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.5';
    fjs.parentNode.insertBefore(b, fjs)
}(document, 'script', 'facebook-jssdk'));
var $ = jQuery.noConflict();
$(document).ready(function() {
    $("#f_chat_name").html(f_chat_name);
    $("#f_enter_1").html(f_chat_star_1);
    $("#f_enter_2").html(f_chat_star_2);
    $("#f_enter_4").html(f_chat_star_4);
    setTimeout(function() {
        f_ck_chat()
    }, 100)
});

function fb_e_html(a, b) {
    try {
        document.getElementById(a).innerHTML = b
    } catch (err) {}
}

function fb_e_style(a, b) {
    try {
        document.getElementById(a).style.display = b
    } catch (err) {}
}

function check_fist_vist_f() {
    var _ = f_read_cki("check_fist_vist_f");
    (0 == _ || "" == _) && (fb_eshow("f-chat-conent"), f_create_cki("check_fist_vist_f", "1", 1), f_create_cki("f_chat_open", "1", 1))
}

function chat_f_close() {
    fb_ehide('b-c-facebook'), f_create_cki('chat_f_close', 1, 1), $('body').find('.zopim').remove(), fb_eshow('chat_f_b_smal'), on_playsound('click')
}

function chat_f_show() {
    f_create_cki('chat_f_close', '0', 1), fb_eshow('b-c-facebook'), fb_eshow('f-chat-conent'), fb_ehide('chat_f_b_smal')
}

function f_bt_start_chat() {
    f_create_cki('f_bt_start_chat', '1', 10), fb_ehide('fb_chat_start'), fb_ehide('fb_alert_num'), on_playsound('click')
}

function f_c_start_chat() {
    var t = f_read_cki('f_bt_start_chat');
    0 == t || '' == t ? (fb_eshow('fb_chat_start'), fb_eshow('fb_alert_num'), f_chat_step()) : (fb_ehide('fb_chat_start'), fb_ehide('fb_alert_num'))
}

function b_f_chat() {
    var t = f_read_cki('f_chat_open');
    0 == t || '' == t ? (fb_eshow('f-chat-conent'), f_create_cki('f_chat_open', '1', 1)) : (fb_ehide('f-chat-conent'), f_create_cki('f_chat_open', '0', 1)), on_playsound('click')
}

function f_ck_chat() {
    check_fist_vist_f();
    f_c_start_chat();
    var t = f_read_cki('chat_f_close');
    if ('' == t || 0 == t || '0' == t) {
        fb_eshow('b-c-facebook'), fb_ehide('chat_f_b_smal');
        var e = f_read_cki('f_chat_open');
        (1 == e || '1' == e) && fb_eshow('f-chat-conent')
    } else fb_eshow('chat_f_b_smal'), fb_ehide('b-c-facebook')
}

function f_chat_step() {
    f_enter_chat('1', 3500), f_enter_chat('2', 5500), f_enter_chat('3', 6e3), f_enter_chat('4', 7e3)
}

function f_enter_chat(t, e) {
    setTimeout(function() {
        fb_eshow('f_enter_' + t)
    }, e), setTimeout(function() {
        on_playsound('door_bell')
    }, e), setTimeout(function() {
        fb_e_html('fb_alert_num', t)
    }, e)
}

function fb_eshow(t) {
    fb_e_style(t, 'block')
}

function fb_ehide(t) {
    fb_e_style(t, 'none')
}

function f_create_cki(t, e, n) {
    if (n) {
        var o = new Date;
        o.setTime(o.getTime() + 24 * n * 60 * 60 * 1e3);
        var c = '; expires=' + o.toGMTString()
    } else var c = '';
    document.cookie = t + '=' + e + c + '; path=/'
}

function f_read_cki(t) {
    for (var e = t + '=', n = document.cookie.split(';'), o = 0; o < n.length; o++) {
        for (var c = n[o];
             ' ' == c.charAt(0);) c = c.substring(1, c.length);
        if (0 == c.indexOf(e)) return c.substring(e.length, c.length)
    }
    return ''
}

function on_playsound(t) {
    1 == web_sound && $.ionSound.play(t)
}

function ionSound() {
    1 == web_sound && $.ionSound({
        sounds: ['click', 'door_bell'],
        path: f_chat_domain + '/plugins/kenshin/facebook/assets/sounds/',
        multiPlay: !0,
        volume: '1.0'
    })
}
var web_sound = !0;
jQuery(document).ready(function(t) {
    t(window).scroll(function() {
        var e = t(window).width();
        680 >= e ? f_create_cki('f_chat_open', '0', 1) : f_create_cki('f_chat_open', '1', 1)
    })
}), setTimeout(function() {
    f_ck_chat()
}, 100);
var $ = jQuery.noConflict();
! function(t) {
    if (!t.ionSound) {
        var e, n, o, c, _ = {},
            f = {},
            a = !1,
            i = function(e) {
                var c, a; - 1 !== e.indexOf(':') ? (c = e.split(':')[0], a = e.split(':')[1]) : c = e, f[c] = new Audio, n = f[c].canPlayType('audio/mp3'), o = 'probably' === n || 'maybe' === n ? _.path + c + '.mp3' : _.path + c + '.ogg', t(f[c]).prop('src', o), f[c].load(), f[c].preload = 'auto', f[c].volume = a || _.volume
            },
            u = function(t) {
                var e, n, o, c;
                if (-1 !== t.indexOf(':') ? (n = t.split(':')[0], o = t.split(':')[1]) : n = t, e = f[n], 'object' == typeof e && null !== e)
                    if (o && (e.volume = o), _.multiPlay || a) {
                        if (_.multiPlay)
                            if (e.ended) e.play();
                            else {
                                try {
                                    e.currentTime = 0
                                } catch (i) {}
                                e.play()
                            }
                    } else e.play(), a = !0, c = setInterval(function() {
                        e.ended && (clearInterval(c), a = !1)
                    }, 250)
            },
            l = function(t) {
                var e = f[t];
                if ('object' == typeof e && null !== e) {
                    e.pause();
                    try {
                        e.currentTime = 0
                    } catch (n) {}
                }
            },
            r = function(t) {
                var e = f[t];
                if ('object' == typeof e && null !== e) {
                    try {
                        f[t].src = ''
                    } catch (n) {}
                    f[t] = null
                }
            };
        t.ionSound = function(n) {
            if (_ = t.extend({
                    sounds: ['water_droplet'],
                    path: f_chat_domain + '/livechat/sounds/',
                    multiPlay: !0,
                    volume: '0.5'
                }, n), e = _.sounds.length, 'function' == typeof Audio || 'object' == typeof Audio)
                for (c = 0; e > c; c += 1) i(_.sounds[c]);
            t.ionSound.play = function(t) {
                u(t)
            }, t.ionSound.stop = function(t) {
                l(t)
            }, t.ionSound.kill = function(t) {
                r(t)
            }
        }, t.ionSound.destroy = function() {
            for (c = 0; e > c; c += 1) f[_.sounds[c]] = null;
            e = 0, t.ionSound.play = function() {}, t.ionSound.stop = function() {}, t.ionSound.kill = function() {}
        }
    }
}(jQuery), ionSound();
document.write("<style type=\"text/css\" media=\"screen\">#b-c-facebook .f-chat-conent .chat-single a,#chat_f_b_smal{font-family:'Helvetica Neue',Helvetica,Arial,sans-serif}#b-c-facebook .chat-f-b,#chat_f_b_smal{text-shadow:0 1px 0 rgba(0,0,0,.1);background-repeat:repeat-x;background-size:auto;background-position:0 0;text-decoration:none}.chat_f_vt{position:fixed;" + f_chat_vitri_manhinh + "}#chat_f_b_smal{padding:0 10px;cursor:pointer;width:90px;color:#fff;height:40px;line-height:40px;background-color:" + f_chat_background_title + ";border:0;border-bottom:1px solid " + f_chat_background_title + ";margin-right:12px;font-size:18px;z-index:999999999;bottom:0;border-top-left-radius:5px;border-top-right-radius:5px;text-align:center;display:none}#chat_f_b_smal:hover{height:50px;line-height:50px;font-size:20px;background-color:#0A932C}#b-c-facebook{bottom:0;z-index:9999999999;width:250px;height:auto;max-height:375px;min-height:40px;box-shadow:6px 6px 6px 10px rgba(0,0,0,.2);border-top-left-radius:5px;border-top-right-radius:5px;overflow:hidden}#b-c-facebook .f-chat-conent{float:left;width:100%;height:335px;overflow:hidden;display:none;background-color:#fff;position:relative}#b-c-facebook .f-chat-conent .chat-single{float:left;position:absolute;bottom:0;left:0;background-color:#fff;line-height:25px;color:#fff;width:100%}#b-c-facebook .f-chat-conent .chat-single a{float:left;text-decoration:none;margin-left:10px;color:#0C5BB5;font-size:12px}#b-c-facebook .f-chat-conent .chat-single a:hover{color:#F60}#b-c-facebook .f-chat-conent .chat-single label{float:right;color:silver;margin-right:5px;font-size:12px;font-family:Arial}#b-c-facebook .chat-f-b,#b-c-facebook .chat-f-b label{line-height: 20px; margin: 0px; cursor:pointer;font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;font-size:18px}#b-c-facebook .f-chat-conent .chat-single i{color:#0C5BB5}#b-c-facebook .f-chat-conent .fb-page{margin-top:0;float:left;height:310px}#b-c-facebook .chat-f-b{float:left;padding:0 25px;width:250px;color:" + f_chat_color_title + ";height:40px;line-height:40px;background-color:#F77213;border:0;border-bottom:1px solid #EC8209;z-index:9999999;margin-right:12px}#b-c-facebook .chat-f-b label{position:absolute;left:40px;top:12px}.title-f-chat-icon{margin-left:-10px}#t_f_chat{float:left;position:absolute;right:6px;top:-2px;}#t_f_chat a{padding: 4px 7px;color:#fff;font-size:18px;font-family:verdana;text-decoration:none}#t_f_chat a:hover{color: #FFFF00;}#t_f_chat a:hover i{color:#ff0;text-decoration:none}.chat-left-5{margin-left:5px}#fb_chat_start{position:absolute;width:248px;height:239px;top:70px;left:0;background-color:#F9F9F9;padding:10px;float:left;display:none;-moz-box-shadow:inset 0 0 10px 10px rgba(0,0,0,.1);-webkit-box-shadow:inset 0 0 10px 10px rgba(0,0,0,.1);box-shadow:inset 0 0 10px 10px rgba(0,0,0,.1)}#fb_chat_start em{font-size:11px;color:gray}.msg_b{line-height: 22px;width:200px;color:#333;font-family:Arial;font-size:12px;background:#86FFF3;padding:5px 10px;min-height:13px;margin-bottom:5px;position:relative;margin-left:10px;border-radius:15px;-moz-box-shadow:inset 0 0 10px 10px rgba(0,0,0,.1);-webkit-box-shadow:inset 0 0 10px 10px rgba(0,0,0,.1);box-shadow:inset 0 0 10px 10px rgba(0,0,0,.1)}.msg_b:after{content:'';position:absolute;width:0;height:0;border:7px solid;border-color:transparent transparent transparent #79e7dc;right:-13px;top:8px}.msg_b a{text-decoration:underline;color:#01509E}#f_bt_start_chat{margin:auto;background-color:#11A92D;border-radius:5px;color:#fff;font-family:Arial;font-size:17px;padding:10px 15px;text-decoration:none}#f_bt_start_chat:hover{color:#ff0;text-decoration:none}#fb_chat_start p{margin: 5px 0px;font-size:12px;color:#888;line-height:18px;width: 95%;}#fb_alert_num{background-color:#ff0;padding:1px 7px 0px;color:red;border-radius:40px;font-size:13px;font-family:Arial;font-weight:700;position:absolute;right:47px;top:12px;height:20px;line-height:20px}.fb_hide{display:none}</style>");