import{c as n,w as m,o as e,a as i,e as r,b as t,f as s,F as c}from"./app-a99c1f11.js";import{_ as l}from"./AppLayout-f8922642.js";import u from"./DeleteUserForm-f2b2d7b1.js";import{S as a}from"./SectionBorder-2c2069aa.js";import d from"./UpdatePasswordForm-bd072e85.js";import f from"./UpdateProfileInformationForm-0bd2c7b7.js";import"./Banner-af0e7d7b.js";import"./BottomTab-9f3a44df.js";import"./Sidebar-08876489.js";import"./_plugin-vue_export-helper-c27b6911.js";import"./ToastList-b09059d6.js";import"./ActionSection-f0a7ff7b.js";import"./SectionTitle-af7ea66f.js";import"./DangerButton-985e2987.js";import"./DialogModal-c682f939.js";import"./Modal-6b8225ed.js";import"./InputError-00a923bd.js";import"./SecondaryButton-9f95c4b3.js";import"./TextInput-aed48f04.js";import"./ActionMessage-75f411c1.js";import"./FormSection-6d136f65.js";import"./InputLabel-4d3c9eb7.js";import"./PrimaryButton-c774a4fc.js";const _=i("h2",{class:"font-semibold text-xl text-gray-800 leading-tight"}," Profile ",-1),h={class:"max-w-7xl mx-auto py-10 sm:px-6 lg:px-8"},g={key:0},$={key:1},H={__name:"Show",props:{confirmsTwoFactorAuthentication:Boolean,sessions:Array,countries:Object},setup(p){return(o,x)=>(e(),n(l,{title:"Profile"},{header:m(()=>[_]),default:m(()=>[i("div",null,[i("div",h,[o.$page.props.jetstream.canUpdateProfileInformation?(e(),r("div",g,[t(f,{countries:p.countries,user:o.$page.props.user},null,8,["countries","user"]),t(a)])):s("",!0),o.$page.props.jetstream.canUpdatePassword?(e(),r("div",$,[t(d,{class:"mt-10 sm:mt-0"}),t(a)])):s("",!0),o.$page.props.jetstream.hasAccountDeletionFeatures?(e(),r(c,{key:2},[t(a),t(u,{class:"mt-10 sm:mt-0"})],64)):s("",!0)])])]),_:1}))}};export{H as default};
