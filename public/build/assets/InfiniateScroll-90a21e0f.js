import{s as n,o as l,e as r,r as s}from"./app-a99c1f11.js";const d={__name:"InfiniateScroll",emits:["loadMore"],setup(m,{emit:o}){return n(()=>{window.addEventListener("scroll",_.debounce(e=>{document.documentElement.offsetHeight-document.documentElement.scrollTop-window.innerHeight<200&&o("loadMore")},100))}),(e,t)=>(l(),r("div",null,[s(e.$slots,"default")]))}};export{d as _};
