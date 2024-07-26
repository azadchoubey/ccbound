import{d as r,y as N,c as B,w as p,o,a as e,b as c,e as a,i as S,F as j,g as C,h as y,K as h,t as i,f as n}from"./app-ad745f98.js";import{_ as F}from"./InputLabel-dc2871da.js";import{_ as R}from"./TextInput-e764b81b.js";import{_ as I}from"./AdminLayout-91e7dc08.js";import{t as L}from"./laravel-vue-pagination.es-5db2614b.js";import{f as M}from"./helpers-3a38de6b.js";import{_ as T}from"./DialogModal-ea914144.js";import{_ as $}from"./SecondaryButton-efbe443f.js";import"./Banner-2b5a5794.js";import"./_plugin-vue_export-helper-c27b6911.js";import"./UserGroupIcon-957e0a5d.js";import"./MoneyIcon-a70d50ab.js";import"./LogoutIcon-b8d63e69.js";import"./ToastList-cd5f7580.js";import"./Modal-fb88d194.js";const U={class:"p-[1rem]"},E={class:"w-full py-2"},K={class:"bg-white rounded-md shadow overfl"},O={class:"w-full whitespace-nowrap"},q=e("thead",null,[e("tr",{class:"font-bold text-left"},[e("th",{class:"px-6 pt-6 pb-4"},"Date"),e("th",{class:"px-6 pt-6 pb-4"},"ID"),e("th",{class:"px-6 pt-6 pb-4"},"User"),e("th",{class:"px-6 pt-6 pb-4"},"Company"),e("th",{class:"px-6 pt-6 pb-4"},"Product Name"),e("th",{class:"px-6 pt-6 pb-4"},"CAS No"),e("th",{class:"px-6 pt-6 pb-4"},"Status"),e("th",{class:"px-6 pt-6 pb-4"},"Actions")])],-1),z={class:"hover:bg-gray-100 focus-within:bg-gray-100"},G={class:"border-t"},H={class:"flex items-center px-6 py-4 font-semibold"},J={class:"border-t"},Q={class:"flex items-center px-6 py-4 font-semibold"},W={class:"border-t"},X={class:"flex items-center px-6 py-4 font-semibold"},Y={class:"border-t"},Z={class:"flex items-center px-6 py-4 font-semibold"},ee={class:"border-t"},te={class:"flex items-center px-6 py-4 font-semibold"},se={class:"border-t"},oe={class:"flex items-center px-6 py-4 font-semibold"},ae={class:"border-t"},le={class:"flex items-center px-6 py-4 font-semibold"},ne={key:0,class:"px-2 text-sm text-yellow-600 bg-yellow-200 rounded-xl"},ce={key:1,class:"px-2 text-sm text-green-600 bg-green-200 rounded-xl"},ie={key:2,class:"px-2 text-sm text-yellow-600 bg-yellow-200 rounded-xl"},de={key:3,class:"px-2 text-sm bg-red-200 text-redd-600 rounded-xl"},re={class:"border-t"},pe={class:"flex gap-2"},_e=["href"],me=e("p",null,"View",-1),ue=[me],fe=["onClick"],he=["onClick"],xe=["onClick"],ve=["onClick"],be=["onClick"],ye=e("div",{class:"mt-4"},[e("p",{class:"mb-2"},"Are you sure you want to delete?")],-1),ge={class:"flex justify-center mt-2"},Me={__name:"Index",props:{confirmsTwoFactorAuthentication:Boolean,sessions:Array,products:Object},setup(A){const d=r(A.products),_=(s,l,t)=>{h.post(route("admin.product.updateStatus",{product:s,status:l,active:t})).then(u=>{u.status===200&&(console.log(u.data),window.location.reload())})},D=(s=1)=>{h.get(route("admin.product.index",{page:s})).then(l=>{d.value=l.data})};let m=r(!1),x=r(null),v=r(null);const P=(s,l)=>{m.value=!0,x.value=s,v.value=l},g=()=>{m.value=!1},V=()=>{d.value.splice(v.value,1),h.delete(`products/${x.value}`).then(s=>{x.value=null,v.value=null,m.value=!1})},b=r();return N(b,async(s,l)=>{s.value!==""?h.get(route("admin.product.index",{search:s})).then(t=>{d.value=t.data}):window.location.reload()}),(s,l)=>(o(),B(I,{title:"Products"},{default:p(()=>[e("div",U,[e("div",E,[c(F,{for:"search",value:"Search"}),c(R,{type:"text",class:"w-full",modelValue:b.value,"onUpdate:modelValue":l[0]||(l[0]=t=>b.value=t)},null,8,["modelValue"])]),e("div",K,[e("table",O,[q,e("tbody",null,[(o(!0),a(j,null,S(d.value.data,(t,u)=>{var w,k;return o(),a("tr",z,[e("td",G,[e("p",H,i(y(M)(t.updated_at.slice(0,10))),1)]),e("td",J,[e("p",Q,i("PRD"+t.id),1)]),e("td",W,[e("p",X,i((w=t.user)==null?void 0:w.name),1)]),e("td",Y,[e("p",Z,i((k=t.user)==null?void 0:k.company.name),1)]),e("td",ee,[e("p",te,i(t.product_name),1)]),e("td",se,[e("p",oe,i(t.cas_no),1)]),e("td",ae,[e("p",le,[t.approved===0?(o(),a("p",ne,"Pending ")):n("",!0),t.approved===1&&t.active===1?(o(),a("p",ce,"Approved ")):t.approved===1&&t.active===0?(o(),a("p",ie,"Disapproved ")):n("",!0),t.approved===2?(o(),a("p",de,"Rejected")):n("",!0)])]),e("td",re,[e("div",pe,[e("a",{href:s.route("product.show",{product:t}),target:"_blank",class:"flex items-center gap-1 py-1 text-sm font-bold text-slate-900"},ue,8,_e),t.approved===0||t.approved===2?(o(),a("button",{key:0,onClick:f=>_(t,1,1),class:"flex items-center gap-1 py-1 text-sm font-bold text-slate-900"},"Approve",8,fe)):n("",!0),t.approved===0||t.approved===1?(o(),a("button",{key:1,onClick:f=>_(t,2,0),class:"flex items-center gap-1 py-1 text-sm font-bold text-slate-900"},"Reject",8,he)):n("",!0),t.approved===1&&t.active===0?(o(),a("button",{key:2,onClick:f=>_(t,1,1),class:"flex items-center gap-1 py-1 text-sm font-bold text-slate-900"},"Activate",8,xe)):n("",!0),t.approved===1&&t.active===1?(o(),a("button",{key:3,onClick:f=>_(t,1,0),class:"flex items-center gap-1 py-1 text-sm font-bold text-slate-900"},"De Active",8,ve)):n("",!0),e("button",{onClick:f=>P(t.id,u),class:"flex items-center gap-1 py-1 text-sm font-bold text-slate-900"},"Delete",8,be)])])])}),256))])])]),c(T,{show:y(m),onClose:g},{content:p(()=>[ye]),footer:p(()=>[c($,{onClick:V},{default:p(()=>[C(" Delete ")]),_:1}),c($,{onClick:g},{default:p(()=>[C(" Cancel ")]),_:1})]),_:1},8,["show"]),e("div",ge,[c(y(L),{data:d.value,onPaginationChangePage:D},null,8,["data"])])])]),_:1}))}};export{Me as default};
