!function(e,t){"use strict";"object"!=typeof module||"object"!=typeof module.exports?t(e):module.exports=e.document?t(e):function(e){if(!e.document)throw new Error("jscolor needs a window with document");return t(e)}}("undefined"!=typeof window?window:this,function(e){"use strict";var t,r,n,i=((n={initialized:!1,instances:[],triggerQueue:[],register:function(){void 0!==e&&e.document&&e.document.addEventListener("DOMContentLoaded",n.pub.init,!1)},installBySelector:function(t,r){if(!(r=r?n.node(r):e.document))throw new Error("Missing root node");for(var i=r.querySelectorAll(t),o=new RegExp("(^|\\s)("+n.pub.lookupClass+")(\\s*(\\{[^}]*\\})|\\s|$)","i"),a=0;a<i.length;a+=1){var s,l;if(!(i[a].jscolor&&i[a].jscolor instanceof n.pub))if(void 0===i[a].type||"color"!=i[a].type.toLowerCase()||!n.isColorAttrSupported)if(null!==(s=n.getDataAttr(i[a],"jscolor"))||i[a].className&&(l=i[a].className.match(o))){var d=i[a],h="";null!==s?h=s:l&&(console.warn('Installation using class name is DEPRECATED. Use data-jscolor="" attribute instead.'+n.docsRef),l[4]&&(h=l[4]));var c=null;if(h.trim())try{c=n.parseOptionsStr(h)}catch(e){console.warn(e+"\n"+h)}try{new n.pub(d,c)}catch(e){console.warn(e)}}}},parseOptionsStr:function(e){var t=null;try{t=JSON.parse(e)}catch(r){if(!n.pub.looseJSON)throw new Error("Could not parse jscolor options as JSON: "+r);try{t=new Function("var opts = ("+e+'); return typeof opts === "object" ? opts : {};')()}catch(e){throw new Error("Could not evaluate jscolor options: "+e)}}return t},getInstances:function(){for(var e=[],t=0;t<n.instances.length;t+=1)n.instances[t]&&n.instances[t].targetElement&&e.push(n.instances[t]);return e},createEl:function(t){var r=e.document.createElement(t);return n.setData(r,"gui",!0),r},node:function(t){if(!t)return null;if("string"==typeof t){var r=t,i=null;try{i=e.document.querySelector(r)}catch(e){return console.warn(e),null}return i||console.warn("No element matches the selector: %s",r),i}return n.isNode(t)?t:(console.warn("Invalid node of type %s: %s",typeof t,t),null)},isNode:function(e){return"object"==typeof Node?e instanceof Node:e&&"object"==typeof e&&"number"==typeof e.nodeType&&"string"==typeof e.nodeName},nodeName:function(e){return!(!e||!e.nodeName)&&e.nodeName.toLowerCase()},removeChildren:function(e){for(;e.firstChild;)e.removeChild(e.firstChild)},isTextInput:function(e){return e&&"input"===n.nodeName(e)&&"text"===e.type.toLowerCase()},isButton:function(e){if(!e)return!1;var t=n.nodeName(e);return"button"===t||"input"===t&&["button","submit","reset"].indexOf(e.type.toLowerCase())>-1},isButtonEmpty:function(e){switch(n.nodeName(e)){case"input":return!e.value||""===e.value.trim();case"button":return""===e.textContent.trim()}return null},isPassiveEventSupported:function(){var t=!1;try{var r=Object.defineProperty({},"passive",{get:function(){t=!0}});e.addEventListener("testPassive",null,r),e.removeEventListener("testPassive",null,r)}catch(e){}return t}(),isColorAttrSupported:(r=e.document.createElement("input"),!(!r.setAttribute||(r.setAttribute("type","color"),"color"!=r.type.toLowerCase()))),dataProp:"_data_jscolor",setData:function(){var e=arguments[0];if(3===arguments.length){var t=e.hasOwnProperty(n.dataProp)?e[n.dataProp]:e[n.dataProp]={},r=arguments[1],i=arguments[2];return t[r]=i,!0}if(2===arguments.length&&"object"==typeof arguments[1]){t=e.hasOwnProperty(n.dataProp)?e[n.dataProp]:e[n.dataProp]={};var o=arguments[1];for(var r in o)o.hasOwnProperty(r)&&(t[r]=o[r]);return!0}throw new Error("Invalid arguments")},removeData:function(){var e=arguments[0];if(!e.hasOwnProperty(n.dataProp))return!0;for(var t=1;t<arguments.length;t+=1){var r=arguments[t];delete e[n.dataProp][r]}return!0},getData:function(e,t,r){if(!e.hasOwnProperty(n.dataProp)){if(void 0===r)return;e[n.dataProp]={}}var i=e[n.dataProp];return i.hasOwnProperty(t)||void 0===r||(i[t]=r),i[t]},getDataAttr:function(e,t){var r="data-"+t;return e.getAttribute(r)},_attachedGroupEvents:{},attachGroupEvent:function(e,t,r,i){n._attachedGroupEvents.hasOwnProperty(e)||(n._attachedGroupEvents[e]=[]),n._attachedGroupEvents[e].push([t,r,i]),t.addEventListener(r,i,!1)},detachGroupEvents:function(e){if(n._attachedGroupEvents.hasOwnProperty(e)){for(var t=0;t<n._attachedGroupEvents[e].length;t+=1){var r=n._attachedGroupEvents[e][t];r[0].removeEventListener(r[1],r[2],!1)}delete n._attachedGroupEvents[e]}},preventDefault:function(e){e.preventDefault&&e.preventDefault(),e.returnValue=!1},captureTarget:function(e){e.setCapture&&(n._capturedTarget=e,n._capturedTarget.setCapture())},releaseTarget:function(){n._capturedTarget&&(n._capturedTarget.releaseCapture(),n._capturedTarget=null)},triggerEvent:function(t,r,i,o){if(t){var a=null;return"function"==typeof Event?a=new Event(r,{bubbles:i,cancelable:o}):(a=e.document.createEvent("Event")).initEvent(r,i,o),a?(n.setData(a,"internal",!0),t.dispatchEvent(a),!0):!1}},triggerInputEvent:function(e,t,r,i){e&&n.isTextInput(e)&&n.triggerEvent(e,t,r,i)},eventKey:function(e){var t={9:"Tab",13:"Enter",27:"Escape"};return"string"==typeof e.code?e.code:void 0!==e.keyCode&&t.hasOwnProperty(e.keyCode)?t[e.keyCode]:null},strList:function(e){return e?e.replace(/^\s+|\s+$/g,"").split(/\s+/):[]},hasClass:function(e,t){return!!t&&(void 0!==e.classList?e.classList.contains(t):-1!=(" "+e.className.replace(/\s+/g," ")+" ").indexOf(" "+t+" "))},addClass:function(e,t){var r=n.strList(t);if(void 0===e.classList)for(i=0;i<r.length;i+=1)n.hasClass(e,r[i])||(e.className+=(e.className?" ":"")+r[i]);else for(var i=0;i<r.length;i+=1)e.classList.add(r[i])},removeClass:function(e,t){var r=n.strList(t);if(void 0===e.classList)for(o=0;o<r.length;o+=1){var i=new RegExp("^\\s*"+r[o]+"\\s*|\\s*"+r[o]+"\\s*$|\\s+"+r[o]+"(\\s+)","g");e.className=e.className.replace(i,"$1")}else for(var o=0;o<r.length;o+=1)e.classList.remove(r[o])},getCompStyle:function(t){var r=e.getComputedStyle?e.getComputedStyle(t):t.currentStyle;return r||{}},setStyle:function(e,t,r,i){var o=r?"important":"",a=null;for(var s in t)if(t.hasOwnProperty(s)){var l=null;null===t[s]?(a||(a=n.getData(e,"origStyle")),a&&a.hasOwnProperty(s)&&(l=a[s])):(i&&(a||(a=n.getData(e,"origStyle",{})),a.hasOwnProperty(s)||(a[s]=e.style[s])),l=t[s]),null!==l&&e.style.setProperty(s,l,o)}},linearGradient:function(){var t=function(){for(var t=["","-webkit-","-moz-","-o-","-ms-"],r=e.document.createElement("div"),n=0;n<t.length;n+=1){var i=t[n]+"linear-gradient",o=i+"(to right, rgba(0,0,0,0), rgba(0,0,0,0))";if(r.style.background=o,r.style.background)return i}return"linear-gradient"}();return function(){return t+"("+Array.prototype.join.call(arguments,", ")+")"}}(),setBorderRadius:function(e,t){n.setStyle(e,{"border-radius":t||"0"})},setBoxShadow:function(e,t){n.setStyle(e,{"box-shadow":t||"none"})},getElementPos:function(e,t){var r=0,i=0,o=e.getBoundingClientRect();if(r=o.left,i=o.top,!t){var a=n.getViewPos();r+=a[0],i+=a[1]}return[r,i]},getElementSize:function(e){return[e.offsetWidth,e.offsetHeight]},getAbsPointerPos:function(e){var t=0,r=0;return void 0!==e.changedTouches&&e.changedTouches.length?(t=e.changedTouches[0].clientX,r=e.changedTouches[0].clientY):"number"==typeof e.clientX&&(t=e.clientX,r=e.clientY),{x:t,y:r}},getRelPointerPos:function(e){var t=(e.target||e.srcElement).getBoundingClientRect(),r=0,n=0;return void 0!==e.changedTouches&&e.changedTouches.length?(r=e.changedTouches[0].clientX,n=e.changedTouches[0].clientY):"number"==typeof e.clientX&&(r=e.clientX,n=e.clientY),{x:r-t.left,y:n-t.top}},getViewPos:function(){var t=e.document.documentElement;return[(e.pageXOffset||t.scrollLeft)-(t.clientLeft||0),(e.pageYOffset||t.scrollTop)-(t.clientTop||0)]},getViewSize:function(){var t=e.document.documentElement;return[e.innerWidth||t.clientWidth,e.innerHeight||t.clientHeight]},RGB_HSV:function(e,t,r){e/=255,t/=255,r/=255;var n=Math.min(Math.min(e,t),r),i=Math.max(Math.max(e,t),r),o=i-n;if(0===o)return[null,0,100*i];var a=e===n?3+(r-t)/o:t===n?5+(e-r)/o:1+(t-e)/o;return[60*(6===a?0:a),o/i*100,100*i]},HSV_RGB:function(e,t,r){var n=r/100*255;if(null===e)return[n,n,n];e/=60,t/=100;var i=Math.floor(e),o=n*(1-t),a=n*(1-t*(i%2?e-i:1-(e-i)));switch(i){case 6:case 0:return[n,a,o];case 1:return[a,n,o];case 2:return[o,n,a];case 3:return[o,a,n];case 4:return[a,o,n];case 5:return[n,o,a]}},parseColorString:function(e){var t,r={rgba:null,format:null};if(t=e.match(/^\W*([0-9A-F]{3}([0-9A-F]{3})?)\W*$/i))return r.format="hex",6===t[1].length?r.rgba=[parseInt(t[1].substr(0,2),16),parseInt(t[1].substr(2,2),16),parseInt(t[1].substr(4,2),16),null]:r.rgba=[parseInt(t[1].charAt(0)+t[1].charAt(0),16),parseInt(t[1].charAt(1)+t[1].charAt(1),16),parseInt(t[1].charAt(2)+t[1].charAt(2),16),null],r;if(t=e.match(/^\W*rgba?\(([^)]*)\)\W*$/i)){var n,i,o,a,s=t[1].split(","),l=/^\s*(\d+|\d*\.\d+|\d+\.\d*)\s*$/;if(s.length>=3&&(n=s[0].match(l))&&(i=s[1].match(l))&&(o=s[2].match(l)))return r.format="rgb",r.rgba=[parseFloat(n[1])||0,parseFloat(i[1])||0,parseFloat(o[1])||0,null],s.length>=4&&(a=s[3].match(l))&&(r.format="rgba",r.rgba[3]=parseFloat(a[1])||0),r}return!1},scaleCanvasForHighDPR:function(t){var r=e.devicePixelRatio||1;t.width*=r,t.height*=r,t.getContext("2d").scale(r,r)},genColorPreviewCanvas:function(e,t,r,i){var o=Math.round(n.pub.previewSeparator.length),a=n.pub.chessboardSize,s=n.pub.chessboardColor1,l=n.pub.chessboardColor2,d=r||2*a,h=2*a,c=n.createEl("canvas"),p=c.getContext("2d");c.width=d,c.height=h,i&&n.scaleCanvasForHighDPR(c),p.fillStyle=s,p.fillRect(0,0,d,h),p.fillStyle=l;for(var u=0;u<d;u+=2*a)p.fillRect(u,0,a,a),p.fillRect(u+a,a,a,a);e&&(p.fillStyle=e,p.fillRect(0,0,d,h));var g=null;switch(t){case"left":g=0,p.clearRect(0,0,o/2,h);break;case"right":g=d-o,p.clearRect(d-o/2,0,o/2,h)}if(null!==g){p.lineWidth=1;for(var f=0;f<n.pub.previewSeparator.length;f+=1)p.beginPath(),p.strokeStyle=n.pub.previewSeparator[f],p.moveTo(.5+g+f,0),p.lineTo(.5+g+f,h),p.stroke()}return{canvas:c,width:d,height:h}},genColorPreviewGradient:function(e,t,r){var i=[];return i=t&&r?["to "+{left:"right",right:"left"}[t],e+" 0%",e+" "+r+"px","rgba(0,0,0,0) "+(r+1)+"px","rgba(0,0,0,0) 100%"]:["to right",e+" 0%",e+" 100%"],n.linearGradient.apply(this,i)},redrawPosition:function(){if(n.picker&&n.picker.owner){var e,t,r=n.picker.owner;r.fixed?(e=n.getElementPos(r.targetElement,!0),t=[0,0]):(e=n.getElementPos(r.targetElement),t=n.getViewPos());var i,o,a,s=n.getElementSize(r.targetElement),l=n.getViewSize(),d=n.getPickerOuterDims(r);switch(r.position.toLowerCase()){case"left":i=1,o=0,a=-1;break;case"right":i=1,o=0,a=1;break;case"top":i=0,o=1,a=-1;break;default:i=0,o=1,a=1}var h=(s[o]+d[o])/2;if(r.smartPosition)c=[-t[i]+e[i]+d[i]>l[i]&&-t[i]+e[i]+s[i]/2>l[i]/2&&e[i]+s[i]-d[i]>=0?e[i]+s[i]-d[i]:e[i],-t[o]+e[o]+s[o]+d[o]-h+h*a>l[o]?-t[o]+e[o]+s[o]/2>l[o]/2&&e[o]+s[o]-h-h*a>=0?e[o]+s[o]-h-h*a:e[o]+s[o]-h+h*a:e[o]+s[o]-h+h*a>=0?e[o]+s[o]-h+h*a:e[o]+s[o]-h-h*a];else var c=[e[i],e[o]+s[o]-h+h*a];var p=c[i],u=c[o],g=r.fixed?"fixed":"absolute",f=(c[0]+d[0]>e[0]||c[0]<e[0]+s[0])&&c[1]+d[1]<e[1]+s[1];n._drawPosition(r,p,u,g,f)}},_drawPosition:function(e,t,r,i,o){var a=o?0:e.shadowBlur;n.picker.wrap.style.position=i,n.picker.wrap.style.left=t+"px",n.picker.wrap.style.top=r+"px",n.setBoxShadow(n.picker.boxS,e.shadow?new n.BoxShadow(0,a,e.shadowBlur,0,e.shadowColor):null)},getPickerDims:function(e){var t=[2*e.controlBorderWidth+2*e.padding+e.width,2*e.controlBorderWidth+2*e.padding+e.height],r=2*e.controlBorderWidth+2*n.getControlPadding(e)+e.sliderSize;return n.getSliderChannel(e)&&(t[0]+=r),e.hasAlphaChannel()&&(t[0]+=r),e.closeButton&&(t[1]+=2*e.controlBorderWidth+e.padding+e.buttonHeight),t},getPickerOuterDims:function(e){var t=n.getPickerDims(e);return[t[0]+2*e.borderWidth,t[1]+2*e.borderWidth]},getControlPadding:function(e){return Math.max(e.padding/2,2*e.pointerBorderWidth+e.pointerThickness-e.controlBorderWidth)},getPadYChannel:function(e){switch(e.mode.charAt(1).toLowerCase()){case"v":return"v"}return"s"},getSliderChannel:function(e){if(e.mode.length>2)switch(e.mode.charAt(2).toLowerCase()){case"s":return"s";case"v":return"v"}return null},onDocumentMouseDown:function(e){var t=e.target||e.srcElement;if(t.jscolor&&t.jscolor instanceof n.pub)t.jscolor.showOnClick&&!t.disabled&&t.jscolor.show();else if(n.getData(t,"gui")){n.getData(t,"control")&&n.onControlPointerStart(e,t,n.getData(t,"control"),"mouse")}else n.picker&&n.picker.owner&&n.picker.owner.tryHide()},onDocumentKeyUp:function(e){-1!==["Tab","Escape"].indexOf(n.eventKey(e))&&n.picker&&n.picker.owner&&n.picker.owner.tryHide()},onWindowResize:function(e){n.redrawPosition()},onParentScroll:function(e){n.picker&&n.picker.owner&&n.picker.owner.tryHide()},onPickerTouchStart:function(e){var t=e.target||e.srcElement;n.getData(t,"control")&&n.onControlPointerStart(e,t,n.getData(t,"control"),"touch")},triggerCallback:function(e,t){if(e[t]){var r=null;if("string"==typeof e[t])try{r=new Function(e[t])}catch(e){console.error(e)}else r=e[t];r&&r.call(e)}},triggerGlobal:function(e){for(var t=n.getInstances(),r=0;r<t.length;r+=1)t[r].trigger(e)},_pointerMoveEvent:{mouse:"mousemove",touch:"touchmove"},_pointerEndEvent:{mouse:"mouseup",touch:"touchend"},_pointerOrigin:null,_capturedTarget:null,onControlPointerStart:function(t,r,i,o){var a=n.getData(r,"instance");n.preventDefault(t),n.captureTarget(r);var s=function(e,a){n.attachGroupEvent("drag",e,n._pointerMoveEvent[o],n.onDocumentPointerMove(t,r,i,o,a)),n.attachGroupEvent("drag",e,n._pointerEndEvent[o],n.onDocumentPointerEnd(t,r,i,o))};if(s(e.document,[0,0]),e.parent&&e.frameElement){var l=e.frameElement.getBoundingClientRect(),d=[-l.left,-l.top];s(e.parent.window.document,d)}var h=n.getAbsPointerPos(t),c=n.getRelPointerPos(t);switch(n._pointerOrigin={x:h.x-c.x,y:h.y-c.y},i){case"pad":"v"===n.getSliderChannel(a)&&0===a.channels.v&&a.fromHSVA(null,null,100,null),n.setPad(a,t,0,0);break;case"sld":n.setSld(a,t,0);break;case"asld":n.setASld(a,t,0)}a.trigger("input")},onDocumentPointerMove:function(e,t,r,i,o){return function(e){var i=n.getData(t,"instance");switch(r){case"pad":n.setPad(i,e,o[0],o[1]);break;case"sld":n.setSld(i,e,o[1]);break;case"asld":n.setASld(i,e,o[1])}i.trigger("input")}},onDocumentPointerEnd:function(e,t,r,i){return function(e){var r=n.getData(t,"instance");n.detachGroupEvents("drag"),n.releaseTarget(),r.trigger("input"),r.trigger("change")}},setPad:function(e,t,r,i){var o=n.getAbsPointerPos(t),a=r+o.x-n._pointerOrigin.x-e.padding-e.controlBorderWidth,s=i+o.y-n._pointerOrigin.y-e.padding-e.controlBorderWidth,l=a*(360/(e.width-1)),d=100-s*(100/(e.height-1));switch(n.getPadYChannel(e)){case"s":e.fromHSVA(l,d,null,null);break;case"v":e.fromHSVA(l,null,d,null)}},setSld:function(e,t,r){var i=100-(r+n.getAbsPointerPos(t).y-n._pointerOrigin.y-e.padding-e.controlBorderWidth)*(100/(e.height-1));switch(n.getSliderChannel(e)){case"s":e.fromHSVA(null,i,null,null);break;case"v":e.fromHSVA(null,null,i,null)}},setASld:function(e,t,r){var i=1-(r+n.getAbsPointerPos(t).y-n._pointerOrigin.y-e.padding-e.controlBorderWidth)*(1/(e.height-1));i<1&&"any"===e.format.toLowerCase()&&"rgba"!==e.getFormat()&&(e._currentFormat="rgba"),e.fromHSVA(null,null,null,i)},createPalette:function(){var e={elm:null,draw:null},t=n.createEl("canvas"),r=t.getContext("2d");return e.elm=t,e.draw=function(e,n,i){t.width=e,t.height=n,r.clearRect(0,0,t.width,t.height);var o=r.createLinearGradient(0,0,t.width,0);o.addColorStop(0,"#F00"),o.addColorStop(1/6,"#FF0"),o.addColorStop(2/6,"#0F0"),o.addColorStop(.5,"#0FF"),o.addColorStop(4/6,"#00F"),o.addColorStop(5/6,"#F0F"),o.addColorStop(1,"#F00"),r.fillStyle=o,r.fillRect(0,0,t.width,t.height);var a=r.createLinearGradient(0,0,0,t.height);switch(i.toLowerCase()){case"s":a.addColorStop(0,"rgba(255,255,255,0)"),a.addColorStop(1,"rgba(255,255,255,1)");break;case"v":a.addColorStop(0,"rgba(0,0,0,0)"),a.addColorStop(1,"rgba(0,0,0,1)")}r.fillStyle=a,r.fillRect(0,0,t.width,t.height)},e},createSliderGradient:function(){var e={elm:null,draw:null},t=n.createEl("canvas"),r=t.getContext("2d");return e.elm=t,e.draw=function(e,n,i,o){t.width=e,t.height=n,r.clearRect(0,0,t.width,t.height);var a=r.createLinearGradient(0,0,0,t.height);a.addColorStop(0,i),a.addColorStop(1,o),r.fillStyle=a,r.fillRect(0,0,t.width,t.height)},e},createASliderGradient:function(){var e={elm:null,draw:null},t=n.createEl("canvas"),r=t.getContext("2d");return e.elm=t,e.draw=function(e,i,o){t.width=e,t.height=i,r.clearRect(0,0,t.width,t.height);var a=t.width/2,s=n.pub.chessboardColor1,l=n.pub.chessboardColor2;r.fillStyle=s,r.fillRect(0,0,t.width,t.height);for(var d=0;d<t.height;d+=2*a)r.fillStyle=l,r.fillRect(0,d,a,a),r.fillRect(a,d+a,a,a);var h=r.createLinearGradient(0,0,0,t.height);h.addColorStop(0,o),h.addColorStop(1,"rgba(0,0,0,0)"),r.fillStyle=h,r.fillRect(0,0,t.width,t.height)},e},BoxShadow:(t=function(e,t,r,n,i,o){this.hShadow=e,this.vShadow=t,this.blur=r,this.spread=n,this.color=i,this.inset=!!o},t.prototype.toString=function(){var e=[Math.round(this.hShadow)+"px",Math.round(this.vShadow)+"px",Math.round(this.blur)+"px",Math.round(this.spread)+"px",this.color];return this.inset&&e.push("inset"),e.join(" ")},t),flags:{leaveValue:1,leaveAlpha:2,leavePreview:4},enumOpts:{format:["auto","any","hex","rgb","rgba"],previewPosition:["left","right"],mode:["hsv","hvs","hs","hv"],position:["left","right","top","bottom"],alphaChannel:["auto",!0,!1]},deprecatedOpts:{styleElement:"previewElement",onFineChange:"onInput",overwriteImportant:"forceStyle",closable:"closeButton",insetWidth:"controlBorderWidth",insetColor:"controlBorderColor",refine:null},docsRef:" See https://jscolor.com/docs/",pub:function(t,r){var i=this;if(r||(r={}),this.channels={r:255,g:255,b:255,h:0,s:0,v:100,a:1},this.format="auto",this.value=void 0,this.alpha=void 0,this.onChange=void 0,this.onInput=void 0,this.valueElement=void 0,this.alphaElement=void 0,this.previewElement=void 0,this.previewPosition="left",this.previewSize=32,this.previewPadding=8,this.required=!0,this.hash=!0,this.uppercase=!0,this.forceStyle=!0,this.width=181,this.height=101,this.mode="HSV",this.alphaChannel="auto",this.position="bottom",this.smartPosition=!0,this.showOnClick=!0,this.hideOnLeave=!0,this.sliderSize=16,this.crossSize=8,this.closeButton=!1,this.closeText="Close",this.buttonColor="rgba(0,0,0,1)",this.buttonHeight=18,this.padding=12,this.backgroundColor="rgba(255,255,255,1)",this.borderWidth=1,this.borderColor="rgba(187,187,187,1)",this.borderRadius=8,this.controlBorderWidth=1,this.controlBorderColor="rgba(187,187,187,1)",this.shadow=!0,this.shadowBlur=15,this.shadowColor="rgba(0,0,0,0.2)",this.pointerColor="rgba(76,76,76,1)",this.pointerBorderWidth=1,this.pointerBorderColor="rgba(255,255,255,1)",this.pointerThickness=2,this.zIndex=5e3,this.container=void 0,this.minS=0,this.maxS=100,this.minV=0,this.maxV=100,this.minA=0,this.maxA=1,n.pub.options)for(var o in n.pub.options)if(n.pub.options.hasOwnProperty(o))try{h(o,n.pub.options[o])}catch(e){console.warn(e)}var a=[];r.preset&&("string"==typeof r.preset?a=r.preset.split(/\s+/):Array.isArray(r.preset)?a=r.preset.slice():console.warn("Unrecognized preset value")),-1===a.indexOf("default")&&a.push("default");for(var s=a.length-1;s>=0;s-=1){var l=a[s];if(l)if(n.pub.presets.hasOwnProperty(l)){for(var o in n.pub.presets[l])if(n.pub.presets[l].hasOwnProperty(o))try{h(o,n.pub.presets[l][o])}catch(e){console.warn(e)}}else console.warn("Unknown preset: %s",l)}var d=["preset"];for(var o in r)if(r.hasOwnProperty(o)&&-1===d.indexOf(o))try{h(o,r[o])}catch(e){console.warn(e)}function h(e,t){if("string"!=typeof e)throw new Error("Invalid value for option name: "+e);if(n.enumOpts.hasOwnProperty(e)&&("string"==typeof t&&(t=t.toLowerCase()),-1===n.enumOpts[e].indexOf(t)))throw new Error("Option '"+e+"' has invalid value: "+t);if(n.deprecatedOpts.hasOwnProperty(e)){var r=e,o=n.deprecatedOpts[e];if(!o)throw new Error("Option '"+e+"' is DEPRECATED");console.warn("Option '%s' is DEPRECATED, using '%s' instead."+n.docsRef,r,o),e=o}if(!(e in i))throw new Error("Unrecognized configuration option: "+e);return i[e]=t,!0}function c(){i._processParentElementsInDOM(),n.picker||(n.picker={owner:null,wrap:n.createEl("div"),box:n.createEl("div"),boxS:n.createEl("div"),boxB:n.createEl("div"),pad:n.createEl("div"),padB:n.createEl("div"),padM:n.createEl("div"),padPal:n.createPalette(),cross:n.createEl("div"),crossBY:n.createEl("div"),crossBX:n.createEl("div"),crossLY:n.createEl("div"),crossLX:n.createEl("div"),sld:n.createEl("div"),sldB:n.createEl("div"),sldM:n.createEl("div"),sldGrad:n.createSliderGradient(),sldPtrS:n.createEl("div"),sldPtrIB:n.createEl("div"),sldPtrMB:n.createEl("div"),sldPtrOB:n.createEl("div"),asld:n.createEl("div"),asldB:n.createEl("div"),asldM:n.createEl("div"),asldGrad:n.createASliderGradient(),asldPtrS:n.createEl("div"),asldPtrIB:n.createEl("div"),asldPtrMB:n.createEl("div"),asldPtrOB:n.createEl("div"),btn:n.createEl("div"),btnT:n.createEl("span")},n.picker.pad.appendChild(n.picker.padPal.elm),n.picker.padB.appendChild(n.picker.pad),n.picker.cross.appendChild(n.picker.crossBY),n.picker.cross.appendChild(n.picker.crossBX),n.picker.cross.appendChild(n.picker.crossLY),n.picker.cross.appendChild(n.picker.crossLX),n.picker.padB.appendChild(n.picker.cross),n.picker.box.appendChild(n.picker.padB),n.picker.box.appendChild(n.picker.padM),n.picker.sld.appendChild(n.picker.sldGrad.elm),n.picker.sldB.appendChild(n.picker.sld),n.picker.sldB.appendChild(n.picker.sldPtrOB),n.picker.sldPtrOB.appendChild(n.picker.sldPtrMB),n.picker.sldPtrMB.appendChild(n.picker.sldPtrIB),n.picker.sldPtrIB.appendChild(n.picker.sldPtrS),n.picker.box.appendChild(n.picker.sldB),n.picker.box.appendChild(n.picker.sldM),n.picker.asld.appendChild(n.picker.asldGrad.elm),n.picker.asldB.appendChild(n.picker.asld),n.picker.asldB.appendChild(n.picker.asldPtrOB),n.picker.asldPtrOB.appendChild(n.picker.asldPtrMB),n.picker.asldPtrMB.appendChild(n.picker.asldPtrIB),n.picker.asldPtrIB.appendChild(n.picker.asldPtrS),n.picker.box.appendChild(n.picker.asldB),n.picker.box.appendChild(n.picker.asldM),n.picker.btn.appendChild(n.picker.btnT),n.picker.box.appendChild(n.picker.btn),n.picker.boxB.appendChild(n.picker.box),n.picker.wrap.appendChild(n.picker.boxS),n.picker.wrap.appendChild(n.picker.boxB),n.picker.wrap.addEventListener("touchstart",n.onPickerTouchStart,!!n.isPassiveEventSupported&&{passive:!1}));var t=n.picker,r=!!n.getSliderChannel(i),o=i.hasAlphaChannel(),a=n.getPickerDims(i),s=2*i.pointerBorderWidth+i.pointerThickness+2*i.crossSize,l=n.getControlPadding(i),d=Math.min(i.borderRadius,Math.round(i.padding*Math.PI));t.wrap.className="jscolor-picker-wrap",t.wrap.style.clear="both",t.wrap.style.width=a[0]+2*i.borderWidth+"px",t.wrap.style.height=a[1]+2*i.borderWidth+"px",t.wrap.style.zIndex=i.zIndex,t.box.className="jscolor-picker",t.box.style.width=a[0]+"px",t.box.style.height=a[1]+"px",t.box.style.position="relative",t.boxS.className="jscolor-picker-shadow",t.boxS.style.position="absolute",t.boxS.style.left="0",t.boxS.style.top="0",t.boxS.style.width="100%",t.boxS.style.height="100%",n.setBorderRadius(t.boxS,d+"px"),t.boxB.className="jscolor-picker-border",t.boxB.style.position="relative",t.boxB.style.border=i.borderWidth+"px solid",t.boxB.style.borderColor=i.borderColor,t.boxB.style.background=i.backgroundColor,n.setBorderRadius(t.boxB,d+"px"),t.padM.style.background="rgba(255,0,0,.2)",t.sldM.style.background="rgba(0,255,0,.2)",t.asldM.style.background="rgba(0,0,255,.2)",t.padM.style.opacity=t.sldM.style.opacity=t.asldM.style.opacity="0",t.pad.style.position="relative",t.pad.style.width=i.width+"px",t.pad.style.height=i.height+"px",t.padPal.draw(i.width,i.height,n.getPadYChannel(i)),t.padB.style.position="absolute",t.padB.style.left=i.padding+"px",t.padB.style.top=i.padding+"px",t.padB.style.border=i.controlBorderWidth+"px solid",t.padB.style.borderColor=i.controlBorderColor,t.padM.style.position="absolute",t.padM.style.left="0px",t.padM.style.top="0px",t.padM.style.width=i.padding+2*i.controlBorderWidth+i.width+l+"px",t.padM.style.height=2*i.controlBorderWidth+2*i.padding+i.height+"px",t.padM.style.cursor="crosshair",n.setData(t.padM,{instance:i,control:"pad"}),t.cross.style.position="absolute",t.cross.style.left=t.cross.style.top="0",t.cross.style.width=t.cross.style.height=s+"px",t.crossBY.style.position=t.crossBX.style.position="absolute",t.crossBY.style.background=t.crossBX.style.background=i.pointerBorderColor,t.crossBY.style.width=t.crossBX.style.height=2*i.pointerBorderWidth+i.pointerThickness+"px",t.crossBY.style.height=t.crossBX.style.width=s+"px",t.crossBY.style.left=t.crossBX.style.top=Math.floor(s/2)-Math.floor(i.pointerThickness/2)-i.pointerBorderWidth+"px",t.crossBY.style.top=t.crossBX.style.left="0",t.crossLY.style.position=t.crossLX.style.position="absolute",t.crossLY.style.background=t.crossLX.style.background=i.pointerColor,t.crossLY.style.height=t.crossLX.style.width=s-2*i.pointerBorderWidth+"px",t.crossLY.style.width=t.crossLX.style.height=i.pointerThickness+"px",t.crossLY.style.left=t.crossLX.style.top=Math.floor(s/2)-Math.floor(i.pointerThickness/2)+"px",t.crossLY.style.top=t.crossLX.style.left=i.pointerBorderWidth+"px",t.sld.style.overflow="hidden",t.sld.style.width=i.sliderSize+"px",t.sld.style.height=i.height+"px",t.sldGrad.draw(i.sliderSize,i.height,"#000","#000"),t.sldB.style.display=r?"block":"none",t.sldB.style.position="absolute",t.sldB.style.left=i.padding+i.width+2*i.controlBorderWidth+2*l+"px",t.sldB.style.top=i.padding+"px",t.sldB.style.border=i.controlBorderWidth+"px solid",t.sldB.style.borderColor=i.controlBorderColor,t.sldM.style.display=r?"block":"none",t.sldM.style.position="absolute",t.sldM.style.left=i.padding+i.width+2*i.controlBorderWidth+l+"px",t.sldM.style.top="0px",t.sldM.style.width=i.sliderSize+2*l+2*i.controlBorderWidth+(o?0:Math.max(0,i.padding-l))+"px",t.sldM.style.height=2*i.controlBorderWidth+2*i.padding+i.height+"px",t.sldM.style.cursor="default",n.setData(t.sldM,{instance:i,control:"sld"}),t.sldPtrIB.style.border=t.sldPtrOB.style.border=i.pointerBorderWidth+"px solid "+i.pointerBorderColor,t.sldPtrOB.style.position="absolute",t.sldPtrOB.style.left=-(2*i.pointerBorderWidth+i.pointerThickness)+"px",t.sldPtrOB.style.top="0",t.sldPtrMB.style.border=i.pointerThickness+"px solid "+i.pointerColor,t.sldPtrS.style.width=i.sliderSize+"px",t.sldPtrS.style.height=n.pub.sliderInnerSpace+"px",t.asld.style.overflow="hidden",t.asld.style.width=i.sliderSize+"px",t.asld.style.height=i.height+"px",t.asldGrad.draw(i.sliderSize,i.height,"#000"),t.asldB.style.display=o?"block":"none",t.asldB.style.position="absolute",t.asldB.style.left=i.padding+i.width+2*i.controlBorderWidth+l+(r?i.sliderSize+3*l+2*i.controlBorderWidth:0)+"px",t.asldB.style.top=i.padding+"px",t.asldB.style.border=i.controlBorderWidth+"px solid",t.asldB.style.borderColor=i.controlBorderColor,t.asldM.style.display=o?"block":"none",t.asldM.style.position="absolute",t.asldM.style.left=i.padding+i.width+2*i.controlBorderWidth+l+(r?i.sliderSize+2*l+2*i.controlBorderWidth:0)+"px",t.asldM.style.top="0px",t.asldM.style.width=i.sliderSize+2*l+2*i.controlBorderWidth+Math.max(0,i.padding-l)+"px",t.asldM.style.height=2*i.controlBorderWidth+2*i.padding+i.height+"px",t.asldM.style.cursor="default",n.setData(t.asldM,{instance:i,control:"asld"}),t.asldPtrIB.style.border=t.asldPtrOB.style.border=i.pointerBorderWidth+"px solid "+i.pointerBorderColor,t.asldPtrOB.style.position="absolute",t.asldPtrOB.style.left=-(2*i.pointerBorderWidth+i.pointerThickness)+"px",t.asldPtrOB.style.top="0",t.asldPtrMB.style.border=i.pointerThickness+"px solid "+i.pointerColor,t.asldPtrS.style.width=i.sliderSize+"px",t.asldPtrS.style.height=n.pub.sliderInnerSpace+"px";var h,c;t.btn.className="jscolor-btn-close",t.btn.style.display=i.closeButton?"block":"none",t.btn.style.position="absolute",t.btn.style.left=i.padding+"px",t.btn.style.bottom=i.padding+"px",t.btn.style.padding="0 15px",t.btn.style.maxWidth=a[0]-2*i.padding-2*i.controlBorderWidth-30+"px",t.btn.style.overflow="hidden",t.btn.style.height=i.buttonHeight+"px",t.btn.style.whiteSpace="nowrap",t.btn.style.border=i.controlBorderWidth+"px solid",h=i.controlBorderColor.split(/\s+/),c=h.length<2?h[0]:h[1]+" "+h[0]+" "+h[0]+" "+h[1],t.btn.style.borderColor=c,t.btn.style.color=i.buttonColor,t.btn.style.font="12px sans-serif",t.btn.style.textAlign="center",t.btn.style.cursor="pointer",t.btn.onmousedown=function(){i.hide()},t.btnT.style.lineHeight=i.buttonHeight+"px",t.btnT.innerHTML="",t.btnT.appendChild(e.document.createTextNode(i.closeText)),p(),u(),g(),n.picker.owner&&n.picker.owner!==i&&n.removeClass(n.picker.owner.targetElement,n.pub.activeClassName),n.picker.owner=i,i.container===e.document.body?n.redrawPosition():n._drawPosition(i,0,0,"relative",!1),t.wrap.parentNode!==i.container&&i.container.appendChild(t.wrap),n.addClass(i.targetElement,n.pub.activeClassName)}function p(){var e=n.getPadYChannel(i),t=Math.round(i.channels.h/360*(i.width-1)),r=Math.round((1-i.channels[e]/100)*(i.height-1)),o=2*i.pointerBorderWidth+i.pointerThickness+2*i.crossSize,a=-Math.floor(o/2);switch(n.picker.cross.style.left=t+a+"px",n.picker.cross.style.top=r+a+"px",n.getSliderChannel(i)){case"s":var s=n.HSV_RGB(i.channels.h,100,i.channels.v),l=n.HSV_RGB(i.channels.h,0,i.channels.v),d="rgb("+Math.round(s[0])+","+Math.round(s[1])+","+Math.round(s[2])+")",h="rgb("+Math.round(l[0])+","+Math.round(l[1])+","+Math.round(l[2])+")";n.picker.sldGrad.draw(i.sliderSize,i.height,d,h);break;case"v":var c=n.HSV_RGB(i.channels.h,i.channels.s,100);d="rgb("+Math.round(c[0])+","+Math.round(c[1])+","+Math.round(c[2])+")",h="#000";n.picker.sldGrad.draw(i.sliderSize,i.height,d,h)}n.picker.asldGrad.draw(i.sliderSize,i.height,i.toHEXString())}function u(){var e=n.getSliderChannel(i);if(e){var t=Math.round((1-i.channels[e]/100)*(i.height-1));n.picker.sldPtrOB.style.top=t-(2*i.pointerBorderWidth+i.pointerThickness)-Math.floor(n.pub.sliderInnerSpace/2)+"px"}n.picker.asldGrad.draw(i.sliderSize,i.height,i.toHEXString())}function g(){var e=Math.round((1-i.channels.a)*(i.height-1));n.picker.asldPtrOB.style.top=e-(2*i.pointerBorderWidth+i.pointerThickness)-Math.floor(n.pub.sliderInnerSpace/2)+"px"}function f(){return n.picker&&n.picker.owner===i}if(this.option=function(){if(!arguments.length)throw new Error("No option specified");if(1===arguments.length&&"string"==typeof arguments[0]){try{return function(e){if(n.deprecatedOpts.hasOwnProperty(e)){var t=e,r=n.deprecatedOpts[e];if(!r)throw new Error("Option '"+e+"' is DEPRECATED");console.warn("Option '%s' is DEPRECATED, using '%s' instead."+n.docsRef,t,r),e=r}if(!(e in i))throw new Error("Unrecognized configuration option: "+e);return i[e]}(arguments[0])}catch(e){console.warn(e)}return!1}if(arguments.length>=2&&"string"==typeof arguments[0]){try{if(!h(arguments[0],arguments[1]))return!1}catch(e){return console.warn(e),!1}return this.redraw(),this.exposeColor(),!0}if(1===arguments.length&&"object"==typeof arguments[0]){var e=arguments[0],t=!0;for(var r in e)if(e.hasOwnProperty(r))try{h(r,e[r])||(t=!1)}catch(e){console.warn(e),t=!1}return this.redraw(),this.exposeColor(),t}throw new Error("Invalid arguments")},this.channel=function(e,t){if("string"!=typeof e)throw new Error("Invalid value for channel name: "+e);if(void 0===t)return this.channels.hasOwnProperty(e.toLowerCase())?this.channels[e.toLowerCase()]:(console.warn("Getting unknown channel: "+e),!1);var r=!1;switch(e.toLowerCase()){case"r":r=this.fromRGBA(t,null,null,null);break;case"g":r=this.fromRGBA(null,t,null,null);break;case"b":r=this.fromRGBA(null,null,t,null);break;case"h":r=this.fromHSVA(t,null,null,null);break;case"s":r=this.fromHSVA(null,t,null,null);break;case"v":r=this.fromHSVA(null,null,t,null);break;case"a":r=this.fromHSVA(null,null,null,t);break;default:return console.warn("Setting unknown channel: "+e),!1}return!!r&&(this.redraw(),!0)},this.trigger=function(e){for(var t=n.strList(e),r=0;r<t.length;r+=1){var i=t[r].toLowerCase(),o=null;switch(i){case"input":o="onInput";break;case"change":o="onChange"}o&&n.triggerCallback(this,o),n.triggerInputEvent(this.valueElement,i,!0,!0)}},this.fromHSVA=function(e,t,r,i,o){if(void 0===e&&(e=null),void 0===t&&(t=null),void 0===r&&(r=null),void 0===i&&(i=null),null!==e){if(isNaN(e))return!1;this.channels.h=Math.max(0,Math.min(360,e))}if(null!==t){if(isNaN(t))return!1;this.channels.s=Math.max(0,Math.min(100,this.maxS,t),this.minS)}if(null!==r){if(isNaN(r))return!1;this.channels.v=Math.max(0,Math.min(100,this.maxV,r),this.minV)}if(null!==i){if(isNaN(i))return!1;this.channels.a=this.hasAlphaChannel()?Math.max(0,Math.min(1,this.maxA,i),this.minA):1}var a=n.HSV_RGB(this.channels.h,this.channels.s,this.channels.v);return this.channels.r=a[0],this.channels.g=a[1],this.channels.b=a[2],this.exposeColor(o),!0},this.fromRGBA=function(e,t,r,i,o){if(void 0===e&&(e=null),void 0===t&&(t=null),void 0===r&&(r=null),void 0===i&&(i=null),null!==e){if(isNaN(e))return!1;e=Math.max(0,Math.min(255,e))}if(null!==t){if(isNaN(t))return!1;t=Math.max(0,Math.min(255,t))}if(null!==r){if(isNaN(r))return!1;r=Math.max(0,Math.min(255,r))}if(null!==i){if(isNaN(i))return!1;this.channels.a=this.hasAlphaChannel()?Math.max(0,Math.min(1,this.maxA,i),this.minA):1}var a=n.RGB_HSV(null===e?this.channels.r:e,null===t?this.channels.g:t,null===r?this.channels.b:r);null!==a[0]&&(this.channels.h=Math.max(0,Math.min(360,a[0]))),0!==a[2]&&(this.channels.s=Math.max(0,this.minS,Math.min(100,this.maxS,a[1]))),this.channels.v=Math.max(0,this.minV,Math.min(100,this.maxV,a[2]));var s=n.HSV_RGB(this.channels.h,this.channels.s,this.channels.v);return this.channels.r=s[0],this.channels.g=s[1],this.channels.b=s[2],this.exposeColor(o),!0},this.fromHSV=function(e,t,r,i){return console.warn("fromHSV() method is DEPRECATED. Using fromHSVA() instead."+n.docsRef),this.fromHSVA(e,t,r,null,i)},this.fromRGB=function(e,t,r,i){return console.warn("fromRGB() method is DEPRECATED. Using fromRGBA() instead."+n.docsRef),this.fromRGBA(e,t,r,null,i)},this.fromString=function(e,t){if(!this.required&&""===e.trim())return this.setPreviewElementBg(null),this.setValueElementValue(""),!0;var r=n.parseColorString(e);return!!r&&("any"===this.format.toLowerCase()&&(this._currentFormat=r.format,"rgba"!==this.getFormat()&&(r.rgba[3]=1),this.redraw()),this.fromRGBA(r.rgba[0],r.rgba[1],r.rgba[2],r.rgba[3],t),!0)},this.toString=function(e){switch(void 0===e&&(e=this.getFormat()),e.toLowerCase()){case"hex":return this.toHEXString();case"rgb":return this.toRGBString();case"rgba":return this.toRGBAString()}return!1},this.toHEXString=function(){return"#"+(("0"+Math.round(this.channels.r).toString(16)).substr(-2)+("0"+Math.round(this.channels.g).toString(16)).substr(-2)+("0"+Math.round(this.channels.b).toString(16)).substr(-2)).toUpperCase()},this.toRGBString=function(){return"rgb("+Math.round(this.channels.r)+","+Math.round(this.channels.g)+","+Math.round(this.channels.b)+")"},this.toRGBAString=function(){return"rgba("+Math.round(this.channels.r)+","+Math.round(this.channels.g)+","+Math.round(this.channels.b)+","+Math.round(100*this.channels.a)/100+")"},this.toGrayscale=function(){return.213*this.channels.r+.715*this.channels.g+.072*this.channels.b},this.toCanvas=function(){return n.genColorPreviewCanvas(this.toRGBAString()).canvas},this.toDataURL=function(){return this.toCanvas().toDataURL()},this.toBackground=function(){return n.pub.background(this.toRGBAString())},this.isLight=function(){return this.toGrayscale()>127.5},this.hide=function(){f()&&(n.removeClass(i.targetElement,n.pub.activeClassName),n.picker.wrap.parentNode.removeChild(n.picker.wrap),delete n.picker.owner)},this.show=function(){c()},this.redraw=function(){f()&&c()},this.getFormat=function(){return this._currentFormat},this.hasAlphaChannel=function(){return"auto"===this.alphaChannel?"any"===this.format.toLowerCase()||"rgba"===this.getFormat()||void 0!==this.alpha||void 0!==this.alphaElement:this.alphaChannel},this.processValueInput=function(e){this.fromString(e)||this.exposeColor()},this.processAlphaInput=function(e){this.fromHSVA(null,null,null,parseFloat(e))||this.exposeColor()},this.exposeColor=function(e){if(!(e&n.flags.leaveValue)&&this.valueElement){var t=this.toString();"hex"===this.getFormat()&&(this.uppercase||(t=t.toLowerCase()),this.hash||(t=t.replace(/^#/,""))),this.setValueElementValue(t)}if(!(e&n.flags.leaveAlpha)&&this.alphaElement){t=Math.round(100*this.channels.a)/100;this.setAlphaElementValue(t)}if(!(e&n.flags.leavePreview)&&this.previewElement){(n.isTextInput(this.previewElement)||n.isButton(this.previewElement)&&!n.isButtonEmpty(this.previewElement))&&this.previewPosition,this.setPreviewElementBg(this.toRGBAString())}f()&&(p(),u(),g())},this.setPreviewElementBg=function(e){if(this.previewElement){var t=null,r=null;(n.isTextInput(this.previewElement)||n.isButton(this.previewElement)&&!n.isButtonEmpty(this.previewElement))&&(t=this.previewPosition,r=this.previewSize);var i=[];if(e){i.push({image:n.genColorPreviewGradient(e,t,r?r-n.pub.previewSeparator.length:null),position:"left top",size:"auto",repeat:t?"repeat-y":"repeat",origin:"padding-box"});var o=n.genColorPreviewCanvas("rgba(0,0,0,0)",t?{left:"right",right:"left"}[t]:null,r,!0);i.push({image:"url('"+o.canvas.toDataURL()+"')",position:(t||"left")+" top",size:o.width+"px "+o.height+"px",repeat:t?"repeat-y":"repeat",origin:"padding-box"})}else i.push({image:"none",position:"left top",size:"auto",repeat:"no-repeat",origin:"padding-box"});for(var a={image:[],position:[],size:[],repeat:[],origin:[]},s=0;s<i.length;s+=1)a.image.push(i[s].image),a.position.push(i[s].position),a.size.push(i[s].size),a.repeat.push(i[s].repeat),a.origin.push(i[s].origin);var l={"background-image":a.image.join(", "),"background-position":a.position.join(", "),"background-size":a.size.join(", "),"background-repeat":a.repeat.join(", "),"background-origin":a.origin.join(", ")};n.setStyle(this.previewElement,l,this.forceStyle);var d={left:null,right:null};t&&(d[t]=this.previewSize+this.previewPadding+"px");l={"padding-left":d.left,"padding-right":d.right};n.setStyle(this.previewElement,l,this.forceStyle,!0)}},this.setValueElementValue=function(e){this.valueElement&&("input"===n.nodeName(this.valueElement)?this.valueElement.value=e:this.valueElement.innerHTML=e)},this.setAlphaElementValue=function(e){this.alphaElement&&("input"===n.nodeName(this.alphaElement)?this.alphaElement.value=e:this.alphaElement.innerHTML=e)},this._processParentElementsInDOM=function(){if(!this._linkedElementsProcessed){this._linkedElementsProcessed=!0;var e=this.targetElement;do{var t=n.getCompStyle(e);t.position&&"fixed"===t.position.toLowerCase()&&(this.fixed=!0),e!==this.targetElement&&(n.getData(e,"hasScrollListener")||(e.addEventListener("scroll",n.onParentScroll,!1),n.setData(e,"hasScrollListener",!0)))}while((e=e.parentNode)&&"body"!==n.nodeName(e))}},this.tryHide=function(){this.hideOnLeave&&this.hide()},void 0===this.container?this.container=e.document.body:this.container=n.node(this.container),!this.container)throw new Error("Cannot instantiate color picker without a container element");if(this.targetElement=n.node(t),!this.targetElement){if("string"==typeof t&&/^[a-zA-Z][\w:.-]*$/.test(t)){throw new Error("If '"+t+"' is supposed to be an ID, please use '#"+t+"' or any valid CSS selector.")}throw new Error("Cannot instantiate color picker without a target element")}if(this.targetElement.jscolor&&this.targetElement.jscolor instanceof n.pub)throw new Error("Color picker already installed on this element");if(this.targetElement.jscolor=this,n.addClass(this.targetElement,n.pub.className),n.instances.push(this),n.isButton(this.targetElement)&&("button"!==this.targetElement.type.toLowerCase()&&(this.targetElement.type="button"),n.isButtonEmpty(this.targetElement))){n.removeChildren(this.targetElement),this.targetElement.appendChild(e.document.createTextNode(" "));var v=n.getCompStyle(this.targetElement);(parseFloat(v["min-width"])||0)<this.previewSize&&n.setStyle(this.targetElement,{"min-width":this.previewSize+"px"},this.forceStyle)}if(void 0===this.valueElement?n.isTextInput(this.targetElement)&&(this.valueElement=this.targetElement):null===this.valueElement||(this.valueElement=n.node(this.valueElement)),this.alphaElement&&(this.alphaElement=n.node(this.alphaElement)),void 0===this.previewElement?this.previewElement=this.targetElement:null===this.previewElement||(this.previewElement=n.node(this.previewElement)),this.valueElement&&n.isTextInput(this.valueElement)){var m={onInput:this.valueElement.oninput};this.valueElement.oninput=null,this.valueElement.addEventListener("keydown",function(e){"Enter"===n.eventKey(e)&&(i.valueElement&&i.processValueInput(i.valueElement.value),i.tryHide())},!1),this.valueElement.addEventListener("change",function(e){if(!n.getData(e,"internal")){var t=i.valueElement.value;i.processValueInput(i.valueElement.value),n.triggerCallback(i,"onChange"),i.valueElement.value!==t&&n.triggerInputEvent(i.valueElement,"change",!0,!0)}},!1),this.valueElement.addEventListener("input",function(e){n.getData(e,"internal")||(i.valueElement&&i.fromString(i.valueElement.value,n.flags.leaveValue),n.triggerCallback(i,"onInput"))},!1),m.onInput&&this.valueElement.addEventListener("input",m.onInput,!1),this.valueElement.setAttribute("autocomplete","off"),this.valueElement.setAttribute("autocorrect","off"),this.valueElement.setAttribute("autocapitalize","off"),this.valueElement.setAttribute("spellcheck",!1)}this.alphaElement&&n.isTextInput(this.alphaElement)&&(this.alphaElement.addEventListener("keydown",function(e){"Enter"===n.eventKey(e)&&(i.alphaElement&&i.processAlphaInput(i.alphaElement.value),i.tryHide())},!1),this.alphaElement.addEventListener("change",function(e){if(!n.getData(e,"internal")){var t=i.alphaElement.value;i.processAlphaInput(i.alphaElement.value),n.triggerCallback(i,"onChange"),n.triggerInputEvent(i.valueElement,"change",!0,!0),i.alphaElement.value!==t&&n.triggerInputEvent(i.alphaElement,"change",!0,!0)}},!1),this.alphaElement.addEventListener("input",function(e){n.getData(e,"internal")||(i.alphaElement&&i.fromHSVA(null,null,null,parseFloat(i.alphaElement.value),n.flags.leaveAlpha),n.triggerCallback(i,"onInput"),n.triggerInputEvent(i.valueElement,"input",!0,!0))},!1),this.alphaElement.setAttribute("autocomplete","off"),this.alphaElement.setAttribute("autocorrect","off"),this.alphaElement.setAttribute("autocapitalize","off"),this.alphaElement.setAttribute("spellcheck",!1));var b="FFFFFF";void 0!==this.value?b=this.value:this.valueElement&&void 0!==this.valueElement.value&&(b=this.valueElement.value);var w=void 0;if(void 0!==this.alpha?w=""+this.alpha:this.alphaElement&&void 0!==this.alphaElement.value&&(w=this.alphaElement.value),this._currentFormat=null,["auto","any"].indexOf(this.format.toLowerCase())>-1){var y=n.parseColorString(b);this._currentFormat=y?y.format:"hex"}else this._currentFormat=this.format.toLowerCase();this.processValueInput(b),void 0!==w&&this.processAlphaInput(w)}}).pub.className="jscolor",n.pub.activeClassName="jscolor-active",n.pub.looseJSON=!0,n.pub.presets={},n.pub.presets.default={},n.pub.presets.light={backgroundColor:"rgba(255,255,255,1)",controlBorderColor:"rgba(187,187,187,1)",buttonColor:"rgba(0,0,0,1)"},n.pub.presets.dark={backgroundColor:"rgba(51,51,51,1)",controlBorderColor:"rgba(153,153,153,1)",buttonColor:"rgba(240,240,240,1)"},n.pub.presets.small={width:101,height:101,padding:10,sliderSize:14},n.pub.presets.medium={width:181,height:101,padding:12,sliderSize:16},n.pub.presets.large={width:271,height:151,padding:12,sliderSize:24},n.pub.presets.thin={borderWidth:1,controlBorderWidth:1,pointerBorderWidth:1},n.pub.presets.thick={borderWidth:2,controlBorderWidth:2,pointerBorderWidth:2},n.pub.sliderInnerSpace=3,n.pub.chessboardSize=8,n.pub.chessboardColor1="#666666",n.pub.chessboardColor2="#999999",n.pub.previewSeparator=["rgba(255,255,255,.65)","rgba(128,128,128,.65)"],n.pub.init=function(){if(!n.initialized)for(e.document.addEventListener("mousedown",n.onDocumentMouseDown,!1),e.document.addEventListener("keyup",n.onDocumentKeyUp,!1),e.addEventListener("resize",n.onWindowResize,!1),n.pub.install(),n.initialized=!0;n.triggerQueue.length;){var t=n.triggerQueue.shift();n.triggerGlobal(t)}},n.pub.install=function(e){var t=!0;try{n.installBySelector("[data-jscolor]",e)}catch(e){t=!1,console.warn(e)}if(n.pub.lookupClass)try{n.installBySelector("input."+n.pub.lookupClass+", button."+n.pub.lookupClass,e)}catch(e){}return t},n.pub.trigger=function(e){n.initialized?n.triggerGlobal(e):n.triggerQueue.push(e)},n.pub.hide=function(){n.picker&&n.picker.owner&&n.picker.owner.hide()},n.pub.chessboard=function(e){return e||(e="rgba(0,0,0,0)"),n.genColorPreviewCanvas(e).canvas.toDataURL()},n.pub.background=function(e){var t=[];t.push(n.genColorPreviewGradient(e));var r=n.genColorPreviewCanvas();return t.push(["url('"+r.canvas.toDataURL()+"')","left top","repeat"].join(" ")),t.join(", ")},n.pub.options={},n.pub.lookupClass="jscolor",n.pub.installByClassName=function(){return console.error('jscolor.installByClassName() is DEPRECATED. Use data-jscolor="" attribute instead of a class name.'+n.docsRef),!1},n.register(),n.pub);return void 0===e.jscolor&&(e.jscolor=e.JSColor=i),i}),jscolor.presets.default={previewPosition:"right",previewSize:0,previewPadding:0,borderColor:"#D9DBDE",borderRadius:4,padding:10,width:180,height:100,controlBorderColor:"#D9DBDE",pointerBorderColor:"rgba(0,0,0,0)",shadowColor:"rgba(0,0,0,0.12)",shadowBlur:20, onInput: 'this.targetElement.style.color = this.isLight() ? "#000" : "#fff"'};

jQuery(function() {
    'use strict';
    var daftplugAdmin = jQuery('.daftplugAdmin[data-daftplug-plugin="daftplug_instantify"]');
    var optionName = daftplugAdmin.attr('data-daftplug-plugin');
    var objectName = window[optionName + '_admin_js_vars'];

    // Set cookie
    function setCookie(name, value, days) {
        var expires = '';
        if (days) {
            var date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            expires = '; expires=' + date.toUTCString();
        }
        document.cookie = name + '=' + (value || '') + expires + '; path=/';
    }
    
    // Get cookie
    function getCookie(name) {
        var nameEQ = name + '=';
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') c = c.substring(1, c.length);
            if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
        }
        return null;
    }

    // Handle URLs
    if (daftplugAdmin.find('.daftplugAdminPage.-activation').length) {
        window.location.hash = '#/activation/';
        daftplugAdmin.find('.daftplugAdminPage.-activation').addClass('-active');
        daftplugAdmin.find('.daftplugAdminHeader').css('justify-content', 'center');
        daftplugAdmin.find('.daftplugAdminHeader_versionText, .daftplugAdminHeader_support').hide();
    } else {
        if (window.location.hash) {
            var hash = window.location.hash.replace(/#|\//g, '').split('-');
            var pageId = hash[0];
            var subPageId = hash[1];
            var page = daftplugAdmin.find('.daftplugAdminPage.-' + pageId);
            var menuItem = daftplugAdmin.find('.daftplugAdminMenu_item.-' + pageId);
            var subPage = daftplugAdmin.find('.daftplugAdminPage_subpage.-' + subPageId);
            var subMenuItem = daftplugAdmin.find('.daftplugAdminSubmenu_item.-' + subPageId);
            var hasSubPages = page.find('.daftplugAdminPage_subpage').length;
            var firstSubPage = page.find('.daftplugAdminPage_subpage').first();
            var firstSubPageId = firstSubPage.attr('data-subpage');
            var firstSubMenuItem = page.find('.daftplugAdminSubmenu_item').first();
            var errorPage = daftplugAdmin.find('.daftplugAdminPage.-error');

            if (page.length) {
                page.addClass('-active');
                menuItem.addClass('-active');

                if (hasSubPages) {
                    if (hash.includes(subPageId)) {
                        if (subPage.length) {
                            subPage.addClass('-active');
                            subMenuItem.addClass('-active');
                        } else {
                            page.removeClass('-active');
                            menuItem.removeClass('-active');
                            errorPage.addClass('-active');
                        }
                    } else {
                        firstSubPage.addClass('-active');
                        firstSubMenuItem.addClass('-active');
                        window.location.hash = '#/'+pageId+'-'+firstSubPageId+'/';
                    }
                }
            } else {
                errorPage.addClass('-active');
            }
        } else {
            window.location.hash = '#/overview/';
            daftplugAdmin.find('.daftplugAdminPage.-overview').addClass('-active');
            daftplugAdmin.find('.daftplugAdminMenu_item.-overview').addClass('-active');
        }
    }

    // Handle navigation
    daftplugAdmin.on('click', 'a[data-page]', function(e) {
        var self = jQuery(this);
        var pageId = self.attr('data-page');
        var page = daftplugAdmin.find('.daftplugAdminPage.-' + pageId);
        var menuItem = daftplugAdmin.find('.daftplugAdminMenu_item.-' + pageId);
        var subPage = page.find('.daftplugAdminPage_subpage');
        var hasSubPages = subPage.length;
        var firstSubPage = subPage.first();
        var firstSubPageId = firstSubPage.attr('data-subpage');
        var subMenuItem = page.find('.daftplugAdminSubmenu_item');
        var firstSubMenuItem = subMenuItem.first();

        daftplugAdmin.find('.daftplugAdminPage').removeClass('-active');
        page.addClass('-active');

        daftplugAdmin.find('.daftplugAdminMenu_item').removeClass('-active');
        menuItem.addClass('-active');

        if (hasSubPages) {
            subPage.add(subMenuItem).removeClass('-active');
            firstSubPage.add(firstSubMenuItem).addClass('-active');
        } 
    });

    // Handle subnavigation
    daftplugAdmin.on('click', 'a[data-subpage]', function(e) {
        var self = jQuery(this);
        var subPageId = self.attr('data-subpage');
        var subPage = daftplugAdmin.find('.daftplugAdminPage_subpage.-' + subPageId);
        var subMenuItem = daftplugAdmin.find('.daftplugAdminSubmenu_item.-' + subPageId);

        daftplugAdmin.find('.daftplugAdminPage_subpage').removeClass('-active');
        subPage.addClass('-active');

        daftplugAdmin.find('.daftplugAdminSubmenu_item').removeClass('-active');
        subMenuItem.addClass('-active');
    });

    // Handle FAQ
    daftplugAdmin.find('.daftplugAdminFaq_item').each(function(e) {
        var self = jQuery(this);
        var question = self.find('.daftplugAdminFaq_question');

        question.on('click', function(e) {
            if (self.hasClass('-active')) {
                self.removeClass('-active');
            } else {
                daftplugAdmin.find('.daftplugAdminFaq_item').removeClass('-active');
                self.addClass('-active');
            }
        });
    });

    // Handle submit button
    daftplugAdmin.find('.daftplugAdminButton.-submit').each(function(e) {
        var self = jQuery(this);
        var submitText = self.attr('data-submit');
        var waitingText = self.attr('data-waiting');
        var submittedText = self.attr('data-submitted');
        var failedText = self.attr('data-failed');

        self.html(`<span class="daftplugAdminButton_iconset">
                       <svg class="daftplugAdminButton_icon -iconSubmit">
                           <use href="#iconSubmit"></use>
                       </svg>
                       <svg class="daftplugAdminButton_icon -iconLoading">
                           <use href="#iconLoading"></use>
                       </svg>
                       <svg class="daftplugAdminButton_icon -iconSuccess">
                           <use href="#iconSuccess"></use>
                       </svg>
                       <svg class="daftplugAdminButton_icon -iconFail">
                           <use href="#iconFail"></use>
                       </svg>
                   </span>
                   <ul class="daftplugAdminButton_textset">
                       <li class="daftplugAdminButton_text -submit">
                           ${submitText}
                       </li>
                       <li class="daftplugAdminButton_text -waiting">
                           ${waitingText}
                       </li>
                       <li class="daftplugAdminButton_text -submitted">
                           ${submittedText}
                       </li>
                       <li class="daftplugAdminButton_text -submitFailed">
                           ${failedText}
                       </li>
                   </ul>`);

        var buttonTexts = self.find('.daftplugAdminButton_textset');
        var buttonText = buttonTexts.find('.daftplugAdminButton_text');
        var buttonIcons = self.find('.daftplugAdminButton_iconset');
        var buttonIcon = self.find('.daftplugAdminButton_icon');
        var longestButtonTextChars = '';

        buttonText.each(function(e) {
            var self = jQuery(this);
			var buttonTextChars = self.text();
			if (buttonTextChars.length > longestButtonTextChars.length) {
				longestButtonTextChars = buttonTextChars;
			}
        });

        buttonTexts.css('width', longestButtonTextChars.trim().length * 7.5 +'px');

        if (self.hasClass('-confirm')) {
            var sureText = self.attr('data-sure');
            var confirmDuration = self.attr('data-duration');
            var clickDuration = 0;

            self.attr('style', `--confirmDuration:${confirmDuration};`);
            self.on('mousedown touchstart', function(e) {
                e.preventDefault();
                buttonText.filter('.-waiting').text(sureText);
                self.addClass('-loading -progress');
                clickDuration = setTimeout(function(e) {
                    buttonText.filter('.-waiting').text(waitingText);
                    self.removeClass('-loading -progress').trigger('submit');
                }, parseInt(confirmDuration));
            }).on('mouseup touchend', function(e) {
                self.removeClass('-loading -progress');
                clearTimeout(clickDuration);
            });
        }
    });

    // Handle add field button
    daftplugAdmin.find('.daftplugAdminButton.-addField').each(function(e) {
        var self = jQuery(this);
        var addTarget = self.attr('data-add');
        var miniFieldset = daftplugAdmin.find('.-miniFieldset[class*="-'+addTarget+'"]');
        var i = 0;

        miniFieldset.prepend(`
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="daftplugAdminMiniFieldset_close -iconClose">
                <g stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="10" cy="10" r="10" id="circle"></circle>
                    <path d="M7,7 L13,13" id="line"></path>
                    <path d="M7,13 L13,7" id="line"></path>
                </g>
            </svg>
        `).each(function(e) {
            var self = jQuery(this);
            var miniFieldsetCheckboxField = self.find('.daftplugAdminInputCheckbox.-hidden').find('.daftplugAdminInputCheckbox_field');
            if (miniFieldsetCheckboxField.is(':checked')) {
                self.show().prop('disabled', false);
                i++;
            } else {
                self.hide().prop('disabled', true);
            }
        });

        var close = miniFieldset.find('.daftplugAdminMiniFieldset_close');

        self.on('click', function(e) {  
            i++;
            miniFieldset.filter('.-miniFieldset[class*="-'+addTarget+i+'"]').show().prop('disabled', false);
            miniFieldset.find('.daftplugAdminInputCheckbox_field[id="'+addTarget+i+'"]').prop('checked', true).trigger('change');
            miniFieldset.find('.daftplugAdminInputCheckbox_field').trigger('change');
            if (!miniFieldset.filter('.-miniFieldset[class*="-'+addTarget+(i+1)+'"]').length) {
                self.hide();
            }
        });

        close.on('click', function(e) {
            self.show();
            miniFieldset.filter('.-miniFieldset[class*="-'+addTarget+i+'"]').hide().prop('disabled', true);
            miniFieldset.find('.daftplugAdminInputCheckbox_field[id="'+addTarget+i+'"]').prop('checked', false).trigger('change');
            if (i != 0) {
                i--;
            }
        });
    });

    // Handle tooltips
    daftplugAdmin.on('mouseenter mouseleave', '[data-tooltip]', function(e) {
        var self = jQuery(this);
        var tooltip = self.attr('data-tooltip');
        var flow = self.attr('data-tooltip-flow');

        if (e.type === 'mouseenter') {
            self.append(`<span class="daftplugAdminTooltip">${tooltip}</span>`);
            var tooltipEl = self.find('.daftplugAdminTooltip');
            switch (flow) {
                case 'top':
                    tooltipEl.css({
                        'bottom': 'calc(100% + 5px)',
                        'left': '50%',
                        '-webkit-transform': 'translate(-50%, -.5em)',
                        'transform': 'translate(-50%, -.5em)',
                    });
                    break;
                case 'right':
                    tooltipEl.css({
                        'top': '50%',
                        'left': 'calc(100% + 5px)',
                        '-webkit-transform': 'translate(.5em, -50%)',
                        'transform': 'translate(.5em, -50%)',
                    });
                    break;
                case 'bottom':
                    tooltipEl.css({
                        'top': 'calc(100% + 5px)',
                        'left': '50%',
                        '-webkit-transform': 'translate(-50%, .5em)',
                        'transform': 'translate(-50%, .5em)',
                    });
                    break;
                case 'left':
                    tooltipEl.css({
                        'top': '50%',
                        'right': 'calc(100% + 5px)',
                        '-webkit-transform': 'translate(-.5em, -50%)',
                        'transform': 'translate(-.5em, -50%)',
                    });
                    break;
                default:
                    
            }
        }

        if (e.type === 'mouseleave') {
            self.find('.daftplugAdminTooltip').remove();
        }
    });

    // Handle loader
    daftplugAdmin.find('.daftplugAdminLoader').each(function(e) {
        var self = jQuery(this);
        var size = self.attr('data-size');
        var duration = self.attr('data-duration');

        self.html(`
            <div class="daftplugAdminLoader_box">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>
            <div class="daftplugAdminLoader_box">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>
            <div class="daftplugAdminLoader_box">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>
            <div class="daftplugAdminLoader_box">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>
        `).attr('style', `--size:${size};--duration:${duration}`);
    });

    // Handle feature pills
    daftplugAdmin.find('.daftplugAdminFieldset[data-feature-type]').each(function(e) {
        var self = jQuery(this);
        var featureType = self.attr('data-feature-type');
        var title = self.find('.daftplugAdminFieldset_title');

        switch(featureType) {
            case 'new':
                title.append(`<span class="daftplugAdminFeaturePill" style="background-color: #ff3a3a;">${featureType}</span>`);
                break;
            case 'beta':
                title.append(`<span class="daftplugAdminFeaturePill" style="background-color: #ffb13e;">${featureType}</span>`);
                break;
            default:
                title.append(`<span class="daftplugAdminFeaturePill" style="background-color: #444f5b;">${featureType}</span>`);
        }
    });

    // Handle changelog pills
	daftplugAdmin.find('.daftplugAdminChangelog_item').each(function(e) {
        var self = jQuery(this);
        var type = self.attr('data-type');
        var text = self.attr('data-text');

        switch(type) {
            case 'added':
                self.prepend(`
                    <span class="daftplugAdminFeaturePill" style="background-color: #4ad504; margin: 0;">${type}</span>
                    <p class="daftplugAdminChangelog_text"> - ${text}</p>
                `);
                break;
            case 'improved':
                self.prepend(`<span class="daftplugAdminFeaturePill" style="background-color: #4073ff; margin: 0;">${type}</span>
                    <p class="daftplugAdminChangelog_text"> - ${text}</p>
                `);
                break;
            case 'fixed':
                self.prepend(`<span class="daftplugAdminFeaturePill" style="background-color: #ffb13e; margin: 0;">${type}</span>
                    <p class="daftplugAdminChangelog_text"> - ${text}</p>
                `);
                break;
            case 'removed':
                self.prepend(`<span class="daftplugAdminFeaturePill" style="background-color: #ff3a3a; margin: 0;">${type}</span>
                    <p class="daftplugAdminChangelog_text"> - ${text}</p>
                `);
                break;
            default:
                self.prepend(`<span class="daftplugAdminFeaturePill" style="background-color: #444f5b; margin: 0;">${type}</span>
                    <p class="daftplugAdminChangelog_text"> - ${text}</p>
                `);
        }
	});

    // Handle popup
    daftplugAdmin.find('.daftplugAdminPopup').each(function(e) {
        var self = jQuery(this);
        var openPopup = self.attr('data-popup');
        var popupContainer = self.find('.daftplugAdminPopup_container');

        daftplugAdmin.find('[data-open-popup="'+openPopup+'"]').on('click', function(e) {
            self.addClass('-active');
        });

        popupContainer.on('click', function(e) {
            e.stopPropagation();
        }).find('fieldset').not('.-miniFieldset').css('border', 'none');

        self.on('click', function(e) {
            self.removeClass('-active');
        });
    });

    // Handle input has value
    daftplugAdmin.find('.daftplugAdminInputText, .daftplugAdminInputNumber, .daftplugAdminInputTextarea, .daftplugAdminInputColor').each(function(e) {
        var self = jQuery(this);
        var field = self.find('.daftplugAdminInputText_field, .daftplugAdminInputNumber_field, .daftplugAdminInputTextarea_field, .daftplugAdminInputColor_field');

        field.on('change input keyup paste', function() {
            field.val().length ? field.addClass('-hasValue') : field.removeClass('-hasValue');
        }).trigger('change');
    });

    // Handle text input
    daftplugAdmin.find('.daftplugAdminInputText').each(function(e) {
        var self = jQuery(this);
        var field = self.find('.daftplugAdminInputText_field');
        var placeholder = field.attr('data-placeholder');

        field.after('<span class="daftplugAdminInputText_placeholder">' + placeholder + '</span>');

        field.on('invalid', function(e) {
            self.addClass('-invalid');
            setTimeout(function(e) {
                self.removeClass('-invalid');
            }, 2300);
        });
    });

    // Handle textarea
    daftplugAdmin.find('.daftplugAdminInputTextarea').each(function(e) {
        var self = jQuery(this);
        var field = self.find('.daftplugAdminInputTextarea_field');
        var placeholder = field.attr('data-placeholder');

        field.after('<span class="daftplugAdminInputTextarea_placeholder">' + placeholder + '</span>');

        field.on('change keydown keyup paste', function(e) {
            field.height(0).height(field.prop('scrollHeight') - parseInt(field.css('padding-bottom')) - 5);
        }).trigger('change');

        field.on('invalid', function(e) {
            self.addClass('-invalid');
            setTimeout(function(e) {
                self.removeClass('-invalid');
            }, 2300);
        });
    });

    // Handle checkbox
    daftplugAdmin.find('.daftplugAdminInputCheckbox').each(function(e) {
        var self = jQuery(this);
        var field = self.find('.daftplugAdminInputCheckbox_field');
        var dependentDisableD = daftplugAdmin.find('.-' + field.attr('id') + 'DependentDisableD');
        var dependentHideD = daftplugAdmin.find('.-' + field.attr('id') + 'DependentHideD');
        var dependentDisableE = daftplugAdmin.find('.-' + field.attr('id') + 'DependentDisableE');
        var dependentHideE = daftplugAdmin.find('.-' + field.attr('id') + 'DependentHideE');
        var dependentDisableDField = dependentDisableD.find('[class*="_field"]');
        var dependentDisableEField = dependentDisableE.find('[class*="_field"]');
        var dependentHideDField = dependentHideD.find('[class*="_field"]');
        var dependentHideEField = dependentHideE.find('[class*="_field"]');

        dependentDisableDField.add(dependentDisableEField).add(dependentHideDField).add(dependentHideEField).each(function(e) {
        	if (jQuery(this).is('[required]')) {
        		jQuery(this).attr('data-required', 'true');
        	}
        });

        field.after(`<span class="daftplugAdminInputCheckbox_background"></span>
                     <span class="daftplugAdminInputCheckbox_grabholder"></span>`);

        field.on('change', function(e) {
        	if (field.is(':checked')) {
        		dependentDisableD.removeClass('-disabled');
                dependentDisableE.addClass('-disabled');
                dependentHideD.show();
                dependentHideE.hide();
                dependentDisableEField.add(dependentHideEField).prop('required', false);
                dependentDisableDField.add(dependentHideDField).each(function(e) {
	        		if (jQuery(this).attr('data-required') == 'true') {
	        			jQuery(this).prop('required', true);
	        		} else {
	        			jQuery(this).prop('required', false);
	        		}
                });
        	} else {
				dependentDisableD.addClass('-disabled');
                dependentDisableE.removeClass('-disabled');
                dependentHideD.hide();
                dependentHideE.show();
        		dependentDisableDField.add(dependentHideDField).prop('required', false);
                dependentDisableEField.add(dependentHideEField).each(function(e) {
	        		if (jQuery(this).attr('data-required') == 'true') {
	        			jQuery(this).prop('required', true);
	        		} else {
	        			jQuery(this).prop('required', false);
	        		}
                });
        	}
        }).trigger('change');
    });

    // Handle number input
    daftplugAdmin.find('.daftplugAdminInputNumber').each(function(e) {
        var self = jQuery(this);
        var field = self.find('.daftplugAdminInputNumber_field');
        var placeholder = field.attr('data-placeholder');
        var step = parseFloat(field.attr('step'));
        var min = parseFloat(field.attr('min'));
        var max = parseFloat(field.attr('max'));

        field.before('<svg class="daftplugAdminInputNumber_icon -iconMinus"><use href="#iconMinus"></use></svg>')
             .after(`<span class="daftplugAdminInputNumber_placeholder" style="left: 42px;">${placeholder}</span>
                     <svg class="daftplugAdminInputNumber_icon -iconPlus"><use href="#iconPlus"></use></svg>`);

        var icon = self.find('.daftplugAdminInputNumber_icon');

        field.on('focus blur', function(e) {
            if(e.type == 'focus' || e.type == 'focusin') { 
              icon.addClass('-focused');
            } else{
              icon.removeClass('-focused');
            }
        });

        self.find('.daftplugAdminInputNumber_icon.-iconMinus').on('click', function(e) {
            var value = parseFloat(field.val());
            if (value > min) {
                field.val(value - step).trigger('change');
            }
        });

        self.find('.daftplugAdminInputNumber_icon.-iconPlus').on('click', function(e) {
            var value = parseFloat(field.val());
            if (field.val().length) {
                if (value < max) {
                    field.val(value + step).trigger('change');
                }
            } else {
                field.val(step).trigger('change');
            }
        });

        field.on('invalid', function(e) {
            self.add(icon).addClass('-invalid');
            setTimeout(function(e) {
                self.add(icon).removeClass('-invalid');
            }, 2300);
        });
    });

    // Handle select input
    daftplugAdmin.find('.daftplugAdminInputSelect').each(function(e) {
        var self = jQuery(this);
        var field = self.find('.daftplugAdminInputSelect_field');
        var fieldOption = field.find('option');
        var label = jQuery('label[for="'+field.attr('id')+'"]');
        var placeholder = field.attr('data-placeholder');

        field.after(`<div class="daftplugAdminInputSelect_dropdown"></div>
                     <span class="daftplugAdminInputSelect_placeholder">${placeholder}</span>
                     <ul class="daftplugAdminInputSelect_list"></ul>
                     <span class="daftplugAdminInputSelect_arrow"></span>`);

        fieldOption.each(function(e) {
            self.find('.daftplugAdminInputSelect_list').append(`<li class="daftplugAdminInputSelect_option" data-value="${jQuery(this).val().trim()}">
                                                                    <a class="daftplugAdminInputSelect_text">${jQuery(this).text().trim()}</a>
                                                                </li>`);
        });

        var dropdown = self.find('.daftplugAdminInputSelect_dropdown');
        var list = self.find('.daftplugAdminInputSelect_list');
        var option = self.find('.daftplugAdminInputSelect_option');

        dropdown.add(list).attr('data-name', field.attr('name'));

        if (field.is('[multiple]')) {
        	dropdown.attr('data-multiple', 'true');
        	if (!field.find('option:selected').length) {
                fieldOption.first().prop('selected', true);
            }
            field.find('option:selected').each(function(e) {
                var self = jQuery(this);
        		dropdown.append(function(e) {
        			return jQuery('<span class="daftplugAdminInputSelect_choice" data-value="'+self.val()+'">'+self.text()+'<svg class="daftplugAdminInputSelect_deselect -iconX"><use href="#iconX"></use></svg></span>').on('click', function(e) {
		            	var self = jQuery(this);
		                e.stopPropagation();
		                self.remove();
		                list.find('.daftplugAdminInputSelect_option[data-value="'+self.attr('data-value')+'"]').removeClass('-selected');
		                list.css('top', dropdown.height() + 5).find('.daftplugAdminInputSelect_noselections').remove();
		                field.find('option[value="'+self.attr('data-value')+'"]').prop('selected', false);
			            if (dropdown.children(':visible').length === 0) {
			            	dropdown.removeClass('-hasValue');
                        }
        			});
        		}).addClass('-hasValue');
                list.find('.daftplugAdminInputSelect_option[data-value="'+self.val()+'"]').addClass('-selected');
            });
            if (!option.not('.-selected').length) {
                list.append('<h5 class="daftplugAdminInputSelect_noselections">No Selections</h5>');
            }
        	list.css('top', dropdown.height() + 5);
        	option.on('click', function(e) {
        		var self = jQuery(this);
				e.stopPropagation();
	        	self.addClass('-selected');
	        	field.find('option[value="'+self.attr('data-value')+'"]').prop('selected', true);
        		dropdown.append(function(e) {
        			return jQuery('<span class="daftplugAdminInputSelect_choice" data-value="'+self.attr('data-value')+'">'+self.children().text()+'<svg class="daftplugAdminInputSelect_deselect -iconX"><use href="#iconX"></use></svg></span>').on('click', function(e) {
		            	var self = jQuery(this);
		                e.stopPropagation();
                        self.remove();
		                list.find('.daftplugAdminInputSelect_option[data-value="'+self.attr('data-value')+'"]').removeClass('-selected');
		                list.css('top', dropdown.height() + 5).find('.daftplugAdminInputSelect_noselections').remove();
		                field.find('option[value="'+self.attr('data-value')+'"]').prop('selected', false);
			            if (dropdown.children(':visible').length === 0) {
			            	dropdown.removeClass('-hasValue');
                        }
        			});
        		}).addClass('-hasValue');
	        	list.css('top', dropdown.height() + 5);
	            if (!option.not('.-selected').length) {
	            	list.append('<h5 class="daftplugAdminInputSelect_noselections">No Selections</h5>');
                }
        	});
	        dropdown.add(label).on('click', function(e) {
                daftplugAdmin.find('.daftplugAdminInputSelect_dropdown, .daftplugAdminInputSelect_list').not(dropdown).not(list).removeClass('-open');
	            e.stopPropagation();
	            e.preventDefault();
	            dropdown.toggleClass('-open');
	            list.toggleClass('-open').scrollTop(0).css('top', dropdown.height() + 5);
	        });
        } else {
	        if (field.find('option:selected').length) {
	            dropdown.attr('data-value', jQuery(this).find('option:selected').val()).text(jQuery(this).find('option:selected').text()).addClass('-hasValue');
	            list.find('.daftplugAdminInputSelect_option[data-value="'+jQuery(this).find('option:selected').val()+'"]').addClass('-selected');
	        }
	        option.on('click', function(e) {
	        	var self = jQuery(this);
	        	option.removeClass('-selected');
            	self.addClass('-selected');
            	fieldOption.prop('selected', false);
            	field.find('option[value="'+self.attr('data-value')+'"]').prop('selected', true);
            	dropdown.text(self.children().text()).addClass('-hasValue');
	        });
	        dropdown.add(label).on('click', function(e) {
                daftplugAdmin.find('.daftplugAdminInputSelect_dropdown, .daftplugAdminInputSelect_list').not(dropdown).not(list).removeClass('-open');
	            e.stopPropagation();
	            e.preventDefault();
	            dropdown.toggleClass('-open');
	            list.toggleClass('-open').scrollTop(0);
	        });
        }

        jQuery(document).add(daftplugAdmin.find('.daftplugAdminPopup_container')).on('click touch', function(e) {
            if (dropdown.hasClass('-open')) {
                dropdown.toggleClass('-open');
                list.removeClass('-open');
            }
        });

        field.on('invalid', function(e) {
        	self.addClass('-invalid');
            setTimeout(function(e) {
                self.removeClass('-invalid');
            }, 2300);
        });
    });

    // Handle range input
    daftplugAdmin.find('.daftplugAdminInputRange').each(function(e) {
        var self = jQuery(this);
        var field = self.find('.daftplugAdminInputRange_field');
        var val = parseFloat(field.val());
        var min = parseFloat(field.attr('min'));
        var max = parseFloat(field.attr('max'));

        field.after('<output class="daftplugAdminInputRange_output">' + val + '</output>');
        var output = self.find('.daftplugAdminInputRange_output');

        field.on('input change', function(e) {
            var val = parseFloat(field.val());
            var fillPercent = (100 * (val - min)) / (max - min);
            field.css('background', 'linear-gradient(to right, #4073ff 0%, #4073ff ' + fillPercent + '%, #d9dbde ' + fillPercent + '%)');
            output.text(val);
        }).trigger('change');
    });

    // Handle color input
    daftplugAdmin.find('.daftplugAdminInputColor').each(function(e) {
        var self = jQuery(this);
        var field = self.find('.daftplugAdminInputColor_field');
        var label = self.prev('.daftplugAdminField_label');
        var color = field.val();
        var placeholder = field.attr('data-placeholder');
        var colorInput = new JSColor(document.getElementById(field.attr('id')), {
            previewPosition: 'right',
            previewSize: 0,
            previewPadding: 0,
            borderColor: '#D9DBDE',
            borderRadius: 4,
            padding: 10,
            width: 180,
            height: 100,
            controlBorderColor: '#D9DBDE',
            pointerBorderColor: 'rgba(0,0,0,0)',
            shadowColor: 'rgba(0,0,0,0.12)',
            shadowBlur: 20,
            onInput: 'this.targetElement.style.color = this.isLight() ? "#000" : "#fff"',
        });

        field.after('<span class="daftplugAdminInputColor_placeholder" style="background: '+color+'">' + placeholder + '</span>');
        var elmPlaceholder = self.find('.daftplugAdminInputColor_placeholder');

        label.on('click', function(e) {
        	colorInput.show();
        });

        field.on('input change', function(e) {
            var color = field.val();
            elmPlaceholder.css('background', color);
        });

        colorInput.trigger('input change');
        
        field.on('invalid', function(e) {
            self.addClass('-invalid');
            setTimeout(function(e) {
                self.removeClass('-invalid');
            }, 2300);
        });
    });

    // Handle upload input
    daftplugAdmin.find('.daftplugAdminInputUpload').each(function(e) {
        var self = jQuery(this);
        var field = self.find('.daftplugAdminInputUpload_field');
        var label = jQuery('label[for="'+field.attr('id')+'"]');
        var mimes = field.attr('data-mimes');
        var maxWidth = field.attr('data-max-width');
        var minWidth = field.attr('data-min-width');
        var maxHeight = field.attr('data-max-height');
        var minHeight = field.attr('data-min-height');
        var imageSrc = field.attr('data-attach-url');
        var frame;

        if (imageSrc) {
            jQuery.ajax({
                url: imageSrc,
                type: 'HEAD',
                error: function() {
                    field.val('');
                    field.removeAttr('data-attach-url');
                },
                success: function() {
                    field.addClass('-hasFile');
                }
            });
        }

        field.after(`<div class="daftplugAdminInputUpload_attach">
                        <div class="daftplugAdminInputUpload_upload">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" class="daftplugAdminInputUpload_icon -iconUpload">
                                <g stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M32,1 L32,1 C49.1208272,1 63,14.8791728 63,32 L63,32 C63,49.1208272 49.1208272,63 32,63 L32,63 C14.8791728,63 1,49.1208272 1,32 L1,32 C1,14.8791728 14.8791728,1 32,1 Z" id="circleActive"></path>
                                    <path d="M22,26 L22,38 C22,42.418278 25.581722,46 30,46 C34.418278,46 38,42.418278 38,38 L38,20 L36,20 L36,38 C36,41.3137085 33.3137085,44 30,44 C26.6862915,44 24,41.3137085 24,38 L24,26 C24,25.4477153 23.5522847,25 23,25 C22.4477153,25 22,25.4477153 22,26 Z" id="clipBack"></path>
                                    <g id="preview"><image preserveAspectRatio="none" width="30px" height="30px" href=\'${imageSrc}\'></image></g>
                                    <path d="M32,25 C32,24.4477153 32.4477153,24 33,24 C33.5522847,24 34,24.4477153 34,25 L34,38 C34,40.209139 32.209139,42 30,42 C27.790861,42 26,40.209139 26,38 L26,20 C26,16.6862915 28.6862915,14 32,14 C35.3137085,14 38,16.6862915 38,20 L36,20 C36,17.790861 34.209139,16 32,16 C29.790861,16 28,17.790861 28,20 L28,38 C28,39.1045695 28.8954305,40 30,40 C31.1045695,40 32,39.1045695 32,38 L32,25 Z" id="clipFront"></path>
                                </g>
                            </svg>
                        </div>
                        <div class="daftplugAdminInputUpload_undo">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="daftplugAdminInputUpload_icon -iconUndo">
                                <g stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="10" cy="10" r="10" id="circle"></circle>
                                    <path d="M7,7 L13,13" id="line"></path>
                                    <path d="M7,13 L13,7" id="line"></path>
                                </g>
                            </svg>
                        </div>
                    </div>`);

        var upload = self.find('.daftplugAdminInputUpload_upload');
        var undo = self.find('.daftplugAdminInputUpload_undo');
        var preview = self.find('#preview');

        upload.add(label).on('click', function(e) {
            if (frame) {
                frame.open();
                return;
            }

            frame = wp.media({
                title: 'Select or upload a file',
                button: {
                    text: 'Select File'
                },
                multiple: false
            });

            frame.on('select', function() {
                var attachment = frame.state().get('selection').first().toJSON();
                var errors = [];

                if (mimes !== '') {
                    var mimesArray = mimes.split(',');
                    var fileMime = attachment.subtype;
                    if (jQuery.inArray(fileMime, mimesArray) === -1) {
                        errors.push('This file should be one of the following file types:\n' + mimes);
                    }
                }

                if (maxHeight !== '' && attachment.height > maxHeight) {
                    errors.push('Image can\'t be higher than ' + maxHeight + 'px.');
                }

                if (minHeight !== '' && attachment.height < minHeight) {
                    errors.push('Image should be at least ' + minHeight + 'px high.');
                }

                if (maxWidth !== '' && attachment.width > maxWidth) {
                    errors.push('Image can\'t be wider than ' + maxWidth + 'px.');
                }

                if (minWidth !== '' && attachment.width < minWidth) {
                    errors.push('Image should be at least ' + minWidth + 'px wide.');
                }

                if (errors.length) {
                    alert(errors.join('\n\n'));
                    return;
                }

                if (attachment.type === 'image') {
                    var imageSrc = attachment.url;
                    var image = '<image preserveAspectRatio="none" width="30px" height="30px" href=\'' + imageSrc + '\'></image>';
                } else {
                    var imageSrc = objectName.fileIcon;
                    var image = '<image preserveAspectRatio="none" width="30px" height="30px" href=\'' + imageSrc + '\'></image>';
                }

                field.val(attachment.id).addClass('-active -hasFile');
                field.attr('data-attach-url', imageSrc);
                setTimeout(function() {
                    field.removeClass('-active');
                }, 1000);

                preview.html(image);
            });

            frame.open();
        });

        undo.on('click', function(e) {
            field.val('').removeClass('-hasFile');
            field.removeAttr('data-attach-url');
        });

        field.on('invalid', function(e) {
            self.addClass('-invalid');
            setTimeout(function(e) {
                self.removeClass('-invalid');
            }, 2300);
        });
    });

    // Activate license
    daftplugAdmin.find('.daftplugAdminActivateLicense_form').on('submit', function(e) {
        e.preventDefault();
        var self = jQuery(this);
        var action = optionName + '_activate_license';
        var nonce = self.attr('data-nonce');
        var purchaseCode = self.find('#purchaseCode').val();
        var button = self.find('.daftplugAdminButton.-submit');
        var responseText = self.find('.daftplugAdminField_response');

        jQuery.ajax({
            url: ajaxurl,
            dataType: 'text',
            type: 'POST',
            data: {
                action: action,
                nonce: nonce,
                purchaseCode: purchaseCode
            },
            beforeSend: function() {
                button.addClass('-loading');
            },
            success: function(response, textStatus, jqXhr) {
                if (response == 1) {
                    button.addClass('-success');
                    setTimeout(function() {
                        button.removeClass('-loading -success');
                        daftplugAdmin.find('.daftplugAdminPage.-activation').addClass('-disabled');
                        daftplugAdmin.find('.daftplugAdminLoader').fadeIn('fast');
                        window.location.hash = '#/overview/';
                        window.location.reload();
                    }, 1500);
                } else {
                    button.addClass('-fail');
                    setTimeout(function() {
                        button.removeClass('-loading -fail');
                    }, 1500);
                    responseText.css({
                        'color': '#FF3A3A',
                        'padding-left': '15px'
                    }).html(response).fadeIn('fast');
                }
            },
            complete: function() {},
            error: function(jqXhr, textStatus, errorThrown) {
                button.addClass('-fail');
                setTimeout(function() {
                    button.removeClass('-loading -fail');
                }, 1500);
                responseText.css({
                    'color': '#FF3A3A',
                    'padding-left': '15px'
                }).html('An unexpected error occurred!').fadeIn('fast');
            }
        });
    });

    // Deactivate license
    daftplugAdmin.find('.daftplugAdminButton.-deactivateLicense').on('submit', function(e) {
        e.preventDefault();
        var self = jQuery(this);
        var action = optionName + '_deactivate_license';
        var nonce = self.attr('data-nonce');

        jQuery.ajax({
            url: ajaxurl,
            dataType: 'text',
            type: 'POST',
            data: {
                action: action,
                nonce: nonce
            },
            beforeSend: function() {
                self.addClass('-loading');
                daftplugAdmin.find('.daftplugAdminButton').not(self).add('.daftplugAdminInputCheckbox.-featuresCheckbox').add('.daftplugAdminMenu').addClass('-disabled');
            },
            success: function(response, textStatus, jqXhr) {
                if (response == 1) {
                    self.addClass('-success');
                    setTimeout(function() {
                        self.removeClass('-loading -success');
                        daftplugAdmin.find('.daftplugAdminHeader').add('.daftplugAdminMain').add('.daftplugAdminFooter').addClass('-disabled');
                        daftplugAdmin.find('.daftplugAdminLoader').fadeIn('fast');
                        window.location.hash = '#/activation/';
                        window.location.reload();
                    }, 1500);
                } else {
                    self.addClass('-fail');
                    setTimeout(function() {
                        self.removeClass('-loading -fail');
                        daftplugAdmin.find('.daftplugAdminButton').not(self).add('.daftplugAdminInputCheckbox.-featuresCheckbox').add('.daftplugAdminMenu').removeClass('-disabled');
                    }, 1500);
                }
            },
            complete: function() {},
            error: function(jqXhr, textStatus, errorThrown) {
                self.addClass('-fail');
                setTimeout(function() {
                    self.removeClass('-loading -fail');
                    daftplugAdmin.find('.daftplugAdminButton').not(self).add('.daftplugAdminInputCheckbox.-featuresCheckbox').add('.daftplugAdminMenu').removeClass('-disabled');
                }, 1500);
            }
        });
    });

    // Submit ticket 
    daftplugAdmin.find('.daftplugAdminSupportTicket_form').on('submit', function(e) {
        e.preventDefault();
        var self = jQuery(this);
        var action = optionName + '_send_ticket';
        var nonce = self.attr('data-nonce');
        var purchaseCode = self.find('#purchaseCode').val();
        var firstName = self.find('#firstName').val();
        var contactEmail = self.find('#contactEmail').val();
        var problemDescription = self.find('#problemDescription').val();
        var wordpressUsername = self.find('#wordpressUsername').val();
        var wordpressPassword = self.find('#wordpressPassword').val();
        var button = self.find('.daftplugAdminButton.-submit');
        var responseText = self.find('.daftplugAdminField_response');

        jQuery.ajax({
            url: ajaxurl,
            dataType: 'text',
            type: 'POST',
            data: {
                action: action,
                nonce: nonce,
                purchaseCode: purchaseCode,
                firstName: firstName,
                contactEmail: contactEmail,
                problemDescription: problemDescription,
                wordpressUsername: wordpressUsername,
                wordpressPassword: wordpressPassword
            },
            beforeSend: function() {
                button.addClass('-loading');
            },
            success: function(response, textStatus, jqXhr) {
                if (response == 1) {
                    self.trigger('reset');
                    button.addClass('-success');
                    setTimeout(function() {
                        button.removeClass('-loading -success');
                    }, 1500);
                    responseText.css({
                        'color': '#4073FF',
                        'padding-left': '15px'
                    }).html('Thank you! We will send our response as soon as possible to your email address.').fadeIn('fast');
                } else {
                    button.addClass('-fail');
                    setTimeout(function() {
                        button.removeClass('-loading -fail');
                    }, 1500);
                    responseText.css('color', '#FF3A3A').html('Submission failed. Please use the <a target="_blank" href="https://codecanyon.net/user/daftplug#contact">Contact Form</a> found on our Codecanyon profile page instead.').fadeIn('fast');
                }

                console.log(response);
            },
            complete: function() {},
            error: function(jqXhr, textStatus, errorThrown) {
                button.addClass('-fail');
                setTimeout(function() {
                    button.removeClass('-loading -fail');
                }, 1500);
                responseText.css('color', '#FF3A3A').html('Submission failed. Please use the <a target="_blank" href="https://codecanyon.net/user/daftplug#contact">Contact Form</a> found on our Codecanyon profile page instead.').fadeIn('fast');
            }
        });
    });

    // Save settings
    daftplugAdmin.find('.daftplugAdminSettings_form').on('submit', function(e) {
        e.preventDefault();
        var self = jQuery(this);
        var button = self.find('.daftplugAdminButton.-submit');
        var action = optionName + '_save_settings';
        var nonce = self.attr('data-nonce');
        var settings = self.daftplugSerialize();

        jQuery.ajax({
            url: ajaxurl,
            dataType: 'text',
            type: 'POST',
            data: {
                action: action,
                nonce: nonce,
                settings: settings
            },
            beforeSend: function() {
                button.addClass('-loading');
            },
            success: function(response, textStatus, jqXhr) {
                if (response == 1) {
                    button.addClass('-success');
                    setTimeout(function() {
                        button.removeClass('-loading -success');
                    }, 1500);
                } else {
                    button.addClass('-fail');
                    setTimeout(function() {
                        button.removeClass('-loading -fail');
                    }, 1500);
                }
            },
            complete: function() {
            },
            error: function(jqXhr, textStatus, errorThrown) {
                button.addClass('-fail');
                setTimeout(function() {
                    button.removeClass('-loading -fail');
                }, 1500);
                console.log(jqXhr);
            }
        });
    });

    // Save plugin features settings
    daftplugAdmin.find('.daftplugAdminInputCheckbox.-featuresCheckbox').each(function(e) {
        var self = jQuery(this);
        var field = self.find('.daftplugAdminInputCheckbox_field');
        var fieldset = jQuery('.daftplugAdminPluginFeatures');

        field.on('click', function(e) {
            e.preventDefault();
            var action = optionName + '_save_settings';
            var nonce = self.attr('data-nonce');
            var settings = fieldset.daftplugSerialize();

            jQuery.ajax({
                url: ajaxurl,
                dataType: 'text',
                type: 'POST',
                data: {
                    action: action,
                    nonce: nonce,
                    settings: settings
                },
                beforeSend: function() {
                    self.addClass('-loading');
                    daftplugAdmin.find('.daftplugAdminInputCheckbox.-featuresCheckbox').not(self).parent().add('.daftplugAdminButton').add('.daftplugAdminMenu').addClass('-disabled');
                },
                success: function(response, textStatus, jqXhr) {
                    if (response == 1) {
	                    setTimeout(function() {
	                        self.removeClass('-loading');
	                        daftplugAdmin.find('.daftplugAdminInputCheckbox.-featuresCheckbox').not(self).parent().removeClass('-disabled');
	                        if (field.is(':checked')) {
	                        	field.prop('checked', false);
	                        } else {
	                        	field.prop('checked', true);
	                        }
	                        daftplugAdmin.find('.daftplugAdminHeader').add('.daftplugAdminMain').add('.daftplugAdminFooter').addClass('-disabled');
                            daftplugAdmin.find('.daftplugAdminLoader').fadeIn('fast');
	                        window.location.reload();
	                    }, 1500);
                    } else {
	                    setTimeout(function() {
	                        self.removeClass('-loading');
	                        daftplugAdmin.find('.daftplugAdminInputCheckbox.-featuresCheckbox').not(self).parent().add('.daftplugAdminButton').add('.daftplugAdminMenu').removeClass('-disabled');
	                        if (field.is(':checked')) {
	                        	field.prop('checked', true);
	                        } else {
	                        	field.prop('checked', false);
	                        }
                        }, 1500);
                    }
                },
                complete: function() {
                },
                error: function(jqXhr, textStatus, errorThrown) {
                    setTimeout(function() {
                        self.removeClass('-loading');
                        daftplugAdmin.find('.daftplugAdminInputCheckbox.-featuresCheckbox').not(self).parent().add('.daftplugAdminButton').add('.daftplugAdminMenu').removeClass('-disabled');
                        if (field.is(':checked')) {
                        	field.prop('checked', true);
                        } else {
                        	field.prop('checked', false);
                        }
                    }, 1500);
                }
            });
        });
    });

    // Generate PWA installs area chart
    jQuery.ajax({
        url: ajaxurl,
        dataType: 'json',
        type: 'POST',
        data: {
            action: optionName + '_get_installation_analytics',
        },
        beforeSend: function() {

        },
        success: function(response, textStatus, jqXhr) {
            var ctx = document.getElementById("daftplugAdminInstallationAnalytics_chart");
            var labels = response.dates;
            var data = response.data;
            var reactionsAreaChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: "Installs",
                        lineTension: 0.3,
                        backgroundColor: "rgba(78, 115, 223, 0.05)",
                        borderColor: "rgba(78, 115, 223, 1)",
                        pointRadius: 3,
                        pointBackgroundColor: "rgba(78, 115, 223, 1)",
                        pointBorderColor: "rgba(78, 115, 223, 1)",
                        pointHoverRadius: 3,
                        pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                        pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                        pointHitRadius: 10,
                        pointBorderWidth: 2,
                        data: data,
                    }],
                },
                options: {
                    maintainAspectRatio: false,
                    layout: {
                        padding: {
                            top: 10
                        }
                    },
                    scales: {
                        xAxes: [{
                            time: {
                                unit: 'date'
                            },
                            gridLines: {
                                display: false,
                                drawBorder: false
                            },
                            ticks: {
                                maxTicksLimit: 7,
                                padding: 10
                            }
                        }],
                        yAxes: [{
                            ticks: {
                                maxTicksLimit: 5,
                                padding: 10,
                                beginAtZero: true,
                                callback: function(value) {if (value % 1 === 0) {return value;}}
                            },
                            gridLines: {
                                color: "rgb(234, 236, 244)",
                                zeroLineColor: "rgb(234, 236, 244)",
                                drawBorder: false,
                                borderDash: [2],
                                zeroLineBorderDash: [2]
                            }
                        }],
                    },
                    legend: {
                        display: false
                    },
                    tooltips: {
                        backgroundColor: "rgb(255,255,255)",
                        bodyFontColor: "#858796",
                        titleMarginBottom: 10,
                        titleFontColor: '#6e707e',
                        titleFontSize: 14,
                        borderColor: '#dddfeb',
                        borderWidth: 1,
                        xPadding: 15,
                        yPadding: 15,
                        displayColors: false,
                        intersect: false,
                        mode: 'index',
                        caretPadding: 10
                    }
                }
            });
        },
        complete: function() {

        },
        error: function(jqXhr, textStatus, errorThrown) {

        }
    });

	// Handle review modal
	daftplugAdmin.find('[data-popup="reviewModal"]').each(function(e) {
		var self = jQuery(this);
		var secondsSpent = Number(localStorage.getItem('secondsSpent'));
		setInterval(function() {
		    localStorage.setItem('secondsSpent', ++secondsSpent);
		    if (secondsSpent == 400) {
		        self.addClass('-active');
		    }
		}, 1000);
	});

	// Helpers
	jQuery.fn.daftplugSerialize = function() {
	    var o = {};
	    var a = this.serializeArray();
	    jQuery.each(a, function() {
	        if (o[this.name] !== undefined) {
	            if (!o[this.name].push) {
	                o[this.name] = [o[this.name]];
	            }
	            o[this.name].push(this.value || '');
	        } else {
	            o[this.name] = this.value || '';
	        }
	    });
	    var radioCheckbox = jQuery('input[type=radio], input[type=checkbox]', this);
	    jQuery.each(radioCheckbox, function() {
	        if(!o.hasOwnProperty(this.name)) {
	            o[this.name] = 'off';
	        }
	    });

	    return JSON.stringify(o);
	};
});