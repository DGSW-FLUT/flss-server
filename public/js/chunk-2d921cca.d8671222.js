(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-2d921cca"],{"203b":function(t,s,n){},"206d":function(t,s,n){"use strict";var a=n("203b"),i=n.n(a);i.a},a55b:function(t,s,n){"use strict";n.r(s);var a=function(){var t=this,s=t.$createElement,n=t._self._c||s;return n("div",{attrs:{id:"login"}},[n("div",{staticClass:"background"}),t._m(0),t._m(1),n("div",{staticClass:"area-box"},[n("div",{staticClass:"area-form"},[n("div",{staticClass:"text"},[t._v("FLSS에 로그인하기")]),n("div",{staticClass:"form"},[t._m(2),t._m(3),n("button",{staticClass:"input base",on:{click:function(s){t.login()}}},[t._v("\n          로그인\n        ")]),n("button",{staticClass:"input classting",on:{click:function(s){t.loginViaClassting()}}},[t._v("\n          Classting으로 로그인\n        ")]),n("button",{staticClass:"input google"},[t._v("\n          Google+로 로그인\n        ")]),n("button",{staticClass:"input facebook"},[t._v("\n          Facebook으로 로그인\n        ")]),t._m(4)])])])])},i=[function(){var t=this,s=t.$createElement,n=t._self._c||s;return n("div",{staticClass:"header"},[n("span",{staticClass:"title"},[t._v("Flipped Learning Support System")]),n("br"),n("span",{staticClass:"text"},[t._v("선생과 학생을 잇는, 플립러닝 지원 시스템")])])},function(){var t=this,s=t.$createElement,n=t._self._c||s;return n("div",{staticClass:"copyright"},[t._v("Copyright ⓒ "),n("a",{attrs:{href:"https://github.com/DGSW-FLUT",target:"_blank"}},[t._v("FLUT")]),t._v(" 2018, All rights reserved.")])},function(){var t=this,s=t.$createElement,n=t._self._c||s;return n("div",{staticClass:"input"},[n("input",{attrs:{type:"text",placeholder:"ID"}})])},function(){var t=this,s=t.$createElement,n=t._self._c||s;return n("div",{staticClass:"input"},[n("input",{attrs:{type:"password",placeholder:"Password"}})])},function(){var t=this,s=t.$createElement,n=t._self._c||s;return n("div",{staticClass:"signup"},[t._v("\n          아이디가 없으신가요?  "),n("a",[t._v("회원 가입")])])}],e=(n("cadf"),n("551c"),n("097d"),{name:"login",data:function(){return{}},methods:{login:function(){this.$store.commit("setAuthenticated",!0),this.$router.push({name:"select-class"})},loginViaClassting:function(){this.$http.get("http://localhost:3000/auth/classting").then(function(t){console.log(t)}).catch(function(t){console.log(t)})}}}),c=e,l=(n("206d"),n("2877")),o=Object(l["a"])(c,a,i,!1,null,null,null);o.options.__file="Login.vue";s["default"]=o.exports}}]);
//# sourceMappingURL=chunk-2d921cca.d8671222.js.map