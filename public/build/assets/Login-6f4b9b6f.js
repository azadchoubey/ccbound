import{x,u as y,d as v,e as u,b as s,h as t,w as l,F as k,o as c,H as V,t as P,f,a,c as C,g as m,L as p,n as F,p as $}from"./app-ad745f98.js";import{A as B}from"./AuthenticationCard-3522cbd1.js";import{_ as L}from"./AuthenticationCardLogo-cbc190c1.js";import{_}from"./Checkbox-0e530ce3.js";import{_ as w}from"./InputError-5f6dd6ed.js";import{_ as g}from"./InputLabel-dc2871da.js";import{_ as S}from"./PrimaryButton-65f58580.js";import{_ as h}from"./TextInput-e764b81b.js";import"./_plugin-vue_export-helper-c27b6911.js";const N={key:0,class:"mb-4 text-sm font-medium text-green-600"},R=["onSubmit"],U={class:"mt-4"},j={class:"flex justify-between"},q={class:"flex items-center gap-2"},A=a("p",null,"Show Password",-1),E={class:"flex items-center"},D=a("span",{class:"ml-2 text-sm text-gray-600"},"Remember me",-1),H={class:"flex items-center justify-end mt-4"},z={class:"w-full flex justify-center border-t-[1px] border-gray-200 mt-2 py-2"},M=a("p",null,"Don't have an account? ",-1),O=a("p",{class:"text-center"},[m("For Any information write a email to Our Customer Care Email "),a("a",{href:"mailto:info@ccbond.app",class:"underline"},"info@ccbond.app")],-1),Z={__name:"Login",props:{canResetPassword:Boolean,status:String},setup(i){x();const e=y({email:"",password:"",remember:!1}),d=v(!1),b=()=>{e.transform(n=>({...n,remember:e.remember?"on":""})).post(route("login"),{onFinish:()=>e.reset("password")})};return(n,o)=>(c(),u(k,null,[s(t(V),{title:"Log in"}),s(B,null,{logo:l(()=>[s(L)]),default:l(()=>[i.status?(c(),u("div",N,P(i.status),1)):f("",!0),a("form",{onSubmit:$(b,["prevent"])},[a("div",null,[s(g,{for:"email",value:"Email"}),s(h,{id:"email",modelValue:t(e).email,"onUpdate:modelValue":o[0]||(o[0]=r=>t(e).email=r),type:"email",class:"block w-full mt-1",required:"",autofocus:""},null,8,["modelValue"]),s(w,{class:"mt-2",message:t(e).errors.email},null,8,["message"])]),a("div",U,[s(g,{for:"password",value:"Password"}),s(h,{id:"password",modelValue:t(e).password,"onUpdate:modelValue":o[1]||(o[1]=r=>t(e).password=r),type:d.value?"text":"password",class:"block w-full mt-1",required:"",autocomplete:"current-password"},null,8,["modelValue","type"]),s(w,{class:"mt-2",message:t(e).errors.password},null,8,["message"]),a("div",j,[a("div",q,[s(_,{checked:d.value,"onUpdate:checked":o[2]||(o[2]=r=>d.value=r),name:"showPassword"},null,8,["checked"]),A]),a("label",E,[s(_,{checked:t(e).remember,"onUpdate:checked":o[3]||(o[3]=r=>t(e).remember=r),name:"remember"},null,8,["checked"]),D])])]),a("div",H,[i.canResetPassword?(c(),C(t(p),{key:0,href:n.route("password.request"),class:"text-sm text-gray-600 underline hover:text-gray-900"},{default:l(()=>[m(" Forgot your password? ")]),_:1},8,["href"])):f("",!0),s(S,{class:F(["ml-4 bg-blue-600",{"opacity-25":t(e).processing}]),disabled:t(e).processing},{default:l(()=>[m(" Log in ")]),_:1},8,["class","disabled"])]),a("div",z,[M,s(t(p),{href:n.route("register"),class:"underline"},{default:l(()=>[m(" Register ")]),_:1},8,["href"])]),O],40,R)]),_:1})],64))}};export{Z as default};
