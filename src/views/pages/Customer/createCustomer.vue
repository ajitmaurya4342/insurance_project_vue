<template>
  <div>
    <hr />
    <validation-observer ref="loginValidation">
      <b-form class="auth-login-form" @submit.prevent>
        <b-row class="mt-1">
          <b-col
            :sm="item.col"
            v-for="(item, index) in layoutArray"
            :key="index"
            class="mt-2"
          >
            <b-form-group :label="item.label" :label-for="item.key">
              <validation-provider
                #default="{ errors }"
                :name="item.key.replaceAll('_', ' ')"
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
            >{{ cust_id ? "Update" : "Add" }} Customer
          </b-button>
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
import {
  GetAllCustomer,
  addEditCustomer,
} from "@/apiServices/DashboardServices";
import { ValidationProvider, ValidationObserver } from "vee-validate";
import { required } from "@validations";
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
      cust_id: "",
      form: {
        vehicle_no: "",
        cust_phone: "",
        cust_address: "",
        cust_name: "",
      },
      required,
      layoutArray: [
        {
          col: 6,
          label: "Vehicle No",
          rules: {
            required: true,
          },
          key: "vehicle_no",
          placeholder: "Enter Vehicle No",
          type: "text",
        },
        {
          col: 6,
          label: "Customer Name",
          rules: {
            required: true,
          },
          key: "cust_name",
          placeholder: "Enter Customer Name",
          type: "text",
        },
        {
          col: 6,
          label: "Customer Phone",
          rules: {},
          key: "cust_phone",
          placeholder: "Enter Customer Phone",
          type: "number",
        },
        {
          col: 6,
          label: "Customer Address",
          rules: {},
          key: "cust_address",
          placeholder: "Enter Customer Address",
          type: "text",
        },
      ],
    };
  },

  directives: {
    Ripple,
  },

  beforeMount() {
    const { cust_id } = this.$route.params;
    this.cust_id = cust_id || null;
    if (cust_id) {
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
            const response = await addEditCustomer({
              ...this.form,
              cust_id: this.cust_id || "",
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
              this.$router.go(-1);
            } else {
              this.$toast({
                component: ToastificationContent,
                props: {
                  title: data.message || "Something Went Wrong",
                  icon: "EditIcon",
                  variant: "failure",
                },
              });
            }
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
        const response = await GetAllCustomer({
          cust_id: this.cust_id,
        });
        const { data } = response;
        if (data.status) {
          Object.keys(this.form).map((z) => {
            this.form[z] = data.Records[0][z] || null;
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
