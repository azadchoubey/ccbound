import{d,c as m,w as c,o as u,a as e,e as v,b as l,h as g,L as x,f as _,j as h,R as b,S as y,B as w}from"./app-ad745f98.js";import{U as k,C as B,P as C}from"./UploadIcon-abb0c5da.js";import{E as $}from"./EllipsisHorizontal-36b10a69.js";import{U as I}from"./UserIcon-f7658644.js";import{_ as j}from"./ChatRoomLayout-1e97b12e.js";import"./_plugin-vue_export-helper-c27b6911.js";import"./ArrowLeftIcon-d696fddf.js";import"./Sidebar-8688ddd2.js";import"./ToastList-cd5f7580.js";const q={class:"max-w-[40rem] m-auto pb-5"},M=e("div",{class:"px-2 flex-1 mb-[5rem] w-full bg-white h-[calc(100vh_-_150px)] overflow-y-auto"},[e("div",{class:"w-full p-1"})],-1),U={class:"w-full fixed bottom-0 max-w-[40rem]"},E={key:0,class:"flex flex-col p-1 mx-2 mb-2 bg-white border border-gray-200 rounded-lg"},P={class:"flex justify-end"},S=e("svg",{class:"w-6 h-6",stroke:"currentColor",fill:"none",viewBox:"0 0 24 24"},[e("path",{"stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"2",d:"M6 18L18 6M6 6l12 12"})],-1),T=[S],V={class:"flex justify-between px-[5rem]"},A={class:"flex flex-col items-center"},L=e("p",{class:"text-sm"},"Share My Details",-1),N={class:"flex flex-col items-center"},D={class:"inline-block p-2 bg-green-600 rounded-full",onclick:"document.getElementById('file').click()"},F=e("p",null,"Upload",-1),K={class:"flex flex-col items-center"},O=e("p",null,"More",-1),z={class:"p-2 px-3 bg-white",id:"message-tab"},H={class:"flex"},R={class:"flex items-center flex-1 px-3 py-1 bg-gray-200 rounded-3xl"},G={class:"flex items-center"},oe={__name:"TempShow",props:{confirmsTwoFactorAuthentication:Boolean,sessions:Array,enquiry:Object},setup(p){const i=p,o=d(!1),n=d(null),r=()=>{n.value!==null&&n.value!==""&&w.Inertia.post(route("sale.chatroom.createnew",{message:n.value,enquiry:i.enquiry}))},f=()=>{o.value=!1};return(a,s)=>(u(),m(j,{title:"Chatroom",showInfo:!1,navigationBack:"/chats/enquiry/asdf",name:`My Sale - ${i.enquiry.product_name} - ${i.enquiry.cas_no} - Initiated By ${a.$page.props.user.name} - Posted By ${i.enquiry.user.name}`,profile_image:"/assests/images/avatar.jpg"},{default:c(()=>[e("div",q,[M,e("div",U,[o.value?(u(),v("div",E,[e("div",P,[e("button",{class:"inline-flex items-center justify-center p-1 text-gray-400 transition bg-gray-200 rounded-md hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500",onClick:s[0]||(s[0]=t=>o.value=!o.value)},T)]),e("div",V,[e("div",A,[e("button",{onClick:s[1]||(s[1]=(...t)=>a.show&&a.show(...t)),class:"inline-block p-2 bg-blue-600 rounded-full"},[l(I,{class:"text-white"})]),L]),e("div",N,[e("button",D,[l(k,{class:"text-white"})]),F]),e("div",K,[l(g(x),{class:"block p-2 bg-white border border-gray-200 rounded-full"},{default:c(()=>[l($,{class:"text-red-600"})]),_:1}),O])])])):_("",!0),e("div",z,[e("div",H,[e("div",R,[e("button",{onClick:s[2]||(s[2]=t=>o.value=!o.value)},[l(B)]),e("input",{type:"file",class:"hidden",id:"file",onChange:s[3]||(s[3]=t=>f())},null,32),h(e("input",{type:"text","onUpdate:modelValue":s[4]||(s[4]=t=>n.value=t),onKeyup:s[5]||(s[5]=y(t=>r(),["enter"])),placeholder:"Type a message",class:"w-full bg-gray-200 border-0 focus:outline-none focus:ring-0"},null,544),[[b,n.value]])]),e("div",G,[e("button",{onClick:s[6]||(s[6]=t=>r()),class:"px-3 py-2 text-white bg-blue-700 rounded-2xl"},[l(C)])])])])])])]),_:1},8,["name","profile_image"]))}};export{oe as default};
