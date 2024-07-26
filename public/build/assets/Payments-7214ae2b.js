import{d,c as _,w as m,o as a,a as t,e as i,i as h,F as f,b as u,G as b,t as e,h as x}from"./app-ad745f98.js";import{f as g}from"./helpers-3a38de6b.js";import{_ as y}from"./AdminLayout-91e7dc08.js";import"./Banner-2b5a5794.js";import"./_plugin-vue_export-helper-c27b6911.js";import"./UserGroupIcon-957e0a5d.js";import"./MoneyIcon-a70d50ab.js";import"./LogoutIcon-b8d63e69.js";import"./ToastList-cd5f7580.js";const w={class:"px-[1rem]"},v={class:"mt-2 bg-white rounded-md shadow"},P={class:"w-full whitespace-nowrap"},A=t("thead",null,[t("tr",{class:"font-bold text-left"},[t("th",{class:"px-6 pt-6 pb-4"},"Date"),t("th",{class:"px-6 pt-6 pb-4"},"User"),t("th",{class:"px-6 pt-6 pb-4"},"Subscription"),t("th",{class:"px-6 pt-6 pb-4"},"Accounts"),t("th",{class:"px-6 pt-6 pb-4"},"Amount(After Discount)"),t("th",{class:"px-6 pt-6 pb-4"},"Coupon"),t("th",{class:"px-6 pt-6 pb-4"},"Discount")])],-1),B={class:"hover:bg-gray-100 focus-within:bg-gray-100"},D={class:"border-t"},C={class:"flex items-center px-6 py-4 font-semibold"},k={class:"border-t"},F={class:"flex items-center px-6 py-4 font-semibold"},T={class:"border-t"},j={class:"flex items-center px-6 py-4 font-semibold"},L={class:"border-t"},N={class:"flex items-center px-6 py-4 font-semibold"},S={class:"border-t"},V={class:"flex items-center px-6 py-4 font-semibold"},E={class:"border-t"},G={class:"flex items-center px-6 py-4 font-semibold"},O={class:"border-t"},U={class:"flex items-center px-6 py-4 font-semibold"},$={class:"flex justify-center mt-2"},X={__name:"Payments",props:{confirmsTwoFactorAuthentication:Boolean,sessions:Array,payments:Object},setup(r){const o=d(r.payments),l=(n=1)=>{axios.get(route("admin.payments",{page:n})).then(c=>{o.value=c.data})};return(n,c)=>{const p=b("TailwindPagination");return a(),_(y,{title:"Payments"},{default:m(()=>[t("div",w,[t("div",v,[t("table",P,[A,t("tbody",null,[(a(!0),i(f,null,h(o.value.data,s=>(a(),i("tr",B,[t("td",D,[t("p",C,e(x(g)(s.created_at.slice(0,10))),1)]),t("td",k,[t("p",F,e(s.user.name),1)]),t("td",T,[t("p",j,e(s.subscription),1)]),t("td",L,[t("p",N,e(s.accounts),1)]),t("td",S,[t("p",V,"₹ "+e(s.amount),1)]),t("td",E,[t("p",G,e(s.coupon),1)]),t("td",O,[t("p",U,e(s.discount),1)])]))),256))])])]),t("div",$,[u(p,{data:o.value,onPaginationChangePage:l},null,8,["data"])])])]),_:1})}}};export{X as default};