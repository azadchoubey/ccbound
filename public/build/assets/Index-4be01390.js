import{u as f,c as k,w as l,o,a as e,b as _,h,L as u,e as a,i as y,F as v,t as i,g as w,f as c}from"./app-ad745f98.js";import{_ as g}from"./AppLayout-d8d9702b.js";import"./Banner-2b5a5794.js";import"./BottomTab-9c18cf54.js";import"./Sidebar-8688ddd2.js";import"./_plugin-vue_export-helper-c27b6911.js";import"./ToastList-cd5f7580.js";const C=e("h1",{class:"mb-8 text-3xl font-bold"},"Users",-1),N={class:"flex items-center justify-between mb-6"},A=e("span",null,"Create",-1),B=e("span",{class:"hidden md:inline"}," User",-1),F={class:"bg-white rounded-md shadow overflow-x-auto"},V={class:"w-full whitespace-nowrap"},$=e("thead",null,[e("tr",{class:"text-left font-bold"},[e("th",{class:"pb-4 pt-6 px-6"},"Date"),e("th",{class:"pb-4 pt-6 px-6"},"Name"),e("th",{class:"pb-4 pt-6 px-6"},"Email"),e("th",{class:"pb-4 pt-6 px-6"},"Number"),e("th",{class:"pb-4 pt-6 px-6 text-center",colspan:"4"},"Actions")])],-1),D={class:"border-t"},E={class:"flex items-center px-6 py-4 focus:text-indigo-500"},L={class:"border-t"},S={class:"flex items-center px-6 py-4 focus:text-indigo-500"},U={class:"border-t"},j={class:"flex items-center px-6 py-4",tabindex:"-1"},M={class:"border-t"},T={class:"flex items-center px-6 py-4",tabindex:"-1"},I={class:"border-t"},O=["href"],R={class:"border-t"},q={class:"border-t space-x-2"},z=["onClick"],G=["onClick"],H={class:"border-t"},J=["onClick"],K=["onClick"],te={__name:"Index",props:{confirmsTwoFactorAuthentication:Boolean,sessions:Array,users:Object},setup(x){const b=f({}),d=(s,n)=>{b.post(route("user.updaterole",{user:s,role:n}),{onFinish:()=>window.location.reload})},p=(s,n)=>{axios.patch(route("user.update",{user:s,status:n,type:"update_status"})).then(t=>{window.location.reload()})};return(s,n)=>(o(),k(g,{title:"Settings"},{default:l(()=>[C,e("div",N,[_(h(u),{class:"btn-indigo",href:s.route("user.create")},{default:l(()=>[A,B]),_:1},8,["href"])]),e("div",F,[e("table",V,[$,e("tbody",null,[(o(!0),a(v,null,y(x.users.data,(t,m)=>(o(),a("tr",{key:m,class:"hover:bg-gray-100 focus-within:bg-gray-100"},[e("td",D,[e("p",E,i(t.created_at.slice(0,10)),1)]),e("td",L,[e("p",S,i(t.name),1)]),e("td",U,[e("p",j,i(t.email),1)]),e("td",M,[e("p",T,i(t.number),1)]),e("td",I,[e("a",{href:s.route("profile.display",{id:t.id}),target:"_blank",class:"flex items-center px-4 hover:underline text-blue-600",tabindex:"-1"},"View",8,O)]),e("td",R,[_(h(u),{href:s.route("user.edit",{user:t.id}),class:"flex items-center px-4 hover:underline text-green-600",tabindex:"-1"},{default:l(()=>[w("Edit")]),_:2},1032,["href"])]),e("td",q,[t.active===0?(o(),a("button",{key:0,onClick:r=>p(t,1),class:"text-green-600"},"Activate",8,z)):c("",!0),t.active===1?(o(),a("button",{key:1,onClick:r=>p(t,0),class:"text-red-600"},"Deactivate",8,G)):c("",!0)]),e("td",H,[t.role==="user"?(o(),a("button",{key:0,onClick:r=>d(t,"admin"),class:"flex items-center px-4 hover:underline text-blue-600",tabindex:"-1"},"Make Admin",8,J)):c("",!0),t.role==="admin"?(o(),a("button",{key:1,onClick:r=>d(t,"user"),class:"flex items-center px-4 hover:underline text-blue-600",tabindex:"-1"},"Make User",8,K)):c("",!0)])]))),128))])])])]),_:1}))}};export{te as default};
