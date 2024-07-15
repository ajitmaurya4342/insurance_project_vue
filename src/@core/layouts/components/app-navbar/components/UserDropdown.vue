<template>
  <b-nav-item-dropdown
    right
    toggle-class="d-flex align-items-center dropdown-user-link"
    class="dropdown-user"
  >
    <template #button-content>
      <div class="d-sm-flex d-none user-nav">
        <p class="user-name font-weight-bolder mb-0">
          {{ getLoginDetail && getLoginDetail.name }}
        </p>
        <span class="user-status">{{
          getLoginDetail && getLoginDetail.user_type
        }}</span>
      </div>
      <b-img
        height="40"
        width="40"
        v-if="user_details.profile_image"
        :src="$FILES_URL + user_details.profile_image"
        rounded="circle"
      />
      <b-avatar
        v-else
        size="40"
        variant="light-primary"
        badge
        class="badge-minimal"
        badge-variant="success"
      >
      </b-avatar>
    </template>

    <!-- <b-dropdown-item
      :to="{ name: 'Settings' }"
      link-class="d-flex align-items-center"
    >
      <feather-icon size="16" icon="SettingsIcon" class="mr-50" />
      <span>Settings</span>
    </b-dropdown-item> -->

    <b-dropdown-item link-class="d-flex align-items-center" @click="logout">
      <feather-icon size="16" icon="LogOutIcon" class="mr-50" />
      <span>Logout</span>
    </b-dropdown-item></b-nav-item-dropdown
  >
</template>

<script>
import {
  BNavItemDropdown,
  BDropdownItem,
  BDropdownDivider,
  BAvatar,
  BImg,
} from "bootstrap-vue";
import { avatarText } from "@core/utils/filter";
import store from "@/store";
import { TokenService, UserService } from "@/apiServices/storageService";

export default {
  components: {
    BNavItemDropdown,
    BDropdownItem,
    BDropdownDivider,
    BAvatar,
    BImg,
  },
  data() {
    return {
      avatar: "/img/13-small.d796bffd.png",
      avatarText,
    };
  },
  computed: {
    profile_image() {},
    user_details() {
      return store.getters["user/getUserDetails"];
    },
    getLoginDetail() {
      let userDetail = JSON.parse(UserService.getUserProfile());
      return userDetail;
    },
    FILESURL() {
      return process.env.FILESURL;
    },
  },
  methods: {
    logout() {
      TokenService.removeToken();
      UserService.removeUserProfile();
      this.$router.replace({ name: "login" });
    },
  },
};
</script>
