import{d as p,s as m,C as u,e as n,j as _,v as h,a as e,b as s,w as l,h as i,f as b,F as v,o as d,L as c}from"./app-ad745f98.js";import{B as x}from"./BinIcon-aba235df.js";import{E as y}from"./EditIcon-0d704451.js";import{E as g}from"./EllipsisHorizontal-36b10a69.js";import"./_plugin-vue_export-helper-c27b6911.js";const k={class:"hover:bg-gray-100 focus-within:bg-gray-100"},w=e("td",{class:"border-t"},[e("p",{class:"flex items-center px-6 py-4 font-semibold"},"1/12/2023")],-1),E=e("td",{class:"border-t"},[e("p",{class:"flex items-center px-6 py-4 font-semibold",href:"/organizations/asdf/edit"}," RGB123 ")],-1),B=e("td",{class:"border-t"},[e("p",{class:"flex items-center px-6 py-4 font-semibold"},"10 %")],-1),C={class:"border-t"},z={class:"flex items-center px-6 py-4 font-semibold"},D=["href"],L={class:"border-t relative flex flex-col justify-center items-center pt-2.5"},N={key:0,class:"absolute z-50 bg-white border border-gray-200 rounded-lg p-2 top-[2rem]"},R=e("p",null,"Edit",-1),V=e("p",null,"Delete",-1),M={__name:"TableRow",setup(j){const t=p(!1),a=o=>{t.value&&o.key==="Escape"&&(t.value=!1)};return m(()=>document.addEventListener("keydown",a)),u(()=>document.removeEventListener("keydown",a)),(o,r)=>(d(),n(v,null,[_(e("div",{class:"fixed inset-0 z-40",onClick:r[0]||(r[0]=f=>t.value=!1)},null,512),[[h,t.value]]),e("tr",k,[w,E,B,e("td",C,[e("p",z,[e("a",{href:o.route("profile"),class:"hover:underline",target:"_blank"},"Rakesh",8,D)])]),e("td",L,[e("button",{onClick:r[1]||(r[1]=f=>t.value=!t.value)},[s(g)]),t.value?(d(),n("div",N,[s(i(c),{href:o.route("admin.coupon.edit",{id:1}),class:"flex items-center gap-1 py-1 text-sm text-slate-900 font-bold border-b border-gray-200"},{default:l(()=>[s(y,{class:"h-[0.8rem]"}),R]),_:1},8,["href"]),s(i(c),{class:"flex items-center gap-1 py-1 text-sm text-slate-900 font-bold"},{default:l(()=>[s(x,{class:"h-[1rem]"}),V]),_:1})])):b("",!0)])])],64))}};export{M as default};