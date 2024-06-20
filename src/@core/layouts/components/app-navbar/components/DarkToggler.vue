<template>
  <b-nav-item @click="skin = isDark ? 'light' : 'dark'"> </b-nav-item>
</template>

<script>
import useAppConfig from "@core/app-config/useAppConfig";
import { computed } from "@vue/composition-api";
import { BNavItem } from "bootstrap-vue";

export default {
  components: {
    BNavItem,
  },
  setup() {
    const { skin } = useAppConfig();

    const isDark = computed(() => skin.value === "dark");

    return { skin, isDark };
  },
};
</script>
