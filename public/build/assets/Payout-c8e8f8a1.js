import{u,c as m,w as c,o as b,a as e,p as g,j as r,R as n,h as s,b as l}from"./app-a99c1f11.js";import{_ as p}from"./AppLayout-f8922642.js";import{_ as d}from"./InputError-00a923bd.js";import"./Banner-af0e7d7b.js";import"./BottomTab-9f3a44df.js";import"./Sidebar-08876489.js";import"./_plugin-vue_export-helper-c27b6911.js";import"./ToastList-b09059d6.js";const f={class:"p-2"},x=["onSubmit"],_=e("p",{class:"w-full flex justify-center font-bold text-xl p-2"},"Please fill in the details",-1),y={class:"flex flex-wrap -mx-3 mb-6"},w={class:"w-full md:w-1/2 px-3 mb-6 md:mb-0"},h=e("label",{class:"block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2",for:"grid-first-name"}," First Name ",-1),k={class:"w-full md:w-1/2 px-3"},v=e("label",{class:"block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2",for:"grid-last-name"}," Amount ",-1),V={class:"w-full md:w-1/2 px-3 mb-6 md:mb-0"},U=e("label",{class:"block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2",for:"grid-first-name"}," UPI ID ",-1),N={class:"flex flex-wrap -mx-3 mb-6"},A={class:"w-full md:w-1/2 px-3 mb-6 md:mb-0"},S=e("label",{class:"block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2",for:"grid-first-name"}," Bank Name ",-1),q={class:"w-full md:w-1/2 px-3"},B=e("label",{class:"block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2",for:"grid-last-name"}," Account Number ",-1),P={class:"flex flex-wrap -mx-3 mb-6"},C={class:"w-full md:w-1/2 px-3 mb-6 md:mb-0"},F=e("label",{class:"block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2",for:"grid-first-name"}," Account branch ",-1),I={class:"w-full md:w-1/2 px-3"},j=e("label",{class:"block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2",for:"grid-last-name"}," IFSC Code ",-1),D={class:"flex flex-wrap -mx-3 mb-6"},M={class:"w-full md:w-1/2 px-3 mb-6 md:mb-0"},T=e("label",{class:"block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2",for:"grid-first-name"}," GST No. ",-1),$={class:"w-full md:w-1/2 px-3"},G=e("label",{class:"block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2",for:"grid-last-name"}," PAN No. ",-1),R={class:"flex flex-wrap -mx-3 mb-6"},W={class:"w-full md:w-1/2 px-3 mb-6 md:mb-0"},z=e("label",{class:"block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2",for:"grid-first-name"}," Aadhaar Number ",-1),E=e("button",{type:"submit",class:"text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center"},"Submit",-1),te={__name:"Payout",setup(H){const t=u({first_name:"",amount:"",upi_id:"",bank_name:"",account_number:"",account_branch:"",ifsc_code:"",gst_no:"",pan_no:"",aadhaar_number:""}),i=()=>{t.post(route("payout.store"))};return(J,o)=>(b(),m(p,{title:"Wallet"},{default:c(()=>[e("div",f,[e("form",{onSubmit:g(i,["prevent"]),class:"w-full bg-white p-[2rem]"},[_,e("div",y,[e("div",w,[h,r(e("input",{"onUpdate:modelValue":o[0]||(o[0]=a=>s(t).first_name=a),class:"block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white",id:"grid-first-name",type:"text",required:""},null,512),[[n,s(t).first_name]]),l(d,{class:"mt-2",message:s(t).errors.first_name},null,8,["message"])]),e("div",k,[v,r(e("input",{"onUpdate:modelValue":o[1]||(o[1]=a=>s(t).amount=a),class:"appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500",id:"grid-last-name",type:"number",required:""},null,512),[[n,s(t).amount]]),l(d,{class:"mt-2",message:s(t).errors.amount},null,8,["message"])]),e("div",V,[U,r(e("input",{"onUpdate:modelValue":o[2]||(o[2]=a=>s(t).upi_id=a),class:"appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white",id:"grid-first-name",type:"text"},null,512),[[n,s(t).upi_id]]),l(d,{class:"mt-2",message:s(t).errors.upi_id},null,8,["message"])])]),e("div",N,[e("div",A,[S,r(e("input",{"onUpdate:modelValue":o[3]||(o[3]=a=>s(t).bank_name=a),class:"appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white",id:"grid-first-name",type:"text"},null,512),[[n,s(t).bank_name]]),l(d,{class:"mt-2",message:s(t).errors.bank_name},null,8,["message"])]),e("div",q,[B,r(e("input",{"onUpdate:modelValue":o[4]||(o[4]=a=>s(t).account_number=a),class:"appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500",id:"grid-last-name",type:"text"},null,512),[[n,s(t).account_number]]),l(d,{class:"mt-2",message:s(t).errors.account_number},null,8,["message"])])]),e("div",P,[e("div",C,[F,r(e("input",{"onUpdate:modelValue":o[5]||(o[5]=a=>s(t).account_branch=a),class:"appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white",id:"grid-first-name",type:"text"},null,512),[[n,s(t).account_branch]]),l(d,{class:"mt-2",message:s(t).errors.account_branch},null,8,["message"])]),e("div",I,[j,r(e("input",{"onUpdate:modelValue":o[6]||(o[6]=a=>s(t).ifsc_code=a),class:"appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500",id:"grid-last-name",type:"text"},null,512),[[n,s(t).ifsc_code]]),l(d,{class:"mt-2",message:s(t).errors.ifsc_code},null,8,["message"])])]),e("div",D,[e("div",M,[T,r(e("input",{"onUpdate:modelValue":o[7]||(o[7]=a=>s(t).gst_no=a),class:"appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white",id:"grid-first-name",type:"text"},null,512),[[n,s(t).gst_no]]),l(d,{class:"mt-2",message:s(t).errors.gst_no},null,8,["message"])]),e("div",$,[G,r(e("input",{"onUpdate:modelValue":o[8]||(o[8]=a=>s(t).pan_no=a),class:"appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500",id:"grid-last-name",type:"text",required:""},null,512),[[n,s(t).pan_no]]),l(d,{class:"mt-2",message:s(t).errors.pan_no},null,8,["message"])])]),e("div",R,[e("div",W,[z,r(e("input",{"onUpdate:modelValue":o[9]||(o[9]=a=>s(t).aadhaar_number=a),class:"appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white",id:"grid-first-name",type:"text",required:""},null,512),[[n,s(t).aadhaar_number]]),l(d,{class:"mt-2",message:s(t).errors.aadhaar_number},null,8,["message"])])]),E],40,x)])]),_:1}))}};export{te as default};
