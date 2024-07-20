<template>
  <div>
    <hr />
    <div v-if="hideData">
        <b-tabs  v-model="tabIndex"  @input="tabChange" >
          <b-tab title="Insurance List" >
          </b-tab>
          <b-tab title="Agent Insurance">
          
          </b-tab>
          <b-tab title="Company Insurance" >
          </b-tab>
        </b-tabs>
      </div>
    <b-row class="mt-1" v-if="hideData">
      <b-col sm="4" class="mt-1" v-if="tabIndex==2">
        <b-form-group label="Company">
          <multiselect v-model="company" track-by="ct_id" label="company_type_name" placeholder="Select Company"
            :options="company_array" @input="onGetAllUsers"  />
        </b-form-group>
      </b-col>
      <b-col sm="4" class="mt-1" v-if="tabIndex==1">
        <b-form-group label="Agent">
          <multiselect v-model="agent" track-by="agent_id" label="agent_name" placeholder="Select Agent"
            :options="agent_array.filter((z)=>z.agent_id>1)" @input="onGetAllUsers" />
        </b-form-group>
      </b-col>
      <b-col sm="3" class="mt-1">
        <b-form-group label="From Date">
          <b-form-input v-model="from_date" type="date" placeholder="Select RID" @input="changeToDate"
          :max="maxDate"></b-form-input>
        </b-form-group>
      </b-col>
      <b-col sm="3" class="mt-1">
        <b-form-group label="To Date">
          <b-form-input v-model="to_date" type="date" placeholder="Select RID" :disabled="!from_date" :min="from_date"
            @input="onGetAllUsers" :max="maxDate" ></b-form-input>
        </b-form-group>
      </b-col>

    
      <b-col sm="2" class="mt-1 pt-3 cursor-pointer" @click="reset">
        <u>
          <h5>Reset All Option</h5>
        </u>
      </b-col>

    </b-row>
    <b-row>
      
      <b-col sm="4">
        <b-input-group>
          <b-form-input placeholder="Search Insurance" v-model="search"></b-form-input>
          <b-input-group-append>
            <b-button @click="onSearchUser">Search</b-button>
          </b-input-group-append>
        </b-input-group>
      </b-col>

      <b-col sm="6" class="text-right" v-if="hideData">
        <b-button variant="outline-primary" @click="addUser">
          <b-icon icon="plus-circle" aria-hidden="true"></b-icon>
          Add Insurance</b-button>
      </b-col>
      <b-col sm="2" class="text-right mt-2" v-if="allUserList.length && tabIndex==0">
        <u v-if="hideData">
          <div class="d-flex align-items-center cursor-pointer" @click="excelDownload">
            <b-icon icon="file-earmark-excel-fill" aria-hidden="true" font-scale="1.5" style="color: green"></b-icon>
            <div style="margin-left: 2px; color: green">Download Excel</div>
          </div>
        </u>
      </b-col>
      <b-col sm="2" class="text-right mt-2" v-else-if="tabIndex===1 && this.agent && this.agent.agent_id && this.from_date && allUserList.length">
        <u>
          <div class="d-flex align-items-center cursor-pointer" @click="excelDownload">
            <b-icon icon="file-earmark-excel-fill" aria-hidden="true" font-scale="1.5" style="color: green"></b-icon>
            <div style="margin-left: 2px; color: green">Download Agent Excel</div>
          </div>
        </u>
      </b-col>
      <b-col sm="2" class="text-right mt-2" v-else-if="tabIndex===2 && this.company && this.company.ct_id && this.from_date  && allUserList.length">
        <u>
          <div class="d-flex align-items-center cursor-pointer" @click="excelDownload">
            <b-icon icon="file-earmark-excel-fill" aria-hidden="true" font-scale="1.5" style="color: green"></b-icon>
            <div style="margin-left: 2px; color: green">Download Company Excel</div>
          </div>
        </u>
      </b-col>
      
    </b-row>

    <b-table responsive :items="allUserList" :busy="isBusy" :fields="fields" class="mt-1" outlined show-empty
      :tbody-tr-class="rowClass">
      <template #empty="scope">
        <h4 class="text-center">No Records Found</h4>
      </template>
      <template #table-busy>
        <div class="text-center text-danger my-2">
          <b-spinner class="align-middle"></b-spinner>
          <strong>Loading...</strong>
        </div>
      </template>
      <template #cell(amount)="data">
        <b-row v-for="(item2, index) in Object.keys(keyNameAmount)" :key="index">
          <h6>
            {{ keyNameAmount[item2] }}
            <h5>{{ data.item[item2] || "-" }}</h5>
          </h6>

          <!-- <b-col sm="1">
            <h5>:</h5>
          </b-col>
          -->
        </b-row>
      </template>
      <template #cell(salesAmount2)="data">
        <b-row v-for="(item2, index) in Object.keys(salesAmount)" :key="index"  v-if="(item2=='code_rate' && data.item.seller_type!='Self') || (item2=='company_rate' && data.item.seller_type=='Self') || !['code_rate','company_rate'].includes(item2)" >
          <b-form-group :label="salesAmount[item2]" :label-for="item2">
               <b-form-input :id="item2" :name="item2" 
                 style="width:50%"
                 :disabled="item2=='profit_rate'"
                 @input="calculateProfit(data.item)"
                  v-model="data.item[item2]" type="text" :placeholder="'Enter' +salesAmount[item2] "></b-form-input>
            </b-form-group>

          <!-- <b-col sm="1">
            <h5>:</h5>
          </b-col>
          -->
        </b-row>
      </template>
      <template #cell(edit)="data">
        <b-icon icon="pencil-square" aria-hidden="true" class="cursor-pointer" @click="onEdit(data.item)"
          font-scale="1.5" v-if="hideData"></b-icon>

        <b-icon icon="info-square" aria-hidden="true" class="ml-1 cursor-pointer" @click="onView(data.item)"
          font-scale="1.5"></b-icon>
          <b-button @click="onSaveData(data.item)" class="ml-2">Save Data</b-button>
        <DeleteComponent type="insurance_policy" :id="data.item.insurance_id" class="ml-1" :getData="onGetAllUsers" v-if="hideData">
        </DeleteComponent>
      </template>
    </b-table>

    <b-row class="mt-2">
      <b-col sm="4"> </b-col>
      <b-col sm="6" class="text-center">
        <b-pagination v-model="currentPage" :total-rows="totalRows" :per-page="perPage"
          @change="onChangePagination($event)" size="lg"></b-pagination>
      </b-col>
    </b-row>

    <div>
      <b-modal id="bv-modal-example" hide-footer>
        <template #modal-title>
          <b>Policy No</b> : {{ selectedRow && selectedRow.policy_no }}
        </template>
        <div class="d-block text-center" v-if="selectedRow && selectedRow">
          <b-row style="border-bottom: 1px solid #b8c0d4" class="mb-1" v-for="(item, index) in Object.keys(keyName)"
            :key="index">
            <b-col sm="4">
              <b>
                <h5>{{ keyName[item] }}</h5>
              </b>
            </b-col>
            <b-col sm="1">
              <h5>:</h5>
            </b-col>
            <b-col sm="7">
              <h5>{{ selectedRow[item] || "-" }}</h5>
            </b-col>
            <hr />
          </b-row>
        </div>
      </b-modal>
    </div>
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
} from "bootstrap-vue";
import Ripple from "vue-ripple-directive";
import {
  addEditInsurancePolicy,
  GetAllAgent,
  GetAllCompanyType,
  GetInsurancePolicyList,
} from "@/apiServices/DashboardServices";
import moment from "moment";
import DeleteComponent from "../DeleteComponent.vue";
import ToastificationContent from "@/@core/components/toastification/ToastificationContent.vue";
import { data } from "jquery";

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
    DeleteComponent,
  },
  data() {
    return {
      maxDate:"",
      allUserList: [],
      company_array: [],
      agent_array: [],
      from_date: "",
      to_date: "",
      company: "",
      agent:"",
      tabIndex:0,
      keyNameAmount: {
        premium: "Premium:",
        gst: "GST:",
        net_premium: "Net:",
      },
      salesAmount:{
        purchase_rate: "P Points",
        company_rate: "Company Points",
        code_rate: "Third Party Company Points",
        agent_rate: "Agent Points",
        profit_rate: "Pr Points",
      },
      inputTypeArray:["purchase_rate","company_rate","agent_rate","code_rate","profit_rate"],
      keyName: {
        rid: "RID",
        company_type_name: "Company Name",
        vehicle_no: "Registration No",
        reg_name: "Customer Name",
        policy_no: "Policy No",
        bank_dept_name: "Company ID",
        agent_name: "Agent Name",
        agent_no: "Agent Number",
        policy_date: "Policy Date",
        fuel_type_name: "Fuel Type",
        code_agent: "CODE ID",
        premium: "Premium",
        gst: "GST",
        net_premium: "Net Premium",
        idv: "IDV",
        gvw: "GVW",
        pm_name: "Payment Mode",
        vehicle_type: "Vehicle Type",
        fp_type: "Product Type",
        insurance_type_name: "Insurance Type",

        purchase_rate: "P Points",
        company_rate: "Company Points",
        agent_rate: "Agent Points",
        code_rate: "Third Party Company Points",
        profit_rate: "Pr Points",

        created_user: "Created User",
        created_date_time: "Created Time",
      },
      fields: [
        // {
        //   key: "rid",
        //   formatter: (value, key, item) => {
        //     return value ? moment(value).format("DD MMM, YYYY") : "-";
        //   },
        //   label: "RID",
        // },
        {
          key: "company_type_name",
          formatter: (value, key, item) => {
            return value ? value : "-";
          },
          label: "Company Name",
        },
        {
          key: "vehicle_no",
          formatter: (value, key, item) => {

            return value ? value : "-";
          },
          label: "Reg. No",
        },
        // {
        //   key: "reg_name",
        //   formatter: (value, key, item) => {
        //     return value ? value : "-";
        //   },
        //   label: "Customer Name",
        // },
        {
          key: "policy_no",
          formatter: (value, key, item) => {
            return value ? value : "-";
          },
          label: "Policy No",
        },
        // {
        //   key: "policy_date",
        //   formatter: (value, key, item) => {
        //     return value ? moment(value).format("DD MMM, YYYY") : "-";
        //   },
        //   label: "Policy Date",
        // },
        {
          key: "agent_name",
          formatter: (value, key, item) => {
            return value
              ? value + `${item.agent_no ? ` (${item.agent_no})` : ""}`
              : "-";
          },
          label: "Agent Name & contact",
        },
        {
          key: "amount",

          label: "Amount",
        },
        {
          key: "salesAmount2",

          label: "Sales",
        },
        {
          key: "edit",
          label: "Action",
        },
      ],
      isBusy: false,
      currentPage: 1,
      perPage: 15,
      totalRows: 0,
      search: "",
      selectedRow: null,
      hideData:false

    };
  },

  directives: {
    Ripple,
  },

  beforeMount() {
    this.maxDate=moment().format("YYYY-MM-DD")
    // this.to_date=moment().format("YYYY-MM-DD")
    this.onGetAllUsers();
    this.getCompanyList();
    this.getAgentList()
  },

  methods: {
    calculateProfit(data) {
      let profit=0;
      if(data.premium && data.purchase_rate && data.agent_rate){
        if(data.agent_rate>0){
          profit=+parseFloat(data.agent_rate-data.purchase_rate).toFixed(2);
        }else{
          profit=+parseFloat(data.premium -data.purchase_rate -  Math.abs(data.agent_rate)  ).toFixed(2)
        }
      }
      data.profit_rate=profit;
    },
    async onSaveData(data2){
         const response = await addEditInsurancePolicy({
              ...data2,
                purchase_rate: data2.purchase_rate || 0,
                company_rate: data2.company_rate || 0,
                agent_rate: data2.agent_rate || 0,
                profit_rate: data2.profit_rate || 0,
                code_rate: data2.code_rate || 0,
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
    
    },
    tabChange(){
      if(this.tabIndex>0){
        this.allUserList=[];
      }else{
        this.onGetAllUsers()
      }
      this.company=""
      this.agent=""

    },
    excelDownload() {
      let urlPage="/createInsurancePolicy.php?"
      if(this.tabIndex==1){
        urlPage="/createAgentInsurancePolicyExcel.php?"
      }else   if(this.tabIndex==2) {
        urlPage="/createCompanyInsurancePolicyExcel.php?"
      }
      let url = process.env.VUE_APP_BASEURL + urlPage;
      let obj = {
        ct_id: this.company && this.company.ct_id ? this.company.ct_id : "",
        agent_id: this.agent && this.agent.agent_id ? this.agent.agent_id : "",
        from_date: this.from_date,
        to_date: this.to_date ? this.to_date : moment().format("YYYY-MM-DD"),
        search: this.search,
      };
      let appendUrl = "";
      Object.keys(obj).map((z) => {
        if (obj[z]) {
          appendUrl += z + "=" + obj[z] + "&";
        }
      });
      window.open(url + appendUrl, "_blank");
    },
    reset() {
      this.company = "";
      this.from_date = "";
      this.to_date = "";
      this.search = "";
      this.onGetAllUsers();
    },
    changeToDate() {
      if (!this.to_date || moment(this.from_date).isAfter(this.to_date)) {
        this.to_date = moment().format("YYYY-MM-DD");
      }
      this.onGetAllUsers();
    },
    onView(item) {
      this.selectedRow = item;

      this.$bvModal.show("bv-modal-example");
    },
    rowClass(item, type) {
      if (!item || type !== "row") return;
      // if (item.seller_type !== "Self") return "table-success";
    },
    onChangePagination($event) {
      this.currentPage = $event;
      this.onGetAllUsers();
    },

    async onEdit({ insurance_id }) {
      this.$router.push({
        path: "/update-insurance/" + insurance_id,
      });
    },
    addUser() {
      this.$router.push({
        path: "/add-insurance",
      });
    },
    onSearchUser() {
      this.currentPage = 1;
      this.onGetAllUsers();
    },
    async onGetAllUsers() {

      if((this.tabIndex==1 || this.tabIndex==2) && !this.from_date){
        this.$toast({
                component: ToastificationContent,
                props: {
                  title:  "Please select from date",
                  icon: "EditIcon",
                  variant: "failure",
                },
              });
        return  false
      }

      if((this.tabIndex==1 || this.tabIndex==2) && !this.to_date){
        this.$toast({
                component: ToastificationContent,
                props: {
                  title:  "Please select from date",
                  icon: "EditIcon",
                  variant: "failure",
                },
              });
        return  false
      }

      if(this.tabIndex==1 && !this.agent){
        this.$toast({
                component: ToastificationContent,
                props: {
                  title:  "Please select agent",
                  icon: "EditIcon",
                  variant: "failure",
                },
              });
        return  false
      }

      if(this.tabIndex==2 && !this.company){
        this.$toast({
                component: ToastificationContent,
                props: {
                  title:  "Please select company",
                  icon: "EditIcon",
                  variant: "failure",
                },
              });
        return  false
      }
      try {
        this.allUserList = [];
        this.isBusy = true;
        const response = await GetInsurancePolicyList({
          search: this.search,
          limit: this.perPage,
          onlyZeroValue:true,
          currentPage: this.currentPage,
          ct_id: this.company && this.company.ct_id ? this.company.ct_id : "",
          agent_id: this.agent && this.agent.agent_id ? this.agent.agent_id : "",
          from_date: this.from_date ? this.from_date : "",
          to_date: this.to_date ? this.to_date : "",
        });
        const { data } = response;
        if (data.status) {
          this.allUserList = data.Records;
          if (this.currentPage == 1) {
            this.totalRows = data.total_rows;
          }
        }
        this.isBusy = false;
      } catch (err) { }
    },
    async getCompanyList() {
      try {
        this.allUserList = [];
        this.isBusy = true;
        const response = await GetAllCompanyType({
        });
        const { data } = response;
        if (data.status) {
          this.company_array = data.Records;
        }
        this.isBusy = false;
      } catch (err) { }
    },
    async getAgentList() {
      try {
        this.allUserList = [];
        this.isBusy = true;
        const response = await GetAllAgent({
        });
        const { data } = response;
        if (data.status) {
          this.agent_array = data.Records;
        }
        this.isBusy = false;
      } catch (err) { }
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
