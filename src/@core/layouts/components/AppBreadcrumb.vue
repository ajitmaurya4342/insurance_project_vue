<template>
  <b-row
    v-if="$route.meta.breadcrumb || $route.meta.pageTitle"
    class="content-header"
  >
    <!-- Content Left -->
    <b-col class="content-header-left mb-2" cols="12" md="9">
      <b-row class="breadcrumbs-top">
        <b-col cols="12">
          <h2 class="float-left pr-1 mb-0">
            <b-button
              size="sm"
              v-if="$route.name != 'home'"
              @click="$router.go(-1)"
              v-ripple.400="'rgba(113, 102, 240, 0.15)'"
              variant="primary"
              class="btn-icon rounded-circle mr-1"
            >
              <feather-icon icon="ArrowLeftIcon" />
            </b-button>
            <b> {{ $route.meta.pageTitle }}</b>
          </h2>
          <div class="breadcrumb-wrapper">
            <b-breadcrumb>
              <!-- <b-breadcrumb-item to="/home">
                <feather-icon
                  icon="HomeIcon"
                  size="16"
                  class="align-text-top"
                />
              </b-breadcrumb-item> -->
              <b-breadcrumb-item
                v-for="item in $route.meta.breadcrumb"
                :key="item.text"
                :active="item.active"
                :to="item.to"
              >
                {{ item.text }}
              </b-breadcrumb-item>
            </b-breadcrumb>
          </div>
        </b-col>
      </b-row>
    </b-col>

    <!-- Content Right -->
    <!-- <b-col
      class="content-header-right text-md-right d-md-block d-none mb-1"
      md="3"
      cols="12"
    >
      <b-button
        v-if="fullscreen"
        @click="toggleFullScreen"
        v-ripple.400="'rgba(255, 255, 255, 0.15)'"
        variant="primary"
        class="btn-icon"
        v-b-tooltip.hover
        title="Exit FullScreen"
      >
        <feather-icon icon="MinimizeIcon" />
      </b-button>
      <b-button
        v-if="!fullscreen"
        @click="toggleFullScreen"
        v-ripple.400="'rgba(255, 255, 255, 0.15)'"
        variant="primary"
        class="btn-icon"
        v-b-tooltip.hover
        title="Enter FullScreen"
      >
        <feather-icon icon="MaximizeIcon" />
      </b-button>
    </b-col> -->
  </b-row>
</template>

<script>
import {
  BBreadcrumb,
  BBreadcrumbItem,
  BRow,
  BCol,
  BDropdown,
  BDropdownItem,
  BButton,
  VBTooltip,
} from "bootstrap-vue";
import Ripple from "vue-ripple-directive";

export default {
  data() {
    return {
      fullscreen: false,
    };
  },
  directives: {
    Ripple,
    "b-tooltip": VBTooltip,
  },
  components: {
    BBreadcrumb,
    BBreadcrumbItem,
    BRow,
    BCol,
    BDropdown,
    BDropdownItem,
    BButton,
  },
  created() {
    // Add an event listener to update the fullscreen state when the app is created
    this.updateFullScreenState();

    // Add an event listener to update the fullscreen state when the document enters or exits fullscreen mode
    document.addEventListener("fullscreenchange", this.updateFullScreenState);
  },
  destroyed() {
    // Remove the event listener for updating the fullscreen state when the app is destroyed
    document.removeEventListener(
      "fullscreenchange",
      this.updateFullScreenState
    );
  },
  methods: {
    toggleFullScreen() {
      // If the document is not currently in fullscreen mode, request fullscreen
      if (!document.fullscreenElement) {
        document.documentElement.requestFullscreen();
      }
      // Otherwise, exit fullscreen mode
      else {
        document.exitFullscreen();
      }
    },

    exitFullScreen() {
      // Exit fullscreen mode
      document.exitFullscreen();
    },
    updateFullScreenState() {
      // Update the fullscreen state based on whether the document is in fullscreen mode
      this.fullscreen = Boolean(document.fullscreenElement);
    },
  },
};
</script>
