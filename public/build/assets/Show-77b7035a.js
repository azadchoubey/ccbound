import{c as n,w as m,o as e,a as i,e as r,b as t,f as s,F as c}from"./app-ad745f98.js";import{_ as l}from"./AppLayout-d8d9702b.js";import u from"./DeleteUserForm-3d01f81a.js";import{S as a}from"./SectionBorder-d1602b73.js";import d from"./UpdatePasswordForm-35c48557.js";import f from"./UpdateProfileInformationForm-68d0f739.js";import"./Banner-2b5a5794.js";import"./BottomTab-9c18cf54.js";import"./Sidebar-8688ddd2.js";import"./_plugin-vue_export-helper-c27b6911.js";import"./ToastList-cd5f7580.js";import"./ActionSection-dc33db20.js";import"./SectionTitle-94f0e8f1.js";import"./DangerButton-df50055b.js";import"./DialogModal-ea914144.js";import"./Modal-fb88d194.js";import"./InputError-5f6dd6ed.js";import"./SecondaryButton-efbe443f.js";import"./TextInput-e764b81b.js";import"./ActionMessage-023109ed.js";import"./FormSection-992bfe61.js";import"./InputLabel-dc2871da.js";import"./PrimaryButton-65f58580.js";const _=i("h2",{class:"font-semibold text-xl text-gray-800 leading-tight"}," Profile ",-1),h={class:"max-w-7xl mx-auto py-10 sm:px-6 lg:px-8"},g={key:0},$={key:1},H={__name:"Show",props:{confirmsTwoFactorAuthentication:Boolean,sessions:Array,countries:Object},setup(p){return(o,x)=>(e(),n(l,{title:"Profile"},{header:m(()=>[_]),default:m(()=>[i("div",null,[i("div",h,[o.$page.props.jetstream.canUpdateProfileInformation?(e(),r("div",g,[t(f,{countries:p.countries,user:o.$page.props.user},null,8,["countries","user"]),t(a)])):s("",!0),o.$page.props.jetstream.canUpdatePassword?(e(),r("div",$,[t(d,{class:"mt-10 sm:mt-0"}),t(a)])):s("",!0),o.$page.props.jetstream.hasAccountDeletionFeatures?(e(),r(c,{key:2},[t(a),t(u,{class:"mt-10 sm:mt-0"})],64)):s("",!0)])])]),_:1}))}};export{H as default};