import Vue from "vue";
import { ToastPlugin, ModalPlugin } from "bootstrap-vue";
import VueCompositionAPI from "@vue/composition-api";

import router from "./router";
import store from "./store";
import App from "./App.vue";
import Bootstrap from "bootstrap-vue";
Vue.use(Bootstrap);
// Global Components
import "./global-components";

// 3rd party plugins
import "@axios";
import "@/libs/portal-vue";
import "@/libs/toastification";

import "@riophae/vue-treeselect/dist/vue-treeselect.css";
import "@core/scss/vue/libs/vue-flatpicker.scss";
import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";

// Libs
//import "@/libs/acl";

import VueTelInput from "vue-tel-input";
import "vue-tel-input/dist/vue-tel-input.css";

Vue.use(VueTelInput, {
  mode: "international",
  dropdownOptions: {
    showDialCodeInList: true,
    showFlags: true,
    showDialCodeInSelection: true,
    showSearchBox: true,
  },
});
// BSV Plugin Registration
Vue.use(ToastPlugin);
Vue.use(ModalPlugin);

Vue.use(
  Loading,
  {
    // props
    loader: "spinner",
    color: "#1f307a",
    width: 64,
    height: 64,
    backgroundColor: "#edefff",
    opacity: 0.5,
    zIndex: 999,
  },
  {
    // slots
  }
);
// Composition API
Vue.use(VueCompositionAPI);

Vue.prototype.$flatPickrConfig = {
  dateFormat: "Y-m-d",
  altInput: true,
  altFormat: "d-m-Y",
  allowInput: true,
};

Vue.prototype.$FILES_URL = process.env.VUE_APP_FILESURL;

// import core styles
require("@core/scss/core.scss");
require("@core/assets/fonts/feather/iconfont.css");
require("@core/assets/fonts/feather/common.css");

require("@core/scss/base/pages/app-invoice.scss");

// import assets styles
require("@/assets/scss/style.scss");

Vue.config.productionTip = false;

new Vue({
  router,
  store,
  render: (h) => h(App),
}).$mount("#app");
