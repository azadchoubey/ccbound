import{c,w as n,o,a as t,e as l,i as d,F as i,t as e}from"./app-ad745f98.js";import{_ as r}from"./AppLayout-d8d9702b.js";import"./Banner-2b5a5794.js";import"./BottomTab-9c18cf54.js";import"./Sidebar-8688ddd2.js";import"./_plugin-vue_export-helper-c27b6911.js";import"./ToastList-cd5f7580.js";const _={class:"px-2"},p=t("p",null,null,-1),h={class:"mt-2"},m={class:"container mx-auto font-mono"},u={class:"w-full mb-8 overflow-hidden rounded-lg shadow-lg"},x={class:"w-full overflow-x-auto"},f={class:"w-full"},b=t("thead",null,[t("tr",{class:"text-md font-semibold tracking-wide text-left text-gray-900 bg-white uppercase border-b border-gray-600"},[t("th",{class:"px-4 py-3"},"Name"),t("th",{class:"px-4 py-3"},"Company"),t("th",{class:"px-4 py-3"},"Status"),t("th",{class:"px-4 py-3"},"Date")])],-1),y={class:"bg-white"},g={class:"text-gray-700"},w={class:"px-4 py-3 border"},v={class:"flex items-center text-sm"},k={class:"relative w-8 h-8 mr-3 rounded-full md:block"},B=["src"],C=t("div",{class:"absolute inset-0 rounded-full shadow-inner","aria-hidden":"true"},null,-1),S={class:"font-semibold text-black"},j={class:"px-4 py-3 text-sm border"},D={class:"px-4 py-3 text-xs border"},F={class:"px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-sm"},N={class:"px-4 py-3 text-sm border"},G={__name:"ReferShow",props:{users:Object},setup(a){return(z,E)=>(o(),c(r,{title:"Contacts"},{default:n(()=>[t("div",_,[p,t("div",h,[t("section",m,[t("div",u,[t("div",x,[t("table",f,[b,t("tbody",y,[(o(!0),l(i,null,d(a.users,s=>(o(),l("tr",g,[t("td",w,[t("div",v,[t("div",k,[t("img",{class:"object-cover w-full h-full rounded-full",src:s.profile_photo_url,alt:"",loading:"lazy"},null,8,B),C]),t("div",null,[t("p",S,e(s.name),1)])])]),t("td",j,e(s.company.name),1),t("td",D,[t("span",F,e(s.company.status),1)]),t("td",N,e(s.created_at.slice(0,10)),1)]))),256))])])])])])])])]),_:1}))}};export{G as default};
