<template>
  <div>
    <hr />
    <b-row class="mt-1">
      <b-col sm="5">
        <b-input-group>
          <b-form-input placeholder="Search User"></b-form-input>
          <b-input-group-append>
            <b-button>Search</b-button>
          </b-input-group-append>
        </b-input-group>
      </b-col>

      <b-col sm="7" class="text-right pr-4">
        <b-button variant="outline-primary">
          <b-icon icon="plus-circle" aria-hidden="true"></b-icon> Add User
        </b-button>
      </b-col>
    </b-row>

    <b-table
      responsive
      :items="items"
      :busy="isBusy"
      :fields="fields"
      class="mt-1"
      outlined
      show-empty
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
    </b-table>

    <b-row class="mt-2">
      <b-col sm="4"> </b-col>
      <b-col sm="6" class="text-center">
        <b-pagination
          v-model="currentPage"
          :total-rows="rows"
          :per-page="perPage"
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
import { GetAllUsers } from "@/apiServices/DashboardServices";

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
      items: [],
      fields: [
        {
          key: "last_name",
        },
        {
          key: "first_name",
        },
        {
          key: "age",
          label: "Person age",
        },
      ],
      isBusy: false,
      currentPage: 1,
      perPage: 10,
      rows: 5000,
    };
  },

  directives: {
    Ripple,
  },

  beforeMount() {
    this.onGetAllUsers();
  },

  methods: {
    toggleBusy() {
      this.isBusy = !this.isBusy;
    },
    showLoadMoreData() {
      this.currentPage = this.currentPage + 1;
      this.onGetAllUsers();
    },
    async onEdit(unique_code_generate) {
      this.$router.push({
        name: "createqr",
        query: { qrId: unique_code_generate },
      });
    },
    onSearchUser() {
      this.currentPage = 1;
      this.allUserList = [];
      this.onGetAllUsers();
    },
    async onGetAllUsers() {
      try {
        const response = await GetAllUsers({
          search: this.searchUser,
          limit: this.limit,
          currentPage: this.currentPage,
        });
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
