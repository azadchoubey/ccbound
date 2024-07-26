import{d,c as m,w as c,o as u,a as e,e as v,b as l,h as g,L as x,f as _,j as h,R as b,S as y,B as w}from"./app-a99c1f11.js";import{U as k,C as B,P as C}from"./UploadIcon-ef20ebcd.js";import{E as $}from"./EllipsisHorizontal-c23bad94.js";import{U as I}from"./UserIcon-5b9f3114.js";import{_ as j}from"./ChatRoomLayout-20280f40.js";import"./_plugin-vue_export-helper-c27b6911.js";import"./ArrowLeftIcon-f9739669.js";import"./Sidebar-08876489.js";import"./ToastList-b09059d6.js";const M={class:"max-w-[40rem] m-auto pb-5"},U=e("div",{class:"px-2 flex-1 mb-[5rem] w-full bg-white h-[calc(100vh_-_150px)] overflow-y-auto"},[e("div",{class:"w-full p-1"})],-1),E={class:"w-full fixed bottom-0 max-w-[40rem]"},P={key:0,class:"flex flex-col mb-2 p-1 mx-2 border border-gray-200 rounded-lg bg-white"},T={class:"flex justify-end"},V=e("svg",{class:"h-6 w-6",stroke:"currentColor",fill:"none",viewBox:"0 0 24 24"},[e("path",{"stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"2",d:"M6 18L18 6M6 6l12 12"})],-1),A=[V],L={class:"flex justify-between px-[5rem]"},N={class:"flex flex-col items-center"},S=e("p",{class:"text-sm"},"Share My Deatils",-1),q={class:"flex flex-col items-center"},D={class:"bg-green-600 inline-block p-2 rounded-full",onclick:"document.getElementById('file').click()"},F=e("p",null,"Upload",-1),K={class:"flex flex-col items-center"},O=e("p",null,"More",-1),z={class:"p-2 px-3 bg-white",id:"message-tab"},H={class:"flex"},R={class:"bg-gray-200 flex items-center flex-1 rounded-3xl px-3 py-1"},G={class:"flex items-center"},oe={__name:"TempShow",props:{confirmsTwoFactorAuthentication:Boolean,sessions:Array,product:Object},setup(p){const a=p,o=d(!1),n=d(null),r=()=>{n.value!==null&&n.value!==""&&w.Inertia.post(route("product.chatroom.createnew",{message:n.value,product:a.product}))},f=()=>{o.value=!1};return(i,s)=>(u(),m(j,{title:"Chatroom",showInfo:!1,navigationBack:"/chats/enquiry/asdf",name:`My Enquiry - ${a.product.product_name} - ${a.product.cas_no} - Initiated By ${i.$page.props.user.name} - Posted By ${a.product.user.name}`,profile_image:"/assests/images/avatar.jpg"},{default:c(()=>[e("div",M,[U,e("div",E,[o.value?(u(),v("div",P,[e("div",T,[e("button",{class:"bg-gray-200 inline-flex items-center justify-center p-1 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition",onClick:s[0]||(s[0]=t=>o.value=!o.value)},A)]),e("div",L,[e("div",N,[e("button",{onClick:s[1]||(s[1]=(...t)=>i.show&&i.show(...t)),class:"bg-blue-600 inline-block p-2 rounded-full"},[l(I,{class:"text-white"})]),S]),e("div",q,[e("button",D,[l(k,{class:"text-white"})]),F]),e("div",K,[l(g(x),{class:"bg-white block border border-gray-200 p-2 rounded-full"},{default:c(()=>[l($,{class:"text-red-600"})]),_:1}),O])])])):_("",!0),e("div",z,[e("div",H,[e("div",R,[e("button",{onClick:s[2]||(s[2]=t=>o.value=!o.value)},[l(B)]),e("input",{type:"file",class:"hidden",id:"file",onChange:s[3]||(s[3]=t=>f())},null,32),h(e("input",{type:"text","onUpdate:modelValue":s[4]||(s[4]=t=>n.value=t),onKeyup:s[5]||(s[5]=y(t=>r(),["enter"])),placeholder:"Type a message",class:"w-full border-0 bg-gray-200 focus:outline-none focus:ring-0"},null,544),[[b,n.value]])]),e("div",G,[e("button",{onClick:s[6]||(s[6]=t=>r()),class:"text-white bg-blue-700 px-3 py-2 rounded-2xl"},[l(C)])])])])])])]),_:1},8,["name","profile_image"]))}};export{oe as default};
