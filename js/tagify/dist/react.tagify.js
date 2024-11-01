/**
 * Tagify (v 4.3.1) - tags input component
 * By Yair Even-Or
 * Don't sell this code. (c)
 * https://github.com/yairEO/tagify
 */

!function(e,n){"function"==typeof define&&define.amd?define([],n):"object"==typeof exports?module.exports=n():e.React.tagify=n()}(this,(function(){"use strict";Object.defineProperty(exports,"__esModule",{value:!0}),exports.default=exports.MixedTags=void 0;var e,n=function(e){if(e&&e.__esModule)return e;if(null===e||"object"!=typeof e&&"function"!=typeof e)return{default:e};var n=u();if(n&&n.has(e))return n.get(e);var t={},o=Object.defineProperty&&Object.getOwnPropertyDescriptor;for(var r in e)if(Object.prototype.hasOwnProperty.call(e,r)){var c=o?Object.getOwnPropertyDescriptor(e,r):null;c&&(c.get||c.set)?Object.defineProperty(t,r,c):t[r]=e[r]}t.default=e,n&&n.set(e,t);return t}(require("react")),t=require("react-dom/server"),o=require("prop-types"),r=(e=require("./tagify.min.js"))&&e.__esModule?e:{default:e};function u(){if("function"!=typeof WeakMap)return null;var e=new WeakMap;return u=function(){return e},e}function c(){return(c=Object.assign||function(e){for(var n=1;n<arguments.length;n++){var t=arguments[n];for(var o in t)Object.prototype.hasOwnProperty.call(t,o)&&(e[o]=t[o])}return e}).apply(this,arguments)}function a(e,n){if(null==e)return{};var t,o,r=function(e,n){if(null==e)return{};var t,o,r={},u=Object.keys(e);for(o=0;o<u.length;o++)t=u[o],n.indexOf(t)>=0||(r[t]=e[t]);return r}(e,n);if(Object.getOwnPropertySymbols){var u=Object.getOwnPropertySymbols(e);for(o=0;o<u.length;o++)t=u[o],n.indexOf(t)>=0||Object.prototype.propertyIsEnumerable.call(e,t)&&(r[t]=e[t])}return r}const d=e=>e;const i=({name:e,value:o,loading:u=!1,onInput:c=d,onAdd:a=d,onRemove:i=d,onEditInput:l=d,onEditBeforeUpdate:f=d,onEditUpdated:s=d,onEditStart:p=d,onEditKeydown:y=d,onInvalid:g=d,onClick:w=d,onKeydown:h=d,onFocus:O=d,onBlur:m=d,onChange:b=d,onDropdownShow:v=d,onDropdownHide:E=d,onDropdownSelect:j=d,onDropdownScroll:D=d,onDropdownNoMatch:M=d,onDropdownUpdated:x=d,readOnly:S,children:I,settings:k={},InputMode:N="input",autoFocus:P,className:R,whitelist:T,tagifyRef:C,placeholder:U="",defaultValue:F,showDropdown:_})=>{const V=(0,n.useRef)(),q=(0,n.useRef)(),B=(0,n.useRef)(),K=F||o,A=(0,n.useMemo)((()=>({ref:q,name:e,defaultValue:I||"string"==typeof K?K:JSON.stringify(K),className:R,readOnly:S,autoFocus:P,placeholder:U})),[]),H=(0,n.useCallback)((()=>{P&&B.current&&B.current.DOM.input.focus()}),[B]);return(0,n.useEffect)((()=>{!function(e){if(e)for(let o in e)if(String(e[o]).includes(".createElement")){let r=e[o];e[o]=e=>(0,t.renderToStaticMarkup)(n.default.createElement(r,e))}}(k.templates),"textarea"==N&&(k.mode="mix"),T&&T.length&&(k.whitelist=T);const e=new r.default(q.current,k);return e.on("input",c).on("add",a).on("remove",i).on("invalid",g).on("keydown",h).on("focus",O).on("blur",m).on("click",w).on("change",b).on("edit:input",l).on("edit:beforeUpdate",f).on("edit:updated",s).on("edit:start",p).on("edit:keydown",y).on("dropdown:show",v).on("dropdown:hide",E).on("dropdown:select",j).on("dropdown:scroll",D).on("dropdown:noMatch",M).on("dropdown:updated",x),C&&(C.current=e),B.current=e,H(),()=>{e.destroy()}}),[]),(0,n.useEffect)((()=>{H()}),[P]),(0,n.useEffect)((()=>{V.current&&(B.current.settings.whitelist.length=0,T&&T.length&&B.current.settings.whitelist.push(...T))}),[T]),(0,n.useEffect)((()=>{const e=B.current.getInputValue();V.current&&!((e,n)=>{const t=e=>"string"==typeof e?e:JSON.stringify(e);return t(e)==t(n)})(o,e)&&B.current.loadOriginalValues(o)}),[o]),(0,n.useEffect)((()=>{V.current&&B.current.toggleClass(R)}),[R]),(0,n.useEffect)((()=>{V.current&&B.current.loading(u)}),[u]),(0,n.useEffect)((()=>{V.current&&B.current.setReadonly(S)}),[S]),(0,n.useEffect)((()=>{const e=B.current;V.current&&(_?(e.dropdown.show.call(e,_),e.toggleFocusClass(!0)):e.dropdown.hide.call(e))}),[_]),(0,n.useEffect)((()=>{V.current=!0}),[]),n.default.createElement("div",{className:"tags-input"},n.default.createElement(N,A))};i.propTypes={name:o.string,value:(0,o.oneOfType)([o.string,o.array]),loading:o.bool,children:(0,o.oneOfType)([o.string,o.array]),onChange:o.func,readOnly:o.bool,settings:o.object,InputMode:o.string,autoFocus:o.bool,className:o.string,tagifyRef:o.object,whitelist:o.array,placeholder:o.string,defaultValue:(0,o.oneOfType)([o.string,o.array]),showDropdown:(0,o.oneOfType)([o.string,o.bool]),onInput:o.func,onAdd:o.func,onRemove:o.func,onEditInput:o.func,onEditBeforeUpdate:o.func,onEditUpdated:o.func,onEditStart:o.func,onEditKeydown:o.func,onInvalid:o.func,onClick:o.func,onKeydown:o.func,onFocus:o.func,onBlur:o.func,onDropdownShow:o.func,onDropdownHide:o.func,onDropdownSelect:o.func,onDropdownScroll:o.func,onDropdownNoMatch:o.func,onDropdownUpdated:o.func};const l=n.default.memo(i);l.displayName="Tags";exports.MixedTags=e=>{let t=e.children,o=a(e,["children"]);return n.default.createElement(l,c({InputMode:"textarea"},o),t)};var f=l;return exports.default=f,exports}));