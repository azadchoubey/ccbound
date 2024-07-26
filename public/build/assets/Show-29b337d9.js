import{d as p,y as M,k as A,c as I,w as S,o as n,a as s,t as o,g,b,p as L,j as y,R as Q,l as V,h as m,m as E,e as u,f as _,n as h,i as O,F as R,K as f,u as z,L as K,P as G,Q as H}from"./app-ad745f98.js";import{_ as J}from"./AppLayout-d8d9702b.js";import{_ as W}from"./PrimaryButton-804b527b.js";import{_ as X}from"./TextInput-b0ea2240.js";import{t as Y}from"./laravel-vue-pagination.es-5db2614b.js";import Z from"./ConfirmModal-f517b05b.js";import{f as j,c as ee,a as se}from"./helpers-3a38de6b.js";import{_ as te}from"./_plugin-vue_export-helper-c27b6911.js";import"./Banner-2b5a5794.js";import"./BottomTab-9c18cf54.js";import"./Sidebar-8688ddd2.js";import"./ToastList-cd5f7580.js";const q=v=>(G("data-v-94c0883a"),v=v(),H(),v),ae={class:"max-w-[45rem]"},le={class:"flex flex-col px-2 bg-white"},oe={class:"bg-white p-[1rem]"},ne=q(()=>s("p",{class:"text-xl font-bold"},"My Enquiry",-1)),re={class:"text-xl font-bold"},de={class:"px-2 mt-2 md:px-0"},ue={class:"mt-4"},ie={class:"my-5"},ce=q(()=>s("p",{class:"text-xl font-bold"},"Share message",-1)),me=["onSubmit"],pe={class:"flex justify-end w-full"},_e={class:"flex justify-between items-center pr-[2rem]"},he={class:"grid grid-cols-2 border-b-[1px] border-gray-200"},fe={class:"flex items-center w-full gap-4 p-1 rounded-lg"},ve=["value"],ge={class:"relative"},be=["onUpdate:modelValue","onChange"],xe={key:0,class:"font-bold"},ye={key:0},we={key:1},ke={key:0,class:"text-blue-400"},Ce={key:0,class:"float-right text-sm text-gray-500"},Se={key:1,class:"float-right text-sm text-gray-500"},Ve={class:"flex justify-center mt-2"},$e={__name:"Show",props:{confirmsTwoFactorAuthentication:Boolean,sessions:Array,chat:Object,chatrooms:Object},setup(v){const l=v,r=p("all"),d=p(l.chatrooms),w=p(null),k=p(null),i=p([]),$=a=>{r.value=a},B=(a=1)=>{f.get(route("enquiry.chats.show",{page:a,tab:r.value,chat:l.chat.id,search:newSearchQuery})).then(t=>{d.value=t.data})};M(w,async(a,t)=>{a.value!==""?f.get(route("enquiry.chats.show",{tab:r.value,chat:l.chat.id,search:a})).then(e=>{console.log(e),d.value=e.data}):window.location.reload()}),M(r,async(a,t)=>{f.get(route("enquiry.chats.show",{tab:r.value,chat:l.chat.id})).then(e=>{d.value=e.data})});const D=a=>{f.post(route("enquiry.chats.star",{chat:l.chat,chatroom:a})).then(t=>{console.log(t.data)})},T=()=>{f.post(route("chatroom.shareMessage",{message:k.value,chatrooms:i.value})).then(a=>{window.location.reload()})},C=A({get(){return d.value?i.value.length==d.value.length:!1},set(a){var t=[];a&&d.value.data.forEach(function(e){t.push(e)}),i.value=t}}),x=p(!1),U=()=>{x.value=!0},F=()=>{x.value=!1},N=()=>{x.value=!1,z().post(route("chatroom.deleteChats",{chatrooms:i.value})),f.get(`enquiry-chats/${l.chat.id}`).then(t=>{d.value=t.data})},P=a=>a.replace(l.chat.product_name+"-"+l.chat.cas_no+" - ","").trim();return(a,t)=>(n(),I(J,{title:"Chats"},{default:S(()=>[s("div",ae,[s("div",le,[s("div",oe,[ne,s("p",re,o(l.chat.product_name),1),s("p",null,o(l.chat.cas_no),1),s("p",null,[g("Posted By: "),s("b",null,o(l.chat.user.name),1),g("@"+o(l.chat.user.company.name),1)])])]),s("div",de,[b(X,{type:"text",class:"w-full p-2 bg-gray-200",modelValue:w.value,"onUpdate:modelValue":t[0]||(t[0]=e=>w.value=e),placeholder:"Search"},null,8,["modelValue"]),s("div",ue,[s("div",ie,[ce,s("form",{onSubmit:L(T,["prevent"])},[y(s("textarea",{class:"w-full rounded-lg focus:outline-none","onUpdate:modelValue":t[1]||(t[1]=e=>k.value=e),required:""},null,512),[[Q,k.value]]),s("div",pe,[b(W,{class:"bg-blue-600 border-blue-600"},{default:S(()=>[g("Share")]),_:1})])],40,me)]),s("div",_e,[y(s("input",{type:"checkbox","onUpdate:modelValue":t[2]||(t[2]=e=>E(C)?C.value=e:null)},null,512),[[V,m(C)]]),i.value.length>0?(n(),u("button",{key:0,onClick:U,class:"px-4 py-2 text-sm text-white bg-red-600 rounded-lg"},"Delete")):_("",!0)]),s("div",he,[s("button",{onClick:t[3]||(t[3]=e=>$("all")),class:h(`${r.value==="all"?"border-b-[1px] pb-2 border-black":""} transition-all duration-500`)},[s("p",{class:h(` ${r.value==="all"?"font-bold":""} w-full flex justify-center`)}," All Chats ",2)],2),s("button",{onClick:t[4]||(t[4]=e=>$("starred")),class:h(`${r.value==="starred"?"border-b-[1px] pb-2 border-black":""} transition-all duration-500`)},[s("p",{class:h(` ${r.value==="starred"?"font-bold":""} w-full flex justify-center`)}," Starred ",2)],2)]),(n(!0),u(R,null,O(d.value.data,e=>(n(),u("div",{class:h(["mt-4","bg-white flex items-center gap-2 px-[0.2rem]"])},[s("div",fe,[y(s("input",{type:"checkbox",class:"block",value:e,"onUpdate:modelValue":t[5]||(t[5]=c=>i.value=c)},null,8,ve),[[V,i.value]]),s("div",ge,[y(s("input",{class:"block star",type:"checkbox","onUpdate:modelValue":c=>e.starred=c,onChange:c=>D(e.id)},null,40,be),[[V,e.starred]])]),b(m(K),{href:a.route("enquiry.chatroom.show",{chatroom:e}),class:"flex justify-between w-full py-2"},{default:S(()=>{var c;return[s("div",null,[e.last_message&&e.last_message.user?(n(),u("p",xe,[e.members.length>0&&e.members[1]&&e.members[1].id!=e.auth_id?(n(),u("span",ye,o(e.members[1].name),1)):e.members.length>0&&e.members[0].id!=e.auth_id?(n(),u("span",we,o(e.members[0].name),1)):_("",!0),g(" ("+o(P(e.name))+") ",1)])):_("",!0),s("p",{class:h(`text-sm ${e.message_read!==!0?"font-bold":""}`)},[e.last_message&&e.last_message.user?(n(),u("span",ke,o(e.last_message.user.name),1)):_("",!0),g(": "+o((c=e==null?void 0:e.last_message)==null?void 0:c.message),1)],2)])]}),_:2},1032,["href"])]),e.last_message&&m(j)(e.last_message.created_at)!=m(ee)()?(n(),u("span",Ce,o(m(j)(e.last_message.created_at)),1)):_("",!0),e.last_message?(n(),u("span",Se,o(m(se)(e.last_message.created_at)),1)):_("",!0)],2))),256)),s("div",Ve,[b(m(Y),{data:d.value,onPaginationChangePage:B},null,8,["data"])])])])]),b(Z,{show:x.value,message:"This will delete the Message From Both sides.",onClose:F,onConfirm:N},null,8,["show","message"])]),_:1}))}},Le=te($e,[["__scopeId","data-v-94c0883a"]]);export{Le as default};