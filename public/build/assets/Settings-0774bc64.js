import{d as _,e as s,b as t,w as a,F as p,o as r,a as e,t as m,f as v,i as g,g as d,u as b,h as x,L as w,j as M,l as L}from"./app-ad745f98.js";import{C as N}from"./ChemicalDetailsCard-6c195794.js";import{_ as O}from"./PrimaryButton-65f58580.js";import{_ as V}from"./SecondaryButton-efbe443f.js";import{L as $}from"./LogoutIcon-b8d63e69.js";import{_ as D}from"./DialogModal-ea914144.js";import{A as F}from"./AddUserIcon-88bcfd9c.js";import{B as U}from"./BinIcon-aba235df.js";import{_ as I}from"./ChatRoomLayout-1e97b12e.js";import"./BuildingIcon-56240bf1.js";import"./_plugin-vue_export-helper-c27b6911.js";import"./MapPinIcon-fb198b97.js";import"./UserIcon-f7658644.js";import"./helpers-3a38de6b.js";/* empty css                                                                            */import"./Modal-fb88d194.js";import"./ArrowLeftIcon-d696fddf.js";import"./Sidebar-8688ddd2.js";import"./ToastList-cd5f7580.js";const S={class:"max-w-[40rem] m-auto"},E={class:"px-2 flex-1 mb-[5rem] w-full"},P={class:"bg-white mt-2 p-2"},T={class:"text-sm text-gray-600 font-bold"},G={class:"bg-green-500 p-1 rounded-full"},q=e("p",null,"Add participants",-1),z=["src"],H={class:"w-full"},J={class:"w-full flex justify-between"},K={class:"bg-white mt-2 p-2"},Q=e("p",{class:"text-red-500"},"Exit group",-1),R=e("p",{class:"text-red-500"},"Delete Chat",-1),W={class:"mt-4"},X=e("p",{class:"mb-2"},"Add People",-1),Y={class:"flex items-center gap-2 mb-2"},Z=["value"],ee={for:"name"},xe={__name:"Settings",props:{confirmsTwoFactorAuthentication:Boolean,sessions:Array,chatroom:Object,members:Object,memberCount:Number,employees:Object,auth_member:Object,product:Object},setup(i){const l=i,n=_(!1),u=_([]),C=()=>{n.value=!0},f=()=>{n.value=!1},k=()=>{console.log("asdfasdf")},y=()=>{axios.post(route("sale.chatroom.addUser",{id:l.chatroom.id,staff:u.value})).then(c=>{window.location.reload(),n.value=!1})},j=()=>{if(!confirm("Are u sure u wanna leave the group"))return;b({user:page.props.value.user.id}).post(route("chatroom.exitGroup",{chatroom:l.chatroom}))},A=()=>{b({user:page.props.value.user.id}).post(route("chatroom.deleteMessages",{chatroom:l.chatroom}))};return(c,h)=>(r(),s(p,null,[t(I,{title:"Chatrom",name:`My Sale - ${l.chatroom.name}`,profile_image:"/assests/images/avatar.jpg"},{default:a(()=>[e("div",S,[e("div",E,[t(N,{details:i.product,link:null},null,8,["details"]),e("div",P,[e("p",T,m(l.memberCount)+" participants",1),i.auth_member.pivot.chat_left==0?(r(),s("button",{key:0,onClick:C,class:"p-2 flex items-center gap-2"},[e("div",G,[t(F,{class:"text-white"})]),q])):v("",!0),(r(!0),s(p,null,g(l.members,o=>(r(),s("div",{class:"flex gap-2 mb-2",onClick:k},[e("div",null,[e("img",{src:o.profile_photo_url,alt:"profile image",class:"h-[3rem] w-[3rem]"},null,8,z)]),e("div",H,[e("div",J,[t(x(w),{href:c.route("profile.display",{id:o.id})},{default:a(()=>[d(m(o.name),1)]),_:2},1032,["href"])]),t(x(w),{href:c.route("company.show",{id:o.company.id})},{default:a(()=>[d(m(o.company.name),1)]),_:2},1032,["href"])])]))),256))]),e("div",K,[i.auth_member.pivot.chat_left==0?(r(),s("button",{key:0,onClick:j,class:"flex p-2 gap-4"},[t($,{class:"text-red-500"}),Q])):v("",!0),e("button",{onClick:A,class:"flex p-2 gap-4"},[t(U,{class:"text-red-500"}),R])])])])]),_:1},8,["name","profile_image"]),t(D,{show:n.value,onClose:f},{content:a(()=>[e("div",W,[X,(r(!0),s(p,null,g(i.employees,o=>(r(),s("div",Y,[M(e("input",{type:"checkbox",name:"staff",value:o.id,"onUpdate:modelValue":h[0]||(h[0]=B=>u.value=B)},null,8,Z),[[L,u.value]]),e("label",ee,m(o.name),1)]))),256))])]),footer:a(()=>[t(V,{onClick:f},{default:a(()=>[d(" Cancel ")]),_:1}),t(O,{onClick:y,class:"ml-4"},{default:a(()=>[d(" Add ")]),_:1})]),_:1},8,["show"])],64))}};export{xe as default};
