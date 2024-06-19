<template>
  <b-nav-item-dropdown
    class="dropdown-notification mr-25"
    menu-class="dropdown-menu-media"
    right
  >
    <template #button-content>
      <feather-icon
        :badge="$store.state.user.new_notifications_count"
        badge-classes="bg-danger"
        class="text-body"
        icon="BellIcon"
        size="21"
        @click="setNotificationsNotified"
      />
    </template>

    <!-- Header -->
    <li class="dropdown-menu-header">
      <div class="dropdown-header d-flex">
        <h4 class="notification-title mb-0 mr-auto">Notifications</h4>
        <b-badge
          v-if="$store.state.user.new_notifications_count"
          pill
          variant="light-primary"
        >
          {{ $store.state.user.new_notifications_count }} New
        </b-badge>
      </div>
    </li>
    <!-- Notifications -->
    <vue-perfect-scrollbar
      :settings="perfectScrollbarSettings"
      class="scrollable-container media-list scroll-area"
      tagname="li"
    >
      <!-- Account Notification -->
      <b-link
        v-for="(notification, n_index) in $store.state.user.new_notifications"
        :key="'notification' + n_index"
      >
        <b-media>
          <template #aside>
            <b-avatar
              size="32"
              v-if="notification.notification_image"
              :src="notification.notification_image"
            />
          </template>
          <p class="media-heading">
            <span class="font-weight-bolder">
              {{ notification.notification_heading }}
            </span>
          </p>
          <small class="notification-text">{{
            notification.notification_text
          }}</small>
        </b-media>
      </b-link>
      <div
        v-if="
          $store.state.user.new_notifications &&
          $store.state.user.new_notifications.length <= 0
        "
        class="text-center"
      >
        <span>no new notifications</span>
      </div>
    </vue-perfect-scrollbar>

    <!-- Cart Footer -->
    <li class="dropdown-menu-footer">
      <b-button
        v-ripple.400="'rgba(255, 255, 255, 0.15)'"
        variant="primary"
        block
        @click="$router.push({ name: 'Notifications' })"
        >view all notifications</b-button
      >
    </li>
  </b-nav-item-dropdown>
</template>

<script>
import {
  BNavItemDropdown,
  BBadge,
  BMedia,
  BLink,
  BAvatar,
  BButton,
  BFormCheckbox,
} from "bootstrap-vue";
import VuePerfectScrollbar from "vue-perfect-scrollbar";
import Ripple from "vue-ripple-directive";

export default {
  components: {
    BNavItemDropdown,
    BBadge,
    BMedia,
    BLink,
    BAvatar,
    VuePerfectScrollbar,
    BButton,
    BFormCheckbox,
  },
  directives: {
    Ripple,
  },
  data() {
    return {
      new_notifications: [],
    };
  },
  setup() {
    const perfectScrollbarSettings = {
      maxScrollbarLength: 60,
      wheelPropagation: false,
    };
    return {
      perfectScrollbarSettings,
    };
  },
  methods: {
    setNotificationsNotified() {
      setTimeout(() => {
        this.$store.commit("user/SET_NEW_NOTIFICATIONS_COUNT", 0);
      }, 2000);
    },
  },
};
</script>

<style></style>
