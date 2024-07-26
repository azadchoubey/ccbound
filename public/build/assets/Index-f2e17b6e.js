import{d,y as P,c as S,w as r,o as s,a as t,b as p,e as a,i as j,F,g as C,h as _,K as f,t as i,f as c}from"./app-a99c1f11.js";import{_ as I}from"./AdminLayout-332649b1.js";import{t as L}from"./laravel-vue-pagination.es-8bba9f07.js";import{f as w}from"./helpers-3a38de6b.js";import{_ as M}from"./DialogModal-c682f939.js";import{_ as $}from"./SecondaryButton-9f95c4b3.js";import{_ as R}from"./InputLabel-4d3c9eb7.js";import{_ as T}from"./TextInput-aed48f04.js";import"./Banner-af0e7d7b.js";import"./_plugin-vue_export-helper-c27b6911.js";import"./UserGroupIcon-c8a6de1d.js";import"./MoneyIcon-6dab46af.js";import"./LogoutIcon-25c55303.js";import"./ToastList-b09059d6.js";import"./Modal-6b8225ed.js";const U={class:"p-[1rem]"},J={class:"w-full py-2"},K={class:"overflow-auto bg-white rounded-md shadow"},O={class:"w-full whitespace-nowrap"},Q=t("thead",null,[t("tr",{class:"font-bold text-left"},[t("th",{class:"px-6 pt-6 pb-4"},"Date"),t("th",{class:"px-6 pt-6 pb-4"},"ID"),t("th",{class:"px-6 pt-6 pb-4"},"User"),t("th",{class:"px-6 pt-6 pb-4"},"Product Name"),t("th",{class:"px-6 pt-6 pb-4"},"CAS No"),t("th",{class:"px-6 pt-6 pb-4"},"Expiry Date"),t("th",{class:"px-6 pt-6 pb-4"},"Status"),t("th",{class:"px-6 pt-6 pb-4"},"Actions")])],-1),z={class:"hover:bg-gray-100 focus-within:bg-gray-100"},G={class:"border-t"},H={class:"flex items-center px-6 py-4 font-semibold"},W={class:"border-t"},X={class:"flex items-center px-6 py-4 font-semibold"},Y={class:"border-t"},Z={class:"flex items-center px-6 py-4 font-semibold"},q={class:"border-t"},tt={class:"flex items-center px-6 py-4 font-semibold"},et={class:"border-t"},st={class:"flex items-center px-6 py-4 font-semibold"},ot={class:"border-t"},at={key:0,class:"flex items-center px-6 py-4 font-semibold"},lt={class:"border-t"},ct={class:"flex items-center px-6 py-4 font-semibold"},nt={key:0,class:"px-2 text-sm text-yellow-600 bg-yellow-200 rounded-xl"},dt={key:1,class:"px-2 text-sm text-green-600 bg-green-200 rounded-xl"},pt={key:2,class:"px-2 text-sm text-yellow-600 bg-yellow-200 rounded-xl"},it={key:3,class:"px-2 text-sm bg-red-200 text-redd-600 rounded-xl"},rt={class:"border-t"},_t={class:"flex gap-2"},mt=["href"],ut=t("p",null,"View",-1),xt=[ut],ft=["onClick"],ht=["onClick"],vt=["onClick"],bt=["onClick"],gt=["onClick"],wt=t("div",{class:"mt-4"},[t("p",{class:"mb-2"},"Are you sure you want to delete?")],-1),kt={class:"flex justify-center mt-2"},Mt={__name:"Index",props:{confirmsTwoFactorAuthentication:Boolean,sessions:Array,enquiries:Object},setup(A){const D=A;let m=d(!1);const n=d(D.enquiries),V=d(null);let h=d(null),v=d(null);const N=(o,l)=>{m.value=!0,h.value=o,v.value=l},k=()=>{m.value=!1},u=(o,l,e)=>{f.post(route("admin.enquiry.updateStatus",{enquiry:o,status:l,active:e})).then(g=>{g.status===200&&window.location.reload()})},E=(o=1)=>{n.value=[],f.get(route("admin.enquiry.index",{page:o,approved:V.value})).then(l=>{n.value=l.data})},B=()=>{m.value=!1,n.value.data.splice(v.value,1),f.delete(`enquiries/${h.value}`).then(o=>{h.value=null,v.value=null})},b=d();return P(b,async(o,l)=>{o.value!==""?f.get(route("admin.enquiry.index",{search:o})).then(e=>{n.value=e.data}):window.location.reload()}),(o,l)=>(s(),S(I,{title:"Enquiries"},{default:r(()=>[t("div",U,[t("div",J,[p(R,{for:"search",value:"Search"}),p(T,{type:"text",class:"w-full",modelValue:b.value,"onUpdate:modelValue":l[0]||(l[0]=e=>b.value=e)},null,8,["modelValue"])]),t("div",K,[t("table",O,[Q,t("tbody",null,[(s(!0),a(F,null,j(n.value.data,(e,g)=>{var y;return s(),a("tr",z,[t("td",G,[t("p",H,i(e.updated_at?_(w)(e.updated_at.slice(0,10)):""),1)]),t("td",W,[t("p",X,i("ENQ"+e.id),1)]),t("td",Y,[t("p",Z,i((y=e.user)==null?void 0:y.name),1)]),t("td",q,[t("p",tt,i(e.product_name),1)]),t("td",et,[t("p",st,i(e.cas_no),1)]),t("td",ot,[_(w)(e.expiry_date)!="01 Jan 1970"?(s(),a("p",at,i(_(w)(e.expiry_date)),1)):c("",!0)]),t("td",lt,[t("p",ct,[e.approved===0?(s(),a("p",nt,"Pending ")):c("",!0),e.approved===1&&e.active===1?(s(),a("p",dt,"Approved ")):e.approved===1&&e.active===0?(s(),a("p",pt,"Disapproved ")):c("",!0),e.approved===2?(s(),a("p",it,"Rejected")):c("",!0)])]),t("td",rt,[t("div",_t,[t("a",{href:o.route("enquiry.show",{enquiry:e}),target:"_blank",class:"flex items-center gap-1 py-1 text-sm font-bold text-slate-900"},xt,8,mt),e.approved===0||e.approved===2?(s(),a("button",{key:0,onClick:x=>u(e,1,1),class:"flex items-center gap-1 py-1 text-sm font-bold text-slate-900"},"Approve",8,ft)):c("",!0),e.approved===0||e.approved===1?(s(),a("button",{key:1,onClick:x=>u(e,2,0),class:"flex items-center gap-1 py-1 text-sm font-bold text-slate-900"},"Reject",8,ht)):c("",!0),e.approved===1&&e.active===0?(s(),a("button",{key:2,onClick:x=>u(e,1,1),class:"flex items-center gap-1 py-1 text-sm font-bold text-slate-900"},"Activate",8,vt)):c("",!0),e.approved===1&&e.active===1?(s(),a("button",{key:3,onClick:x=>u(e,1,0),class:"flex items-center gap-1 py-1 text-sm font-bold text-slate-900"},"De Active",8,bt)):c("",!0),t("button",{onClick:x=>N(e.id,g),class:"flex items-center gap-1 py-1 text-sm font-bold text-slate-900"},"Delete",8,gt)])])])}),256))])])]),p(M,{show:_(m),onClose:k},{content:r(()=>[wt]),footer:r(()=>[p($,{onClick:B},{default:r(()=>[C(" Delete ")]),_:1}),p($,{onClick:k},{default:r(()=>[C(" Cancel ")]),_:1})]),_:1},8,["show"]),t("div",kt,[p(_(L),{data:n.value,onPaginationChangePage:E},null,8,["data"])])])]),_:1}))}};export{Mt as default};
