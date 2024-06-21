<template>
  <div>
    <hr />
    <b-row class="mt-1">
      <b-col sm="5">
        <b-input-group>
          <b-form-input
            placeholder="Search Payment"
            v-model="search"
          ></b-form-input>
          <b-input-group-append>
            <b-button @click="onSearchUser">Search</b-button>
          </b-input-group-append>
        </b-input-group>
      </b-col>

      <b-col sm="7" class="text-right pr-4">
        <b-button variant="outline-primary" @click="addUser">
          <b-icon icon="plus-circle" aria-hidden="true"></b-icon> Add Payment
        </b-button>
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
        <b-icon
          icon="pencil-square"
          aria-hidden="true"
          @click="onEdit(data.item)"
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
import { GetAllPayment } from "@/apiServices/DashboardServices";

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
      fields: [
        {
          key: "pm_name",
          formatter: (value, key, item) => {
            return value ? value : "-";
          },
          label: "Payment Mode",
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
    rowClass(item, type) {
      if (!item || type !== "row") return;
      if (item.user_type === "admin") return "table-success";
    },
    onChangePagination($event) {
      this.currentPage = $event;
      this.onGetAllUsers();
    },

    async onEdit({ pm_id }) {
      this.$router.push({
        path: "/update-payment/" + pm_id,
      });
    },
    addUser() {
      this.$router.push({
        path: "/add-payment",
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
        const response = await GetAllPayment({
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
