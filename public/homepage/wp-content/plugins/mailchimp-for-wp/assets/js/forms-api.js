(function(){var require=undefined;var define=undefined;(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){'use strict';var mc4wp=window.mc4wp||{};var Gator=require('gator');var forms=require('./forms/forms.js');var config=window.mc4wp_forms_config||{};function scrollToForm(form){var animate=config.auto_scroll==='animated';var args={behavior:animate?"smooth":"instant"};form.element.scrollIntoView(args);}
function handleFormRequest(form,action,errors,data){var pageHeight=document.body.clientHeight;var timeStart=Date.now();if(errors){form.setData(data);}
if(config.auto_scroll){scrollToForm(form);}
window.addEventListener('load',function(){var timeElapsed=Date.now()- timeStart;if(config.auto_scroll&&timeElapsed<800&&document.body.clientHeight!=pageHeight){scrollToForm(form);}
forms.trigger('submitted',[form]);forms.trigger(form.id+'.submitted',[form]);if(errors){forms.trigger('error',[form,errors]);forms.trigger(form.id+'.error',[form,errors]);}else{forms.trigger('success',[form,data]);forms.trigger(form.id+'.success',[form,data]);forms.trigger(action+"d",[form,data]);forms.trigger(form.id+"."+ action+"d",[form,data]);}});}
function toggleElement(el,expectedValue,show){return function(){var value=this.value.trim();var checked=this.getAttribute('type')!=='radio'&&this.getAttribute('type')!=='checked'||this.checked;var conditionMet=checked&&(value===expectedValue&&expectedValue!==""||expectedValue===""&&value.length>0);if(show){el.style.display=conditionMet?'':'none';}else{el.style.display=conditionMet?'none':'';}};}
function toggleConditionalElements(){var input=this;var elements=input.form.querySelectorAll('[data-show-if], [data-hide-if]');var inputName=(input.getAttribute('name')||'').toLowerCase();[].forEach.call(elements,function(el){var show=!!el.getAttribute('data-show-if');var conditions=show?el.getAttribute('data-show-if').split(':'):el.getAttribute('data-hide-if').split(':');var nameCondition=conditions[0];var valueCondition=conditions[1]||"";if(inputName!==nameCondition.toLowerCase()){return;}
var callback=toggleElement(el,valueCondition,show);callback.call(input);});}
Gator(document.body).on('keyup','.mc4wp-form input, .mc4wp-form textarea, .mc4wp-form select',toggleConditionalElements);Gator(document.body).on('change','.mc4wp-form input, .mc4wp-form textarea, .mc4wp-form select',toggleConditionalElements);window.addEventListener('load',function(){[].forEach.call(document.querySelectorAll('.mc4wp-form input, .mc4wp-form textarea, .mc4wp-form select'),function(el){toggleConditionalElements.call(el);});});Gator(document.body).on('submit','.mc4wp-form',function(event){var form=forms.getByElement(event.target||event.srcElement);forms.trigger('submit',[form,event]);forms.trigger(form.id+'.submit',[form,event]);});Gator(document.body).on('focus','.mc4wp-form',function(event){var form=forms.getByElement(event.target||event.srcElement);if(!form.started){forms.trigger('started',[form,event]);forms.trigger(form.id+'.started',[form,event]);form.started=true;}});Gator(document.body).on('change','.mc4wp-form',function(event){var form=forms.getByElement(event.target||event.srcElement);forms.trigger('change',[form,event]);forms.trigger(form.id+'.change',[form,event]);});if(mc4wp.listeners){var listeners=mc4wp.listeners;for(var i=0;i<listeners.length;i++){forms.on(listeners[i].event,listeners[i].callback);}
delete mc4wp["listeners"];}
mc4wp.forms=forms;if(config.submitted_form){var formConfig=config.submitted_form,element=document.getElementById(formConfig.element_id),form=forms.getByElement(element);handleFormRequest(form,formConfig.action,formConfig.errors,formConfig.data);}
window.mc4wp=mc4wp;},{"./forms/forms.js":3,"gator":5}],2:[function(require,module,exports){'use strict';var serialize=require('form-serialize');var populate=require('populate.js');var Form=function Form(id,element){this.id=id;this.element=element||document.createElement('form');this.name=this.element.getAttribute('data-name')||"Form #"+ this.id;this.errors=[];this.started=false;};Form.prototype.setData=function(data){try{populate(this.element,data);}catch(e){console.error(e);}};Form.prototype.getData=function(){return serialize(this.element,{hash:true});};Form.prototype.getSerializedData=function(){return serialize(this.element);};Form.prototype.setResponse=function(msg){this.element.querySelector('.mc4wp-response').innerHTML=msg;};Form.prototype.reset=function(){this.setResponse('');this.element.querySelector('.mc4wp-form-fields').style.display='';this.element.reset();};module.exports=Form;},{"form-serialize":4,"populate.js":6}],3:[function(require,module,exports){'use strict';var EventEmitter=require('wolfy87-eventemitter');var Form=require('./form.js');var events=new EventEmitter();var forms=[];function get(formId){for(var i=0;i<forms.length;i++){if(forms[i].id==formId){return forms[i];}}
var formElement=document.querySelector('.mc4wp-form-'+ formId);return createFromElement(formElement,formId);}
function getByElement(element){var formElement=element.form||element;for(var i=0;i<forms.length;i++){if(forms[i].element==formElement){return forms[i];}}
return createFromElement(formElement);}
function createFromElement(formElement,id){id=id||parseInt(formElement.getAttribute('data-id'))||0;var form=new Form(id,formElement);forms.push(form);return form;}
function all(){return forms;}
module.exports={"all":all,"get":get,"getByElement":getByElement,"on":events.on.bind(events),"trigger":events.trigger.bind(events),"off":events.off.bind(events)};},{"./form.js":2,"wolfy87-eventemitter":7}],4:[function(require,module,exports){var k_r_submitter=/^(?:submit|button|image|reset|file)$/i;var k_r_success_contrls=/^(?:input|select|textarea|keygen)/i;var brackets=/(\[[^\[\]]*\])/g;function serialize(form,options){if(typeof options!='object'){options={hash:!!options};}
else if(options.hash===undefined){options.hash=true;}
var result=(options.hash)?{}:'';var serializer=options.serializer||((options.hash)?hash_serializer:str_serialize);var elements=form&&form.elements?form.elements:[];var radio_store=Object.create(null);for(var i=0;i<elements.length;++i){var element=elements[i];if((!options.disabled&&element.disabled)||!element.name){continue;}
if(!k_r_success_contrls.test(element.nodeName)||k_r_submitter.test(element.type)){continue;}
var key=element.name;var val=element.value;if((element.type==='checkbox'||element.type==='radio')&&!element.checked){val=undefined;}
if(options.empty){if(element.type==='checkbox'&&!element.checked){val='';}
if(element.type==='radio'){if(!radio_store[element.name]&&!element.checked){radio_store[element.name]=false;}
else if(element.checked){radio_store[element.name]=true;}}
if(val==undefined&&element.type=='radio'){continue;}}
else{if(!val){continue;}}
if(element.type==='select-multiple'){val=[];var selectOptions=element.options;var isSelectedOptions=false;for(var j=0;j<selectOptions.length;++j){var option=selectOptions[j];var allowedEmpty=options.empty&&!option.value;var hasValue=(option.value||allowedEmpty);if(option.selected&&hasValue){isSelectedOptions=true;if(options.hash&&key.slice(key.length- 2)!=='[]'){result=serializer(result,key+'[]',option.value);}
else{result=serializer(result,key,option.value);}}}
if(!isSelectedOptions&&options.empty){result=serializer(result,key,'');}
continue;}
result=serializer(result,key,val);}
if(options.empty){for(var key in radio_store){if(!radio_store[key]){result=serializer(result,key,'');}}}
return result;}
function parse_keys(string){var keys=[];var prefix=/^([^\[\]]*)/;var children=new RegExp(brackets);var match=prefix.exec(string);if(match[1]){keys.push(match[1]);}
while((match=children.exec(string))!==null){keys.push(match[1]);}
return keys;}
function hash_assign(result,keys,value){if(keys.length===0){result=value;return result;}
var key=keys.shift();var between=key.match(/^\[(.+?)\]$/);if(key==='[]'){result=result||[];if(Array.isArray(result)){result.push(hash_assign(null,keys,value));}
else{result._values=result._values||[];result._values.push(hash_assign(null,keys,value));}
return result;}
if(!between){result[key]=hash_assign(result[key],keys,value);}
else{var string=between[1];var index=+string;if(isNaN(index)){result=result||{};result[string]=hash_assign(result[string],keys,value);}
else{result=result||[];result[index]=hash_assign(result[index],keys,value);}}
return result;}
function hash_serializer(result,key,value){var matches=key.match(brackets);if(matches){var keys=parse_keys(key);hash_assign(result,keys,value);}
else{var existing=result[key];if(existing){if(!Array.isArray(existing)){result[key]=[existing];}
result[key].push(value);}
else{result[key]=value;}}
return result;}
function str_serialize(result,key,value){value=value.replace(/(\r)?\n/g,'\r\n');value=encodeURIComponent(value);value=value.replace(/%20/g,'+');return result+(result?'&':'')+ encodeURIComponent(key)+'='+ value;}
module.exports=serialize;},{}],5:[function(require,module,exports){(function(){var _matcher,_level=0,_id=0,_handlers={},_gatorInstances={};function _addEvent(gator,type,callback){var useCapture=type=='blur'||type=='focus';gator.element.addEventListener(type,callback,useCapture);}
function _cancel(e){e.preventDefault();e.stopPropagation();}
function _getMatcher(element){if(_matcher){return _matcher;}
if(element.matches){_matcher=element.matches;return _matcher;}
if(element.webkitMatchesSelector){_matcher=element.webkitMatchesSelector;return _matcher;}
if(element.mozMatchesSelector){_matcher=element.mozMatchesSelector;return _matcher;}
if(element.msMatchesSelector){_matcher=element.msMatchesSelector;return _matcher;}
if(element.oMatchesSelector){_matcher=element.oMatchesSelector;return _matcher;}
_matcher=Gator.matchesSelector;return _matcher;}
function _matchesSelector(element,selector,boundElement){if(selector=='_root'){return boundElement;}
if(element===boundElement){return;}
if(_getMatcher(element).call(element,selector)){return element;}
if(element.parentNode){_level++;return _matchesSelector(element.parentNode,selector,boundElement);}}
function _addHandler(gator,event,selector,callback){if(!_handlers[gator.id]){_handlers[gator.id]={};}
if(!_handlers[gator.id][event]){_handlers[gator.id][event]={};}
if(!_handlers[gator.id][event][selector]){_handlers[gator.id][event][selector]=[];}
_handlers[gator.id][event][selector].push(callback);}
function _removeHandler(gator,event,selector,callback){if(!_handlers[gator.id]){return;}
if(!event){for(var type in _handlers[gator.id]){if(_handlers[gator.id].hasOwnProperty(type)){_handlers[gator.id][type]={};}}
return;}
if(!callback&&!selector){_handlers[gator.id][event]={};return;}
if(!callback){delete _handlers[gator.id][event][selector];return;}
if(!_handlers[gator.id][event][selector]){return;}
for(var i=0;i<_handlers[gator.id][event][selector].length;i++){if(_handlers[gator.id][event][selector][i]===callback){_handlers[gator.id][event][selector].splice(i,1);break;}}}
function _handleEvent(id,e,type){if(!_handlers[id][type]){return;}
var target=e.target||e.srcElement,selector,match,matches={},i=0,j=0;_level=0;for(selector in _handlers[id][type]){if(_handlers[id][type].hasOwnProperty(selector)){match=_matchesSelector(target,selector,_gatorInstances[id].element);if(match&&Gator.matchesEvent(type,_gatorInstances[id].element,match,selector=='_root',e)){_level++;_handlers[id][type][selector].match=match;matches[_level]=_handlers[id][type][selector];}}}
e.stopPropagation=function(){e.cancelBubble=true;};for(i=0;i<=_level;i++){if(matches[i]){for(j=0;j<matches[i].length;j++){if(matches[i][j].call(matches[i].match,e)===false){Gator.cancel(e);return;}
if(e.cancelBubble){return;}}}}}
function _bind(events,selector,callback,remove){if(!this.element){return;}
if(!(events instanceof Array)){events=[events];}
if(!callback&&typeof(selector)=='function'){callback=selector;selector='_root';}
var id=this.id,i;function _getGlobalCallback(type){return function(e){_handleEvent(id,e,type);};}
for(i=0;i<events.length;i++){if(remove){_removeHandler(this,events[i],selector,callback);continue;}
if(!_handlers[id]||!_handlers[id][events[i]]){Gator.addEvent(this,events[i],_getGlobalCallback(events[i]));}
_addHandler(this,events[i],selector,callback);}
return this;}
function Gator(element,id){if(!(this instanceof Gator)){for(var key in _gatorInstances){if(_gatorInstances[key].element===element){return _gatorInstances[key];}}
_id++;_gatorInstances[_id]=new Gator(element,_id);return _gatorInstances[_id];}
this.element=element;this.id=id;}
Gator.prototype.on=function(events,selector,callback){return _bind.call(this,events,selector,callback);};Gator.prototype.off=function(events,selector,callback){return _bind.call(this,events,selector,callback,true);};Gator.matchesSelector=function(){};Gator.cancel=_cancel;Gator.addEvent=_addEvent;Gator.matchesEvent=function(){return true;};if(typeof module!=='undefined'&&module.exports){module.exports=Gator;}
window.Gator=Gator;})();},{}],6:[function(require,module,exports){;(function(root){var populate=function(form,data,basename){for(var key in data){if(!data.hasOwnProperty(key)){continue;}
var name=key;var value=data[key];if('undefined'===typeof value){value='';}
if(null===value){value='';}
if(typeof(basename)!=="undefined"){name=basename+"["+ key+"]";}
if(value.constructor===Array){name+='[]';}else if(typeof value=="object"){populate(form,value,name);continue;}
var element=form.elements.namedItem(name);if(!element){continue;}
var type=element.type||element[0].type;switch(type){default:element.value=value;break;case'radio':case'checkbox':for(var j=0;j<element.length;j++){element[j].checked=(value.indexOf(element[j].value)>-1);}
break;case'select-multiple':var values=value.constructor==Array?value:[value];for(var k=0;k<element.options.length;k++){element.options[k].selected|=(values.indexOf(element.options[k].value)>-1);}
break;case'select':case'select-one':element.value=value.toString()||value;break;case'date':element.value=new Date(value).toISOString().split('T')[0];break;}}};if(typeof define=='function'&&typeof define.amd=='object'&&define.amd){define(function(){return populate;});}else if(typeof module!=='undefined'&&module.exports){module.exports=populate;}else{root.populate=populate;}}(this));},{}],7:[function(require,module,exports){;(function(exports){'use strict';function EventEmitter(){}
var proto=EventEmitter.prototype;var originalGlobalValue=exports.EventEmitter;function indexOfListener(listeners,listener){var i=listeners.length;while(i--){if(listeners[i].listener===listener){return i;}}
return-1;}
function alias(name){return function aliasClosure(){return this[name].apply(this,arguments);};}
proto.getListeners=function getListeners(evt){var events=this._getEvents();var response;var key;if(evt instanceof RegExp){response={};for(key in events){if(events.hasOwnProperty(key)&&evt.test(key)){response[key]=events[key];}}}
else{response=events[evt]||(events[evt]=[]);}
return response;};proto.flattenListeners=function flattenListeners(listeners){var flatListeners=[];var i;for(i=0;i<listeners.length;i+=1){flatListeners.push(listeners[i].listener);}
return flatListeners;};proto.getListenersAsObject=function getListenersAsObject(evt){var listeners=this.getListeners(evt);var response;if(listeners instanceof Array){response={};response[evt]=listeners;}
return response||listeners;};function isValidListener(listener){if(typeof listener==='function'||listener instanceof RegExp){return true}else if(listener&&typeof listener==='object'){return isValidListener(listener.listener)}else{return false}}
proto.addListener=function addListener(evt,listener){if(!isValidListener(listener)){throw new TypeError('listener must be a function');}
var listeners=this.getListenersAsObject(evt);var listenerIsWrapped=typeof listener==='object';var key;for(key in listeners){if(listeners.hasOwnProperty(key)&&indexOfListener(listeners[key],listener)===-1){listeners[key].push(listenerIsWrapped?listener:{listener:listener,once:false});}}
return this;};proto.on=alias('addListener');proto.addOnceListener=function addOnceListener(evt,listener){return this.addListener(evt,{listener:listener,once:true});};proto.once=alias('addOnceListener');proto.defineEvent=function defineEvent(evt){this.getListeners(evt);return this;};proto.defineEvents=function defineEvents(evts){for(var i=0;i<evts.length;i+=1){this.defineEvent(evts[i]);}
return this;};proto.removeListener=function removeListener(evt,listener){var listeners=this.getListenersAsObject(evt);var index;var key;for(key in listeners){if(listeners.hasOwnProperty(key)){index=indexOfListener(listeners[key],listener);if(index!==-1){listeners[key].splice(index,1);}}}
return this;};proto.off=alias('removeListener');proto.addListeners=function addListeners(evt,listeners){return this.manipulateListeners(false,evt,listeners);};proto.removeListeners=function removeListeners(evt,listeners){return this.manipulateListeners(true,evt,listeners);};proto.manipulateListeners=function manipulateListeners(remove,evt,listeners){var i;var value;var single=remove?this.removeListener:this.addListener;var multiple=remove?this.removeListeners:this.addListeners;if(typeof evt==='object'&&!(evt instanceof RegExp)){for(i in evt){if(evt.hasOwnProperty(i)&&(value=evt[i])){if(typeof value==='function'){single.call(this,i,value);}
else{multiple.call(this,i,value);}}}}
else{i=listeners.length;while(i--){single.call(this,evt,listeners[i]);}}
return this;};proto.removeEvent=function removeEvent(evt){var type=typeof evt;var events=this._getEvents();var key;if(type==='string'){delete events[evt];}
else if(evt instanceof RegExp){for(key in events){if(events.hasOwnProperty(key)&&evt.test(key)){delete events[key];}}}
else{delete this._events;}
return this;};proto.removeAllListeners=alias('removeEvent');proto.emitEvent=function emitEvent(evt,args){var listenersMap=this.getListenersAsObject(evt);var listeners;var listener;var i;var key;var response;for(key in listenersMap){if(listenersMap.hasOwnProperty(key)){listeners=listenersMap[key].slice(0);for(i=0;i<listeners.length;i++){listener=listeners[i];if(listener.once===true){this.removeListener(evt,listener.listener);}
response=listener.listener.apply(this,args||[]);if(response===this._getOnceReturnValue()){this.removeListener(evt,listener.listener);}}}}
return this;};proto.trigger=alias('emitEvent');proto.emit=function emit(evt){var args=Array.prototype.slice.call(arguments,1);return this.emitEvent(evt,args);};proto.setOnceReturnValue=function setOnceReturnValue(value){this._onceReturnValue=value;return this;};proto._getOnceReturnValue=function _getOnceReturnValue(){if(this.hasOwnProperty('_onceReturnValue')){return this._onceReturnValue;}
else{return true;}};proto._getEvents=function _getEvents(){return this._events||(this._events={});};EventEmitter.noConflict=function noConflict(){exports.EventEmitter=originalGlobalValue;return EventEmitter;};if(typeof define==='function'&&define.amd){define(function(){return EventEmitter;});}
else if(typeof module==='object'&&module.exports){module.exports=EventEmitter;}
else{exports.EventEmitter=EventEmitter;}}(this||{}));},{}]},{},[1]);})();