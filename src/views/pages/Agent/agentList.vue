<template>
  <div>
    <hr />
    <b-row class="mt-1">
      <b-col sm="5">
        <b-input-group>
          <b-form-input
            placeholder="Search Agent"
            v-model="search"
          ></b-form-input>
          <b-input-group-append>
            <b-button @click="onSearchUser">Search</b-button>
          </b-input-group-append>
        </b-input-group>
      </b-col>

      <b-col sm="7" class="text-right pr-4">
        <b-button variant="outline-primary" @click="addUser">
          <b-icon icon="plus-circle" aria-hidden="true"></b-icon> Add Agent
        </b-button>
      </b-col>

      <b-col sm="12" class="text-right mt-1 pr-4">
        <u>
          <div class="d-flex align-items-center cursor-pointer" style="justify-content:flex-end"
            @click="excelDownloadAgent">
            <b-icon icon="file-earmark-excel-fill" aria-hidden="true" font-scale="1.5" style="color: green"></b-icon>
            <div style="margin-left: 2px; color: green">Download Agent List</div>
          </div>
        </u>
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
      <template #cell(edit)="data">
        <b-row>
          <b-icon
            icon="pencil-square"
            aria-hidden="true"
            font-scale="1.2"
            class="cursor-pointer"
            @click="onEdit(data.item)"
          ></b-icon>
          <!-- <DeleteComponent
            v-if="data.item.agent_id > 1"
            type="agent"
            :id="data.item.agent_id"
            class="ml-1"
            :getData="onGetAllUsers"
          ></DeleteComponent> -->
        </b-row>
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
import { GetAllAgent } from "@/apiServices/DashboardServices";
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
          key: "agent_name",
          formatter: (value, key, item) => {
            return value ? value : "-";
          },
        },
        {
          key: "agent_mobile_number",
          formatter: (value, key, item) => {
            return value ? value : "-";
          },
        },
        {
          key: "agent_address",
          formatter: (value, key, item) => {
            return value ? value : "-";
          },
        },
        {
          key: "balance_amount",
          formatter: (value, key, item) => {
            return value ? Number(value) : "-";
          },
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
    this.onGetAllUsers();
  },

  methods: {
    excelDownloadAgent() {
      this.$bvModal
        .msgBoxConfirm(`Are you sure you want to download agent excel?`, {
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
            let url = process.env.VUE_APP_BASEURL + "/createAgentExcel.php";
            window.open(url, "_blank");
          }
        });

    },
     
    rowClass(item, type) {
      if (!item || type !== "row") return;
      if (item.user_type === "admin") return "table-success";
    },
    onChangePagination($event) {
      this.currentPage = $event;
      this.onGetAllUsers();
    },

    async onEdit({ agent_id }) {
      this.$router.push({
        path: "/update-agent-users/" + agent_id,
      });
    },
    addUser() {
      this.$router.push({
        path: "/add-agent-users",
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
        const response = await GetAllAgent({
          search: this.search,
          limit: this.perPage,
          currentPage: this.currentPage,
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
