<template>
  <div class="btn-scroll-to-top" :class="{ show: y > 250 }">
    <!-- We have wrapper because ripple effect give position relative to this absolute positioned btn -->
    <!-- Hence due to that our btn get lost -->
    <b-button
      v-b-tooltip.hover.v-primary.top="'Scroll to top'"
      v-ripple.400="'rgba(255, 255, 255, 0.15)'"
      id="scroll-to-top"
      variant="primary"
      class="btn-icon rounded-circle"
      @click="scrollToTop"
    >
      <feather-icon icon="ArrowUpIcon" size="16" />
    </b-button>
    <!-- <b-tooltip title="Top" :target="`scroll-to-top`" /> -->
  </div>
</template>

<script>
import { useWindowScroll } from "@vueuse/core";
import { BButton, BTooltip, VBTooltip } from "bootstrap-vue";
import Ripple from "vue-ripple-directive";

export default {
  directives: {
    Ripple,
    "b-tooltip": VBTooltip,
  },
  components: {
    BButton,
    BTooltip,
  },
  setup() {
    const { y } = useWindowScroll();

    const scrollToTop = () => {
      const rootEle = document.documentElement;
      rootEle.scrollTo({
        top: 0,
        behavior: "smooth",
      });
    };

    return { y, scrollToTop };
  },
};
</script>

<style lang="scss" scoped>
.btn-scroll-to-top {
  position: fixed;
  bottom: 5%;
  right: 30px;
  z-index: 99;

  // opacity: 0;
  display: none;
  // transform: translateY(100px);
  transition: all 0.5s ease;

  &.show {
    // opacity: 1;
    display: block;
    // transform: translateY(0)
  }
}
</style>
