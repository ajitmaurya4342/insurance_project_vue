<template>
  <div>
    <hr />
    <b-row class="mt-1">

      <b-col sm="12" class="text-right pr-4">
        <b-button variant="outline-primary" @click="addUser">
          <b-icon icon="plus-circle" aria-hidden="true"></b-icon> Add Credit/Debit
          Type
        </b-button>
      </b-col>
      <b-col sm="12" class="text-right pr-4 mt-1">
        <u>
          <div class="d-flex align-items-center cursor-pointer " style="justify-content:flex-end"
            @click="excelDownload">
            <b-icon icon="file-earmark-excel-fill" aria-hidden="true" font-scale="1.5" style="color: green"></b-icon>
            <div style="margin-left: 2px; color: green">Download Agent Credit</div>
          </div>
        </u>
      </b-col>


      <b-col sm="12" class="text-right mt-1 pr-4">
        <u>
          <div class="d-flex align-items-center cursor-pointer" style="justify-content:flex-end"
            @click="excelDownloadCompany">
            <b-icon icon="file-earmark-excel-fill" aria-hidden="true" font-scale="1.5" style="color: green"></b-icon>
            <div style="margin-left: 2px; color: green">Download Company Credit</div>
          </div>
        </u>
      </b-col>
      <b-col sm="12" class="text-right mt-1 pr-4">
        <u>
          <div class="d-flex align-items-center cursor-pointer" style="justify-content:flex-end"
            @click="excelDownloadCompany('other')">
            <b-icon icon="file-earmark-excel-fill" aria-hidden="true" font-scale="1.5" style="color: green"></b-icon>
            <div style="margin-left: 2px; color: green">Download Other Credit</div>
          </div>
        </u>
      </b-col>
      <b-col sm="4">
        <b-input-group>
          <b-form-input placeholder="Search Credit Note" v-model="search"></b-form-input>
          <b-input-group-append>
            <b-button @click="onSearchCredit">Search</b-button>
          </b-input-group-append>
        </b-input-group>
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
      <template #cell(edit)="data">
        <b-row v-if="!data.item.policy_no">
          <b-icon icon="pencil-square" aria-hidden="true" font-scale="1.2" class="cursor-pointer"
            v-if="data.item.parent_c_ref_id<=0"
            @click="onEdit(data.item)"></b-icon> 
          <DeleteComponent :type="data.item.type" :id="data.item.type_id" class="ml-1" :getData="onGetCreditNote" v-if="data.item.parent_c_ref_id==data.item.type_id || data.item.parent_c_ref_id<=0 ">
          </DeleteComponent>
        </b-row>
      </template>
    </b-table>

    <b-row class="mt-2">
      <b-col sm="4"> </b-col>
      <b-col sm="6" class="text-center">
        <b-pagination v-model="currentPage" :total-rows="totalRows" :per-page="perPage"
          @change="onChangePagination($event)" size="lg"></b-pagination>
      </b-col>
    </b-row>
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
import moment from "moment"
import Ripple from "vue-ripple-directive";
import { GetCreditNoteList } from "@/apiServices/DashboardServices";
import DeleteComponent from "../DeleteComponent.vue";

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
      allUserList: [],
      fields: [
        {
          key: "name",
          formatter: (value, key, item) => {
            return value ? `${value} (${item.type_name})` : "-";
          },
          label: "Payment By",
        },
        {
          key: "amount",
          formatter: (value, key, item) => {
            return value ? Number(value) : "-";
          },
          label: "Amount",
        },
        {
          key: "payment_date",
          formatter: (value, key, item) => {
            return value ? moment(value).format("DD MMM, YYYY") : "-";

          },
          label: "Payment Date",
        },
        {
          key: "pm_name",
          formatter: (value, key, item) => {
            return value ? value : "-";
          },
          label: "Payment To",
        },
        {
          key: "description",
          formatter: (value, key, item) => {
            return value ? value : "-";
          },
          label: "Remarks",
        },
        {
          key: "edit",
        },
      ],
      isBusy: false,
      currentPage: 1,
      perPage: 15,
      totalRows: 0,
      search: "",
    };
  },

  directives: {
    Ripple,
  },

  beforeMount() {
    this.onGetCreditNote();
  },

  methods: {
    onSearchCredit() {
      this.currentPage = 1;
      this.onGetCreditNote()
    },
    excelDownload() {
      this.$bvModal
        .msgBoxConfirm(`Are you sure you want to download agent credit note excel?`, {
          title: "Please Confirm",
          size: "sm",
          buttonSize: "sm",
          okVariant: "danger",
          okTitle: "YES",
          cancelTitle: "NO",
          footerClass: "p-2",
          hideHeaderClose: false,
          centered: true,
        })
        .then(async (value) => {
          if (value) {
            let url = process.env.VUE_APP_BASEURL + "/createAgentCreditExcel.php";
            window.open(url, "_blank");
          }
        });
    },
    excelDownloadCompany(type) {
      this.$bvModal
        .msgBoxConfirm(`Are you sure you want to download company credit note excel?`, {
          title: "Please Confirm",
          size: "sm",
          buttonSize: "sm",
          okVariant: "danger",
          okTitle: "YES",
          cancelTitle: "NO",
          footerClass: "p-2",
          hideHeaderClose: false,
          centered: true,
        })
        .then(async (value) => {
          if (value) {
            let url = process.env.VUE_APP_BASEURL + "/createCompanyCreditExcel.php";
            if (type) {
              url += `?type=${type}`
            }
            window.open(url, "_blank");
          }
        });

    },
    rowClass(item, type) {
      if (!item || type !== "row") return;
      if (item.policy_no) return "table-danger";
      if (item.type === "add_credit_note_company") return "table-success";

    },
    onChangePagination($event) {
      this.currentPage = $event;
      this.onGetCreditNote();
    },

    async onEdit({ type, type_id }) {
      console.log(type, type_id)
      this.$router.push({
        path: `/update-credit-note/${type}/${type_id}`,
      });
    },
    addUser() {
      this.$router.push({
        path: "/add-credit-note",
      });
    },
    onSearchUser() {
      this.currentPage = 1;
      this.onGetCreditNote();
    },
    async onGetCreditNote() {
      try {
        this.allUserList = [];
        this.isBusy = true;
        const response = await GetCreditNoteList({
          search: this.search,
          limit: this.perPage,
          currentPage: this.currentPage,
        });
        const { data } = response;
        if (data.status) {
          this.allUserList = data.Records.map((z) => {
            z["parent_c_ref_id"] = z["parent_c_ref_id"] && +parseFloat(z["parent_c_ref_id"]) > 0 ? +parseFloat(z.parent_c_ref_id) : 0
            return z
          });
          if (this.currentPage == 1) {
            this.totalRows = data.total_rows;
          }
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
