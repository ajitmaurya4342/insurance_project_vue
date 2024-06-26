<template>
  <li
    v-if="canViewVerticalNavMenuLink(item) && checkItem(item)"
    class="nav-item"
    :class="{
      active: isActive,
      disabled: item.disabled,
    }"
  >
    <b-link v-bind="linkProps" class="d-flex align-items-center">
      <feather-icon :icon="item.icon || 'CircleIcon'" class="text-success" />
      <span class="menu-title text-truncate">{{ t(item.title) }} </span>
      <b-badge
        v-if="item.tag"
        pill
        :variant="item.tagVariant || 'primary'"
        class="mr-1 ml-auto"
      >
        {{ item.tag }}
      </b-badge>
    </b-link>
  </li>
</template>

<script>
import { useUtils as useAclUtils } from "@core/libs/acl";
import { BLink, BBadge } from "bootstrap-vue";
import { useUtils as useI18nUtils } from "@core/libs/i18n";
import useVerticalNavMenuLink from "./useVerticalNavMenuLink";
import mixinVerticalNavMenuLink from "./mixinVerticalNavMenuLink";
import { UserService } from "@/apiServices/storageService";

export default {
  components: {
    BLink,
    BBadge,
  },
  mixins: [mixinVerticalNavMenuLink],
  props: {
    item: {
      type: Object,
      required: true,
    },
  },
  setup(props) {
    const { isActive, linkProps, updateIsActive } = useVerticalNavMenuLink(
      props.item
    );
    const { t } = useI18nUtils();
    const { canViewVerticalNavMenuLink } = useAclUtils();

    return {
      isActive,
      linkProps,
      updateIsActive,

      // ACL
      canViewVerticalNavMenuLink,

      // i18n
      t,
    };
  },
  methods: {
    checkItem(item) {
      let getUserProfile = JSON.parse(UserService.getUserProfile() || {});
      let checkIsAdminUser = getUserProfile.user_type == "admin";
      if (item.isOnlyVisibleToAdmin) {
        return checkIsAdminUser;
      } else {
        return true;
      }
    },
  },
};
</script>
