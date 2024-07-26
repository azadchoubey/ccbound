import{u as N,d as g,c as b,w as l,o as _,b as e,g as i,e as U,a as s,j as y,v as w,M as x,p as k,f as P,h as a,n as B,B as A}from"./app-a99c1f11.js";import{_ as T}from"./ActionMessage-75f411c1.js";import{_ as j}from"./FormSection-6d136f65.js";import{_ as t}from"./InputError-00a923bd.js";import{_ as r}from"./InputLabel-4d3c9eb7.js";import{_ as F}from"./PrimaryButton-c774a4fc.js";import{_ as S}from"./SecondaryButton-9f95c4b3.js";import{_ as f}from"./TextInput-aed48f04.js";import{_ as E}from"./AdminLayout-332649b1.js";import"./SectionTitle-af7ea66f.js";import"./_plugin-vue_export-helper-c27b6911.js";import"./Banner-af0e7d7b.js";import"./UserGroupIcon-c8a6de1d.js";import"./MoneyIcon-6dab46af.js";import"./LogoutIcon-25c55303.js";import"./ToastList-b09059d6.js";const R={key:0,class:"col-span-6 sm:col-span-4"},z={class:"mt-2"},D=["src","alt"],H={class:"mt-2"},M={class:"col-span-6 sm:col-span-4"},L={class:"col-span-6 sm:col-span-4"},O={class:"col-span-6 sm:col-span-4"},q={class:"col-span-3 sm:col-span-3"},G=s("select",{name:"",id:"",class:"w-full rounded-lg border border-gray-200"},[s("option",{value:"India"},"India")],-1),J={class:"col-span-3 sm:col-span-3"},K=s("select",{name:"",id:"",class:"w-full rounded-lg border border-gray-200"},[s("option",{value:"Telangana"},"Telangana")],-1),Q={class:"col-span-3 sm:col-span-3"},W=s("select",{name:"",id:"",class:"w-full rounded-lg border border-gray-200"},[s("option",{value:"Hyderabad"},"Hyderabad")],-1),X={class:"col-span-6 sm:col-span-4"},fe={__name:"Edit",props:{confirmsTwoFactorAuthentication:Boolean,sessions:Array,user:Object},setup(p){const v=p,o=N({_method:"PUT",name:v.user.name,email:v.user.email,photo:null}),u=g(null),n=g(null),C=()=>{n.value&&(o.photo=n.value.files[0]),o.post(route("user-profile-information.update"),{errorBag:"updateProfileInformation",preserveScroll:!0,onSuccess:()=>h()})},V=()=>{n.value.click()},I=()=>{const m=n.value.files[0];if(!m)return;const c=new FileReader;c.onload=d=>{u.value=d.target.result},c.readAsDataURL(m)},$=()=>{A.Inertia.delete(route("current-user-photo.destroy"),{preserveScroll:!0,onSuccess:()=>{u.value=null,h()}})},h=()=>{var m;(m=n.value)!=null&&m.value&&(n.value.value=null)};return(m,c)=>(_(),b(E,{title:"Users"},{default:l(()=>[e(j,{onSubmitted:C,class:"mx-[5rem] m-[2rem]"},{title:l(()=>[i(" User Information ")]),description:l(()=>[i(" Update User account's profile information and email address. ")]),form:l(()=>[m.$page.props.jetstream.managesProfilePhotos?(_(),U("div",R,[s("input",{ref_key:"photoInput",ref:n,type:"file",class:"hidden",onChange:I},null,544),e(r,{for:"photo",value:"Photo"}),y(s("div",z,[s("img",{src:p.user.profile_photo_url,alt:p.user.name,class:"rounded-full h-20 w-20 object-cover"},null,8,D)],512),[[w,!u.value]]),y(s("div",H,[s("span",{class:"block rounded-full w-20 h-20 bg-cover bg-no-repeat bg-center",style:x("background-image: url('"+u.value+"');")},null,4)],512),[[w,u.value]]),e(S,{class:"mt-2 mr-2",type:"button",onClick:k(V,["prevent"])},{default:l(()=>[i(" Select A New Photo ")]),_:1},8,["onClick"]),p.user.profile_photo_path?(_(),b(S,{key:0,type:"button",class:"mt-2",onClick:k($,["prevent"])},{default:l(()=>[i(" Remove Photo ")]),_:1},8,["onClick"])):P("",!0),e(t,{message:a(o).errors.photo,class:"mt-2"},null,8,["message"])])):P("",!0),s("div",M,[e(r,{for:"name",value:"Name"}),e(f,{id:"name",modelValue:a(o).name,"onUpdate:modelValue":c[0]||(c[0]=d=>a(o).name=d),type:"text",class:"mt-1 block w-full",autocomplete:"name"},null,8,["modelValue"]),e(t,{message:a(o).errors.name,class:"mt-2"},null,8,["message"])]),s("div",L,[e(r,{for:"email",value:"Email"}),e(f,{id:"email",modelValue:a(o).email,"onUpdate:modelValue":c[1]||(c[1]=d=>a(o).email=d),type:"email",class:"mt-1 block w-full"},null,8,["modelValue"]),e(t,{message:a(o).errors.email,class:"mt-2"},null,8,["message"])]),s("div",O,[e(r,{for:"number",value:"Number"}),e(f,{id:"number",type:"text",value:"1234567890",class:"mt-1 block w-full",autocomplete:"name"}),e(t,{message:a(o).errors.name,class:"mt-2"},null,8,["message"])]),s("div",q,[e(r,{for:"country",value:"Country"}),G,e(t,{message:a(o).errors.name,class:"mt-2"},null,8,["message"])]),s("div",J,[e(r,{for:"state",value:"State"}),K,e(t,{message:a(o).errors.name,class:"mt-2"},null,8,["message"])]),s("div",Q,[e(r,{for:"city",value:"City"}),W,e(t,{message:a(o).errors.name,class:"mt-2"},null,8,["message"])]),s("div",X,[e(r,{for:"address",value:"Address"}),e(f,{id:"address",type:"text",value:"521 ",class:"mt-1 block w-full",autocomplete:"name"}),e(t,{message:a(o).errors.name,class:"mt-2"},null,8,["message"])])]),actions:l(()=>[e(T,{on:a(o).recentlySuccessful,class:"mr-3"},{default:l(()=>[i(" Saved. ")]),_:1},8,["on"]),e(F,{class:B({"opacity-25":a(o).processing}),disabled:a(o).processing},{default:l(()=>[i(" Save ")]),_:1},8,["class","disabled"])]),_:1})]),_:1}))}};export{fe as default};
