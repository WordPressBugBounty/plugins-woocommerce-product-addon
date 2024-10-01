/*!
  SerializeJSON jQuery plugin.
  https://github.com/marioizquierdo/jquery.serializeJSON
  version 3.2.1 (Feb, 2021)

  Copyright (c) 2012-2021 Mario Izquierdo
  Dual licensed under the MIT (http://www.opensource.org/licenses/mit-license.php)
  and GPL (http://www.opensource.org/licenses/gpl-license.php) licenses.
*/
!function(e){if("function"==typeof define&&define.amd)define(["jquery"],e);else if("object"==typeof exports){var n=require("jquery");module.exports=e(n)}else e(window.jQuery||window.Zepto||window.$)}(function(e){"use strict";var n=/\r?\n/g,r=/^(?:submit|button|image|reset|file)$/i,t=/^(?:input|select|textarea|keygen)/i,i=/^(?:checkbox|radio)$/i;e.fn.serializeJSON=function(n){var r=e.serializeJSON,t=r.setupOpts(n),i=e.extend({},t.defaultTypes,t.customTypes),a=r.serializeArray(this,t),u={};return e.each(a,function(n,a){var s=a.name,l=e(a.el).attr("data-value-type");if(!l&&!t.disableColonTypes){var o=r.splitType(a.name);s=o[0],l=o[1]}if("skip"!==l){l||(l=t.defaultType);var p=r.applyTypeFunc(a.name,a.value,l,a.el,i);if(p||!r.shouldSkipFalsy(a.name,s,l,a.el,t)){var f=r.splitInputNameIntoKeysArray(s);r.deepSet(u,f,p,t)}}}),u},e.serializeJSON={defaultOptions:{},defaultBaseOptions:{checkboxUncheckedValue:void 0,useIntKeysAsArrayIndex:!1,skipFalsyValuesForTypes:[],skipFalsyValuesForFields:[],disableColonTypes:!1,customTypes:{},defaultTypes:{string:function(e){return String(e)},number:function(e){return Number(e)},boolean:function(e){return-1===["false","null","undefined","","0"].indexOf(e)},null:function(e){return-1===["false","null","undefined","","0"].indexOf(e)?e:null},array:function(e){return JSON.parse(e)},object:function(e){return JSON.parse(e)},skip:null},defaultType:"string"},setupOpts:function(n){null==n&&(n={});var r=e.serializeJSON,t=["checkboxUncheckedValue","useIntKeysAsArrayIndex","skipFalsyValuesForTypes","skipFalsyValuesForFields","disableColonTypes","customTypes","defaultTypes","defaultType"];for(var i in n)if(-1===t.indexOf(i))throw new Error("serializeJSON ERROR: invalid option '"+i+"'. Please use one of "+t.join(", "));return e.extend({},r.defaultBaseOptions,r.defaultOptions,n)},serializeArray:function(a,u){null==u&&(u={});var s=e.serializeJSON;return a.map(function(){var n=e.prop(this,"elements");return n?e.makeArray(n):this}).filter(function(){var n=e(this),a=this.type;return this.name&&!n.is(":disabled")&&t.test(this.nodeName)&&!r.test(a)&&(this.checked||!i.test(a)||null!=s.getCheckboxUncheckedValue(n,u))}).map(function(r,t){var a=e(this),l=a.val(),p=this.type;return null==l?null:(i.test(p)&&!this.checked&&(l=s.getCheckboxUncheckedValue(a,u)),o(l)?e.map(l,function(e){return{name:t.name,value:e.replace(n,"\r\n"),el:t}}):{name:t.name,value:l.replace(n,"\r\n"),el:t})}).get()},getCheckboxUncheckedValue:function(e,n){var r=e.attr("data-unchecked-value");return null==r&&(r=n.checkboxUncheckedValue),r},applyTypeFunc:function(e,n,r,t,i){var u=i[r];if(!u)throw new Error("serializeJSON ERROR: Invalid type "+r+" found in input name '"+e+"', please use one of "+a(i).join(", "));return u(n,t)},splitType:function(e){var n=e.split(":");if(n.length>1){var r=n.pop();return[n.join(":"),r]}return[e,""]},shouldSkipFalsy:function(n,r,t,i,a){var u=e(i).attr("data-skip-falsy");if(null!=u)return"false"!==u;var s=a.skipFalsyValuesForFields;if(s&&(-1!==s.indexOf(r)||-1!==s.indexOf(n)))return!0;var l=a.skipFalsyValuesForTypes;return!(!l||-1===l.indexOf(t))},splitInputNameIntoKeysArray:function(n){var r=n.split("[");return""===(r=e.map(r,function(e){return e.replace(/\]/g,"")}))[0]&&r.shift(),r},deepSet:function(n,r,t,i){null==i&&(i={});var a=e.serializeJSON;if(s(n))throw new Error("ArgumentError: param 'o' expected to be an object or array, found undefined");if(!r||0===r.length)throw new Error("ArgumentError: param 'keys' expected to be an array with least one element");var p=r[0];if(1!==r.length){var f=r[1],c=r.slice(1);if(""===p){var d=n.length-1,y=n[d];p=u(y)&&s(a.deepGet(y,c))?d:d+1}""===f?!s(n[p])&&o(n[p])||(n[p]=[]):i.useIntKeysAsArrayIndex&&l(f)?!s(n[p])&&o(n[p])||(n[p]=[]):!s(n[p])&&u(n[p])||(n[p]={}),a.deepSet(n[p],c,t,i)}else""===p?n.push(t):n[p]=t},deepGet:function(n,r){var t=e.serializeJSON;if(s(n)||s(r)||0===r.length||!u(n)&&!o(n))return n;var i=r[0];if(""!==i){if(1===r.length)return n[i];var a=r.slice(1);return t.deepGet(n[i],a)}}};var a=function(e){if(Object.keys)return Object.keys(e);var n,r=[];for(n in e)r.push(n);return r},u=function(e){return e===Object(e)},s=function(e){return void 0===e},l=function(e){return/^[0-9]+$/.test(String(e))},o=Array.isArray||function(e){return"[object Array]"===Object.prototype.toString.call(e)}});