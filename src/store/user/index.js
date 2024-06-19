import { setAbilities } from "@/libs/acl/setAbilities";

export default {
  namespaced: true,
  state: {
    user_authenticated: false,
    user_details: {
      name: "Firstname",
      email: "Lastname",
      role_name: "User",
    },
    new_notifications: [],
    new_notifications_count: 0,
  },
  getters: {
    getUserDetails: (state) => state.user_details,
    getUserAuthenticated: (state) => state.user_authenticated,
    getNewNotifications: (state) => state.new_notifications,
  },
  mutations: {
    SET_USER_AUTHENTICATED(state, val) {
      state.user_authenticated = val;
    },
    SET_USER_DETAILS(state, val) {
      state.user_details = val;
    },
    SET_NEW_NOTIFICATIONS(state, val) {
      state.new_notifications = val;
    },
    SET_NEW_NOTIFICATIONS_COUNT(state, val) {
      state.new_notifications_count = val;
    },
  },
  actions: {
    // setUserDetails: async ({ dispatch, commit, state }, payload) => {
    //   MasterService.getProfile()
    //     .then(async (response) => {
    //       if (response.data.status) {
    //         await commit("SET_USER_DETAILS", response.data.data);
    //         await commit("SET_USER_AUTHENTICATED", true);
    //         if (response.data.data.access_map && response.data.data.access_map.length) {
    //           setAbilities(response.data.data.access_map)
    //         }
    //       }
    //     })
    //     .catch((err) => {
    //       console.log("Error in getting user profile ", err);
    //     });
    // },
    // setNewNotifications: async ({ dispatch, commit, state }, payload) => {
    //   MasterService.getNewNotifications()
    //     .then(async (response) => {
    //       if (response.data.status) {
    //         const arr = response.data.data.concat(state.new_notifications);
    //         await commit(
    //           "SET_NEW_NOTIFICATIONS_COUNT",
    //           state.new_notifications_count + response.data.data.length
    //         );
    //         await commit("SET_NEW_NOTIFICATIONS", arr);
    //       }
    //     })
    //     .catch((err) => {
    //       console.log("Error in setting new notifications ", err);
    //     });
    // },
  },
};
