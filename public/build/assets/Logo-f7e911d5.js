import{u as d,c as g,w as l,o as f,a as o,h as m,p as u,b as e,g as h}from"./app-ad745f98.js";import{_ as w}from"./AdminLayout-91e7dc08.js";import{_ as b}from"./TextInput-e764b81b.js";import{_ as v}from"./InputError-5f6dd6ed.js";import{_ as x}from"./PrimaryButton-65f58580.js";import"./Banner-2b5a5794.js";import"./_plugin-vue_export-helper-c27b6911.js";import"./UserGroupIcon-957e0a5d.js";import"./MoneyIcon-a70d50ab.js";import"./LogoutIcon-b8d63e69.js";import"./ToastList-cd5f7580.js";const S={class:"px-[2rem]"},$={class:"bg-white p-[2rem] mt-2 max-w-[45rem]"},B=o("p",{class:"text-xl font-bold"},"LOGO",-1),C=["src"],k=["onSubmit"],y={class:"grid grid-cols-2 gap-4 mt-2"},I={__name:"Logo",props:{confirmsTwoFactorAuthentication:Boolean,sessions:Array,logo:Object},setup(c){const n=c,t=d({logo:null});let r=n.logo;const p=()=>{const s=new FormData;s.append("logo",t.logo),t.post(route("admin.logo.store"),{data:s,preserveScroll:!0,onSuccess:a=>{t.reset("logo"),r=a.props.logo},headers:{"Content-Type":"multipart/form-data"}})},_=s=>{t.logo=s.target.files[0]};return(s,a)=>(f(),g(w,{title:"Create"},{default:l(()=>{var i;return[o("div",S,[o("div",$,[B,o("div",null,[o("img",{src:`/${(i=m(r))==null?void 0:i.logo}`,width:"150",height:"150"},null,8,C)]),o("form",{onSubmit:u(p,["prevent"])},[o("div",y,[o("div",null,[e(b,{id:"logo",type:"file",class:"block w-full mt-1",onChange:_,required:""}),e(v,{class:"mt-2",message:m(t).errors.logo},null,8,["message"])])]),e(x,{class:"mt-2"},{default:l(()=>[h(" Save ")]),_:1})],40,k)])])]}),_:1}))}};export{I as default};
