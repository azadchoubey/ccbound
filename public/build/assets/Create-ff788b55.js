import{d as c,u as O,N as j,k as P,c as F,w as m,o as n,a as e,p as M,b as a,h as o,j as p,l as $,e as d,f as q,R as T,E as V,i as b,F as x,g as U,t as f}from"./app-a99c1f11.js";import{_ as R}from"./DialogModal-264a62a2.js";import{_ as r}from"./InputError-00a923bd.js";import{_ as i}from"./InputLabel-4d3c9eb7.js";import{_ as v}from"./TextInput-aed48f04.js";import{_ as Q}from"./PrimaryButton-47053d9a.js";import{_ as A}from"./SecondaryButton-2db738a4.js";import{_ as X}from"./FormLayout-08758c22.js";import"./Banner-af0e7d7b.js";import"./ArrowLeftIcon-f9739669.js";import"./_plugin-vue_export-helper-c27b6911.js";import"./Sidebar-08876489.js";import"./ToastList-b09059d6.js";const z={class:"max-w-[40rem]"},G=e("div",{class:"justify-between hidden px-2 mt-2 md:flex"},[e("p",{class:"flex justify-center w-full px-2 text-xl font-semibold"}," Add Sale ")],-1),H={class:"px-[2rem] py-[1rem] bg-white"},J=["onSubmit"],K={class:"mb-2"},W={class:"flex"},Y=e("span",{class:"text-sm text-red-600"},"*",-1),Z={class:"mb-2"},ee={class:"flex"},te=e("span",{class:"text-sm text-red-600"},"*",-1),se={class:"grid grid-cols-2 gap-2 mb-2"},le={class:"flex items-center gap-2"},oe=e("label",{for:"sales"},"Sales",-1),ae={class:"grid items-center grid-cols-1 gap-4 my-2"},ue={class:"grid grid-cols-3 gap-2"},ne=e("div",null,null,-1),de={class:"flex flex-col items-center w-full"},re=e("div",null,null,-1),ie={class:"grid grid-cols-3"},ce=e("div",null,null,-1),me={class:"w-full mt-2"},pe=e("div",null,null,-1),fe={class:"grid grid-cols-2 gap-2"},ve=e("option",{value:"",selected:"",disabled:""}," Select Country ",-1),_e=["value"],ye={key:0},ge=e("option",{value:"",selected:"",disabled:""}," Select State ",-1),be=["value"],xe={key:1},he=e("option",{value:"",selected:"",disabled:""}," Select City ",-1),we=["value"],qe=e("p",{class:"mt-2 text-red-600"}," Note: The sale will be deactivated after 14 days. ",-1),Ve={class:"flex justify-center"},ke={class:"mt-4"},Se=e("p",{class:"mb-2"},"Add People",-1),Ce={class:"p-2 mt-2 bg-white"},Ne={class:"flex gap-2"},$e=e("option",{value:"user"},"User",-1),Ue=e("option",{value:"company"},"Company",-1),je=[$e,Ue],Re={class:"flex items-center gap-2 mb-2"},Ae=["value"],Be={for:"name"},Ee={class:"flex justify-end"},De={class:"mt-4"},Ie=e("p",{class:"mb-2"},"Add Staff",-1),Le={class:"flex items-center gap-2 mb-2"},Oe=["value"],Pe={for:"name"},Fe={class:"flex justify-end"},tt={__name:"Create",props:{employees:Object,contacts:Object,countries:Object},setup(k){const S=k,h=c(!1),_=c(!1),y=c("user"),g=c(""),t=O({productName:"",casNo:"",quantityRequired:"",purityRequired:"",structure:null,description:"",staff:c([]),docs:null,sale:!0,quote:"",people:c([]),country:"",state:"",city:""}),C=c(null),w=c(null);j(()=>{t.country&&axios.get(route("states",{country:t.country})).then(u=>{C.value=u.data.length>0?u.data:null,t.state=null,t.city=null,w.value=null})}),j(()=>{t.state&&axios.get(route("cities",{state:t.state})).then(u=>{w.value=u.data.length>0?u.data:null})});const B=P(()=>{if(g.value!==""){if(y.value==="user")return S.contacts.filter(u=>g.value.toLowerCase().split(" ").every(l=>u.name.toLowerCase().includes(l)));if(y.value==="company")return S.contacts.filter(u=>g.value.toLowerCase().split(" ").every(l=>u.company.name.toLowerCase().includes(l)))}else return S.contacts}),E=()=>{t.quote=document.getElementById("quote").value,t.post(route("sale.store"),{onSuccess:u=>{console.log("res"+u.props)}})},D=()=>{t.structure=null,document.getElementById("structure").value=null},I=()=>{t.docs=null,document.getElementById("docs").value=null},L=u=>{t.docs=Array.from(u.target.files)};return(u,l)=>(n(),F(X,{title:"Add Sale",navigation:u.route("sales.index")},{default:m(()=>[e("div",z,[G,e("div",H,[e("form",{onSubmit:M(E,["prevent"])},[e("div",K,[e("div",W,[a(i,{for:"product_name",value:"Product Name"}),Y]),a(v,{id:"product_name",modelValue:o(t).productName,"onUpdate:modelValue":l[0]||(l[0]=s=>o(t).productName=s),type:"text",class:"block w-full mt-1",required:""},null,8,["modelValue"]),a(r,{class:"mt-2",message:o(t).errors.productName},null,8,["message"])]),e("div",Z,[e("div",ee,[a(i,{for:"cas_no",value:"CAS No"}),te]),a(v,{id:"cas_no",modelValue:o(t).casNo,"onUpdate:modelValue":l[1]||(l[1]=s=>o(t).casNo=s),type:"text",class:"block w-full mt-1",required:""},null,8,["modelValue"]),a(r,{class:"mt-2",message:o(t).errors.casNo},null,8,["message"])]),e("div",se,[e("div",null,[a(i,{for:"quantity_required",value:"Quantity in stock"}),a(v,{id:"quantity_required",modelValue:o(t).quantityRequired,"onUpdate:modelValue":l[2]||(l[2]=s=>o(t).quantityRequired=s),type:"text",class:"block w-full mt-1"},null,8,["modelValue"]),a(r,{class:"mt-2",message:o(t).errors.quantityRequired},null,8,["message"])]),e("div",null,[a(i,{for:"purity_required",value:"Purity"}),a(v,{id:"purity_required",modelValue:o(t).purityRequired,"onUpdate:modelValue":l[3]||(l[3]=s=>o(t).purityRequired=s),type:"text",class:"block w-full mt-1"},null,8,["modelValue"]),a(r,{class:"mt-2",message:o(t).errors.purityRequired},null,8,["message"])])]),e("div",le,[p(e("input",{type:"checkbox",name:"sales",id:"sales","onUpdate:modelValue":l[4]||(l[4]=s=>o(t).sale=s),checked:""},null,512),[[$,o(t).sale]]),oe]),e("div",null,[a(i,{for:"structure",value:"Structure"}),e("input",{type:"file",name:"structure",onInput:l[5]||(l[5]=s=>o(t).structure=s.target.files[0]),accept:".pdf, .jpg, .jpeg, .png, .doc, .docx",id:"structure"},null,32),o(t).structure?(n(),d("button",{key:0,class:"text-red-800 bg-white rounded",onClick:D},"X")):q("",!0),a(r,{class:"mt-2",message:o(t).errors.purityRequired},null,8,["message"])]),e("div",ae,[e("div",null,[a(i,{for:"description",value:"Description"}),p(e("textarea",{type:"text",class:"block w-full mt-1","onUpdate:modelValue":l[6]||(l[6]=s=>o(t).description=s)},null,512),[[T,o(t).description]]),a(r,{class:"mt-2",message:o(t).errors.description},null,8,["message"])]),e("div",ue,[ne,e("div",de,[e("button",{type:"button",onClick:l[7]||(l[7]=s=>_.value=!0),class:"w-full py-2 text-white bg-blue-400 rounded-lg"}," Add Staff ")]),re]),e("div",null,[a(i,{for:"docs",value:"Docs"}),e("input",{type:"file",name:"docs",multiple:"",onInput:L,id:"docs",accept:".pdf, .jpg, .jpeg, .png, .doc, .docx"},null,32),o(t).docs?(n(),d("button",{key:0,class:"text-red-800 bg-white rounded",onClick:I},"X")):q("",!0),a(r,{class:"mt-2",message:o(t).errors.docs},null,8,["message"])])]),a(v,{id:"quote",modelValue:o(t).quote,"onUpdate:modelValue":l[8]||(l[8]=s=>o(t).quote=s),type:"text",class:"block w-full mt-1",value:`Please Quote for ${o(t).productName} with ${o(t).purityRequired} for ${o(t).quantityRequired}`},null,8,["modelValue","value"]),a(r,{class:"mt-2",message:o(t).errors.quote},null,8,["message"]),e("div",ie,[ce,e("div",me,[e("button",{type:"button",onClick:l[9]||(l[9]=s=>h.value=!0),class:"w-full py-2 text-white bg-blue-500 rounded-lg"}," Share with ")]),pe]),e("div",fe,[e("div",null,[a(i,{for:"country",value:"Country"}),p(e("select",{class:"w-full border border-gray-200 rounded-lg","onUpdate:modelValue":l[10]||(l[10]=s=>o(t).country=s),required:""},[ve,(n(!0),d(x,null,b(k.countries,s=>(n(),d("option",{value:s.id},f(s.name),9,_e))),256))],512),[[V,o(t).country]]),a(r,{class:"mt-2",message:o(t).errors.country},null,8,["message"])]),C.value?(n(),d("div",ye,[a(i,{for:"state",value:"State"}),p(e("select",{class:"w-full border border-gray-200 rounded-lg","onUpdate:modelValue":l[11]||(l[11]=s=>o(t).state=s)},[ge,(n(!0),d(x,null,b(C.value,s=>(n(),d("option",{value:s.id},f(s.name),9,be))),256))],512),[[V,o(t).state]]),a(r,{class:"mt-2",message:o(t).errors.state},null,8,["message"])])):q("",!0),w.value?(n(),d("div",xe,[a(i,{for:"city",value:"City"}),p(e("select",{class:"w-full border border-gray-200 rounded-lg","onUpdate:modelValue":l[12]||(l[12]=s=>o(t).city=s)},[he,(n(!0),d(x,null,b(w.value,s=>(n(),d("option",{value:s.id},f(s.name),9,we))),256))],512),[[V,o(t).city]]),a(r,{class:"mt-2",message:o(t).errors.city},null,8,["message"])])):q("",!0)]),qe,e("div",Ve,[a(Q,{class:"mt-4 w-[10rem] flex justify-center rounded-lg font-bold p-2 mb-[5rem] bg-blue-600"},{default:m(()=>[U(" Submit ")]),_:1})])],40,J)])]),a(R,{show:h.value,onClose:l[17]||(l[17]=s=>h.value=!1)},{content:m(()=>[e("div",ke,[Se,e("div",Ce,[e("div",Ne,[p(e("select",{"onUpdate:modelValue":l[13]||(l[13]=s=>y.value=s),class:"rounded-lg"},je,512),[[V,y.value]]),a(v,{type:"text",class:"flex-1",modelValue:g.value,"onUpdate:modelValue":l[14]||(l[14]=s=>g.value=s),placeholder:`Search ${y.value}`},null,8,["modelValue","placeholder"])])]),(n(!0),d(x,null,b(o(B),s=>(n(),d("div",Re,[p(e("input",{type:"checkbox",name:"contact",id:"contact",value:s,"onUpdate:modelValue":l[15]||(l[15]=N=>o(t).people=N)},null,8,Ae),[[$,o(t).people]]),e("label",Be,f(s.name)+" @ "+f(s.company.name),1)]))),256))])]),footer:m(()=>[e("div",Ee,[a(A,{type:"button",onClick:l[16]||(l[16]=s=>h.value=!1)},{default:m(()=>[U("Ok")]),_:1})])]),_:1},8,["show"]),a(R,{show:_.value,onClose:l[20]||(l[20]=s=>_.value=!_.value)},{content:m(()=>[e("div",De,[Ie,(n(!0),d(x,null,b(k.employees,s=>(n(),d("div",Le,[p(e("input",{type:"checkbox",name:"staff",value:s.id,"onUpdate:modelValue":l[18]||(l[18]=N=>o(t).staff=N)},null,8,Oe),[[$,o(t).staff]]),e("label",Pe,f(s.name),1)]))),256))])]),footer:m(()=>[e("div",Fe,[a(A,{type:"button",onClick:l[19]||(l[19]=s=>_.value=!1)},{default:m(()=>[U("Ok")]),_:1})])]),_:1},8,["show"])]),_:1},8,["navigation"]))}};export{tt as default};
