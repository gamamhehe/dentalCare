<<<<<<< HEAD
﻿/*
 Copyright (c) 2003-2015, CKSource - Frederico Knabben. All rights reserved.
 For licensing, see LICENSE.html or http://ckeditor.com/license
*/
CKEDITOR.dialog.add("checkspell",function(a){function c(a,c){var d=0;return function(){"function"==typeof window.doSpell?("undefined"!=typeof e&&window.clearInterval(e),l(a)):180==d++&&window._cancelOnError(c)}}function l(c){var f=new window._SP_FCK_LangCompare,b=CKEDITOR.getUrl(a.plugins.wsc.path+"dialogs/"),e=b+"tmpFrameset.html";window.gFCKPluginName="wsc";f.setDefaulLangCode(a.config.defaultLanguage);window.doSpell({ctrl:g,lang:a.config.wsc_lang||f.getSPLangCode(a.langCode),intLang:a.config.wsc_uiLang||
f.getSPLangCode(a.langCode),winType:d,onCancel:function(){c.hide()},onFinish:function(b){a.focus();c.getParentEditor().setData(b.value);c.hide()},staticFrame:e,framesetPath:e,iframePath:b+"ciframe.html",schemaURI:b+"wsc.css",userDictionaryName:a.config.wsc_userDictionaryName,customDictionaryName:a.config.wsc_customDictionaryIds&&a.config.wsc_customDictionaryIds.split(","),domainName:a.config.wsc_domainName});CKEDITOR.document.getById(h).setStyle("display","none");CKEDITOR.document.getById(d).setStyle("display",
"block")}var b=CKEDITOR.tools.getNextNumber(),d="cke_frame_"+b,g="cke_data_"+b,h="cke_error_"+b,e,b=document.location.protocol||"http:",k=a.lang.wsc.notAvailable,m='\x3ctextarea style\x3d"display: none" id\x3d"'+g+'" rows\x3d"10" cols\x3d"40"\x3e \x3c/textarea\x3e\x3cdiv id\x3d"'+h+'" style\x3d"display:none;color:red;font-size:16px;font-weight:bold;padding-top:160px;text-align:center;z-index:11;"\x3e\x3c/div\x3e\x3ciframe src\x3d"" style\x3d"width:100%;background-color:#f1f1e3;" frameborder\x3d"0" name\x3d"'+
d+'" id\x3d"'+d+'" allowtransparency\x3d"1"\x3e\x3c/iframe\x3e',n=a.config.wsc_customLoaderScript||b+"//loader.webspellchecker.net/sproxy_fck/sproxy.php?plugin\x3dfck2\x26customerid\x3d"+a.config.wsc_customerId+"\x26cmd\x3dscript\x26doc\x3dwsc\x26schema\x3d22";a.config.wsc_customLoaderScript&&(k+='\x3cp style\x3d"color:#000;font-size:11px;font-weight: normal;text-align:center;padding-top:10px"\x3e'+a.lang.wsc.errorLoading.replace(/%s/g,a.config.wsc_customLoaderScript)+"\x3c/p\x3e");window._cancelOnError=
function(c){if("undefined"==typeof window.WSC_Error){CKEDITOR.document.getById(d).setStyle("display","none");var b=CKEDITOR.document.getById(h);b.setStyle("display","block");b.setHtml(c||a.lang.wsc.notAvailable)}};return{title:a.config.wsc_dialogTitle||a.lang.wsc.title,minWidth:485,minHeight:380,buttons:[CKEDITOR.dialog.cancelButton],onShow:function(){var b=this.getContentElement("general","content").getElement();b.setHtml(m);b.getChild(2).setStyle("height",this._.contentSize.height+"px");"function"!=
typeof window.doSpell&&CKEDITOR.document.getHead().append(CKEDITOR.document.createElement("script",{attributes:{type:"text/javascript",src:n}}));b=a.getData();CKEDITOR.document.getById(g).setValue(b);e=window.setInterval(c(this,k),250)},onHide:function(){window.ooo=void 0;window.int_framsetLoaded=void 0;window.framesetLoaded=void 0;window.is_window_opened=!1},contents:[{id:"general",label:a.config.wsc_dialogTitle||a.lang.wsc.title,padding:0,elements:[{type:"html",id:"content",html:""}]}]}});
=======
﻿/*
 Copyright (c) 2003-2015, CKSource - Frederico Knabben. All rights reserved.
 For licensing, see LICENSE.html or http://ckeditor.com/license
*/
CKEDITOR.dialog.add("checkspell",function(a){function c(a,c){var d=0;return function(){"function"==typeof window.doSpell?("undefined"!=typeof e&&window.clearInterval(e),l(a)):180==d++&&window._cancelOnError(c)}}function l(c){var f=new window._SP_FCK_LangCompare,b=CKEDITOR.getUrl(a.plugins.wsc.path+"dialogs/"),e=b+"tmpFrameset.html";window.gFCKPluginName="wsc";f.setDefaulLangCode(a.config.defaultLanguage);window.doSpell({ctrl:g,lang:a.config.wsc_lang||f.getSPLangCode(a.langCode),intLang:a.config.wsc_uiLang||
f.getSPLangCode(a.langCode),winType:d,onCancel:function(){c.hide()},onFinish:function(b){a.focus();c.getParentEditor().setData(b.value);c.hide()},staticFrame:e,framesetPath:e,iframePath:b+"ciframe.html",schemaURI:b+"wsc.css",userDictionaryName:a.config.wsc_userDictionaryName,customDictionaryName:a.config.wsc_customDictionaryIds&&a.config.wsc_customDictionaryIds.split(","),domainName:a.config.wsc_domainName});CKEDITOR.document.getById(h).setStyle("display","none");CKEDITOR.document.getById(d).setStyle("display",
"block")}var b=CKEDITOR.tools.getNextNumber(),d="cke_frame_"+b,g="cke_data_"+b,h="cke_error_"+b,e,b=document.location.protocol||"http:",k=a.lang.wsc.notAvailable,m='\x3ctextarea style\x3d"display: none" id\x3d"'+g+'" rows\x3d"10" cols\x3d"40"\x3e \x3c/textarea\x3e\x3cdiv id\x3d"'+h+'" style\x3d"display:none;color:red;font-size:16px;font-weight:bold;padding-top:160px;text-align:center;z-index:11;"\x3e\x3c/div\x3e\x3ciframe src\x3d"" style\x3d"width:100%;background-color:#f1f1e3;" frameborder\x3d"0" name\x3d"'+
d+'" id\x3d"'+d+'" allowtransparency\x3d"1"\x3e\x3c/iframe\x3e',n=a.config.wsc_customLoaderScript||b+"//loader.webspellchecker.net/sproxy_fck/sproxy.php?plugin\x3dfck2\x26customerid\x3d"+a.config.wsc_customerId+"\x26cmd\x3dscript\x26doc\x3dwsc\x26schema\x3d22";a.config.wsc_customLoaderScript&&(k+='\x3cp style\x3d"color:#000;font-size:11px;font-weight: normal;text-align:center;padding-top:10px"\x3e'+a.lang.wsc.errorLoading.replace(/%s/g,a.config.wsc_customLoaderScript)+"\x3c/p\x3e");window._cancelOnError=
function(c){if("undefined"==typeof window.WSC_Error){CKEDITOR.document.getById(d).setStyle("display","none");var b=CKEDITOR.document.getById(h);b.setStyle("display","block");b.setHtml(c||a.lang.wsc.notAvailable)}};return{title:a.config.wsc_dialogTitle||a.lang.wsc.title,minWidth:485,minHeight:380,buttons:[CKEDITOR.dialog.cancelButton],onShow:function(){var b=this.getContentElement("general","content").getElement();b.setHtml(m);b.getChild(2).setStyle("height",this._.contentSize.height+"px");"function"!=
typeof window.doSpell&&CKEDITOR.document.getHead().append(CKEDITOR.document.createElement("script",{attributes:{type:"text/javascript",src:n}}));b=a.getData();CKEDITOR.document.getById(g).setValue(b);e=window.setInterval(c(this,k),250)},onHide:function(){window.ooo=void 0;window.int_framsetLoaded=void 0;window.framesetLoaded=void 0;window.is_window_opened=!1},contents:[{id:"general",label:a.config.wsc_dialogTitle||a.lang.wsc.title,padding:0,elements:[{type:"html",id:"content",html:""}]}]}});
>>>>>>> 6647e7f68513f34b86ec6c59d3a99f618da1b2de
CKEDITOR.dialog.on("resize",function(a){a=a.data;var c=a.dialog;"checkspell"==c._.name&&((c=(c=c.getContentElement("general","content").getElement())&&c.getChild(2))&&c.setSize("height",a.height),c&&c.setSize("width",a.width))});