<template>
  <div>
    <div>
      <hr />
      <b-row class="mt-2" v-if="layoutArray.length">
        <b-col sm="3" v-for="(item, index) in layoutArray" :key="index">
          <b-card
            @click="redirectList(item)"
            class="cursor-pointer"
            :header="item.heading"
            header-text-variant="white"
            header-tag="header"
            header-bg-variant="primary"
            style="max-width: 20rem"
          >
            <b-card-text class="p-2">
              <b-row class="justify-content-center display-flex mt-1">
                <feather-icon :icon="item.icon" size="30" />
                <h2 class="pl-1">{{ item.title }}</h2>
              </b-row>
            </b-card-text>
          </b-card>
        </b-col>
      </b-row>
      <!-- <button @click="createExcel">Create Excel</button> -->
    </div>

    <hr class="m-2" />
  </div>
</template>

<script>
import {
  BCard,
  BRow,
  BCol,
  BCardText,
  BButton,
  BCardFooter,
  BCardImg,
  BCardBody,
  BCardTitle,
  BCardSubTitle,
  BListGroup,
  BListGroupItem,
  BFormInput,
  BImg,
  BNav,
  BNavItem,
  BNavForm,
} from "bootstrap-vue";
import Ripple from "vue-ripple-directive";
import { GetDashboard } from "@/apiServices/DashboardServices";

import { UserService } from "@/apiServices/storageService";


import QrcodeVue from "qrcode.vue";
import * as XLSX from "xlsx";

export default {
  components: {
    BCard,
    BRow,
    BCol,
    BCardText,
    BButton,
    BCardFooter,
    BCardImg,
    BCardBody,
    BCardTitle,
    BCardSubTitle,
    BListGroup,
    BListGroupItem,
    BImg,
    QrcodeVue,
    BFormInput,
    BNav,
    BNavItem,
    BNavForm,
  },
  data() {
    return {
      layoutArray: [
        {
    title: "Vehicle/Customer",
    route: "customerList",
    icon: "TruckIcon",
  },
  {
    title: "Company ",
    route: "companyTypeList",
    icon: "LayoutIcon",
  },
  {
    title: "Company Id",
    route: "bankList",
    icon: "DollarSignIcon",
  },
  {
    title: "Payment Mode",
    route: "paymentList",
    icon: "KeyIcon",
  },
  {
    title: "Vehicle Type",
    route: "vehicleTypeList",
    icon: "HardDriveIcon",
  },

  {
    title: "Product Type",
    route: "fpTypeList",
    icon: "SquareIcon",
  },
  {
    title: "Insurance Type",
    route: "insuranceTypeList",
    icon: "CreditCardIcon",
  },
  {
    title: "Fuel Type",
    route: "fuelTypeList",
    icon: "FilterIcon",
  },
  {
    title: "User",
    route: "users",
    icon: "UserIcon",
    isOnlyVisibleToAdmin: true,
  },
  {
    title: "Setting",
    route: "addSetting",
    icon: "SettingsIcon",
    isOnlyVisibleToAdmin: true,
  },

      ],
    };
  },

  directives: {
    Ripple,
  },

  beforeMount() {
    this.getDashboardData();
 
  },

  methods: {
    // createExcel() {
    //   const data = [
    //     ["Name", "Age", "Gender"],
    //     ["John", 25, "Male"],
    //     ["Jane", 30, "Female"],
    //   ];

    //   // Convert the data to a worksheet
    //   const worksheet = XLSX.utils.aoa_to_sheet(data);

    //   // Create a workbook
    //   const workbook = XLSX.utils.book_new();

    //   // Add the worksheet to the workbook
    //   XLSX.utils.book_append_sheet(workbook, worksheet, "Sheet1");

    //   // Generate the XLSX file
    //   const xlsx = XLSX.write(workbook, { type: "binary", bookType: "xlsx" });

    //   // Create a link to download the file
    //   const link = document.createElement("a");
    //   link.href = URL.createObjectURL(
    //     new Blob([xlsx], { type: "application/octet-stream" })
    //   );
    //   console.log({ link });
    //   link.download = "data.xlsx";

    //   // Click the link to download the file
    //   link.click();
    //   // var wb = XLSX.utils.book_new();
    //   // wb.Props = {
    //   //   Title: "SheetJS Tutorial",
    //   //   Subject: "Test",
    //   //   Author: "Red Stapler",
    //   //   CreatedDate: new Date(2017, 12, 19),
    //   // };

    //   // wb.SheetNames.push("Test Sheet");
    //   // var ws_data = [["hello", "world"]];
    //   // var ws = XLSX.utils.aoa_to_sheet(ws_data);
    //   // wb.Sheets["Test Sheet"] = ws;

    //   // // var wbout = XLSX.write(wb, { bookType: "xlsx", type: "binary" });
    //   // XLSX.writeFile(wb, "test.xlsx");

    //   // saveAs("test.xlsx");
    //   // console.log({ wbout });
    // },
    async getDashboardData() {
      let userDetail = JSON.parse(UserService.getUserProfile());
      this.layoutArray=this.layoutArray.filter((z)=>{
        let check=z.isOnlyVisibleToAdmin? userDetail.user_type=='admin':true;
        return check
      })
     
    },
    redirectList(item) {
      this.$router.push({
        name:  item.route,
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
