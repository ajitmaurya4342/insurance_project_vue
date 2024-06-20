<template>
  <div>
    <hr />
    <validation-observer ref="loginValidation">
      <b-form class="auth-login-form" @submit.prevent>
        <b-row class="mt-1">
          <b-col
            sm="6"
            v-for="(item, index) in layoutArray"
            :key="index"
            class="mt-2"
          >
            <b-form-group :label="item.label" :label-for="item.key">
              <validation-provider
                #default="{ errors }"
                :name="item.key.replace('_', ' ')"
                :rules="{
                  ...item.rules,
                }"
              >
                <b-form-input
                  :id="item.key"
                  v-model="form[item.key]"
                  :state="errors.length > 0 ? false : null"
                  :name="item.key"
                  :placeholder="item.placeholder"
                  :type="item.type"
                />
                <small class="text-danger">{{
                  errors[0] && errors[0].includes("too short")
                    ? `${item.label} must be more than ${
                        item.rules.min - 1
                      } character`
                    : errors[0]
                }}</small>
              </validation-provider>
            </b-form-group>
          </b-col>
        </b-row>
      </b-form>

      <b-row class="mt-2">
        <b-col class="text-center">
          <b-button variant="primary" @click="saveForm"
            >{{ user_id ? "Update" : "Add" }} user</b-button
          >
          <b-button variant="primary" @click="onReset" class="ml-5"
            >Reset</b-button
          >
        </b-col>
      </b-row>
    </validation-observer>
  </div>
</template>

<script>
import {
  BNav,
  BNavItem,
  BTable,
  BRow,
  BCol,
  BInputGroup,
  BFormInput,
  BIcon,
  BIconArrowUp,
  BIconArrowDown,
  BPagination,
  BFormGroup,
  BForm,
} from "bootstrap-vue";
import Ripple from "vue-ripple-directive";
import { GetAllUsers, addEditUsers } from "@/apiServices/DashboardServices";
import { ValidationProvider, ValidationObserver } from "vee-validate";
import { required, email } from "@validations";
import ToastificationContent from "@core/components/toastification/ToastificationContent.vue";
export default {
  components: {
    BNav,
    BNavItem,
    BTable,
    BRow,
    BCol,
    BInputGroup,
    BFormInput,
    BIcon,
    BIconArrowUp,
    BIconArrowDown,
    BPagination,
    BFormGroup,
    BForm,
    ValidationProvider,
    ValidationObserver,
  },
  data() {
    return {
      user_id: "",
      form: {
        name: "",
        mobile_number: "",
        username: "",
        password: "",
      },
      required,
      layoutArray: [
        {
          col: 6,
          label: "Name",
          rules: {
            required: true,
          },
          key: "name",
          placeholder: "Enter name",
          type: "text",
        },
        {
          col: 6,
          label: "Mobile Number",
          rules: {
            required: true,
          },
          key: "mobile_number",
          placeholder: "Enter mobile number",
          type: "number",
        },
        {
          col: 6,
          label: "Username",
          rules: {
            required: true,
            min: 6,
          },
          key: "username",
          placeholder: "Enter username",
          type: "text",
        },
        {
          col: 6,
          label: "Password",
          rules: {
            required: true,
            min: 6,
          },
          key: "password",
          placeholder: "Enter password",
          type: "text",
        },
      ],
    };
  },

  directives: {
    Ripple,
  },

  beforeMount() {
    const { user_id } = this.$route.params;
    this.user_id = user_id || null;
    if (user_id) {
      this.onGetAllUsers();
    }
  },

  methods: {
    onReset() {
      Object.keys(this.form).map((z) => {
        this.form[z] = "";
      });
    },
    saveForm() {
      this.$refs.loginValidation.validate().then(async (success) => {
        if (success) {
          try {
            const response = await addEditUsers({
              ...this.form,
              user_id: this.user_id || "",
            });
            const { data } = response;
            if (data.status) {
              this.$toast({
                component: ToastificationContent,
                props: {
                  title: data.message || "Record Saved Successfully",
                  icon: "EditIcon",
                  variant: "success",
                },
              });
            }
            this.$router.go(-1);
          } catch (error) {
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
    async onGetAllUsers() {
      try {
        this.allUserList = [];
        this.isBusy = true;
        const response = await GetAllUsers({
          user_id: this.user_id,
        });
        const { data } = response;
        if (data.status) {
          Object.keys(this.form).map((z) => {
            this.form[z] = data.Records[0][z] || "";
          });
        }
        this.isBusy = false;
      } catch (err) {}
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
