<template></template>

<script>
/* eslint-disable global-require */
import { BLink, BButton, BImg } from "bootstrap-vue";
import VuexyLogo from "@core/layouts/components/Logo.vue";
import store from "@/store/index";

export default {
  components: {
    VuexyLogo,
    BLink,
    BButton,
    BImg,
  },
  data() {
    return {};
  },
  computed: {},
};
</script>

<style lang="scss">
@import "@core/scss/vue/pages/page-misc.scss";
</style>
