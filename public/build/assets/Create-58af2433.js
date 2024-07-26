import{d as _,u as j,N as V,c as A,w as g,o as n,a as e,p as U,b as a,h as o,e as r,f as v,j as c,E as p,R as P,i as y,F as b,g as k,t as x,l as $}from"./app-ad745f98.js";import{_ as M}from"./DialogModal-1e7001ec.js";import{_ as i}from"./InputError-5f6dd6ed.js";import{_ as u}from"./InputLabel-dc2871da.js";import{_ as q}from"./PrimaryButton-804b527b.js";import{_ as w}from"./TextInput-e764b81b.js";import{_ as T}from"./FormLayout-ff926ca8.js";import{_ as B}from"./SecondaryButton-efbe443f.js";import"./Banner-2b5a5794.js";import"./ArrowLeftIcon-d696fddf.js";import"./_plugin-vue_export-helper-c27b6911.js";import"./Sidebar-8688ddd2.js";import"./ToastList-cd5f7580.js";const D={class:"max-w-[40rem]"},L=e("div",{class:"justify-between hidden px-2 mt-2 md:flex"},[e("p",{class:"flex justify-center w-full px-2 text-xl font-semibold"},"Add Product")],-1),O={class:"px-[2rem] py-[1rem] bg-white"},R=["onSubmit"],F={class:"mb-2"},H={class:"flex"},X=e("span",{class:"text-sm text-red-600"},"*",-1),Y={class:"mb-2"},K={class:"flex"},z=e("span",{class:"text-sm text-red-600"},"*",-1),G={class:"flex gap-4"},J={class:"flex items-center gap-2"},Q=e("option",{value:"campaign"}," Campaign ",-1),W=e("option",{value:"regular"}," Regular ",-1),Z=[Q,W],ee={class:"grid items-center grid-cols-1 gap-4 my-2"},te=e("option",null,"API",-1),se=e("option",null,"API INTERMEDIATE",-1),oe=e("option",null,"FINE CHEMICAL",-1),le=e("option",null,"API IMPURITY",-1),ae=e("option",null,"CRO MOLECULE",-1),ne=e("option",null,"SPECIALITY CHEMICAL",-1),re=[te,se,oe,le,ae,ne],ue={class:"grid grid-cols-3 gap-2"},de=e("div",null,null,-1),ie={class:"flex flex-col items-center w-full"},ce=e("div",null,null,-1),me={class:"grid grid-cols-2 gap-2"},pe=e("option",{value:"",selected:"",disabled:""}," Select Country ",-1),fe=["value"],_e={key:0},ge=e("option",{value:"",selected:"",disabled:""}," Select State ",-1),ve=["value"],ye={key:1},be=e("option",{value:"",selected:"",disabled:""}," Select City ",-1),xe=["value"],he={class:"flex justify-center"},we={class:"mt-4"},Ce=e("p",{class:"mb-2"},"Add People",-1),Ve={class:"flex items-center gap-2 mb-2"},ke=["value"],Ie={for:"name"},Ne={class:"flex justify-end"},Oe={__name:"Create",props:{employees:Object,countries:Object},setup(C){const m=_(!1),t=j({productName:"",casNo:"",structure:null,description:"",type:"",category:"",staff:_([]),docs:null,country:"",state:"",city:""}),h=_(null),f=_(null);V(()=>{t.country&&axios.get(route("states",{country:t.country})).then(d=>{h.value=d.data.length>0?d.data:null,t.state=null,t.city=null,f.value=null})}),V(()=>{t.state&&axios.get(route("cities",{state:t.state})).then(d=>{f.value=d.data.length>0?d.data:null})});const I=()=>{t.post(route("product.store"),{onSuccess:d=>{console.log("res"+d.props)}})},N=()=>{t.structure=null,document.getElementById("structure").value=null},S=()=>{t.docs=null,document.getElementById("docs").value=null};return(d,l)=>(n(),A(T,{title:"Add Product",navigation:d.route("company.manage")},{default:g(()=>[e("div",D,[L,e("div",O,[e("form",{onSubmit:U(I,["prevent"])},[e("div",F,[e("div",H,[a(u,{for:"product_name",value:"Product Name"}),X]),a(w,{id:"product_name",modelValue:o(t).productName,"onUpdate:modelValue":l[0]||(l[0]=s=>o(t).productName=s),type:"text",class:"block w-full mt-1",required:""},null,8,["modelValue"]),a(i,{class:"mt-2",message:o(t).errors.productName},null,8,["message"])]),e("div",Y,[e("div",K,[a(u,{for:"cas_no",value:"CAS No"}),z]),a(w,{id:"cas_no",modelValue:o(t).casNo,"onUpdate:modelValue":l[1]||(l[1]=s=>o(t).casNo=s),type:"text",class:"block w-full mt-1",required:""},null,8,["modelValue"]),a(i,{class:"mt-2",message:o(t).errors.casNo},null,8,["message"])]),e("div",null,[a(u,{for:"structure",value:"Structure"}),e("input",{type:"file",name:"structure",onInput:l[2]||(l[2]=s=>o(t).structure=s.target.files[0]),id:"structure",accept:".pdf, .jpg, .jpeg, .png, .doc, .docx"},null,32),o(t).structure?(n(),r("button",{key:0,class:"text-red-800 bg-white rounded",onClick:N},"X")):v("",!0),a(i,{class:"mt-2",message:o(t).errors.structure},null,8,["message"])]),e("div",G,[e("div",J,[a(u,{for:"purity_required",value:"Type"}),c(e("select",{"onUpdate:modelValue":l[3]||(l[3]=s=>o(t).type=s)},Z,512),[[p,o(t).type]])])]),e("div",ee,[e("div",null,[a(u,{for:"purity_required",value:"Category"}),c(e("select",{"onUpdate:modelValue":l[4]||(l[4]=s=>o(t).category=s)},re,512),[[p,o(t).category]])]),e("div",null,[a(u,{for:"category",value:"Category (If not in the list)"}),a(w,{id:"cas_no",type:"text",class:"block w-full mt-1",modelValue:o(t).category,"onUpdate:modelValue":l[5]||(l[5]=s=>o(t).category=s)},null,8,["modelValue"]),a(i,{class:"mt-2",message:o(t).errors.category},null,8,["message"])]),e("div",null,[a(u,{for:"description",value:"Description"}),c(e("textarea",{type:"text",class:"block w-full mt-1","onUpdate:modelValue":l[6]||(l[6]=s=>o(t).description=s),required:""},null,512),[[P,o(t).description]]),a(i,{class:"mt-2",message:o(t).errors.description},null,8,["message"])]),e("div",ue,[de,e("div",ie,[e("button",{type:"button",onClick:l[7]||(l[7]=s=>m.value=!0),class:"w-full py-2 text-white bg-blue-400 rounded-lg"}," Add Staff ")]),ce]),e("div",null,[a(u,{for:"docs",value:"Docs"}),e("input",{type:"file",name:"docs",onInput:l[8]||(l[8]=s=>o(t).docs=s.target.files[0]),id:"docs",accept:".pdf, .jpg, .jpeg, .png, .doc, .docx"},null,32),o(t).docs?(n(),r("button",{key:0,class:"text-red-800 bg-white rounded",onClick:S},"X")):v("",!0),a(i,{class:"mt-2",message:o(t).errors.docs},null,8,["message"])])]),e("div",me,[e("div",null,[a(u,{for:"country",value:"Country"}),c(e("select",{class:"w-full border border-gray-200 rounded-lg","onUpdate:modelValue":l[9]||(l[9]=s=>o(t).country=s),required:""},[pe,(n(!0),r(b,null,y(C.countries,s=>(n(),r("option",{value:s.id},x(s.name),9,fe))),256))],512),[[p,o(t).country]]),a(i,{class:"mt-2",message:o(t).errors.country},null,8,["message"])]),h.value?(n(),r("div",_e,[a(u,{for:"state",value:"State"}),c(e("select",{class:"w-full border border-gray-200 rounded-lg","onUpdate:modelValue":l[10]||(l[10]=s=>o(t).state=s),required:""},[ge,(n(!0),r(b,null,y(h.value,s=>(n(),r("option",{value:s.id},x(s.name),9,ve))),256))],512),[[p,o(t).state]]),a(i,{class:"mt-2",message:o(t).errors.state},null,8,["message"])])):v("",!0),f.value?(n(),r("div",ye,[a(u,{for:"city",value:"City"}),c(e("select",{class:"w-full border border-gray-200 rounded-lg","onUpdate:modelValue":l[11]||(l[11]=s=>o(t).city=s)},[be,(n(!0),r(b,null,y(f.value,s=>(n(),r("option",{value:s.id},x(s.name),9,xe))),256))],512),[[p,o(t).city]]),a(i,{class:"mt-2",message:o(t).errors.city},null,8,["message"])])):v("",!0)]),e("div",he,[a(q,{class:"mt-4 w-[10rem] flex justify-center rounded-lg font-bold p-2 mb-[5rem] bg-blue-600"},{default:g(()=>[k("Submit ")]),_:1})])],40,R)])]),a(M,{show:m.value,onClose:l[14]||(l[14]=s=>m.value=!1)},{content:g(()=>[e("div",we,[Ce,(n(!0),r(b,null,y(C.employees,s=>(n(),r("div",Ve,[c(e("input",{type:"checkbox",name:"staff",value:s.id,"onUpdate:modelValue":l[12]||(l[12]=E=>o(t).staff=E)},null,8,ke),[[$,o(t).staff]]),e("label",Ie,x(s.name),1)]))),256))]),e("div",Ne,[a(B,{onClick:l[13]||(l[13]=s=>m.value=!m.value),class:"mr-2"},{default:g(()=>[k("OK")]),_:1})])]),_:1},8,["show"])]),_:1},8,["navigation"]))}};export{Oe as default};