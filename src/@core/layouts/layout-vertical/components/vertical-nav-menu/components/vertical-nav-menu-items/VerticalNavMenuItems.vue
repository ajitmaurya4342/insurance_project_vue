<template>
  <ul>
    <component
      v-for="item in items"
      :is="resolveNavItemComponent(item)"
      :key="item.header || item.title"
      :item="item"
    />
  </ul>
</template>

<script>
import { provide, ref } from "@vue/composition-api";
import VerticalNavMenuHeader from "../vertical-nav-menu-header";
import VerticalNavMenuLink from "../vertical-nav-menu-link/VerticalNavMenuLink.vue";
import VerticalNavMenuGroup from "../vertical-nav-menu-group/VerticalNavMenuGroup.vue";
import store from "@/store";

export default {
  components: {
    VerticalNavMenuHeader,
    VerticalNavMenuLink,
    VerticalNavMenuGroup,
  },
  props: {
    items: {
      type: Array,
      required: true,
    },
  },
  data() {
    return {};
  },
  computed: {},
  methods: {
    resolveNavItemComponent(item) {
      const user_details = store.getters["user/getUserDetails"];
      const user_type = user_details.user_type;

      if (
        !item.user_types ||
        !item.user_types.length > 0 ||
        item.user_types.includes(user_type)
      ) {
        if (item.header) return "vertical-nav-menu-header";
        if (item.children) return "vertical-nav-menu-group";
        return "vertical-nav-menu-link";
      } else {
        return null;
      }
    },
  },
  setup() {
    provide("openGroups", ref([]));

    return {
      // resolveNavItemComponent,
    };
  },
};
</script>
