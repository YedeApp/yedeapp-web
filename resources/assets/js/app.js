
/**
 * First, we will load all of this project's Javascript utilities and other
 * dependencies. Then, we will be ready to develop a robust and powerful
 * application frontend using useful Laravel and JavaScript libraries.
 */

require('./bootstrap');

window.HtmlUtil = {
  // 用正则表达式转码 html
  htmlEncodeByRegExp: function(str) {
    var s = "";

    if (str.length == 0) return "";

    s = str.replace(/&/g,"&amp;");
    s = s.replace(/</g,"&lt;");
    s = s.replace(/>/g,"&gt;");
    s = s.replace(/ /g,"&nbsp;");
    s = s.replace(/\'/g,"&#39;");
    s = s.replace(/\"/g,"&quot;");

    return s;
  },

  // 用正则表达式解码 html
  htmlDecodeByRegExp: function(str) {
      var s = "";

      if (str.length == 0) return "";

      s = str.replace(/&amp;/g,"&");
      s = s.replace(/&lt;/g,"<");
      s = s.replace(/&gt;/g,">");
      s = s.replace(/&nbsp;/g," ");
      s = s.replace(/&#39;/g,"\'");
      s = s.replace(/&quot;/g,"\"");

      return s;
  }
};
