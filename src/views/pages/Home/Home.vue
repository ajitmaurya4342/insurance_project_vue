<template>
  <div>
    <!-- <div class="mb-1">
      <button class="AddNewButton" @click="$router.push({ name: 'createqr' })">
        Create New User QR
      </button>
    </div> -->
    <div>
      <b-nav pills>
        <b-nav-item @click="$router.push({ name: 'createqr' })" active
          >Create New User</b-nav-item
        >
      </b-nav>
    </div>
    <!-- <b-row>
    <b-col cols="4" class="mb-1 p-0 ml-3">
        <b-form-input
          placeholder="Search"
          v-model="searchUser"
          id="nested-street"
        ></b-form-input>
      </b-col>
      <b-col cols="1" class="mb-1 p-0">
        <b-button @click="onSearchUser">Search</b-button>
      </b-col>
    <b-col cols="6" class="mb-1" style="text-align: right">
        <button
          class="AddNewButton text-center"
          @click="$router.push({ name: 'createqr' })"
        >
          Create New User
        </button>
      </b-col>
    </b-row> -->
    <!-- <b-row>
      <b-col cols="12" style="text-align: right">
        <u>Total : {{ this.totalUsers }} Users</u>
      </b-col>
    </b-row> -->

    <!-- <hr class="p-0 mb-1" style="border: 1px solid rgb(197 196 196)" /> -->
    <hr class="m-2" />
    <div>
      <b-nav pills align="left">
        <b-nav-form @submit.stop.prevent="alert('Form Submitted')">
          <b-form-input
            placeholder="search user.."
            v-model="searchUser"
            aria-label="Input"
            class="mr-1"
          ></b-form-input>
          <b-button class="AddNewButton" type="submit" @click="onSearchUser"
            >Search</b-button
          >
        </b-nav-form>
      </b-nav>
    </div>
    <!-- <b-row v-if="false">
      <b-col v-for="(item, index) in allUserList" :key="index" cols="12" md="3">
        <b-card no-body>
          <b-row
            v-for="(imgItem, imgIndex) in item.all_data"
            :key="imgIndex"
            v-if="imgItem.inputType == 'file'"
          >
            <b-col>
              <b-img
                v-if="imgItem.vModelValue"
                class="m-1"
                rounded="circle"
                fluid
                :src="BASE_URL + imgItem.vModelValue"
                alt="Image 1"
              ></b-img>
              <b-img
                v-else
                class="m-1"
                rounded="circle"
                fluid
                :src="imgAvtar"
                alt="Image 1"
              ></b-img>
            </b-col>
            <b-col>
              <qrcode-vue
                class="m-1"
                :size="qrSize"
                level="H"
                :value="qrValue + item.unique_code_generate"
              ></qrcode-vue>
            </b-col>
          </b-row>

          <b-list-group flush>
            <b-list-group-item
              v-for="(subItem, subIndex) in item.all_data"
              :key="subIndex"
              v-if="subItem.label == 'Full Name'"
              >{{ subItem.label }} :
              {{ subItem.vModelValue }}</b-list-group-item
            >
          </b-list-group>

          <b-card-text> </b-card-text>
          <template #footer>
            <small
              @click="
                $router.push({
                  name: 'qrdetails',
                  query: { qrId: item.unique_code_generate },
                })
              "
              style="cursor: pointer"
              class="text-muted"
              >View Details</small
            >
            |
            <small
              style="cursor: pointer"
              class="text-muted"
              @click="onEdit(item.unique_code_generate)"
              >Edit</small
            >
          </template>
        </b-card>
      </b-col>
    </b-row> -->

    <div class="card-container pb-3" v-if="allUserList.length">
      <template v-for="item in allUserList">
        <CardComponent
          :data="item.all_data"
          :unique_id="item.unique_code_generate"
          :key="item"
        />
      </template>
    </div>
    <div v-else>
      <div style="width: 100%; display: flex; justify-content: space-around">
        <h5 style="font-weight: bold">No Users Found</h5>
      </div>
    </div>

    <b-row class="pb-3" v-if="showLoadMore && allUserList.length">
      <b-col cols="12" style="text-align: center">
        <b-button variant="info" @click="showLoadMoreData">Load More</b-button>
      </b-col>
    </b-row>
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
import { GetAllUsers } from "@/apiServices/DashboardServices";
import QrcodeVue from "qrcode.vue";
import CardComponent from "./CardComponent.vue";

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
    CardComponent,
    BNav,
    BNavItem,
    BNavForm,
  },
  data() {
    return {
      allUserList: [],
      BASE_URL: process.env.VUE_APP_BASEURL,
      qrValue: null,
      qrSize: 100,
      imgAvtar: require("@/assets/images/avatars/user.png"),
      searchUser: "",
      limit: 9,
      currentPage: 1,
      showLoadMore: false,
      totalUsers: 0,
      totalPages: 0,
    };
  },

  directives: {
    Ripple,
  },

  beforeMount() {
    this.qrValue = window.location.origin + "/afterscan/";
    this.onGetAllUsers();
  },

  methods: {
    showLoadMoreData() {
      this.currentPage = this.currentPage + 1;
      this.onGetAllUsers();
    },
    async onEdit(unique_code_generate) {
      this.$router.push({
        name: "createqr",
        query: { qrId: unique_code_generate },
      });
    },
    onSearchUser() {
      this.currentPage = 1;
      this.allUserList = [];
      this.onGetAllUsers();
    },
    async onGetAllUsers() {
      try {
        const response = await GetAllUsers({
          search: this.searchUser,
          limit: this.limit,
          currentPage: this.currentPage,
        });

        if (response.data.status) {
          this.allUserList = [
            ...this.allUserList,
            ...response.data.Records.data,
          ];

          if (this.currentPage == 1) {
            this.totalUsers = response.data.Records.pagination.total;
            this.totalPages = response.data.Records.pagination.lastPage;
          }
          this.showLoadMore = this.totalPages != this.currentPage;
        }
      } catch (err) {
        console.log("Error in GenerateQrCode ", err);
      }
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
