<template>
  <div class="auth-wrapper auth-v2">
    <b-row class="auth-inner m-0">
      <!-- Brand logo-->
      <b-link class="brand-logo">
        <!-- <h2 class="brand-text text-primary ml-1">QR APP</h2> -->
      </b-link>

      <b-col lg="7" class="d-none d-lg-flex align-items-center p-5">
        <div
          class="w-100 d-lg-flex align-items-center justify-content-center px-5"
        >
          <b-img width="150" fluid :src="imgUrl" alt="Login V2" />
        </div>
      </b-col>

      <b-col lg="5" class="d-flex align-items-center auth-bg px-0 p-lg-5">
        <b-col sm="8" md="6" lg="12" class="px-xl-2 pt-5 pt-xl-0 mx-auto">
          <b-card-title title-tag="h2" class="font-weight-bold mb-1">
            Welcome to QR APP! 👋
          </b-card-title>
          <b-card-text class="mb-2">
            Please sign-in to your account.
          </b-card-text>

          <!-- form -->
          <validation-observer ref="loginValidation">
            <b-form class="auth-login-form mt-2" @submit.prevent>
              <!-- email -->
              <b-form-group label="Email" label-for="login-email">
                <validation-provider
                  #default="{ errors }"
                  name="Email"
                  rules="required|email"
                >
                  <b-form-input
                    id="login-email"
                    v-model="form.user_name"
                    :state="errors.length > 0 ? false : null"
                    name="login-email"
                    placeholder="john@example.com"
                  />
                  <small class="text-danger">{{ errors[0] }}</small>
                </validation-provider>
              </b-form-group>

              <!-- forgot password -->
              <b-form-group>
                <div class="d-flex justify-content-between">
                  <label for="login-password">Password</label>
                  <!-- <b-link :to="{ name: 'ForgotPassword' }">
                    <small>Forgot Password?</small>
                  </b-link> -->
                </div>
                <validation-provider
                  #default="{ errors }"
                  name="Password"
                  rules="required"
                >
                  <b-input-group
                    class="input-group-merge"
                    :class="errors.length > 0 ? 'is-invalid' : null"
                  >
                    <b-form-input
                      id="login-password"
                      v-model="form.password"
                      :state="errors.length > 0 ? false : null"
                      class="form-control-merge"
                      :type="passwordFieldType"
                      name="login-password"
                      placeholder="············"
                    />
                    <b-input-group-append is-text>
                      <feather-icon
                        class="cursor-pointer"
                        :icon="passwordToggleIcon"
                        @click="togglePasswordVisibility"
                      />
                    </b-input-group-append>
                  </b-input-group>
                  <small class="text-danger">{{ errors[0] }}</small>
                </validation-provider>
              </b-form-group>
              <b-button
                class="mt-2"
                type="submit"
                variant="primary"
                block
                @click="Login"
              >
                Sign in
              </b-button>
            </b-form>
          </validation-observer>

          <b-card-text class="text-center mt-2">
            <span
              >The login credentials are provided by the admin at QR APP
            </span>
          </b-card-text>
        </b-col>
      </b-col>
    </b-row>
  </div>
</template>

<script>
/* eslint-disable global-require */

import { ValidationProvider, ValidationObserver } from "vee-validate";
import VuexyLogo from "@core/layouts/components/Logo.vue";
import {
  BRow,
  BCol,
  BLink,
  BFormGroup,
  BFormInput,
  BInputGroupAppend,
  BInputGroup,
  BFormCheckbox,
  BCardText,
  BCardTitle,
  BImg,
  BForm,
  BButton,
} from "bootstrap-vue";
import { required, email } from "@validations";
import { togglePasswordVisibility } from "@core/mixins/ui/forms";
import store from "@/store/index";
import ToastificationContent from "@core/components/toastification/ToastificationContent.vue";
import * as AuthServices from "@/apiServices/AuthServices";
import { TokenService } from "@/apiServices/storageService";

export default {
  components: {
    BRow,
    BCol,
    BLink,
    BFormGroup,
    BFormInput,
    BInputGroupAppend,
    BInputGroup,
    BFormCheckbox,
    BCardText,
    BCardTitle,
    BImg,
    BForm,
    BButton,
    VuexyLogo,
    ValidationProvider,
    ValidationObserver,
  },
  mixins: [togglePasswordVisibility],
  data() {
    return {
      form: {
        status: "",
        password: "",
        user_name: "",
      },
      sideImg: require("@/assets/images/pages/qr-code.png"),
      required,
      email,
    };
  },
  computed: {
    passwordToggleIcon() {
      return this.passwordFieldType === "password" ? "EyeIcon" : "EyeOffIcon";
    },
    imgUrl() {
      if (store.state.appConfig.layout.skin === "dark") {
        this.sideImg = require("@/assets/images/pages/qr-code.png");

        return this.sideImg;
      }
      return this.sideImg;
    },
  },
  methods: {
    Login() {
      this.$refs.loginValidation.validate().then(async (success) => {
        if (success) {
          try {
            const response = await AuthServices.Login(this.form);
            if (response.data.status) {
              TokenService.saveToken("rdtrjbkjg54878787hfgf");

              this.$store.commit("user/SET_USER_AUTHENTICATED", true);

              this.$toast({
                component: ToastificationContent,
                props: {
                  title: response.data.message || "Login Successful",
                  icon: "EditIcon",
                  variant: "success",
                },
              });
              //this.$store.dispatch("user/setUserDetails");
              this.$router.push({ name: "home" });
            } else {
              this.$toast({
                component: ToastificationContent,
                props: {
                  title: response.data.message || "Login Failure",
                  icon: "EditIcon",
                  variant: "failure",
                },
              });
            }
          } catch (error) {
            console.log("Error Login ", error);
            this.$toast({
              component: ToastificationContent,
              props: {
                title: "Server Error",
                icon: "EditIcon",
                variant: "failure",
              },
            });
          }
        }
      });
    },
  },
};
</script>

<style lang="scss">
@import "@core/scss/vue/pages/page-auth.scss";
</style>
