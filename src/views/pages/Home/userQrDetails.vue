<template>
  <div>
    <b-row>
      <b-col cols="12" md="8">
        <div class="mb-1">
          <button
            class="AddNewButton text-center mr-1"
            @click="
              $router.push({
                name: 'createqr',
                query: { qrId: unique_code_generate },
              })
            "
          >
            Edit Profile
          </button>
          <button
            class="AddNewButton text-center"
            @click="
              $router.push({
                name: 'scanDetails',
                query: { qrId: unique_code_generate },
              })
            "
          >
            Scan View
          </button>
        </div>
        <div>
          <div>
            <div class="panel panel-info">
              <div class="panel-heading m-2">
                <div>
                  <b-col>
                    <b-row
                      v-for="(imgItem, imgIndex) in userDetailsArray"
                      :key="imgIndex"
                      v-if="imgItem.inputType == 'file'"
                    >
                      <b-col>
                        <b-img
                          v-if="imgItem.vModelValue"
                          class="align-left text-left mt-2"
                          width="150"
                          height="150"
                          fluid
                          :src="BASE_URL + imgItem.vModelValue"
                          alt="Image"
                        ></b-img>
                        <b-img
                          width="150"
                          height="150"
                          v-else
                          class="m-1"
                          fluid
                          :src="imgAvtar"
                          alt="Image 1"
                        ></b-img>
                      </b-col>
                      <b-col
                        ><h3 class="panel-title text-center">
                          <b>Profile</b>
                        </h3></b-col
                      >
                      <b-col>
                        <!-- <qrcode-vue
                          class="mt-2 align-right text-right"
                          :size="qrSize"
                          level="H"
                          :value="qrValue + imgItem.unique_code_generate"
                        ></qrcode-vue
                      > -->
                      </b-col>
                    </b-row>
                  </b-col>
                </div>
              </div>
              <div>
                <div>
                  <div>
                    <table class="table">
                      <tbody>
                        <tr
                          v-for="(item, index) in userDetailsArray"
                          :key="index"
                        >
                          <td
                            align="left"
                            style="text-align: left"
                            v-if="item.inputType != 'file'"
                          >
                            <b> {{ item.label }} </b><br />
                            <div
                              style="text-align: left; width: 50%"
                              v-if="item.inputType == 'quill'"
                              v-html="item.vModelValue"
                            ></div>
                            <div style="text-align: left" v-else>
                              {{ item.vModelValue }}
                            </div>
                          </td>

                          <!-- <td
                            align="left"
                            style="text-align: left"
                            v-if="item.inputType != 'file'"
                          >
                           
                            <div
                              style="text-align: left"
                              v-if="item.inputType == 'quill'"
                              v-html="item.vModelValue"
                            ></div>
                            <div style="text-align: left" v-else>
                              {{ item.vModelValue }}
                            </div>
                          </td> -->
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </b-col>
    </b-row>
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
