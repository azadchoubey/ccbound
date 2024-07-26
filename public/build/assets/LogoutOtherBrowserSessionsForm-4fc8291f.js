import{d as p,u as k,c as x,w as e,o as a,g as t,e as l,F as b,i as B,f as S,a as s,b as n,h as i,S as C,n as L,t as d}from"./app-ad745f98.js";import{_ as O}from"./ActionMessage-023109ed.js";import{_ as M}from"./ActionSection-dc33db20.js";import{_ as V}from"./DialogModal-ea914144.js";import{_ as $}from"./InputError-5f6dd6ed.js";import{_ as w}from"./PrimaryButton-65f58580.js";import{_ as y}from"./SecondaryButton-efbe443f.js";import{_ as F}from"./TextInput-e764b81b.js";import"./SectionTitle-94f0e8f1.js";import"./_plugin-vue_export-helper-c27b6911.js";import"./Modal-fb88d194.js";const I=s("div",{class:"max-w-xl text-sm text-gray-600"}," If necessary, you may log out of all of your other browser sessions across all of your devices. Some of your recent sessions are listed below; however, this list may not be exhaustive. If you feel your account has been compromised, you should also update your password. ",-1),N={key:0,class:"mt-5 space-y-6"},z={key:0,fill:"none","stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"2",viewBox:"0 0 24 24",stroke:"currentColor",class:"w-8 h-8 text-gray-500"},K=s("path",{d:"M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"},null,-1),T=[K],U={key:1,xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 24 24","stroke-width":"2",stroke:"currentColor",fill:"none","stroke-linecap":"round","stroke-linejoin":"round",class:"w-8 h-8 text-gray-500"},j=s("path",{d:"M0 0h24v24H0z",stroke:"none"},null,-1),D=s("rect",{x:"7",y:"4",width:"10",height:"16",rx:"1"},null,-1),E=s("path",{d:"M11 5h2M12 17v.01"},null,-1),H=[j,D,E],P={class:"ml-3"},A={class:"text-sm text-gray-600"},q={class:"text-xs text-gray-500"},G={key:0,class:"font-semibold text-green-500"},J={key:1},Q={class:"flex items-center mt-5"},R={class:"mt-4"},is={__name:"LogoutOtherBrowserSessionsForm",props:{sessions:Array},setup(m){const u=p(!1),_=p(null),r=k({password:""}),g=()=>{u.value=!0,setTimeout(()=>_.value.focus(),250)},h=()=>{r.delete(route("other-browser-sessions.destroy"),{preserveScroll:!0,onSuccess:()=>c(),onError:()=>_.value.focus(),onFinish:()=>r.reset()})},c=()=>{u.value=!1,r.reset()};return(W,f)=>(a(),x(M,null,{title:e(()=>[t(" Browser Sessions ")]),description:e(()=>[t(" Manage and log out your active sessions on other browsers and devices. ")]),content:e(()=>[I,m.sessions.length>0?(a(),l("div",N,[(a(!0),l(b,null,B(m.sessions,(o,v)=>(a(),l("div",{key:v,class:"flex items-center"},[s("div",null,[o.agent.is_desktop?(a(),l("svg",z,T)):(a(),l("svg",U,H))]),s("div",P,[s("div",A,d(o.agent.platform?o.agent.platform:"Unknown")+" - "+d(o.agent.browser?o.agent.browser:"Unknown"),1),s("div",null,[s("div",q,[t(d(o.ip_address)+", ",1),o.is_current_device?(a(),l("span",G,"This device")):(a(),l("span",J,"Last active "+d(o.last_active),1))])])])]))),128))])):S("",!0),s("div",Q,[n(w,{onClick:g},{default:e(()=>[t(" Log Out Other Browser Sessions ")]),_:1}),n(O,{on:i(r).recentlySuccessful,class:"ml-3"},{default:e(()=>[t(" Done. ")]),_:1},8,["on"])]),n(V,{show:u.value,onClose:c},{title:e(()=>[t(" Log Out Other Browser Sessions ")]),content:e(()=>[t(" Please enter your password to confirm you would like to log out of your other browser sessions across all of your devices. "),s("div",R,[n(F,{ref_key:"passwordInput",ref:_,modelValue:i(r).password,"onUpdate:modelValue":f[0]||(f[0]=o=>i(r).password=o),type:"password",class:"block w-3/4 mt-1",placeholder:"Password",onKeyup:C(h,["enter"])},null,8,["modelValue","onKeyup"]),n($,{message:i(r).errors.password,class:"mt-2"},null,8,["message"])])]),footer:e(()=>[n(y,{onClick:c},{default:e(()=>[t(" Ok ")]),_:1}),n(y,{onClick:c},{default:e(()=>[t(" Cancel ")]),_:1}),n(w,{class:L(["ml-3",{"opacity-25":i(r).processing}]),disabled:i(r).processing,onClick:h},{default:e(()=>[t(" Log Out Other Browser Sessions ")]),_:1},8,["class","disabled"])]),_:1},8,["show"])]),_:1}))}};export{is as default};
