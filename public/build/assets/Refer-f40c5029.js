import{x as c,c as f,w as s,o as d,a as e,b as o,h as p,L as u}from"./app-ad745f98.js";import{_ as m}from"./AppLayout-d8d9702b.js";import{A as h}from"./ArrowLeftIcon-d696fddf.js";import"./Banner-2b5a5794.js";import"./BottomTab-9c18cf54.js";import"./Sidebar-8688ddd2.js";import"./_plugin-vue_export-helper-c27b6911.js";import"./ToastList-cd5f7580.js";const g={class:"lg:hidden w-full border-b bg-white border-gray-200 py-[1rem] px-[1rem]"},x=e("p",{class:"w-full flex justify-center text-3xl font-bold"},"Refer & Earn",-1),y=e("div",{class:"w-full flex justify-center"},[e("img",{src:"/assests/images/refer.jpg",class:"md:h-[30rem]",alt:""})],-1),w=e("div",{class:"mt-2"},[e("p",{class:"w-full text-2xl font-semibold flex justify-center text-center px-[4rem]"},"Invite your friends and get 250 each"),e("p",{class:"mt-2 w-full text-gray-500 flex justify-center text-center px-[2rem]"},"Share the below link and ask your friends use this link to signup. Earn when your friend signs up on our app.")],-1),_=e("div",{class:"flex justify-center m-4"},[e("p",null,"OR")],-1),A={__name:"Refer",setup(b){const r=c(),a=location.protocol+"//"+location.host+"/register?referrer="+r.props.value.user.id,l={title:"refer",url:location.protocol+"//"+location.host+"/register?referrer="+r.props.value.user.id},i=async()=>{if(navigator.share)try{await navigator.share(l)}catch(t){console.log(t)}},n=async()=>{try{await navigator.clipboard.writeText(a),alert("Content copied to clipboard")}catch(t){console.error("Failed to copy: ",t)}};return(t,v)=>(d(),f(m,{title:"Refer and Earn"},{default:s(()=>[e("div",g,[o(p(u),{href:t.route("settings")},{default:s(()=>[o(h)]),_:1},8,["href"])]),e("div",{class:"px-2 bg-white py-[2rem] mt-2"},[x,e("div",{class:"mt-2"},[y,w,e("div",{class:"mt-10 flex justify-center"},[e("button",{onClick:i,class:"bg-green-400 w-full md:w-[30rem] py-3 rounded-lg text-white font-bold"},"Invite")]),_,e("div",{class:"flex justify-center"},[e("button",{onClick:n,class:"bg-green-400 w-full md:w-[30rem] py-3 rounded-lg text-white font-bold"},"Click to copy")])])])]),_:1}))}};export{A as default};
