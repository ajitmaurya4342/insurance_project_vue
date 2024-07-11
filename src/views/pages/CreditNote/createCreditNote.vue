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
            v-if="item.show"
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
                  v-if="item.type !== 'select'"
                  :id="item.key"
                  v-model="form[item.key]"
                  :state="errors.length > 0 ? false : null"
                  :name="item.key"
                  :placeholder="item.placeholder"
                  :type="item.type"
                />
              <multiselect :id="item.key" :name="item.key" 
               v-else
                  v-model="form[item.key]" :track-by="item.trackBy" :label="item.labelSelect" :placeholder="item.placeholder"
                  :options="item.option" :searchable="false" @input="selectChange($event,item)" />

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
            >{{ type_id ? "Update" : "Add" }} Credit Note
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
  GetAllCompanyType,
  GetAllAgent,
  GetAllPayment,
  addEditCreditNote,
 
} from "@/apiServices/DashboardServices";
import { ValidationProvider, ValidationObserver } from "vee-validate";
import { required } from "@validations";
import ToastificationContent from "@core/components/toastification/ToastificationContent.vue";
import Multiselect from "vue-multiselect";
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
      type_id: "",
      form: {
        type: "",
        amount: "",
        payment_date: "",
        pm_id:"",
        agent_id:"",
        company_id:""
      },
      required,
      layoutArray: [
         {
          col: 6,
          label: "Type",
          rules: {
            required: true,
          },
          key: "type",
          placeholder: "Select Type",
          type: "select",
          labelSelect:"name",
          trackBy:"value",
          option:[
           {
            name:"Company",
            value:"add_credit_note_company"
           },
           {
            name:"Agent",
            value:"add_credit_note_agent"
           }
          ],
          show:true
        },
        {
          col: 6,
          label: "Payment Date",
          rules: {
            required: true,
          },
          key: "payment_date",
          placeholder: "Select Payment Date",
          type: "date",
          show:true
        },
        {
          col: 6,
          label: "Amount",
          rules: {},
          key: "amount",
          placeholder: "Enter Amount",
          type: "number",
          show:true
        },
        {
          col: 6,
          label: "Payment To",
          rules: {
          },
          key: "pm_id",
          placeholder: "Select Payment Account",
          type: "select",
          labelSelect:"pm_name",
          trackBy:"pm_id",
          option:[
          ],
          show:true
        },
        {
          col: 6,
          label: "Agent",
          rules: {
            required:true
          },
          key: "agent_id",
          placeholder: "Select Agent",
          type: "select",
          labelSelect:"agent_name",
          trackBy:"agent_id",
          option:[
          ],
          show:false
        },
        {
          col: 6,
          label: "Company",
          rules: {
            required:true
          },
          key: "company_id",
          placeholder: "Select Company",
          type: "select",
          labelSelect:"company_type_name",
          trackBy:"ct_id",
          option:[
          ],
          show:false
        },
        
      ],

    };
  },

  directives: {
    Ripple,
  },

  beforeMount() {
    const { type_id } = this.$route.params;
    this.type_id = type_id || null;
    this.getCompanyList();
    this.getAgentList();
    this.getPaymentMode()
    if (type_id) {
      this.onGetAllUsers();
    }
  },

  methods: {
    selectChange(event,{key}){
      if(key=="type"){
        let findCompany=this.layoutArray.findIndex((_la)=>{
          return _la.key==="company_id"
        })
        let findAgent=this.layoutArray.findIndex((_la)=>{
          return _la.key==="agent_id"
        })
       if(event.value=="add_credit_note_company") {
        this.layoutArray[findCompany]["show"]=true
        this.layoutArray[findAgent]["show"]=false;
        this.form["agent_id"]=null
       }else{
        this.layoutArray[findCompany]["show"]=false
        this.layoutArray[findAgent]["show"]=true
        this.form["company_id"]=null
       }
      }

    },
    onReset() {
      Object.keys(this.form).map((z) => {
        this.form[z] = "";
      });
    },
    saveForm() {
      this.$refs.loginValidation.validate().then(async (success) => {
        if (success) {
          try {
            const response = await addEditCreditNote({
              ...this.form,
              agent_id: this.form.agent_id &&  this.form.agent_id.agent_id?this.form.agent_id.agent_id:0,
              pm_id: this.form.pm_id &&  this.form.pm_id.pm_id?this.form.pm_id.pm_id:0,
              company_id: this.form.company_id &&  this.form.company_id.ct_id?this.form.company_id.ct_id:0,
              type: this.form.type &&  this.form.type.value?this.form.type.value:"",
              type_id: this.type_id || "",
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
        const response = await GetAllCompanyType({
          type_id: this.type_id,
          type:""
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

    async getCompanyList() {
      try {
        this.allUserList = [];
        this.isBusy = true;
        const response = await GetAllCompanyType();
        const { data } = response;
        if (data.status) {
        let findCompany=this.layoutArray.findIndex((_la)=>{
            return _la.key==="company_id"
          });
        this.layoutArray[findCompany]["option"]=data.Records
        
        }
        this.isBusy = false;
      } catch (err) {}
    },
    async getAgentList() {
      try {
        this.allUserList = [];
        this.isBusy = true;
        const response = await GetAllAgent();
        const { data } = response;
        if (data.status) {
        let findAgent=this.layoutArray.findIndex((_la)=>{
            return _la.key==="agent_id"
          });
        this.layoutArray[findAgent]["option"]=data.Records
        
        }
        this.isBusy = false;
      } catch (err) {}
    },
    async getPaymentMode() {
      try {
        this.allUserList = [];
        this.isBusy = true;
        const response = await GetAllPayment();
        const { data } = response;
        if (data.status) {
        let findPay=this.layoutArray.findIndex((_la)=>{
            return _la.key==="pm_id"
          });
        this.layoutArray[findPay]["option"]=data.Records
        
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
