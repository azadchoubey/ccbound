import{_}from"./PrimaryButton-47053d9a.js";import{e as f,a as o,r as a,p as u,f as p,o as h,t as y,b as n,w as c,g as d,G as C,P as b,Q as v}from"./app-a99c1f11.js";import{_ as k}from"./_plugin-vue_export-helper-c27b6911.js";const g={components:{PrimaryButton:_},props:{show:{type:Boolean,required:!0},message:{type:String}},methods:{close(){this.$emit("close")},confirm(){this.$emit("confirm")}}},i=e=>(b("data-v-fbe6f51c"),e=e(),v(),e),w={class:"modal-header"},B=i(()=>o("h4",null,"Confirm",-1)),S={class:"modal-body"},N=i(()=>o("p",null,"Are you sure you want to delete this item?",-1)),I={class:"modal-footer"};function P(e,s,r,V,$,t){const l=C("PrimaryButton");return r.show?(h(),f("div",{key:0,class:"modal-overlay",onClick:s[1]||(s[1]=(...m)=>t.close&&t.close(...m))},[o("div",{class:"p-5 modal-container",onClick:s[0]||(s[0]=u(()=>{},["stop"]))},[o("div",w,[a(e.$slots,"header",{},()=>[B],!0)]),o("div",S,[a(e.$slots,"body",{},()=>[N,o("p",null,y(r.message),1)],!0)]),o("div",I,[a(e.$slots,"footer",{},()=>[n(l,{onClick:t.confirm,class:"bg-red-600 btn"},{default:c(()=>[d("Yes")]),_:1},8,["onClick"]),n(l,{onClick:t.close,class:"ml-5 bg-blue-600 btn"},{default:c(()=>[d("No")]),_:1},8,["onClick"])],!0)])])])):p("",!0)}const A=k(g,[["render",P],["__scopeId","data-v-fbe6f51c"]]);export{A as default};
