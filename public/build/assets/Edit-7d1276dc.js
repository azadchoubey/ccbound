import{u as p,c as _,w as u,o as f,a as e,p as b,b as o,h as t,g as h}from"./app-ad745f98.js";import{_ as V}from"./AdminLayout-91e7dc08.js";import{_ as m}from"./InputLabel-dc2871da.js";import{_ as l}from"./TextInput-e764b81b.js";import{_ as n}from"./InputError-5f6dd6ed.js";import{_ as g}from"./PrimaryButton-65f58580.js";import"./Banner-2b5a5794.js";import"./_plugin-vue_export-helper-c27b6911.js";import"./UserGroupIcon-957e0a5d.js";import"./MoneyIcon-a70d50ab.js";import"./LogoutIcon-b8d63e69.js";import"./ToastList-cd5f7580.js";const y={class:"px-[2rem]"},v={class:"bg-white p-[2rem] mt-2 max-w-[45rem]"},w=e("p",{class:"text-xl font-bold"},"Add admin",-1),x=["onSubmit"],k={class:"grid grid-cols-2 gap-4"},C={__name:"Edit",props:{confirmsTwoFactorAuthentication:Boolean,sessions:Array,subscription:Object},setup(d){const i=d,s=p({price:i.subscription.price,months:i.subscription.months,days:i.subscription.days}),c=()=>{s.patch(route("admin.subscription.update",{subscription:i.subscription}))};return($,r)=>(f(),_(V,{title:"Edit"},{default:u(()=>[e("div",y,[e("div",v,[w,e("form",{onSubmit:b(c,["prevent"])},[e("div",k,[e("div",null,[o(m,{for:"price",value:"Price"}),o(l,{id:"price",type:"number",class:"mt-1 block w-full",modelValue:t(s).price,"onUpdate:modelValue":r[0]||(r[0]=a=>t(s).price=a),required:"",autofocus:""},null,8,["modelValue"]),o(n,{class:"mt-2",message:t(s).errors.price},null,8,["message"])]),e("div",null,[o(m,{for:"duration_months",value:"Duration(Months)"}),o(l,{id:"duration_months",type:"number",class:"mt-1 block w-full",modelValue:t(s).months,"onUpdate:modelValue":r[1]||(r[1]=a=>t(s).months=a),required:""},null,8,["modelValue"]),o(n,{class:"mt-2",message:t(s).errors.months},null,8,["message"])]),e("div",null,[o(m,{for:"duration_days",value:"Duration Days"}),o(l,{id:"duration_months",type:"number",class:"mt-1 block w-full",modelValue:t(s).days,"onUpdate:modelValue":r[2]||(r[2]=a=>t(s).days=a),required:""},null,8,["modelValue"]),o(n,{class:"mt-2",message:t(s).errors.days},null,8,["message"])])]),o(g,{class:"mt-2"},{default:u(()=>[h(" Update ")]),_:1})],40,x)])])]),_:1}))}};export{C as default};
