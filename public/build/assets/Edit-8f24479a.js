import{u as c,c as _,w as n,o as f,a,p as w,b as s,h as o,j as b,E as v,g}from"./app-ad745f98.js";import{_ as V}from"./AdminLayout-91e7dc08.js";import{_ as r}from"./InputLabel-dc2871da.js";import{_ as i}from"./TextInput-e764b81b.js";import{_ as t}from"./InputError-5f6dd6ed.js";import{_ as x}from"./PrimaryButton-65f58580.js";import"./Banner-2b5a5794.js";import"./_plugin-vue_export-helper-c27b6911.js";import"./UserGroupIcon-957e0a5d.js";import"./MoneyIcon-a70d50ab.js";import"./LogoutIcon-b8d63e69.js";import"./ToastList-cd5f7580.js";const A={class:"px-[2rem]"},h={class:"bg-white p-[2rem] mt-2 max-w-[45rem]"},k=a("p",{class:"text-xl font-bold"},"Add admin",-1),y=["onSubmit"],q={class:"grid grid-cols-2 gap-4"},S=a("option",{value:"",selected:"",disabled:""},"Select Role",-1),U=a("option",{value:"super_admin"},"Super Admin",-1),N=a("option",{value:"accounts_admin"},"Accounts Admin",-1),$=a("option",{value:"sales_admin"},"Sales Admin",-1),B=a("option",{value:"data_admin"},"Data Admin",-1),E=[S,U,N,$,B],J={__name:"Edit",props:{confirmsTwoFactorAuthentication:Boolean,sessions:Array,admin:Object},setup(u){const d=u,e=c({name:d.admin.name,email:d.admin.email,number:d.admin.number,role:d.admin.role,password:"",password_confirmation:""}),p=()=>{e.patch(route("admin.admin.update",{admin:d.admin}))};return(j,l)=>(f(),_(V,{title:"Edit"},{default:n(()=>[a("div",A,[a("div",h,[k,a("form",{onSubmit:w(p,["prevent"])},[a("div",q,[a("div",null,[s(r,{for:"name",value:"Name"}),s(i,{id:"name",type:"text",class:"mt-1 block w-full",modelValue:o(e).name,"onUpdate:modelValue":l[0]||(l[0]=m=>o(e).name=m),required:"",autofocus:""},null,8,["modelValue"]),s(t,{class:"mt-2",message:o(e).errors.name},null,8,["message"])]),a("div",null,[s(r,{for:"email",value:"Email"}),s(i,{id:"email",type:"email",class:"mt-1 block w-full",modelValue:o(e).email,"onUpdate:modelValue":l[1]||(l[1]=m=>o(e).email=m),required:""},null,8,["modelValue"]),s(t,{class:"mt-2",message:o(e).errors.email},null,8,["message"])]),a("div",null,[s(r,{for:"number",value:"Number"}),s(i,{id:"number",type:"text",class:"mt-1 block w-full",modelValue:o(e).number,"onUpdate:modelValue":l[2]||(l[2]=m=>o(e).number=m),required:""},null,8,["modelValue"]),s(t,{class:"mt-2",message:o(e).errors.number},null,8,["message"])]),a("div",null,[s(r,{for:"role",value:"Role"}),b(a("select",{class:"w-full border border-gray-200 rounded-lg mt-1","onUpdate:modelValue":l[3]||(l[3]=m=>o(e).role=m),required:""},E,512),[[v,o(e).role]]),s(t,{class:"mt-2",message:o(e).errors.role},null,8,["message"])]),a("div",null,[s(r,{for:"passowrd",value:"Password"}),s(i,{id:"password",modelValue:o(e).password,"onUpdate:modelValue":l[4]||(l[4]=m=>o(e).password=m),type:"password",class:"mt-1 block w-full",required:"",autocomplete:"new-password"},null,8,["modelValue"]),s(t,{class:"mt-2",message:o(e).errors.password},null,8,["message"])]),a("div",null,[s(r,{for:"password_confirmation",value:"Confirm Password"}),s(i,{id:"password_confirmation",modelValue:o(e).password_confirmation,"onUpdate:modelValue":l[5]||(l[5]=m=>o(e).password_confirmation=m),type:"password",class:"mt-1 block w-full",required:"",autocomplete:"new-password"},null,8,["modelValue"]),s(t,{class:"mt-2",message:o(e).errors.password_confirmation},null,8,["message"])])]),s(x,{class:"mt-2"},{default:n(()=>[g(" Add user ")]),_:1})],40,y)])])]),_:1}))}};export{J as default};