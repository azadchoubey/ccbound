import{y,s as f,C as w,k as v,o as h,c as x,b as o,w as l,j as n,a,T as c,v as i,n as p,h as b,r as g,f as k,D as C}from"./app-ad745f98.js";const B={class:"fixed inset-0 z-50 px-4 py-6 overflow-y-auto sm:px-0","scroll-region":""},T=a("div",{class:"absolute inset-0 bg-gray-500 opacity-75"},null,-1),_=[T],N={__name:"Modal",props:{show:{type:Boolean,default:!1},maxWidth:{type:String,default:"2xl"},closeable:{type:Boolean,default:!0},marginTop:{type:String,default:"mt-2"}},emits:["close"],setup(e,{emit:m}){const s=e;y(()=>s.show,()=>{s.show?document.body.style.overflow="hidden":document.body.style.overflow=null});const r=()=>{s.closeable&&m("close")},d=t=>{t.key==="Escape"&&s.show&&r()};f(()=>document.addEventListener("keydown",d)),w(()=>{document.removeEventListener("keydown",d),document.body.style.overflow=null});const u=v(()=>({sm:"sm:max-w-sm",md:"sm:max-w-md",lg:"sm:max-w-lg",xl:"sm:max-w-xl","2xl":"sm:max-w-2xl"})[s.maxWidth]);return(t,E)=>(h(),x(C,{to:"body"},[o(c,{"leave-active-class":"duration-200"},{default:l(()=>[n(a("div",B,[o(c,{"enter-active-class":"duration-300 ease-out","enter-from-class":"opacity-0","enter-to-class":"opacity-100","leave-active-class":"duration-200 ease-in","leave-from-class":"opacity-100","leave-to-class":"opacity-0"},{default:l(()=>[n(a("div",{class:"fixed inset-0 transition-all transform",onClick:r},_,512),[[i,e.show]])]),_:1}),o(c,{"enter-active-class":"duration-300 ease-out","enter-from-class":"translate-y-4 opacity-0 sm:translate-y-0 sm:scale-95","enter-to-class":"translate-y-0 opacity-100 sm:scale-100","leave-active-class":"duration-200 ease-in","leave-from-class":"translate-y-0 opacity-100 sm:scale-100","leave-to-class":"translate-y-4 opacity-0 sm:translate-y-0 sm:scale-95"},{default:l(()=>[n(a("div",{class:p(["mb-6 overflow-hidden transition-all transform bg-white rounded-lg shadow-xl sm:w-full sm:mx-auto",`${b(u)} ${e.marginTop}`])},[e.show?g(t.$slots,"default",{key:0}):k("",!0)],2),[[i,e.show]])]),_:3})],512),[[i,e.show]])]),_:3})]))}};export{N as _};
