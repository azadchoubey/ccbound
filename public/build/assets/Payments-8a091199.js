import{d as p,c as _,w as h,o as c,a as t,e as d,i as m,F as b,b as x,G as f,t as e}from"./app-a99c1f11.js";import{_ as u}from"./AdminLayout-332649b1.js";import"./Banner-af0e7d7b.js";import"./_plugin-vue_export-helper-c27b6911.js";import"./UserGroupIcon-c8a6de1d.js";import"./MoneyIcon-6dab46af.js";import"./LogoutIcon-25c55303.js";import"./ToastList-b09059d6.js";const y={class:"px-[1rem]"},g={class:"bg-white rounded-md shadow mt-2"},P={class:"w-full whitespace-nowrap"},w=t("thead",null,[t("tr",{class:"text-left font-bold"},[t("th",{class:"pb-4 pt-6 px-6"},"Date"),t("th",{class:"pb-4 pt-6 px-6"},"User"),t("th",{class:"pb-4 pt-6 px-6"},"Cost Per Product"),t("th",{class:"pb-4 pt-6 px-6"},"Products"),t("th",{class:"pb-4 pt-6 px-6"},"Payment Method"),t("th",{class:"pb-4 pt-6 px-6"},"Order Id"),t("th",{class:"pb-4 pt-6 px-6"},"Payment Id"),t("th",{class:"pb-4 pt-6 px-6"},"Amount"),t("th",{class:"pb-4 pt-6 px-6"},"Coupon"),t("th",{class:"pb-4 pt-6 px-6"},"Discount"),t("th",{class:"pb-4 pt-6 px-6"},"Final Amount")])],-1),v={class:"hover:bg-gray-100 focus-within:bg-gray-100"},B={class:"border-t"},C={class:"flex items-center px-6 py-4 font-semibold"},A={class:"border-t"},F={class:"flex items-center px-6 py-4 font-semibold"},k={class:"border-t"},D={class:"flex items-center px-6 py-4 font-semibold"},T={class:"border-t"},j={class:"flex items-center px-6 py-4 font-semibold"},I={class:"border-t"},L={class:"flex items-center px-6 py-4 font-semibold"},N={class:"border-t"},O={class:"flex items-center px-6 py-4 font-semibold"},V={class:"border-t"},E={class:"flex items-center px-6 py-4 font-semibold"},G={class:"border-t"},M={class:"flex items-center px-6 py-4 font-semibold"},S={class:"border-t"},U={class:"flex items-center px-6 py-4 font-semibold"},$={class:"border-t"},q={class:"flex items-center px-6 py-4 font-semibold"},z={class:"border-t"},H={class:"flex items-center px-6 py-4 font-semibold"},J={class:"flex justify-center mt-2"},et={__name:"Payments",props:{confirmsTwoFactorAuthentication:Boolean,sessions:Array,payments:Object},setup(i){const o=p(i.payments),l=(a=1)=>{axios.get(route("admin.payments",{page:a})).then(n=>{o.value=n.data})};return(a,n)=>{const r=f("TailwindPagination");return c(),_(u,{title:"Payments"},{default:h(()=>[t("div",y,[t("div",g,[t("table",P,[w,t("tbody",null,[(c(!0),d(b,null,m(o.value.data,s=>(c(),d("tr",v,[t("td",B,[t("p",C,e(s.created_at.slice(0,10)),1)]),t("td",A,[t("p",F,e(s.user.name),1)]),t("td",k,[t("p",D,e(s.cost_per_product),1)]),t("td",T,[t("p",j,e(s.products),1)]),t("td",I,[t("p",L,e(s.method),1)]),t("td",N,[t("p",O,e(s.order_id),1)]),t("td",V,[t("p",E,e(s.payment_id),1)]),t("td",G,[t("p",M,"₹ "+e(s.amount),1)]),t("td",S,[t("p",U,e(s.coupon),1)]),t("td",$,[t("p",q,e(s.discount)+" %",1)]),t("td",z,[t("p",H,"₹ "+e(s.final_amount),1)])]))),256))])])]),t("div",J,[x(r,{data:o.value,onPaginationChangePage:l},null,8,["data"])])])]),_:1})}}};export{et as default};
