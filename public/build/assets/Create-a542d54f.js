import{d as b,u as V,y as C,c as U,w as p,o as u,a as t,b as i,h as c,L as A,e as d,f as m,t as n,p as N,i as $,F as B,g as h,K as M,j as T,U as j}from"./app-ad745f98.js";import{_ as y}from"./InputLabel-dc2871da.js";import{_ as x}from"./TextInput-e764b81b.js";import{_ as I}from"./PrimaryButton-65f58580.js";import{_ as L}from"./AppLayout-d8d9702b.js";import{A as O}from"./ArrowLeftIcon-d696fddf.js";import"./Banner-2b5a5794.js";import"./BottomTab-9c18cf54.js";import"./Sidebar-8688ddd2.js";import"./_plugin-vue_export-helper-c27b6911.js";import"./ToastList-cd5f7580.js";const E={class:"lg:hidden w-full border-b bg-white border-gray-200 py-[1rem] px-[1rem]"},F={class:"p-[2rem] bg-white mt-2"},q={class:"py-4"},P=t("p",{class:"text-2xl font-bold"},"Your current plan",-1),R={class:"w-full border border-gray-200 rounded-lg p-3"},Y={key:0,class:"w-full text-lg font-semibold"},H={key:1,class:"w-full text-lg font-semibold"},K={key:2,class:"text-red-600 text-sm"},z=["onSubmit"],G=t("div",null,[t("p",{class:"text-xl font-bold"},"Select your plan")],-1),J=t("h3",{class:"mb-2 text-base font-medium text-gray-900 dark:text-white"}," How much do you expect to use each month? ",-1),Q={class:"grid w-full gap-6 md:grid-cols-2"},W={class:"flex items-center gap-2"},X=["value"],Z={class:"w-full h-full flex items-center px-2 py-4 font-semibold text-lg border border-gray-200 rounded-lg"},D={class:"text-red-600"},tt={class:"mt-5"},et={class:"mt-5"},ot={class:"flex items-center gap-2"},st={class:"text-red-600"},nt={class:"mt-10"},lt=t("span",{class:"font-bold"},"Total Amount:",-1),at={class:"text-red-600"},rt=t("div",{class:"w-full flex justify-center mt-2"},[t("button",{class:"text-sm bg-blue-700 px-2 py-3 rounded-lg text-white"}," Make Payment ")],-1),xt={__name:"Create",props:{company:Object,accountsUsed:Number,subscriptions:Object},setup(r){const v=r,s=b(null),f=b(0),e=V({plan:null,accounts:null,coupon:null,amount:null}),g=()=>{let o=new Date().toISOString().slice(0,10);return new Date(v.company.subscription.end_date).toISOString().slice(0,10)<o?"Subscription Pack expired":!1},w=()=>{if(e.coupon){if(!e.plan){alert("select a plan");return}if(!e.accounts){alert("enter accounts");return}M.get(route("coupon.validate",{coupon:e.coupon})).then(o=>{o.data===0&&alert("Invalid Coupon Code"),s.value=o.data,_()})}};C([e],()=>{_()});const _=()=>{var l,a;if(!e.plan||!e.accounts)return;let o=e.plan.price*e.accounts;s&&(s!=null&&s.value)&&((l=s==null?void 0:s.value)!=null&&l.discount)&&(o=o-o*(((a=s==null?void 0:s.value)==null?void 0:a.discount)/100)),f.value=o},k=()=>{e.get(route("subscription.store"))};return(o,l)=>(u(),U(L,{title:"Subscription"},{default:p(()=>[t("div",E,[i(c(A),{href:o.route("settings")},{default:p(()=>[i(O)]),_:1},8,["href"])]),t("div",F,[t("div",q,[P,t("div",null,[t("div",R,[r.company.subscription.subscription==="#SUB000000"?(u(),d("div",Y," Trail ")):m("",!0),r.company.subscription.subscription!=="#SUB000000"?(u(),d("div",H," ₹ "+n(r.company.subscription.amount)+" / "+n(r.company.subscription.months)+" Months ",1)):m("",!0),t("p",null,"Accounts: "+n(r.company.subscription.accounts),1),t("p",null,"No. of accounts used: "+n(r.accountsUsed),1),t("p",null,"Expiry date: "+n(r.company.subscription.end_date),1),g()?(u(),d("p",K," Your Subscription pack expired ")):m("",!0)])])]),t("form",{onSubmit:N(k,["prevent"])},[G,t("div",null,[J,t("ul",Q,[(u(!0),d(B,null,$(r.subscriptions,a=>(u(),d("div",W,[T(t("input",{type:"radio",name:"plan",value:a,"onUpdate:modelValue":l[0]||(l[0]=S=>c(e).plan=S),required:""},null,8,X),[[j,c(e).plan]]),t("div",Z," ₹ "+n(a.price)+" / "+n(a.months)+" Months ",1)]))),256))])]),t("p",D,n(o.$page.props.errors.plan),1),t("div",tt,[i(y,{for:"accounts",value:"No. of accounts"}),i(x,{type:"number",placeholder:"Enter your no. of accounts",min:"1",class:"mt-1 block w-full",modelValue:c(e).accounts,"onUpdate:modelValue":l[1]||(l[1]=a=>c(e).accounts=a),required:""},null,8,["modelValue"])]),t("div",et,[i(y,{for:"coupon",value:"Coupon code"}),t("div",ot,[i(x,{id:"coupon",type:"text",class:"mt-1 block w-full",modelValue:c(e).coupon,"onUpdate:modelValue":l[2]||(l[2]=a=>c(e).coupon=a)},null,8,["modelValue"]),i(I,{type:"button",onClick:w},{default:p(()=>[h("Validate")]),_:1})])]),t("p",st,n(o.$page.props.errors.coupon),1),t("div",nt,[t("p",null,[lt,h(" Rs."+n(f.value)+"/- ",1)])]),t("p",at,n(o.$page.props.errors.amount),1),rt],40,z)])]),_:1}))}};export{xt as default};