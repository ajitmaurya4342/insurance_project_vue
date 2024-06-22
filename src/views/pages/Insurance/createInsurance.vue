<template>
  <div>
    <hr />
    <validation-observer ref="loginValidation">
      <b-form class="auth-login-form" @submit.prevent>
        <b-row class="mt-1">
          <b-col sm="6" class="mt-1">
            <b-form-group label="RID" :label-for="keyname.rid">
              <validation-provider #default="{ errors }" name=" RID">
                <b-form-input
                  :id="keyname.rid"
                  :name="keyname.rid"
                  :state="errors.length > 0 ? false : null"
                  v-model="form.rid"
                  type="date"
                  placeholder="Select RID"
                ></b-form-input>

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
          <b-col sm="6" class="mt-1">
            <b-form-group label="Company" :label-for="keyname.company">
              <validation-provider
                #default="{ errors }"
                name="Company"
                :rules="{
                  required: true,
                }"
              >
                <multiselect
                  :id="keyname.company"
                  :name="keyname.company"
                  :state="errors.length > 0 ? false : null"
                  v-model="form.company"
                  track-by="name"
                  label="name"
                  placeholder="Select Company"
                  :options="company_array"
                  :searchable="false"
                  :allow-empty="true"
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
          <b-col sm="6" class="mt-1">
            <b-form-group label="Registration No" :label-for="keyname.reg_no">
              <validation-provider
                #default="{ errors }"
                name="Registration No"
                :rules="{
                  required: true,
                }"
              >
                <multiselect
                  :id="keyname.reg_no"
                  :name="keyname.reg_no"
                  :state="errors.length > 0 ? false : null"
                  v-model="form.reg_no"
                  track-by="name"
                  label="name"
                  placeholder="Select Vehicle"
                  :options="registration_array"
                  :searchable="false"
                  :allow-empty="true"
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

          <b-col sm="6" class="mt-1">
            <b-form-group label="Customer Name" :label-for="keyname.reg_name">
              <validation-provider
                #default="{ errors }"
                name="Customer Name"
                :rules="{
                  required: true,
                }"
              >
                <b-form-input
                  :id="keyname.reg_name"
                  :name="keyname.reg_name"
                  :state="errors.length > 0 ? false : null"
                  v-model="form.reg_name"
                  placeholder="Enter Customer Name"
                ></b-form-input>

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

          <b-col sm="6" class="mt-1">
            <b-form-group label="Policy No" :label-for="keyname.policy_no">
              <validation-provider
                #default="{ errors }"
                name="Policy No"
                :rules="{
                  required: true,
                }"
              >
                <b-form-input
                  :id="keyname.policy_no"
                  :name="keyname.policy_no"
                  :state="errors.length > 0 ? false : null"
                  v-model="form.policy_no"
                  placeholder="Enter Policy No"
                ></b-form-input>

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

          <b-col sm="6" class="mt-1">
            <b-form-group label="Bank Name (HP)" :label-for="keyname.bank_name">
              <validation-provider
                #default="{ errors }"
                name="Bank Name"
                :rules="{}"
              >
                <multiselect
                  :id="keyname.bank_name"
                  :name="keyname.bank_name"
                  :state="errors.length > 0 ? false : null"
                  v-model="form.bank_name"
                  track-by="name"
                  label="name"
                  placeholder="Select Bank"
                  :options="bank_array"
                  :searchable="false"
                  :allow-empty="true"
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

          <b-col sm="6" class="mt-1">
            <b-form-group label="Agent Name" :label-for="keyname.agent_name">
              <validation-provider
                #default="{ errors }"
                name="Agent Name"
                :rules="{ required: true }"
              >
                <multiselect
                  :id="keyname.agent_name"
                  :name="keyname.agent_name"
                  :state="errors.length > 0 ? false : null"
                  v-model="form.agent_name"
                  track-by="name"
                  label="name"
                  placeholder="Select Agent"
                  :options="agent_array"
                  :searchable="false"
                  :allow-empty="true"
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

          <b-col sm="3" class="mt-1">
            <b-form-group label="Agent Contact" :label-for="keyname.agent_no">
              <validation-provider #default="{ errors }" name="Agent Contact">
                <b-form-input
                  :id="keyname.agent_no"
                  :name="keyname.agent_no"
                  :state="errors.length > 0 ? false : null"
                  v-model="form.agent_no"
                  type="number"
                  placeholder="Enter Agent Contact"
                ></b-form-input>

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

          <b-col sm="3" class="mt-1">
            <b-form-group label="Policy Date" :label-for="keyname.policy_date">
              <validation-provider #default="{ errors }" name=" Policy Date">
                <b-form-input
                  :id="keyname.policy_date"
                  :name="keyname.policy_date"
                  :state="errors.length > 0 ? false : null"
                  v-model="form.policy_date"
                  type="date"
                  placeholder="Select Policy Date"
                ></b-form-input>

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
          <b-col sm="6" class="">
            <b-form-group label="Fuel Type" :label-for="keyname.fuel_type">
              <validation-provider #default="{ errors }" name="Fuel Type">
                <multiselect
                  :id="keyname.fuel_type"
                  :name="keyname.fuel_type"
                  :state="errors.length > 0 ? false : null"
                  v-model="form.fuel_type"
                  track-by="name"
                  label="name"
                  placeholder="Select Fuel Type"
                  :options="fuel_type_array"
                  :searchable="false"
                  :allow-empty="true"
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
          <b-col sm="6" class="">
            <b-form-group label="Code Id" :label-for="keyname.code_id">
              <validation-provider #default="{ errors }" name="Code ID">
                <multiselect
                  :id="keyname.code_id"
                  :name="keyname.code_id"
                  :state="errors.length > 0 ? false : null"
                  v-model="form.code_id"
                  track-by="name"
                  label="name"
                  placeholder="Select Code Id"
                  :options="code_array"
                  :searchable="false"
                  :allow-empty="true"
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

          <b-col sm="3" class="mt-1">
            <b-form-group label="Premium" :label-for="keyname.premium">
              <validation-provider #default="{ errors }" name="Premium">
                <b-form-input
                  :id="keyname.premium"
                  :name="keyname.premium"
                  :state="errors.length > 0 ? false : null"
                  v-model="form.premium"
                  type="number"
                  placeholder="Enter Premium"
                ></b-form-input>

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

          <b-col sm="3" class="mt-1">
            <b-form-group label="GST" :label-for="keyname.gst">
              <validation-provider #default="{ errors }" name="GST">
                <b-form-input
                  :id="keyname.gst"
                  :name="keyname.gst"
                  :state="errors.length > 0 ? false : null"
                  v-model="form.gst"
                  type="number"
                  placeholder="Enter GST"
                ></b-form-input>

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

          <b-col sm="3" class="mt-1">
            <b-form-group label="Net Premium" :label-for="keyname.net_premium">
              <validation-provider #default="{ errors }" name="Net Premium">
                <b-form-input
                  :id="keyname.net_premium"
                  :name="keyname.net_premium"
                  :state="errors.length > 0 ? false : null"
                  v-model="form.net_premium"
                  type="number"
                  placeholder="Enter Net Premium"
                ></b-form-input>

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

          <b-col sm="3" class="mt-1">
            <b-form-group label="IDV" :label-for="keyname.idv">
              <validation-provider #default="{ errors }" name="IDV">
                <b-form-input
                  :id="keyname.idv"
                  :name="keyname.idv"
                  :state="errors.length > 0 ? false : null"
                  v-model="form.idv"
                  type="number"
                  placeholder="Enter IDV"
                ></b-form-input>

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

          <b-col sm="3" class="">
            <b-form-group
              label="Payment Mode"
              :label-for="keyname.payment_mode"
            >
              <validation-provider #default="{ errors }" name="Payment Mode">
                <multiselect
                  :id="keyname.payment_mode"
                  :name="keyname.payment_mode"
                  :state="errors.length > 0 ? false : null"
                  v-model="form.payment_mode"
                  track-by="name"
                  label="name"
                  placeholder="Select Payment Mode"
                  :options="payment_mode_array"
                  :searchable="false"
                  :allow-empty="true"
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

          <b-col sm="3" class="">
            <b-form-group
              label="Vehicle Type"
              :label-for="keyname.vehicle_type"
            >
              <validation-provider #default="{ errors }" name="Vehicle Type">
                <multiselect
                  :id="keyname.vehicle_type"
                  :name="keyname.vehicle_type"
                  :state="errors.length > 0 ? false : null"
                  v-model="form.vehicle_type"
                  track-by="name"
                  label="name"
                  placeholder="Select Vehicle Type"
                  :options="vehicle_type_array"
                  :searchable="false"
                  :allow-empty="true"
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

          <b-col sm="3" class="">
            <b-form-group
              label="Product Type"
              :label-for="keyname.product_type"
            >
              <validation-provider #default="{ errors }" name="Product Type">
                <multiselect
                  :id="keyname.product_type"
                  :name="keyname.product_type"
                  :state="errors.length > 0 ? false : null"
                  v-model="form.product_type"
                  track-by="name"
                  label="name"
                  placeholder="Select Product Type"
                  :options="product_type_array"
                  :searchable="false"
                  :allow-empty="true"
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

          <b-col sm="3" class="">
            <b-form-group
              label="Insurance Type"
              :label-for="keyname.insurance_type"
            >
              <validation-provider #default="{ errors }" name="Insurance Type">
                <multiselect
                  :id="keyname.insurance_type"
                  :name="keyname.insurance_type"
                  :state="errors.length > 0 ? false : null"
                  v-model="form.insurance_type"
                  track-by="name"
                  label="name"
                  placeholder="Select Insurance Tyoe"
                  :options="insurance_type_array"
                  :searchable="false"
                  :allow-empty="true"
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

      <b-row class="mt-1 pb-4">
        <b-col class="text-center">
          <b-button variant="primary" @click="saveForm"
            >{{ insurance_id ? "Update" : "Add" }} Insurance
          </b-button>
          <!-- <b-button variant="primary" @click="onReset" class="ml-5"
            >Reset</b-button
          > -->
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
import Multiselect from "vue-multiselect";
import moment from "moment";
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
    Multiselect,
  },
  data() {
    return {
      insurance_id: "",
      required,

      keyname: {
        rid: "",
        reg_no: "reg_no",
        reg_name: "reg_name",
        policy_no: "policy_no",
        bank_name: "bank_name",
        agent_name: "agent_name",
        agent_no: "agent_no",
        policy_date: "policy_date",
        fuel_type: "fuel_type",
        premium: "premium",
        gst: "gst",
        net_premium: "net_premium",
        idv: "idv",
        payment_mode: "payment_mode",
        vehicle_type: "vehicle_type",
        product_type: "product_type",
        insurance_type: "insurance_type",
      },
      form: {
        rid: "",
        reg_no: "",
        reg_name: "",
        policy_no: "",
        bank_name: "",
        agent_name: "",
        agent_no: "",
        policy_date: "",
        fuel_type: "",
        premium: "",
        gst: "",
        net_premium: "",
        idv: "",
        payment_mode: "",
        vehicle_type: "",
        product_type: "",
        insurance_type: "",
      },
      registration_array: [],
      bank_array: [],
      agent_array: [],
      code_array: [],
      payment_mode_array: [],
      vehicle_type_array: [],
      product_type_array: [],
      insurance_type_array: [],
      fuel_type_array: [],
      company_array: [],
    };
  },

  directives: {
    Ripple,
  },

  beforeMount() {
    const { insurance_id } = this.$route.params;
    this.form.policy_date = moment().format("YYYY-MM-DD");
    this.form.rid = moment().format("YYYY-MM-DD");
    this.insurance_id = insurance_id || null;
    if (insurance_id) {
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
              insurance_id: this.insurance_id || "",
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
          insurance_id: this.insurance_id,
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
