<template>
  <div>
    <div>
      <hr />
      <b-row class="mt-2" v-if="layoutArray.length">
        <b-col sm="3" v-for="(item, index) in layoutArray" :key="index">
          <b-card
            @click="redirectList(item)"
            class="cursor-pointer"
            :header="item.heading"
            header-text-variant="white"
            header-tag="header"
            header-bg-variant="primary"
            style="max-width: 20rem"
          >
            <b-card-text class="p-2">
              <b-row class="justify-content-center display-flex mt-1">
                <feather-icon :icon="item.icon" size="30" />
                <h2 class="pl-1">{{ item.total_count }}</h2>
              </b-row>
            </b-card-text>
          </b-card>
        </b-col>
      </b-row>
    </div>

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
import { GetDashboard } from "@/apiServices/DashboardServices";

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
    return {
      layoutArray: [],
    };
  },

  directives: {
    Ripple,
  },

  beforeMount() {
    this.getDashboardData();
  },

  methods: {
    async getDashboardData() {
      this.layoutArray = [];
      const response = await GetDashboard({
        setting_id: 1,
      });
      const { data } = response;
      if (data.status && data.Records) {
        this.layoutArray = data.Records;
      }
    },
    redirectList(item) {
      this.$router.push({
        path: "/" + item.path,
      });
    },
  },
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
