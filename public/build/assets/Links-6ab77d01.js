import{o as p,c as h,w as o,a as s,r as u,d as m,e as g,b as e,F as x,h as i,L as n,g as a,B as w,G as v}from"./app-ad745f98.js";import{A as l}from"./ArrowRightIcon-cbb24bf8.js";import{B as b}from"./BuildingIcon-56240bf1.js";import{S as y,W as $,C as j,H as B}from"./WalletIcon-6775c3c9.js";import{M as I}from"./MoneyIcon-a70d50ab.js";import{U as C}from"./UserGroupIcon-957e0a5d.js";import{U as L}from"./UserIcon-f7658644.js";import{_ as S}from"./SettingsLayout-0b2ea9e7.js";import{_ as k}from"./Modal-fb88d194.js";import{L as W}from"./LogoutIcon-b8d63e69.js";import"./_plugin-vue_export-helper-c27b6911.js";import"./Banner-2b5a5794.js";import"./BottomTab-9c18cf54.js";import"./Sidebar-8688ddd2.js";import"./ToastList-cd5f7580.js";const T={class:"px-6 py-4"},A={class:"text-lg"},M={class:"mt-4"},U={class:"flex flex-row justify-end px-6 py-4 text-right bg-gray-100"},F={__name:"Loader",props:{show:{type:Boolean,default:!1},maxWidth:{type:String,default:"2xl"},closeable:{type:Boolean,default:!0},marginTop:{type:String,default:"mt-2"}},emits:["close"],setup(r,{emit:c}){const d=()=>{c("close")};return(t,f)=>(p(),h(k,{show:r.show,"max-width":r.maxWidth,closeable:r.closeable,marginTop:"mt-52",onClose:d},{default:o(()=>[s("div",T,[s("div",A,[u(t.$slots,"title")]),s("div",M,[u(t.$slots,"content")])]),s("div",U,[u(t.$slots,"footer")])]),_:3},8,["show","max-width","closeable"]))}};const H={class:"bg-white max-w-[40rem] md:mt-2"},N=s("div",{class:"flex justify-between p-2"},[s("p",{class:"px-2 text-2xl font-bold"},"Settings")],-1),V={class:"flex flex-col gap-5 p-4 mt-5"},E={class:"flex items-center gap-2"},G={class:"p-1 bg-purple-500 rounded-lg"},P={class:"flex items-center gap-2"},R={class:"p-1 rounded-lg bg-slate-900"},q={class:"flex items-center gap-2"},z={class:"p-1 rounded-lg bg-lime-500"},D={class:"flex items-center gap-2"},J={class:"p-1 bg-indigo-500 rounded-lg"},K={class:"flex items-center gap-2"},O={class:"p-1 bg-yellow-500 rounded-lg"},Q={class:"flex items-center gap-2"},X={class:"p-1 bg-orange-500 rounded-lg"},Y={class:"flex items-center gap-2"},Z={class:"p-1 rounded-lg bg-rose-500"},ee={class:"flex items-center gap-2"},se={class:"p-1 bg-gray-500 rounded-lg"},te={class:"flex items-center gap-2"},oe={class:"p-1 bg-blue-400 rounded-lg"},ae=s("div",{class:"loader"},null,-1),le=s("p",{class:"mt-3"},"Wait for a Second",-1),ye={__name:"Links",props:{confirmsTwoFactorAuthentication:Boolean,sessions:Array},setup(r){const c=m(!1),d=()=>{c.value=!0,setTimeout(function(){w.Inertia.post(route("logout"))},1e3)};return(t,f)=>{const _=v("center");return p(),g(x,null,[e(S,{title:"Settings"},{default:o(()=>[s("div",H,[N,s("div",V,[e(i(n),{href:t.route("profile.display",{id:t.$page.props.user.id}),class:"flex justify-between"},{default:o(()=>[s("div",E,[s("div",G,[e(L,{class:"text-white"})]),a(" My Profile ")]),e(l)]),_:1},8,["href"]),e(i(n),{href:t.route("company.manage"),class:"flex justify-between"},{default:o(()=>[s("div",P,[s("div",R,[e(b,{class:"text-white"})]),a(" Manage Company ")]),e(l)]),_:1},8,["href"]),e(i(n),{href:t.route("subscription.create"),class:"flex justify-between"},{default:o(()=>[s("div",q,[s("div",z,[e(y,{class:"text-white"})]),a(" Subscription ")]),e(l)]),_:1},8,["href"]),e(i(n),{href:t.route("buy"),class:"flex justify-between"},{default:o(()=>[s("div",D,[s("div",J,[e(I,{class:"text-white"})]),a(" Buy Product upload pack ")]),e(l)]),_:1},8,["href"]),e(i(n),{href:t.route("wallet"),class:"flex justify-between"},{default:o(()=>[s("div",K,[s("div",O,[e($,{class:"text-white"})]),a(" Wallet ")]),e(l)]),_:1},8,["href"]),e(i(n),{href:t.route("contacts"),class:"flex justify-between"},{default:o(()=>[s("div",Q,[s("div",X,[e(j,{class:"text-white"})]),a(" Contacts ")]),e(l)]),_:1},8,["href"]),e(i(n),{href:t.route("refer"),class:"flex justify-between"},{default:o(()=>[s("div",Y,[s("div",Z,[e(C,{class:"text-white"})]),a(" Refer and Earn ")]),e(l)]),_:1},8,["href"]),e(i(n),{href:t.route("help"),class:"flex justify-between"},{default:o(()=>[s("div",ee,[s("div",se,[e(B,{class:"text-white"})]),a(" Help ")]),e(l)]),_:1},8,["href"]),s("button",{onClick:d,class:"flex justify-between"},[s("div",te,[s("div",oe,[e(W,{class:"text-white"})]),a("Logout ")]),e(l)])])])]),_:1}),e(F,{show:c.value,onClose:f[0]||(f[0]=ie=>c.value=!c.value)},{content:o(()=>[e(_,null,{default:o(()=>[ae,le]),_:1})]),_:1},8,["show"])],64)}}};export{ye as default};
