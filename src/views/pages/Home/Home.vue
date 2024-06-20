<template>
  <div>
    <!-- <div class="mb-1">
      <button class="AddNewButton" @click="$router.push({ name: 'createqr' })">
        Create New User QR
      </button>
    </div> -->
    <div></div>

    <hr class="m-2" />
  </div>
</template>

<script>
import {
  BCard,
  BRow,
  BCol,
  BCardText,
  BButton,
  BCardFooter,
  BCardImg,
  BCardBody,
  BCardTitle,
  BCardSubTitle,
  BListGroup,
  BListGroupItem,
  BFormInput,
  BImg,
  BNav,
  BNavItem,
  BNavForm,
} from "bootstrap-vue";
import Ripple from "vue-ripple-directive";

import QrcodeVue from "qrcode.vue";

export default {
  components: {
    BCard,
    BRow,
    BCol,
    BCardText,
    BButton,
    BCardFooter,
    BCardImg,
    BCardBody,
    BCardTitle,
    BCardSubTitle,
    BListGroup,
    BListGroupItem,
    BImg,
    QrcodeVue,
    BFormInput,
    BNav,
    BNavItem,
    BNavForm,
  },
  data() {
    return {};
  },

  directives: {
    Ripple,
  },

  beforeMount() {},

  methods: {},
};
</script>

<style lang="scss" scoped>
.card-container {
  display: flex !important;
  justify-content: flex-start;
  flex-wrap: wrap;
}
.AddNewButton {
  display: inline-block;
  padding: 10px 15px;
  font-size: 15px;
  cursor: pointer;
  text-align: center;
  text-decoration: none;
  outline: none;
  color: #fff;
  background-color: #1f307a !important;

  border: none;
  border-radius: 15px;
}

.AddNewButton:hover {
  background-color: #3e8e41;
}

.AddNewButton:active {
  background-color: #3e8e41;
  // transform: translateY(4px);
}
</style>
