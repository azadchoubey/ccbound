import{d as p,y as $,k as A,c as I,w as S,o as n,a as s,t as o,g as b,b as v,p as L,j as x,R as Q,l as C,h as m,m as q,e as d,f as _,n as h,i as E,F as O,u as R,L as W,P as z,Q as G}from"./app-ad745f98.js";import{_ as H}from"./PrimaryButton-65f58580.js";import{_ as J}from"./TextInput-e764b81b.js";import{_ as K}from"./AppLayout-d8d9702b.js";import{t as X}from"./laravel-vue-pagination.es-5db2614b.js";import Y from"./ConfirmModal-f517b05b.js";import{f as M,c as Z,a as ee}from"./helpers-3a38de6b.js";import{_ as se}from"./_plugin-vue_export-helper-c27b6911.js";import"./Banner-2b5a5794.js";import"./BottomTab-9c18cf54.js";import"./Sidebar-8688ddd2.js";import"./ToastList-cd5f7580.js";import"./PrimaryButton-804b527b.js";const j=f=>(z("data-v-827b1bb5"),f=f(),G(),f),te={class:"max-w-[45rem]"},ae={class:"flex flex-col px-2 bg-white"},le={class:"bg-white p-[1rem]"},oe=j(()=>s("p",{class:"text-xl font-bold"},"My Sale",-1)),ne={class:"text-xl font-bold"},re={class:"px-2 mt-2 md:px-0"},de={class:"mt-4"},ie={class:"my-5"},ce=j(()=>s("p",{class:"text-xl font-bold"},"Share message",-1)),ue=["onSubmit"],me={class:"flex justify-end w-full"},pe={class:"flex justify-between items-center pr-[2rem]"},_e={class:"grid grid-cols-2 border-b-[1px] border-gray-200"},he={class:"flex items-center w-full gap-4 p-1 rounded-lg"},fe=["value"],be={class:"relative"},ve=["onUpdate:modelValue","onChange"],ge={class:"flex items-center justify-between w-full"},xe={class:"font-bold"},we={key:0},ye={key:1},ke={key:0,class:"text-blue-400"},Se={key:0,class:"w-3 h-3 bg-black rounded-full"},Ce={key:0,class:"float-right text-sm text-gray-500"},Ve={key:1,class:"float-right text-sm text-gray-500"},$e={class:"flex justify-center mt-2"},Me={__name:"Show",props:{confirmsTwoFactorAuthentication:Boolean,sessions:Array,chat:Object,chatrooms:Object},setup(f){const l=f,r=p("all"),i=p(l.chatrooms);console.log(l.chat);const w=p(null),y=p(null),c=p([]),V=a=>{r.value=a},B=(a=1)=>{axios.get(route("enquiry.chats.show",{page:a,tab:r.value,chat:l.chat.id,search:newSearchQuery})).then(t=>{i.value=t.data})};$(w,async(a,t)=>{a.value!==""?axios.get(route("sale.chats.show",{tab:r.value,chat:l.chat.id,search:a})).then(e=>{i.value=e.data}):window.location.reload()}),$(r,async(a,t)=>{axios.get(route("sale.chats.show",{tab:r.value,chat:l.chat.id})).then(e=>{i.value=e.data})});const D=a=>{axios.post(route("sale.chats.star",{chat:l.chat,chatroom:a})).then(t=>{console.log(t.data)})},T=()=>{axios.post(route("chatroom.shareMessage",{message:y.value,chatrooms:c.value})).then(a=>{window.location.reload()})},k=A({get(){return i.value?c.value.length==i.value.length:!1},set(a){var t=[];a&&i.value.data.forEach(function(e){t.push(e.id)}),c.value=t}}),g=p(!1),U=()=>{g.value=!0},F=()=>{g.value=!1},N=()=>{g.value=!1,R().post(route("chatroom.deleteChats",{chatrooms:c.value}))},P=a=>a.replace(/\s+/g,"").replace(l.chat.product_name.replace(/\s+/g,"")+"-"+l.chat.cas_no.replace(/\s+/g,"")+"-"," ").trim();return(a,t)=>(n(),I(K,{title:"Chats"},{default:S(()=>[s("div",te,[s("div",ae,[s("div",le,[oe,s("p",ne,o(l.chat.product_name),1),s("p",null,o(l.chat.cas_no),1),s("p",null,[b("Posted By: "),s("b",null,o(l.chat.user.name),1),b("@"+o(l.chat.user.company.name),1)])])]),s("div",re,[v(J,{type:"text",class:"w-full p-2 bg-gray-200",modelValue:w.value,"onUpdate:modelValue":t[0]||(t[0]=e=>w.value=e),placeholder:"Search"},null,8,["modelValue"]),s("div",de,[s("div",ie,[ce,s("form",{onSubmit:L(T,["prevent"])},[x(s("textarea",{class:"w-full rounded-lg focus:outline-none","onUpdate:modelValue":t[1]||(t[1]=e=>y.value=e),required:""},null,512),[[Q,y.value]]),s("div",me,[v(H,{class:"bg-blue-600 border-blue-600"},{default:S(()=>[b("Share")]),_:1})])],40,ue)]),s("div",pe,[x(s("input",{type:"checkbox","onUpdate:modelValue":t[2]||(t[2]=e=>q(k)?k.value=e:null)},null,512),[[C,m(k)]]),c.value.length>0?(n(),d("button",{key:0,onClick:U,class:"px-4 py-2 text-sm text-white bg-red-600 rounded-lg"},"Delete")):_("",!0)]),s("div",_e,[s("button",{onClick:t[3]||(t[3]=e=>V("all")),class:h(`${r.value==="all"?"border-b-[1px] pb-2 border-black":""} transition-all duration-500`)},[s("p",{class:h(` ${r.value==="all"?"font-bold":""} w-full flex justify-center`)}," All Chats ",2)],2),s("button",{onClick:t[4]||(t[4]=e=>V("starred")),class:h(`${r.value==="starred"?"border-b-[1px] pb-2 border-black":""} transition-all duration-500`)},[s("p",{class:h(` ${r.value==="starred"?"font-bold":""} w-full flex justify-center`)}," Starred ",2)],2)]),(n(!0),d(O,null,E(i.value.data,e=>(n(),d("div",{class:h(["mt-4","bg-white flex items-center gap-2 px-[0.2rem]"])},[s("div",he,[x(s("input",{type:"checkbox",class:"block",value:e,"onUpdate:modelValue":t[5]||(t[5]=u=>c.value=u)},null,8,fe),[[C,c.value]]),s("div",be,[x(s("input",{class:"block star",type:"checkbox","onUpdate:modelValue":u=>e.starred=u,onChange:u=>D(e.id)},null,40,ve),[[C,e.starred]])]),v(m(W),{href:a.route("sale.chatroom.show",{chatroom:e}),class:"w-full py-2"},{default:S(()=>{var u;return[s("div",ge,[s("div",null,[s("p",xe,[e.members.length>0&&e.members[1]&&e.members[1].id!=e.auth_id?(n(),d("span",we,o(e.members[1].name),1)):e.members.length>0&&e.members[0].id!=e.auth_id?(n(),d("span",ye,o(e.members[0].name),1)):_("",!0),b(" ("+o(P(e.name))+") ",1)]),s("p",{class:h(`text-sm ${e.message_read!==!0?"font-bold":""}`)},[e.last_message&&e.last_message.user?(n(),d("span",ke,o(e.last_message.user.name),1)):_("",!0),b(": "+o((u=e==null?void 0:e.last_message)==null?void 0:u.message),1)],2)]),s("div",null,[e.message_read?_("",!0):(n(),d("div",Se))])])]}),_:2},1032,["href"])]),e.last_message&&m(M)(e.last_message.created_at)!=m(Z)()?(n(),d("span",Ce,o(m(M)(e.last_message.created_at)),1)):_("",!0),e.last_message?(n(),d("span",Ve,o(m(ee)(e.last_message.created_at)),1)):_("",!0)],2))),256)),v(Y,{show:g.value,message:"This will delete the Message From Both sides.",onClose:F,onConfirm:N},null,8,["show","message"]),s("div",$e,[v(m(X),{data:i.value,onPaginationChangePage:B},null,8,["data"])])])])])]),_:1}))}},Ee=se(Me,[["__scopeId","data-v-827b1bb5"]]);export{Ee as default};