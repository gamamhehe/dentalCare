<<<<<<< HEAD
﻿/*
 Copyright (c) 2003-2017, CKSource - Frederico Knabben. All rights reserved.
 For licensing, see LICENSE.md or http://ckeditor.com/license
*/
(function(){CKEDITOR.plugins.add("embed",{icons:"embed",hidpi:!0,requires:"embedbase",init:function(b){var c=CKEDITOR.plugins.embedBase.createWidgetBaseDefinition(b);b.config.embed_provider||CKEDITOR.error("embed-no-provider-url");CKEDITOR.tools.extend(c,{dialog:"embedBase",button:b.lang.embedbase.button,allowedContent:"div[!data-oembed-url]",requiredContent:"div[data-oembed-url]",providerUrl:new CKEDITOR.template(b.config.embed_provider||""),styleToAllowedContentRules:function(a){return{div:{propertiesOnly:!0,
=======
﻿/*
 Copyright (c) 2003-2017, CKSource - Frederico Knabben. All rights reserved.
 For licensing, see LICENSE.md or http://ckeditor.com/license
*/
(function(){CKEDITOR.plugins.add("embed",{icons:"embed",hidpi:!0,requires:"embedbase",init:function(b){var c=CKEDITOR.plugins.embedBase.createWidgetBaseDefinition(b);b.config.embed_provider||CKEDITOR.error("embed-no-provider-url");CKEDITOR.tools.extend(c,{dialog:"embedBase",button:b.lang.embedbase.button,allowedContent:"div[!data-oembed-url]",requiredContent:"div[data-oembed-url]",providerUrl:new CKEDITOR.template(b.config.embed_provider||""),styleToAllowedContentRules:function(a){return{div:{propertiesOnly:!0,
>>>>>>> 6647e7f68513f34b86ec6c59d3a99f618da1b2de
classes:a.getClassesArray(),attributes:"!data-oembed-url"}}},upcast:function(a,b){if("div"==a.name&&a.attributes["data-oembed-url"])return b.url=a.attributes["data-oembed-url"],!0},downcast:function(a){a.attributes["data-oembed-url"]=this.data.url}},!0);b.widgets.add("embed",c);b.filter.addElementCallback(function(a){if("data-oembed-url"in a.attributes)return CKEDITOR.FILTER_SKIP_TREE})}})})();