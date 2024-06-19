<template>
  <div>
    <section style="background-color: #9de2ff">
      <div class="container py-2">
        <div class="row d-flex justify-content-center align-items-center h-100">
          <div class="col col-md-9 col-lg-7 col-xl-5">
            <div class="card" style="border-radius: 15px">
              <div class="card-body">
                <div class="d-flex text-black">
                  <div
                    v-for="(imgItem, imgIndex) in userDetailsArray"
                    :key="imgIndex"
                    class="flex-shrink-0"
                  >
                    <img
                      v-if="imgItem.key == 'photo'"
                      :src="BASE_URL + imgItem.vModelValue"
                      alt="Image"
                      class="img-fluid"
                      style="width: 150px; border-radius: 10px"
                    />
                  </div>
                  <div class="flex-grow-1 ms-3 ml-1">
                    <b-row>
                      <b-col
                        cols="12"
                        v-for="(imgItem1, imgIndex1) in userDetailsArray"
                        :key="imgIndex1"
                      >
                        <h5 v-if="imgItem1.key == 'name'" class="">
                          <b>{{ imgItem1.vModelValue }}</b>
                        </h5>
                        <h6
                          v-if="imgItem1.key == 'dob'"
                          class=""
                          style="color: #2b2a2a"
                        >
                          {{ imgItem1.vModelValue }}
                        </h6>
                        <h6
                          v-if="imgItem1.key == 'gender'"
                          class=""
                          style="color: #2b2a2a"
                        >
                          {{ imgItem1.vModelValue }}
                        </h6>
                      </b-col>
                    </b-row>
                  </div>
                </div>
              </div>
            </div>
            <div class="card" style="border-radius: 15px">
              <div class="card-body">
                <div class="d-flex text-black">
                  <div>
                    <table>
                      <tbody>
                        <tr
                          v-for="(item, index) in userDetailsArray"
                          :key="index"
                          v-if="
                            item.key != 'photo' &&
                            item.key != 'name' &&
                            item.key != 'dob' &&
                            item.key != 'gender'
                          "
                        >
                          <td
                            align="left"
                            style="text-align: left"
                            v-if="item.inputType != 'file'"
                          >
                            <b style=""> {{ item.label }} </b><br />
                            <div
                              style="text-align: left"
                              v-if="item.inputType == 'quill'"
                              v-html="item.vModelValue"
                            ></div>
                            <div style="text-align: left" v-else>
                              {{ item.vModelValue }}
                            </div>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
/* eslint-disable global-require */
import { BLink, BButton, BImg, BRow, BCol } from "bootstrap-vue";
import VuexyLogo from "@core/layouts/components/Logo.vue";
import { GetUserQrDetails } from "@/apiServices/DashboardServices";
import ToastificationContentVue from "@core/components/toastification/ToastificationContent.vue";
import QrcodeVue from "qrcode.vue";

export default {
  components: {
    VuexyLogo,
    BLink,
    BButton,
    BImg,
    BRow,
    BCol,
    QrcodeVue,
  },
  data() {
    return {
      unique_code_generate: this.$route.query.qrId,
      userDetailsArray: [],
      BASE_URL: process.env.VUE_APP_BASEURL,
      qrValue: null,
      qrSize: 100,
      imgAvtar: require("@/assets/images/avatars/user.png"),
    };
  },
  computed: {},

  beforeMount() {
    this.qrValue = window.location.origin + "/afterscan/";
    this.unique_code_generate = this.$route.query.qrId;
    this.onGetUserQRDetails();
  },
  methods: {
    async onGetUserQRDetails() {
      try {
        const response = await GetUserQrDetails({
          unique_code_generate: this.unique_code_generate,
        });
        if (response.data.status) {
          if (
            response.data.Records &&
            response.data.Records.data &&
            response.data.Records.data.length
          ) {
            this.userDetailsArray = response.data.Records.data[0].all_data;
          } else {
            //this.sectionArray = response.data.defaultFieldsArray;
          }
        } else {
          this.$toast({
            component: ToastificationContentVue,
            props: {
              title: response.data.message,
              icon: "EditIcon",
              variant: "danger",
            },
          });
        }
      } catch (err) {
        console.log("Error in GetUserQrDetails ", err);
      }
    },
  },
};
</script>

<style lang="scss" scoped>
@import "@core/scss/vue/pages/page-misc.scss";
.AddNewButton {
  display: inline-block;
  padding: 8px 8px;
  font-size: 14px;
  cursor: pointer;
  text-align: center;
  text-decoration: none;
  outline: none;
  color: #fff;
  background-color: #33414e !important;

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
.panel {
  border: 4px solid #efefef;
  border-radius: 15px;
}
.user-row {
  margin-bottom: 14px;
}

.user-row:last-child {
  margin-bottom: 0;
}

.dropdown-user {
  margin: 13px 0;
  padding: 5px;
  height: 100%;
}

.dropdown-user:hover {
  cursor: pointer;
}

.table-user-information > tbody > tr {
  border-top: 1px solid rgb(221, 221, 221);
}

.table-user-information > tbody > tr:first-child {
  border-top: 0;
}

.table-user-information > tbody > tr > td {
  border-top: 0;
}
.toppad {
  margin-top: 20px;
}
</style>
