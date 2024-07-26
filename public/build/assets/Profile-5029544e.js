import{d as f,u as J,y as W,c as O,w as u,o,a as l,t as k,e as a,b as r,g as v,h as c,L as $,f as i,n as g,m as Y,i as N,F as S,K as p}from"./app-a99c1f11.js";import{C as V}from"./ChemicalDetailsCard-80e77b85.js";import{_ as F}from"./InfiniateScroll-90a21e0f.js";import{_ as Z}from"./TextInput-a7862116.js";import{A as Q}from"./ArrowRightIcon-7d23a428.js";import{_ as ee}from"./ProfileLayout-46c7cae0.js";import{_ as T}from"./DialogModal-c682f939.js";import{_ as P}from"./SecondaryButton-9f95c4b3.js";import"./BuildingIcon-6438f979.js";import"./_plugin-vue_export-helper-c27b6911.js";import"./MapPinIcon-609e4c0a.js";import"./UserIcon-5b9f3114.js";import"./helpers-3a38de6b.js";/* empty css                                                                            */import"./ArrowLeftIcon-f9739669.js";import"./WalletIcon-e52bed39.js";import"./LogoutIcon-25c55303.js";import"./MoneyIcon-6dab46af.js";import"./UserGroupIcon-c8a6de1d.js";import"./BottomTab-9f3a44df.js";import"./Sidebar-08876489.js";import"./ToastList-b09059d6.js";import"./Modal-6b8225ed.js";const te={class:"h-full md:w-[40rem] lg:w-[40rem] md:mt-2"},le={class:"p-2 bg-white"},oe={class:"inline-block rounded-full border-[3px] border-gray-300"},ae=["src"],se={class:"text-2xl font-bold"},re={key:0},ie={key:1},ne={key:2},de={key:3},ue={class:"flex items-center gap-2 mt-2"},ce=["src"],fe={class:"text-sm"},pe=["href"],ve=l("span",{class:"inline-block"},"Edit Profile",-1),he={class:"py-4 bg-gray-100"},me={class:"grid grid-cols-3 border-b-[1px] border-gray-200"},be={class:"px-2"},ye={class:"grid grid-cols-1 gap-2 mt-2"},_e={key:0,class:"grid w-full grid-cols-3 py-2 bg-white border-t border-gray-200"},ke=["onClick"],ge={key:0},we={key:1},Ce=["onClick"],xe=["onClick"],$e={key:0,class:"grid w-full grid-cols-3 py-2 bg-white border-t border-gray-200"},Xe=["onClick"],je={key:0},Ae={key:1,class:"text-red-600"},De=["onClick"],qe=["onClick"],Pe={key:0,class:"grid w-full grid-cols-3 py-2 bg-white border-t border-gray-200"},Ee=["onClick"],Le={key:0},Re=["onClick"],Ne={key:2,class:"text-red-600"},Se=l("div",{class:"mt-4"},[l("p",{class:"mb-2"},"Are you sure you want to delete?")],-1),Ve=l("div",{class:"mt-4"},[l("p",{class:"mb-2"},"Are you sure you want to delete?")],-1),it={__name:"Profile",props:{confirmsTwoFactorAuthentication:Boolean,sessions:Array,profile:Object,enquiries:Object,sales:Object,products:Object,authID:Number},setup(s){const X=s,n=f("enquiry"),E=X.authID,h=f(X.enquiries),m=f(X.sales),w=f(X.products),z=J({}),L=t=>{n.value=t},R=()=>{if(h.value.next_page_url)return p.get(h.value.next_page_url,{tab:n}).then(t=>{n==="enquiry"?h.value={...t.data,data:[...h.value.data,...t.data.data]}:n==="sales"?m.value={...t.data,data:[...m.value.data,...t.data.data]}:n==="products"&&(w.value={...t.data,data:[...w.value.data,...t.data.data]})})},M=(t,d)=>{confirm("Are you sure?")&&p.post(route("enquiry.update",{type:"status_update",enquiry:t,status:d})).then(e=>{window.location.reload()})},K=t=>{confirm("Are you sure?")&&z.delete(route("enquiry.destroy",{enquiry:t}),{onFinish:()=>window.location.reload()})};let j=f(!1),A=f(!1),b=f(null),C=f(null),x=f(null),y=f(null);const B=(t,d,e)=>{y.value=d,e=="sale"&&(C.value=t,j.value=!0),e=="product"&&(x.value=t,A.value=!0)},D=()=>{A.value=!1,j.value=!1,C.value=null,x.value=null,y.value=null},U=()=>{m.value.data.splice(y.value,1),j.value=!1,p.delete(`/sales/${C.value}`).then(t=>{x.value=null,C.value=null,y.value=null})},G=()=>{w.value.data.splice(y.value,1),A.value=!1,p.delete(`/product/${x.value}`).then(t=>{x.value=null,C.value=null,y.value=null})},I=(t,d)=>{confirm("Are you sure?")&&p.post(route("sale.update",{type:"status_update",sale:t,status:d})).then(e=>{window.location.reload()})},H=t=>{confirm("Are you sure?")&&p.post(route("product.share",{product:t})).then(d=>{d.status===200&&(alert("Product shared to sales"),window.location.reload())})};return W(b,async(t,d)=>{t.value!==""?n.value=="products"?p.get(route("product.index",{search:t})).then(e=>{w.value=e.data}):n.value=="sales"?p.get(route("sales.index",{search:t})).then(e=>{m.value=e.data,m.value.data.length||(showProducts.value=!0)}):n.value=="enquiry"&&(console.log("enter enquiry"),p.get(route("enquiry.index",{search:t})).then(e=>{h.value=e.data}),console.log("EXIT =>",h)):window.location.reload(),b.value!=""}),(t,d)=>(o(),O(ee,{title:"Profile"},{default:u(()=>[l("div",te,[l("div",le,[l("div",oe,[l("img",{src:s.profile.profile_photo_url,alt:"profile image",class:"h-[7rem] w-[7rem] rounded-full"},null,8,ae)]),l("p",se,k(s.profile.name),1),t.$page.props.user.id!=s.profile.id&&s.profile.hide_email===1?(o(),a("p",re,"XXXXXXXXXX")):(o(),a("p",ie,k(s.profile.email),1)),t.$page.props.user.id!=s.profile.id&&s.profile.hide_number===1?(o(),a("p",ne,"XXXXXXXXXX")):(o(),a("p",de,k(s.profile.number),1)),l("div",ue,[l("img",{src:s.profile.company.logo_url,alt:"company logo",class:"w-[10rem]"},null,8,ce),r(c($),{href:t.route("company.show",{id:s.profile.company_id})},{default:u(()=>[v("@"+k(s.profile.company.name),1)]),_:1},8,["href"])]),l("p",fe,k(s.profile.address),1),l("a",{href:s.profile.company.website,target:"_blank",class:"block text-blue-600"},k(s.profile.company.website),9,pe),s.profile.canEdit?(o(),O(c($),{key:4,href:t.route("profile.show"),class:"bg-[#0095F6] text-white flex items-center w-[8rem] px-3 py-2 rounded-lg mb-3"},{default:u(()=>[ve,r(Q,{class:"inline-block"})]),_:1},8,["href"])):i("",!0)]),l("div",he,[l("div",me,[l("button",{onClick:d[0]||(d[0]=e=>L("enquiry")),class:g(`${n.value==="enquiry"?"border-b-[1px] pb-2 border-black":""} transition-all duration-500`)},[l("p",{class:g(` ${n.value==="enquiry"?"font-bold":""} w-full flex justify-center`)}," Enquiries ",2)],2),l("button",{onClick:d[1]||(d[1]=e=>L("sales")),class:g(`${n.value==="sales"?"border-b-[1px] pb-2 border-black":""} transition-all duration-500`)},[l("p",{class:g(` ${n.value==="sales"?"font-bold":""} w-full flex justify-center`)}," Sales ",2)],2),l("button",{onClick:d[2]||(d[2]=e=>L("products")),class:g(`${n.value==="products"?"border-b-[1px] pb-2 border-black":""} transition-all duration-500`)},[l("p",{class:g(` ${n.value==="products"?"font-bold":""} w-full flex justify-center`)}," Products ",2)],2)]),l("div",null,[l("div",be,[r(Z,{type:"text",modelValue:c(b),"onUpdate:modelValue":d[3]||(d[3]=e=>Y(b)?b.value=e:b=e),class:"mt-3 block w-full h-[2.5rem] p-1",placeholder:"Search Product Name/CAS No"},null,8,["modelValue"])])]),l("div",ye,[r(F,{onLoadMore:R,class:"space-y-4"},{default:u(()=>[n.value==="enquiry"?(o(!0),a(S,{key:0},N(h.value.data,e=>(o(),a("div",null,[r(V,{details:e,link:t.route("sale.chats.redirect",{enquiry:e.id}),id:c(E)},null,8,["details","link","id"]),t.$page.props.user.id===s.profile.id?(o(),a("div",_e,[r(c($),{href:t.route("enquiry.edit",{enquiry:e}),class:"flex justify-center w-full text-blue-600"},{default:u(()=>[v(" Edit and Reshare")]),_:2},1032,["href"]),l("button",{onClick:_=>K(e),class:"text-red-600"},"Delete",8,ke),e.approved===0?(o(),a("button",ge,"Pending")):i("",!0),e.approved===2?(o(),a("button",we,"Rejected")):i("",!0),e.approved===1&&e.status===!1?(o(),a("button",{key:2,onClick:_=>M(e,"activate"),class:"text-green-600"},"Activate",8,Ce)):i("",!0),e.approved===1&&e.status===!0?(o(),a("button",{key:3,onClick:_=>M(e,"deactivate"),class:"text-red-600"},"Deactivate",8,xe)):i("",!0)])):i("",!0)]))),256)):i("",!0)]),_:1}),r(F,{onLoadMore:R,class:"space-y-4"},{default:u(()=>[n.value==="sales"?(o(!0),a(S,{key:0},N(m.value.data,(e,_)=>(o(),a("div",null,[r(V,{details:e,link:t.route("enquiry.chats.redirect",{sale:e.id}),id:c(E)},null,8,["details","link","id"]),t.$page.props.user.id===s.profile.id?(o(),a("div",$e,[r(c($),{href:t.route("sale.edit",{sale:e}),class:"flex justify-center w-full text-blue-600"},{default:u(()=>[v("Edit and Reshare")]),_:2},1032,["href"]),l("button",{class:"text-red-600",onClick:q=>B(e.id,_,"sale")},"Delete",8,Xe),e.approved===0?(o(),a("button",je,"Pending")):i("",!0),e.approved===2?(o(),a("button",Ae,"Rejected")):i("",!0),e.approved===1&&e.status===!1?(o(),a("button",{key:2,onClick:q=>I(e,"activate"),class:"text-green-600"},"Activate",8,De)):i("",!0),e.approved===1&&e.status===!0?(o(),a("button",{key:3,onClick:q=>I(e,"deactivate"),class:"text-red-600"},"Deactivate",8,qe)):i("",!0)])):i("",!0)]))),256)):i("",!0)]),_:1}),r(F,{onLoadMore:R,class:"space-y-4"},{default:u(()=>[n.value==="products"?(o(!0),a(S,{key:0},N(w.value.data,(e,_)=>(o(),a("div",null,[r(V,{details:e,link:t.route("product.chats.redirect",{product:e.id}),id:c(E)},null,8,["details","link","id"]),t.$page.props.user.id===s.profile.id?(o(),a("div",Pe,[r(c($),{href:t.route("product.edit",{product:e}),class:"flex justify-center w-full text-blue-600"},{default:u(()=>[v(" Edit and Reshare")]),_:2},1032,["href"]),l("button",{class:"text-red-600",onClick:q=>B(e.id,_,"product")},"Delete",8,Ee),e.approved===0?(o(),a("button",Le,"Pending")):i("",!0),e.approved===1?(o(),a("button",{key:1,onClick:q=>H(e),class:"text-blue-600"},"Share to sales",8,Re)):i("",!0),e.approved===2?(o(),a("button",Ne,"Rejected")):i("",!0)])):i("",!0)]))),256)):i("",!0)]),_:1})])])]),r(T,{show:c(j),onClose:D},{content:u(()=>[Se]),footer:u(()=>[r(P,{onClick:U},{default:u(()=>[v(" Delete ")]),_:1}),r(P,{onClick:D},{default:u(()=>[v(" Cancel ")]),_:1})]),_:1},8,["show"]),r(T,{show:c(A),onClose:D},{content:u(()=>[Ve]),footer:u(()=>[r(P,{onClick:G},{default:u(()=>[v(" Delete ")]),_:1}),r(P,{onClick:D},{default:u(()=>[v(" Cancel ")]),_:1})]),_:1},8,["show"])]),_:1}))}};export{it as default};
