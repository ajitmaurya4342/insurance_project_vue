<template>
  <div>
    <hr />
    <b-row class="mt-1">
      <b-col sm="4" class="mt-1">
        <b-form-group label="Company">
          <multiselect
            v-model="company"
            track-by="ct_id"
            label="company_type_name"
            placeholder="Select Company"
            :options="company_array"
            @input="onGetAllUsers"
          />
        </b-form-group>
      </b-col>
      <b-col sm="3" class="mt-1">
        <b-form-group label="From Date">
          <b-form-input
            v-model="from_date"
            type="date"
            placeholder="Select RID"
            @input="changeToDate"
          ></b-form-input>
        </b-form-group>
      </b-col>
      <b-col sm="3" class="mt-1">
        <b-form-group label="To Date">
          <b-form-input
            v-model="to_date"
            type="date"
            placeholder="Select RID"
            :disabled="!from_date"
            :min="from_date"
            @input="onGetAllUsers"
          ></b-form-input>
        </b-form-group>
      </b-col>
      <b-col sm="2" class="mt-1 pt-3 cursor-pointer" @click="reset">
        <u><h5>Reset All Option</h5></u>
      </b-col>

      <b-col sm="4">
        <b-input-group>
          <b-form-input
            placeholder="Search Insurance"
            v-model="search"
          ></b-form-input>
          <b-input-group-append>
            <b-button @click="onSearchUser">Search</b-button>
          </b-input-group-append>
        </b-input-group>
      </b-col>

      <b-col sm="8" class="text-right pr-4">
        <b-button variant="outline-primary" @click="addUser">
          <b-icon icon="plus-circle" aria-hidden="true"></b-icon> Add
          Insurance</b-button
        >
      </b-col>
    </b-row>

    <b-table
      responsive
      :items="allUserList"
      :busy="isBusy"
      :fields="fields"
      class="mt-1"
      outlined
      show-empty
      :tbody-tr-class="rowClass"
    >
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
        <b-row
          v-for="(item2, index) in Object.keys(keyNameAmount)"
          :key="index"
        >
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
      <template #cell(edit)="data">
        <b-icon
          icon="pencil-square"
          aria-hidden="true"
          @click="onEdit(data.item)"
          font-scale="1.5"
        ></b-icon>

        <b-icon
          icon="info-square"
          aria-hidden="true"
          class="ml-1"
          @click="onView(data.item)"
          font-scale="1.5"
        ></b-icon>
      </template>
    </b-table>

    <b-row class="mt-2">
      <b-col sm="4"> </b-col>
      <b-col sm="6" class="text-center">
        <b-pagination
          v-model="currentPage"
          :total-rows="totalRows"
          :per-page="perPage"
          @change="onChangePagination($event)"
          size="lg"
        ></b-pagination>
      </b-col>
    </b-row>

    <div>
      <b-modal id="bv-modal-example" hide-footer>
        <template #modal-title>
          <b>Policy No</b> : {{ selectedRow && selectedRow.policy_no }}
        </template>
        <div class="d-block text-center" v-if="selectedRow && selectedRow">
          <b-row
            style="border-bottom: 1px solid #b8c0d4"
            class="mb-1"
            v-for="(item, index) in Object.keys(keyName)"
            :key="index"
          >
            <b-col sm="4">
              <b
                ><h5>{{ keyName[item] }}</h5></b
              >
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
  GetAllCompanyType,
  GetInsurancePolicyList,
} from "@/apiServices/DashboardServices";
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
  },
  data() {
    return {
      allUserList: [],
      company_array: [],
      from_date: "",
      to_date: "",
      company: "",
      keyNameAmount: {
        premium: "Premium:",
        gst: "GST:",
        net_premium: "Net:",
      },
      keyName: {
        rid: "RID",
        company_type_name: "Company Name",
        vehicle_no: "Registration No",
        reg_name: "Customer Name",
        // policy_no: "Policy No",
        bank_dept_name: "Bank Name",
        agent_name: "Agent Name",
        agent_no: "Agent Number",
        policy_date: "Policy Date",
        fuel_type_name: "Fuel Type",
        code_agent: "CODE ID",
        premium: "Premium",
        gst: "GST",
        net_premium: "Net Premium",
        idv: "IDV",
        pm_name: "Payment Mode",
        vehicle_type: "Vehicle Type",
        fp_type: "Product Type",
        insurance_type_name: "Insurance Type",
        created_user: "Created User",
        created_date_time: "Created Time",
      },
      fields: [
        {
          key: "rid",
          formatter: (value, key, item) => {
            return value ? moment(value).format("DD MMM, YYYY") : "-";
          },
          label: "RID",
        },
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
        {
          key: "reg_name",
          formatter: (value, key, item) => {
            return value ? value : "-";
          },
          label: "Customer Name",
        },
        {
          key: "policy_no",
          formatter: (value, key, item) => {
            return value ? value : "-";
          },
          label: "Policy No",
        },
        {
          key: "policy_date",
          formatter: (value, key, item) => {
            return value ? moment(value).format("DD MMM, YYYY") : "-";
          },
          label: "Policy Date",
        },
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
    };
  },

  directives: {
    Ripple,
  },

  beforeMount() {
    this.onGetAllUsers();
    this.getCompanyList();
  },

  methods: {
    reset() {
      this.company = "";
      this.from_date = "";
      this.to_date = "";
      this.search = "";
      this.onGetAllUsers();
    },
    changeToDate() {
      if (!this.to_date || moment(this.from_date).isAfter(this.to_date)) {
        this.to_date = this.from_date;
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
      try {
        this.allUserList = [];
        this.isBusy = true;
        const response = await GetInsurancePolicyList({
          search: this.search,
          limit: this.perPage,
          currentPage: this.currentPage,
          ct_id: this.company && this.company.ct_id ? this.company.ct_id : "",
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
      } catch (err) {}
    },
    async getCompanyList() {
      try {
        this.allUserList = [];
        this.isBusy = true;
        const response = await GetAllCompanyType({
          search: this.search,
          limit: this.perPage,
          currentPage: this.currentPage,
        });
        const { data } = response;
        if (data.status) {
          this.company_array = data.Records;
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
