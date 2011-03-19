// $Id: comment_info.js,v 1.1.2.2 2007/03/20 23:33:38 mfer Exp $

Drupal.comment_info = {};

Drupal.comment_info.cookie = function(name, value, options) {
  if (typeof value != 'undefined') { // name and value given, set cookie
    options = options || {};
    var expires = '';
    if (options.expires && (typeof options.expires == 'number' || options.expires.toGMTString)) {
      var date;
      if (typeof options.expires == 'number') {
        date = new Date();
        date.setTime(date.getTime() + (options.expires * 24 * 60 * 60 * 1000));
      } else {
        date = options.expires;
      }
      expires = '; expires=' + date.toGMTString(); // use expires attribute, max-age is not supported by IE
    }
    var path = options.path ? '; path=' + options.path : '';
    var domain = options.domain ? '; domain=' + options.domain : '';
    var secure = options.secure ? '; secure' : '';
    document.cookie = [name, '=', encodeURIComponent(value), expires, path, domain, secure].join('');
  } else { // only name given, get cookie
    var cookieValue = null;
    if (document.cookie && document.cookie != '') {
      var cookies = document.cookie.split(';');
      for (var i = 0; i < cookies.length; i++) {
        var cookie = jQuery.trim(cookies[i]);
        // Does this cookie string begin with the name we want?
        if (cookie.substring(0, name.length + 1) == (name + '=')) {
          cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
          break;
        }
      }
    }
    return cookieValue;
  }
};

Drupal.comment_info.autoAttach = function() { 
  var comment_info_x = false;
  $("#comment-form input[@name=optin]").show();
  var comment_info_option = Drupal.comment_info.cookie('comment_info_option');
  if (comment_info_option=='true') {
  	$("#comment-form input[@name=name]").val(Drupal.comment_info.cookie('comment_info_name'));
  	$("#comment-form input[@name=mail]").val(Drupal.comment_info.cookie('comment_info_email'));
  	$("#comment-form input[@name=homepage]").val(Drupal.comment_info.cookie('comment_info_homepage'));
  	$("#comment-form input[@name=optin]").each( function() {
        this.checked = true;
    });
  }
  $("form#comment-form input[@type=submit]").each( function() {
    $(this).click(function() {
      $("#comment-form input[@name=optin]").each( function() {
        comment_info_x = this.checked;
      });
      if(comment_info_x) {
        Drupal.comment_info.cookie('comment_info_option', 'true', { expires: 120 });
        Drupal.comment_info.cookie('comment_info_name', $("#comment-form input[@name=name]").val(), { expires: 120 });
        Drupal.comment_info.cookie('comment_info_email', $("#comment-form input[@name=mail]").val(), { expires: 120 });
        Drupal.comment_info.cookie('comment_info_homepage', $("#comment-form input[@name=homepage]").val(), { expires: 120 });
      }
      else {
        Drupal.comment_info.cookie('comment_info_option', 'false', { expires: -1 });
        Drupal.comment_info.cookie('comment_info_name', '', { expires: -1 });
        Drupal.comment_info.cookie('comment_info_email', '', { expires: -1 });
        Drupal.comment_info.cookie('comment_info_homepage', '', { expires: -1 });
      }
    });
  });
};

if (Drupal.jsEnabled) {
  $(document).ready(Drupal.comment_info.autoAttach);
}