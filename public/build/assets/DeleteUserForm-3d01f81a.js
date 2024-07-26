import{d,u as f,c as y,w as e,o as w,g as s,a as c,b as t,h as a,S as h,n as v}from"./app-ad745f98.js";import{_ as g}from"./ActionSection-dc33db20.js";import{_ as m}from"./DangerButton-df50055b.js";import{_ as k}from"./DialogModal-ea914144.js";import{_ as x}from"./InputError-5f6dd6ed.js";import{_ as C}from"./SecondaryButton-efbe443f.js";import{_ as D}from"./TextInput-e764b81b.js";import"./SectionTitle-94f0e8f1.js";import"./_plugin-vue_export-helper-c27b6911.js";import"./Modal-fb88d194.js";const b=c("div",{class:"max-w-xl text-sm text-gray-600"}," Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain. ",-1),V={class:"mt-5"},$={class:"mt-4"},E={__name:"DeleteUserForm",setup(A){const r=d(!1),l=d(null),o=f({password:""}),p=()=>{r.value=!0,setTimeout(()=>l.value.focus(),250)},u=()=>{o.delete(route("current-user.destroy"),{preserveScroll:!0,onSuccess:()=>n(),onError:()=>l.value.focus(),onFinish:()=>o.reset()})},n=()=>{r.value=!1,o.reset()};return(U,i)=>(w(),y(g,null,{title:e(()=>[s(" Delete Account ")]),description:e(()=>[s(" Permanently delete your account. ")]),content:e(()=>[b,c("div",V,[t(m,{onClick:p},{default:e(()=>[s(" Delete Account ")]),_:1})]),t(k,{show:r.value,onClose:n},{title:e(()=>[s(" Delete Account ")]),content:e(()=>[s(" Are you sure you want to delete your account? Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account. "),c("div",$,[t(D,{ref_key:"passwordInput",ref:l,modelValue:a(o).password,"onUpdate:modelValue":i[0]||(i[0]=_=>a(o).password=_),type:"password",class:"mt-1 block w-3/4",placeholder:"Password",onKeyup:h(u,["enter"])},null,8,["modelValue","onKeyup"]),t(x,{message:a(o).errors.password,class:"mt-2"},null,8,["message"])])]),footer:e(()=>[t(C,{onClick:n},{default:e(()=>[s(" Cancel ")]),_:1}),t(m,{class:v(["ml-3",{"opacity-25":a(o).processing}]),disabled:a(o).processing,onClick:u},{default:e(()=>[s(" Delete Account ")]),_:1},8,["class","disabled"])]),_:1},8,["show"])]),_:1}))}};export{E as default};
