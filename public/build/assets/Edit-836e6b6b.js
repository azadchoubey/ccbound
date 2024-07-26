import{d as v,u as M,N as R,k as T,c as K,w as _,o as n,a as e,p as Q,b as a,h as o,g as S,t as p,e as u,f,j as g,R as z,i as y,F as b,l as U,E as j,K as $,B as G}from"./app-a99c1f11.js";import{_ as B}from"./DialogModal-264a62a2.js";import{_ as H}from"./PrimaryButton-47053d9a.js";import{_ as c}from"./InputError-00a923bd.js";import{_ as m}from"./InputLabel-4d3c9eb7.js";import{_ as h}from"./TextInput-aed48f04.js";import{_ as J}from"./FormLayout-08758c22.js";import{_ as L}from"./SecondaryButton-2db738a4.js";import"./Banner-af0e7d7b.js";import"./ArrowLeftIcon-f9739669.js";import"./_plugin-vue_export-helper-c27b6911.js";import"./Sidebar-08876489.js";import"./ToastList-b09059d6.js";const W={class:"max-w-[40rem]"},Y=e("div",{class:"justify-center hidden w-full p-4 md:flex"},[e("p",{class:"text-xl font-bold"},"Update Sale")],-1),Z={class:"px-[2rem] py-[1rem] bg-white"},ee=["onSubmit"],te={class:"mb-2"},se={class:"flex"},le=e("span",{class:"text-sm text-red-600"},"*",-1),oe={class:"mb-2"},ae={class:"flex"},ne=e("span",{class:"text-sm text-red-600"},"*",-1),ue={class:"grid grid-cols-2 gap-2 mb-2"},re=["href"],de=["src"],ie={class:"grid items-center grid-cols-1 gap-4 my-2"},ce={class:"grid grid-cols-3 gap-2"},me=e("div",null,null,-1),pe={class:"flex flex-col items-center w-full"},fe=e("div",null,null,-1),ve={class:"mt-2"},_e=e("p",{class:"text-lg"},"Staff Added",-1),ge={class:"grid grid-cols-1 gap-2 p-2 md:grid-cols-2"},ye={class:"flex justify-between p-2 bg-white border border-gray-200 rounded-lg"},be={class:"flex items-center gap-2"},he=["src"],xe=["onClick"],we=["href"],ke=["src"],qe=["src"],Ve=["src"],Ce={class:"flex items-center gap-2"},Se=e("label",{for:"enquiries"},"Enquiries",-1),je={class:"grid grid-cols-3"},Ne=e("div",null,null,-1),Ue={class:"w-full mt-2"},$e=e("div",null,null,-1),De={class:"grid grid-cols-2 gap-2"},Ee=e("option",{value:"",selected:"",disabled:""}," Select Country ",-1),Re=["value"],Be={key:0},Le=e("option",{value:"",selected:"",disabled:""}," Select State ",-1),Ie=["value"],Oe={key:1},Ae=e("option",{value:"",selected:"",disabled:""}," Select City ",-1),Pe=["value"],Xe=e("p",{class:"mt-2 text-red-600"}," Note: The sale will be deactivated after 14 days. ",-1),Fe={class:"grid grid-cols-3"},Me=e("div",null,null,-1),Te=e("div",null,null,-1),Ke={class:"mt-4"},Qe=e("p",{class:"mb-2"},"Add People",-1),ze={class:"p-2 mt-2 bg-white"},Ge={class:"flex gap-2"},He=e("option",{value:"user"},"User",-1),Je=e("option",{value:"company"},"Company",-1),We=[He,Je],Ye={class:"flex items-center gap-2 mb-2"},Ze=["value"],et={for:"name"},tt={class:"flex justify-end"},st={class:"mt-4"},lt=e("p",{class:"mb-2"},"Add Staff",-1),ot={class:"flex items-center gap-2 mb-2"},at=["value"],nt={for:"name"},ut={class:"flex justify-end"},xt={__name:"Edit",props:{employees:Object,sale:Object,staffDetails:Object,countries:Object,contacts:Object},setup(i){const r=i,q=v(!1),x=v(!1),w=v("user"),k=v(""),l=M({productName:r.sale.product_name,casNo:r.sale.cas_no,quantityRequired:r.sale.quantity_required,purityRequired:r.sale.purity_required,structure:null,description:r.sale.description,staff:v([]),docs:null,sale:r.sale.sale_show===1,quote:"",people:v([]),country:r.sale.country,state:r.sale.state,city:r.sale.city}),N=v(null),V=v(null);R(()=>{l.country&&$.get(route("states",{country:l.country})).then(d=>{N.value=d.data.length>0?d.data:null,V.value=null})}),R(()=>{l.state&&$.get(route("cities",{state:l.state})).then(d=>{V.value=d.data.length>0?d.data:null})});const I=T(()=>{if(k.value!==""){if(w.value==="user")return r.contacts.filter(d=>k.value.toLowerCase().split(" ").every(s=>d.name.toLowerCase().includes(s)));if(w.value==="company")return r.contacts.filter(d=>k.value.toLowerCase().split(" ").every(s=>d.company.name.toLowerCase().includes(s)))}else return r.contacts}),O=()=>{l.quote=document.getElementById("quote").value,l.post(route("sale.update",{sale:r.sale}),{onSuccess:d=>{G.Inertia.get(route("profile.display",{id:r.sale.user_id}))}})},A=d=>{$.post(route("sale.update",{type:"remove_staff",sale:r.sale,staff:d})).then(s=>{window.location.reload()})},D=()=>{l.structure=null,r.sale.structure=null,r.sale.structure_url=null,document.getElementById("structure").value=null},E=()=>{l.docs=null,r.sale.docs=null,r.sale.docs_url=null,document.getElementById("docs").value=null},P=d=>{const s=["jpg","jpeg","png","gif"],t=d.split(".").pop().toLowerCase();return s.includes(t)},X=d=>d.split(".").pop().toLowerCase()==="pdf",F=d=>d.split(".").pop().toLowerCase()==="docx";return(d,s)=>(n(),K(J,{title:"Update Sale"},{default:_(()=>[e("div",W,[Y,e("div",Z,[e("form",{onSubmit:Q(O,["prevent"])},[e("div",te,[e("div",se,[a(m,{for:"product_name",value:"Product Name"}),le]),a(h,{id:"product_name",modelValue:o(l).productName,"onUpdate:modelValue":s[0]||(s[0]=t=>o(l).productName=t),type:"text",class:"block w-full mt-1",required:""},null,8,["modelValue"]),a(c,{class:"mt-2",message:o(l).errors.productName},null,8,["message"])]),e("div",oe,[e("div",ae,[a(m,{for:"cas_no",value:"CAS No"}),ne]),a(h,{id:"cas_no",modelValue:o(l).casNo,"onUpdate:modelValue":s[1]||(s[1]=t=>o(l).casNo=t),type:"text",class:"block w-full mt-1",required:""},null,8,["modelValue"]),a(c,{class:"mt-2",message:o(l).errors.casNo},null,8,["message"])]),e("div",ue,[e("div",null,[a(m,{for:"quantity_required",value:"Quantity"}),a(h,{id:"quantity_required",modelValue:o(l).quantityRequired,"onUpdate:modelValue":s[2]||(s[2]=t=>o(l).quantityRequired=t),type:"text",class:"block w-full mt-1"},null,8,["modelValue"]),a(c,{class:"mt-2",message:o(l).errors.quantityRequired},null,8,["message"])]),e("div",null,[a(m,{for:"purity_required",value:"Purity"}),a(h,{id:"purity_required",modelValue:o(l).purityRequired,"onUpdate:modelValue":s[3]||(s[3]=t=>o(l).purityRequired=t),type:"text",class:"block w-full mt-1"},null,8,["modelValue"]),a(c,{class:"mt-2",message:o(l).errors.purityRequired},null,8,["message"])])]),e("div",null,[a(m,{for:"structure",value:"Structure"}),e("input",{type:"file",name:"structure",onInput:s[4]||(s[4]=t=>o(l).structure=t.target.files[0]),id:"structure",accept:".pdf, .jpg, .jpeg, .png, .doc, .docx"},null,32),S(p(i.sale.structure)+" ",1),o(l).structure?(n(),u("button",{key:0,type:"button",class:"text-red-800 bg-white rounded",onClick:D},"X")):f("",!0),a(c,{class:"mt-2",message:o(l).errors.structure},null,8,["message"]),e("div",null,[i.sale.structure?(n(),u("button",{key:0,type:"button",class:"ml-12 text-red-800 bg-white rounded",onClick:D},"X")):f("",!0),i.sale.structure?(n(),u("a",{key:1,href:i.sale.structure_url,target:"_blank"},[e("img",{src:i.sale.structure_url,alt:"structure",class:"h-[15rem]"},null,8,de)],8,re)):f("",!0)])]),e("div",ie,[e("div",null,[a(m,{for:"description",value:"Description"}),g(e("textarea",{type:"text",class:"block w-full mt-1","onUpdate:modelValue":s[5]||(s[5]=t=>o(l).description=t)},null,512),[[z,o(l).description]]),a(c,{class:"mt-2",message:o(l).errors.description},null,8,["message"])]),e("div",ce,[me,e("div",pe,[e("button",{type:"button",onClick:s[6]||(s[6]=t=>x.value=!0),class:"w-full py-2 text-white bg-blue-400 rounded-lg"}," Add Staff ")]),fe]),e("div",ve,[_e,e("div",ge,[(n(!0),u(b,null,y(i.staffDetails,t=>(n(),u("div",ye,[e("div",be,[e("img",{src:t.profile_photo_url,alt:"",class:"h-[2rem] rounded-full"},null,8,he),e("p",null,p(t.name),1)]),e("button",{type:"button",onClick:C=>A(t)}," X ",8,xe)]))),256))])]),e("div",null,[a(m,{for:"docs",value:"Docs"}),e("input",{type:"file",name:"docs",onInput:s[7]||(s[7]=t=>o(l).docs=t.target.files[0]),id:"docs",accept:".pdf, .jpg, .jpeg, .png, .doc, .docx"},null,32),o(l).docs?(n(),u("button",{key:0,type:"button",class:"text-red-800 bg-white rounded",onClick:E},"X")):f("",!0),a(c,{class:"mt-2",message:o(l).errors.docs},null,8,["message"]),e("div",null,[i.sale.docs?(n(),u("button",{key:0,type:"button",class:"mt-2 ml-12 text-red-800 bg-white rounded",onClick:E},"X")):f("",!0),i.sale.docs?(n(),u("a",{key:1,href:i.sale.docs_url,target:"_blank",class:"mt-10 ml-5"},[P(i.sale.docs)?(n(),u("img",{key:0,src:i.sale.docs_url,width:"80",height:"90"},null,8,ke)):X(i.sale.docs)?(n(),u("embed",{key:1,src:i.sale.docs_url,width:"80",height:"90",type:"application/pdf"},null,8,qe)):F(i.sale.docs)?(n(),u("img",{key:2,src:"/assests/images/docfile.png",width:"80",height:"90",class:"mt-10 ml-5"},null,8,Ve)):f("",!0),e("p",null,p(i.sale.docs),1)],8,we)):f("",!0)])])]),e("div",Ce,[g(e("input",{type:"checkbox",name:"enquiries",id:"enquiries","onUpdate:modelValue":s[8]||(s[8]=t=>o(l).sale=t),checked:""},null,512),[[U,o(l).sale]]),Se]),a(h,{id:"quote",modelValue:o(l).quote,"onUpdate:modelValue":s[9]||(s[9]=t=>o(l).quote=t),type:"text",class:"block w-full mt-1",value:`${o(l).productName}`},null,8,["modelValue","value"]),a(c,{class:"mt-2",message:o(l).errors.quote},null,8,["message"]),e("div",je,[Ne,e("div",Ue,[e("button",{type:"button",onClick:s[10]||(s[10]=t=>q.value=!0),class:"w-full py-2 text-white bg-blue-500 rounded-lg"}," Share with ")]),$e]),e("div",De,[e("div",null,[a(m,{for:"country",value:"Country"}),g(e("select",{class:"w-full border border-gray-200 rounded-lg","onUpdate:modelValue":s[11]||(s[11]=t=>o(l).country=t),required:""},[Ee,(n(!0),u(b,null,y(i.countries,t=>(n(),u("option",{value:t.id},p(t.name),9,Re))),256))],512),[[j,o(l).country]]),a(c,{class:"mt-2",message:o(l).errors.country},null,8,["message"])]),N.value?(n(),u("div",Be,[a(m,{for:"state",value:"State"}),g(e("select",{class:"w-full border border-gray-200 rounded-lg","onUpdate:modelValue":s[12]||(s[12]=t=>o(l).state=t)},[Le,(n(!0),u(b,null,y(N.value,t=>(n(),u("option",{value:t.id},p(t.name),9,Ie))),256))],512),[[j,o(l).state]]),a(c,{class:"mt-2",message:o(l).errors.state},null,8,["message"])])):f("",!0),V.value?(n(),u("div",Oe,[a(m,{for:"city",value:"City"}),g(e("select",{class:"w-full border border-gray-200 rounded-lg","onUpdate:modelValue":s[13]||(s[13]=t=>o(l).city=t)},[Ae,(n(!0),u(b,null,y(V.value,t=>(n(),u("option",{value:t.id},p(t.name),9,Pe))),256))],512),[[j,o(l).city]]),a(c,{class:"mt-2",message:o(l).errors.city},null,8,["message"])])):f("",!0)]),Xe,e("div",Fe,[Me,a(H,{class:"mt-4 w-full flex justify-center rounded-lg font-bold p-2 mb-[5rem] bg-blue-600"},{default:_(()=>[S(" Submit")]),_:1}),Te])],40,ee)])]),a(B,{show:q.value,onClose:s[18]||(s[18]=t=>q.value=!1)},{content:_(()=>[e("div",Ke,[Qe,e("div",ze,[e("div",Ge,[g(e("select",{"onUpdate:modelValue":s[14]||(s[14]=t=>w.value=t),class:"rounded-lg"},We,512),[[j,w.value]]),a(h,{type:"text",class:"flex-1",modelValue:k.value,"onUpdate:modelValue":s[15]||(s[15]=t=>k.value=t),placeholder:`Search ${w.value}`},null,8,["modelValue","placeholder"])])]),(n(!0),u(b,null,y(o(I),t=>(n(),u("div",Ye,[g(e("input",{type:"checkbox",name:"contact",id:"contact",value:t,"onUpdate:modelValue":s[16]||(s[16]=C=>o(l).people=C)},null,8,Ze),[[U,o(l).people]]),e("label",et,p(t.name)+" @ "+p(t.company.name),1)]))),256))])]),footer:_(()=>[e("div",tt,[a(L,{type:"button",onClick:s[17]||(s[17]=t=>q.value=!1)},{default:_(()=>[S("Ok")]),_:1})])]),_:1},8,["show"]),a(B,{show:x.value,onClose:s[21]||(s[21]=t=>x.value=!x.value)},{content:_(()=>[e("div",st,[lt,(n(!0),u(b,null,y(i.employees,t=>(n(),u("div",ot,[g(e("input",{type:"checkbox",name:"staff",value:t.id,"onUpdate:modelValue":s[19]||(s[19]=C=>o(l).staff=C)},null,8,at),[[U,o(l).staff]]),e("label",nt,p(t.name),1)]))),256))])]),footer:_(()=>[e("div",ut,[a(L,{type:"button",onClick:s[20]||(s[20]=t=>x.value=!1)},{default:_(()=>[S("Ok")]),_:1})])]),_:1},8,["show"])]),_:1}))}};export{xt as default};
