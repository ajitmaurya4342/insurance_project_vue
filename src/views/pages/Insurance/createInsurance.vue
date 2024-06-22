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
                  track-by="ct_id"
                  label="company_type_name"
                  placeholder="Select Company"
                  :options="company_array"
                  @input="changeCompany"
                  :searchable="true"
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
            <b-form-group
              label="Registration No"
              :label-for="keyname.reg_no"
              class="m-0"
            >
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
                  track-by="cust_id"
                  label="vehicle_no"
                  placeholder="Select Vehicle"
                  :options="registration_array"
                  @input="changeVehicle"
                  :searchable="true"
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
            <b-form-group
              label="Customer Name"
              :label-for="keyname.reg_name"
              class="m-0"
            >
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

          <b-col sm="12" class="m-0 mb-1">
            <h6
              @click="showModal(keyname.reg_no)"
              lass="m-0"
              style="color: #1f307a; cursor: pointer"
            >
              <u>Create New Vehicle</u>
            </h6>
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
                  track-by="bd_id"
                  label="bank_dept_name"
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
            <b-form-group
              label="Agent Name"
              :label-for="keyname.agent_name"
              class="m-0"
            >
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
                  track-by="agent_id"
                  label="agent_name"
                  placeholder="Select Agent"
                  :options="agent_array"
                  :searchable="true"
                  :allow-empty="true"
                  @input="changeAgent"
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
            <b-form-group
              label="Agent Contact"
              :label-for="keyname.agent_no"
              class="m-0"
            >
              <validation-provider #default="{ errors }" name="Agent Contact">
                <b-form-input
                  :id="keyname.agent_no"
                  :name="keyname.agent_no"
                  :state="errors.length > 0 ? false : null"
                  v-model="form.agent_no"
                  type="number"
                  placeholder="Enter Agent Contact"
                  :disabled="
                    form.agent_name && form.agent_name.agent_name == 'Self'
                      ? false
                      : true
                  "
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
            <b-form-group
              label="Policy Date"
              :label-for="keyname.policy_date"
              class="m-0"
            >
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

          <b-col sm="12" class="m-0 mb-1">
            <h6
              @click="showModal(keyname.agent_name)"
              lass="m-0"
              style="color: #1f307a; cursor: pointer"
            >
              <u>Create New Agent</u>
            </h6>
          </b-col>

          <b-col sm="6" class="">
            <b-form-group label="Fuel Type" :label-for="keyname.fuel_type">
              <validation-provider #default="{ errors }" name="Fuel Type">
                <multiselect
                  :id="keyname.fuel_type"
                  :name="keyname.fuel_type"
                  :state="errors.length > 0 ? false : null"
                  v-model="form.fuel_type"
                  track-by="fuel_id"
                  label="fuel_type_name"
                  placeholder="Select Fuel Type"
                  :options="fuel_type_array"
                  :searchable="true"
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
                  track-by="agent_id"
                  label="agent_name"
                  placeholder="Select Code
                Id"
                  :options="agent_array"
                  :searchable="true"
                  :allow-empty="true"
                  :disabled="
                    form.company && form.company.seller_type !== 'Self'
                      ? false
                      : true
                  "
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
                  @input="calculateGST"
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
                  :disabled="true"
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
                  :disabled="true"
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
                  track-by="pm_id"
                  label="pm_name"
                  placeholder="Select Payment Mode"
                  :options="payment_mode_array"
                  :searchable="true"
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
                  track-by="vehicle_id"
                  label="vehicle_type"
                  placeholder="Select Vehicle Type"
                  :options="vehicle_type_array"
                  :searchable="true"
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
                  track-by="fp_id"
                  label="fp_type"
                  placeholder="Select Product Type"
                  :options="product_type_array"
                  :searchable="true"
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
                  track-by="it_id"
                  label="insurance_type_name"
                  placeholder="Select Insurance Tyoe"
                  :options="insurance_type_array"
                  :searchable="true"
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
  GetAllCompanyType,
  GetAllVehicleType,
  GetAllFPType,
  GetAllInsuranceType,
  GetAllFuelType,
  GetAllBank,
  GetAllCustomer,
  GetAllAgent,
  GetAllPayment,
  addEditInsurancePolicy,
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
        rid: "rid",
        company: "company",
        reg_no: "reg_no",
        reg_name: "reg_name",
        policy_no: "policy_no",
        bank_name: "bank_name",
        agent_name: "agent_name",
        agent_no: "agent_no",
        policy_date: "policy_date",
        fuel_type: "fuel_type",
        code_id: "",
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
        company: "",
        reg_no: "",
        reg_name: "",
        policy_no: "",
        bank_name: "",
        agent_name: "",
        agent_no: "",
        policy_date: "",

        fuel_type: "",
        code_id: "",
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
      payment_mode_array: [],
      vehicle_type_array: [],
      product_type_array: [],
      insurance_type_array: [],
      fuel_type_array: [],
      company_array: [],
      gst: 1.18,
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
    }
    this.getAllCompany();
    this.getAllAgent();
    this.getAllVehicle();
    this.getAllFuel();
    this.getAllProduct();
    this.getAllPayment();
    this.getAllInsuranceType();
    this.getAllBank();
    this.getAllCustomer();
  },

  methods: {
    calculateGST() {
      let net_premium = +parseFloat(this.form.premium / this.gst).toFixed(2);
      this.form.net_premium = net_premium;
      this.form.gst = +parseFloat(this.form.premium - net_premium).toFixed(2);
    },
    showModal(type) {
      let typeName = type == this.keyname.agent_name ? "Agent" : "Vehicle";
      this.$bvModal
        .msgBoxConfirm(
          `Please confirm that you want to create new ${typeName}?`,
          {
            title: "Please Confirm",
            size: "sm",
            buttonSize: "sm",
            okVariant: "danger",
            okTitle: "YES",
            cancelTitle: "NO",
            footerClass: "p-2",
            hideHeaderClose: false,
            centered: true,
          }
        )
        .then((value) => {
          if (value) {
            console.log({ type });
            if (type == this.keyname.agent_name) {
              this.createNewAgent();
            } else if (type == this.keyname.reg_no) {
              this.createNewVehicle();
            }
          }
        })
        .catch((err) => {
          // An error occurred
        });
    },
    createNewAgent() {
      this.$router.push({
        path: "/add-agent-users",
      });
    },
    createNewVehicle() {
      this.$router.push({
        path: "/add-customer",
      });
    },
    changeAgent(item) {
      if (item && item.agent_name == "Self") {
        this.form.agent_no = "";
      } else if (item && item.agent_mobile_number) {
        this.form.agent_no = item.agent_mobile_number;
      } else {
        this.form.agent_no = "";
      }
    },
    changeVehicle(item) {
      if (item && item.cust_name) {
        this.form.reg_name = item.cust_name || "";
      } else {
        this.form.reg_name = "";
      }
    },
    changeCompany(item) {
      this.form.code_id = "";
    },
    async getAllCustomer() {
      try {
        this.registration_array = [];
        const response = await GetAllCustomer({
          insurance_id: this.insurance_id,
        });
        const { data } = response;
        if (data.status) {
          this.registration_array = data.Records || [];
        }
        this.isBusy = false;
      } catch (err) {}
    },
    async getAllBank() {
      try {
        this.bank_array = [];
        const response = await GetAllBank({
          insurance_id: this.insurance_id,
        });
        const { data } = response;
        if (data.status) {
          this.bank_array = data.Records || [];
        }
        this.isBusy = false;
      } catch (err) {}
    },
    async getAllInsuranceType() {
      try {
        this.insurance_type_array = [];
        const response = await GetAllInsuranceType({
          insurance_id: this.insurance_id,
        });
        const { data } = response;
        if (data.status) {
          this.insurance_type_array = data.Records || [];
        }
        this.isBusy = false;
      } catch (err) {}
    },
    async getAllPayment() {
      try {
        this.payment_mode_array = [];
        const response = await GetAllPayment({
          insurance_id: this.insurance_id,
        });
        const { data } = response;
        if (data.status) {
          this.payment_mode_array = data.Records || [];
        }
        this.isBusy = false;
      } catch (err) {}
    },
    async getAllProduct() {
      try {
        this.product_type_array = [];
        const response = await GetAllFPType({
          insurance_id: this.insurance_id,
        });
        const { data } = response;
        if (data.status) {
          this.product_type_array = data.Records || [];
        }
        this.isBusy = false;
      } catch (err) {}
    },
    async getAllFuel() {
      try {
        this.fuel_type_array = [];
        const response = await GetAllFuelType({
          insurance_id: this.insurance_id,
        });
        const { data } = response;
        if (data.status) {
          this.fuel_type_array = data.Records || [];
        }
        this.isBusy = false;
      } catch (err) {}
    },
    async getAllVehicle() {
      try {
        this.vehicle_type_array = [];
        const response = await GetAllVehicleType({
          insurance_id: this.insurance_id,
        });
        const { data } = response;
        if (data.status) {
          this.vehicle_type_array = data.Records || [];
        }
        this.isBusy = false;
      } catch (err) {}
    },
    async getAllAgent() {
      try {
        this.agent_array = [];
        const response = await GetAllAgent({
          insurance_id: this.insurance_id,
        });
        const { data } = response;
        if (data.status) {
          this.agent_array = data.Records || [];
        }
        this.isBusy = false;
      } catch (err) {}
    },
    async getAllCompany() {
      try {
        this.company_array = [];
        const response = await GetAllCompanyType({
          insurance_id: this.insurance_id,
        });
        const { data } = response;
        if (data.status) {
          this.company_array = data.Records || [];
        }
        this.isBusy = false;
      } catch (err) {}
    },
    onReset() {
      Object.keys(this.form).map((z) => {
        this.form[z] = "";
      });
    },
    saveForm() {
      this.$refs.loginValidation.validate().then(async (success) => {
        if (success) {
          let payload = {
            ...this.form,
            premium: this.form.premium || 0,
            gst: this.form.gst || 0,
            net_premium: this.form.net_premium || 0,
            idv: this.form.idv || 0,

            ct_id:
              this.form.company && this.form.company.ct_id
                ? this.form.company.ct_id
                : 0,
            cust_id:
              this.form.reg_no && this.form.reg_no.cust_id
                ? this.form.reg_no.cust_id
                : 0,
            bd_id:
              this.form.bank_name && this.form.bank_name.bd_id
                ? this.form.bank_name.bd_id
                : 0,
            agent_id:
              this.form.agent_name && this.form.agent_name.agent_id
                ? this.form.agent_name.agent_id
                : 0,
            code_id:
              this.form.code_id && this.form.code_id.agent_id
                ? this.form.code_id.agent_id
                : 0,
            fuel_id:
              this.form.fuel_type && this.form.fuel_type.fuel_id
                ? this.form.fuel_type.fuel_id
                : 0,
            pm_id:
              this.form.payment_mode && this.form.payment_mode.pm_id
                ? this.form.payment_mode.pm_id
                : 0,
            vehicle_id:
              this.form.vehicle_type && this.form.vehicle_type.vehicle_id
                ? this.form.vehicle_type.vehicle_id
                : 0,
            fp_id:
              this.form.product_type && this.form.product_type.fp_id
                ? this.form.product_type.fp_id
                : 0,
            it_id:
              this.form.insurance_type && this.form.insurance_type.it_id
                ? this.form.insurance_type.it_id
                : 0,
          };
          try {
            const response = await addEditInsurancePolicy({
              ...payload,
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
