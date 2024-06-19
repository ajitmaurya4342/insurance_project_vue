import Vue from "vue";
import VueRouter from "vue-router";

Vue.use(VueRouter);

const router = new VueRouter({
  mode: "history",
  base: process.env.BASE_URL,
  scrollBehavior() {
    return { x: 0, y: 0 };
  },
  routes: [
    {
      path: "/",
      name: "login",
      component: () => import("@/views/pages/Authentication/Login.vue"),
      meta: {
        layout: "full",
      },
    },

    {
      path: "/home",
      name: "home",
      component: () => import("@/views/pages/Home/Home.vue"),
      meta: {
        pageTitle: "QR-Code Users",
      },
    },
    {
      path: "/createqr",
      name: "createqr",
      component: () => import("@/views/pages/Home/CreateQr.vue"),
      meta: {
        pageTitle: "Create QR",
      },
    },
    {
      path: "/grdetails",
      name: "qrdetails",
      component: () => import("@/views/pages/Home/userQrDetails.vue"),
      meta: {
        pageTitle: "Qr Details",
      },
    },
    {
      path: "/afterscan",
      name: "scanDetails",
      component: () => import("@/views/pages/Home/afterScanDetailsNew.vue"),
      meta: {
        pageTitle: "Scan Details",
        layout: "full",
      },
    },
  ],
});

// ? For splash screen
// Remove afterEach hook if you are not using splash screen
router.afterEach(() => {
  // Remove initial loading
  const appLoading = document.getElementById("loading-bg");
  if (appLoading) {
    appLoading.style.display = "none";
  }
});

export default router;
