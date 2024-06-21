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
        pageTitle: "Dashboard",
      },
    },

    /// Userr Route
    {
      path: "/users",
      name: "users",
      component: () => import("@/views/pages/User/userList.vue"),
      meta: {
        pageTitle: "User List",
      },
    },
    {
      path: "/add-users",
      name: "addUsers",
      component: () => import("@/views/pages/User/createUser.vue"),
      meta: {
        pageTitle: "Add User",
      },
    },
    {
      path: "/update-users/:user_id",
      name: "updateUser",
      component: () => import("@/views/pages/User/createUser.vue"),
      meta: {
        pageTitle: "Update User",
      },
    },

    /// Agent Route
    {
      path: "/agent-user",
      name: "agentUser",
      component: () => import("@/views/pages/Agent/agentList.vue"),
      meta: {
        pageTitle: "Agent List",
      },
    },
    {
      path: "/add-agent-users",
      name: "addAgent",
      component: () => import("@/views/pages/Agent/createAgent.vue"),
      meta: {
        pageTitle: "Add Agent",
      },
    },
    {
      path: "/update-agent-users/:agent_id",
      name: "updateAgent",
      component: () => import("@/views/pages/Agent/createAgent.vue"),
      meta: {
        pageTitle: "Update Agent",
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
