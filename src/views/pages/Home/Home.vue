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
import { GetAllUsers } from "@/apiServices/DashboardServices";
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
