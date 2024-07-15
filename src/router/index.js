import { TokenService } from "@/apiServices/storageService";
import Vue from "vue";
import VueRouter from "vue-router";

Vue.use(VueRouter);

const router = new VueRouter({
  mode: "history",
  base: process.env.BASE_URL,
  scrollBehavior() {
    return { x: 0, y: 0 };
  },
  routes: [
    {
      path: "/",
      name: "login",
      component: () => import("@/views/pages/Authentication/Login.vue"),
      meta: {
        layout: "full",
      },
      auth:false
    },

    {
      path: "/home",
      name: "home",
      component: () => import("@/views/pages/Home/Home.vue"),
      meta: {
        pageTitle: "Dashboard",
      },
      auth:true
    },

    /// Userr Route
    {
      path: "/users",
      name: "users",
      component: () => import("@/views/pages/User/userList.vue"),
      meta: {
        pageTitle: "User List",
      },
      auth:true
    },
    {
      path: "/add-users",
      name: "addUsers",
      component: () => import("@/views/pages/User/createUser.vue"),
      meta: {
        pageTitle: "Add User",
      },
      auth:true
    },
    {
      path: "/update-users/:user_id",
      name: "updateUser",
      component: () => import("@/views/pages/User/createUser.vue"),
      meta: {
        pageTitle: "Update User",
      },
      auth:true
    },

    /// Agent Route
    {
      path: "/agent-user",
      name: "agentUser",
      component: () => import("@/views/pages/Agent/agentList.vue"),
      meta: {
        pageTitle: "Agent List",
      },
      auth:true
    },
    {
      path: "/add-agent-users",
      name: "addAgent",
      component: () => import("@/views/pages/Agent/createAgent.vue"),
      meta: {
        pageTitle: "Add Agent",
      },
      auth:true
    },
    {
      path: "/update-agent-users/:agent_id",
      name: "updateAgent",
      component: () => import("@/views/pages/Agent/createAgent.vue"),
      meta: {
        pageTitle: "Update Agent",
      },
      auth:true
    },

    /// Payment Route
    {
      path: "/payment-list",
      name: "paymentList",
      component: () => import("@/views/pages/Payment/paymentList.vue"),
      meta: {
        pageTitle: "Payment List",
      },
      auth:true
    },
    {
      path: "/add-payment",
      name: "addPayment",
      component: () => import("@/views/pages/Payment/createPayment.vue"),
      meta: {
        pageTitle: "Add Payment",
      },
      auth:true
    },
    {
      path: "/update-payment/:pm_id",
      name: "updatePayment",
      component: () => import("@/views/pages/Payment/createPayment.vue"),
      meta: {
        pageTitle: "Update Payment",
      },
      auth:true
    },

    /// Vehicle Type Route
    {
      path: "/vehicle-type-list",
      name: "vehicleTypeList",
      component: () => import("@/views/pages/VehicleType/vehicleTypeList.vue"),
      meta: {
        pageTitle: "Vehicle Type List",
      },
      auth:true
    },
    {
      path: "/add-vehicle-type",
      name: "addVehicleType",
      component: () =>
        import("@/views/pages/VehicleType/createVehicleType.vue"),
      meta: {
        pageTitle: "Add Vehicle Type",
      },
      auth:true
    },
    {
      path: "/update-vehicle-type/:vehicle_id",
      name: "updateVehicleType",
      component: () =>
        import("@/views/pages/VehicleType/createVehicleType.vue"),
      meta: {
        pageTitle: "Update Vehicle Type",
      },
      auth:true
    },

    /// Company Type Route
    {
      path: "/company-type-list",
      name: "companyTypeList",
      component: () => import("@/views/pages/CompanyType/companyTypeList.vue"),
      meta: {
        pageTitle: "Company  List",
      },
      auth:true
    },
    {
      path: "/add-company-type",
      name: "addCompanyType",
      component: () =>
        import("@/views/pages/CompanyType/createCompanyType.vue"),
      meta: {
        pageTitle: "Add Company Type",
      },
      auth:true
    },
    {
      path: "/update-company-type/:ct_id",
      name: "updateCompanyType",
      component: () =>
        import("@/views/pages/CompanyType/createCompanyType.vue"),
      meta: {
        pageTitle: "Update Company Type",
      },
      auth:true
    },

    /// FP Type Route
    {
      path: "/fp-type-list",
      name: "fpTypeList",
      component: () => import("@/views/pages/FPType/fpTypeList.vue"),
      meta: {
        pageTitle: "Product List",
      },
      auth:true
    },
    {
      path: "/add-fp-type",
      name: "addFpType",
      component: () => import("@/views/pages/FPType/createFpType.vue"),
      meta: {
        pageTitle: "Add Product Type",
      },
      auth:true
    },
    {
      path: "/update-fp-type/:fp_id",
      name: "updateFpType",
      component: () => import("@/views/pages/FPType/createFpType.vue"),
      meta: {
        pageTitle: "Update Product Type",
      },
      auth:true
    },

    /// Insurance Type Route
    {
      path: "/insurance-type-list",
      name: "insuranceTypeList",
      component: () =>
        import("@/views/pages/InsuranceType/insuranceTypeList.vue"),
      meta: {
        pageTitle: "Insurance Type List",
      },
      auth:true
    },
    {
      path: "/add-insurance-type",
      name: "addInsuranceType",
      component: () =>
        import("@/views/pages/InsuranceType/createInsuranceType.vue"),
      meta: {
        pageTitle: "Add Insurance Type",
      },
      auth:true
    },
    {
      path: "/update-insurance-type/:it_id",
      name: "updateInsuranceType",
      component: () =>
        import("@/views/pages/InsuranceType/createInsuranceType.vue"),
      meta: {
        pageTitle: "Update Insurance Type",
      },
      auth:true
    },

    /// Fuel Type Route
    {
      path: "/fuel-type-list",
      name: "fuelTypeList",
      component: () => import("@/views/pages/FuelType/fuelTypeList.vue"),
      meta: {
        pageTitle: "Fuel Type List",
      },
      auth:true
    },
    {
      path: "/add-fuel-type",
      name: "addFuelType",
      component: () => import("@/views/pages/FuelType/createFuelType.vue"),
      meta: {
        pageTitle: "Add Fuel Type",
      },
      auth:true
    },
    {
      path: "/update-fuel-type/:fuel_id",
      name: "updateFuelType",
      component: () => import("@/views/pages/FuelType/createFuelType.vue"),
      meta: {
        pageTitle: "Update Fuel Type",
      },
      auth:true
    },

    /// Bank Dept
    {
      path: "/bank-list",
      name: "bankList",
      component: () => import("@/views/pages/Bank/bankList.vue"),
      meta: {
        pageTitle: "Bank List",
      },
      auth:true
    },
    {
      path: "/add-bank",
      name: "addBankType",
      component: () => import("@/views/pages/Bank/createBank.vue"),
      meta: {
        pageTitle: "Add Bank ",
      },
      auth:true
    },
    {
      path: "/update-bank/:bd_id",
      name: "updateBank",
      component: () => import("@/views/pages/Bank/createBank.vue"),
      meta: {
        pageTitle: "Update Bank ",
      },
      auth:true
    },

    /// Customer Route
    {
      path: "/customer-list",
      name: "customerList",
      component: () => import("@/views/pages/Customer/customerList.vue"),
      meta: {
        pageTitle: "Customer List",
      },
      auth:true
    },
    {
      path: "/add-customer",
      name: "addCustomer",
      component: () => import("@/views/pages/Customer/createCustomer.vue"),
      meta: {
        pageTitle: "Add Customer",
      },
      auth:true
    },
    {
      path: "/update-customer/:cust_id",
      name: "updateCustomer",
      component: () => import("@/views/pages/Customer/createCustomer.vue"),
      meta: {
        pageTitle: "Update Customer ",
      },
      auth:true
    },

     /// Credit Note Route
     {
      path: "/credit-note-list",
      name: "creditNoteList",
      component: () => import("@/views/pages/CreditNote/creditNoteList.vue"),
      meta: {
        pageTitle: "Credit Note List",
      },
      auth:true
    },
    {
      path: "/add-credit-note",
      name: "addCreditNote",
      component: () => import("@/views/pages/CreditNote/createCreditNote.vue"),
      meta: {
        pageTitle: "Add Credit Note",
      },
      auth:true
    },
    {
      path: "/update-credit-note/:type/:type_id",
      name: "updateCreditNote",
      component: () => import("@/views/pages/CreditNote/createCreditNote.vue"),
      meta: {
        pageTitle: "Update Credit Note ",
      },
      auth:true
    },


    /// Customer Route
    {
      path: "/insurance-list",
      name: "insuranceList",
      component: () => import("@/views/pages/Insurance/insuranceList.vue"),
      meta: {
        pageTitle: "Insurance List",
      },
      auth:true
    },
    {
      path: "/add-insurance",
      name: "addInsurance",
      component: () => import("@/views/pages/Insurance/createInsurance.vue"),
      meta: {
        pageTitle: "Add Insurance",
      },
      auth:true
    },
    {
      path: "/update-insurance/:insurance_id",
      name: "updateInsurance",
      component: () => import("@/views/pages/Insurance/createInsurance.vue"),
      meta: {
        pageTitle: "Update Bank ",
      },
      auth:true
    },
    {
      path: "/add-setting",
      name: "addSetting",
      component: () => import("@/views/pages/Setting/createSetting.vue"),
      meta: {
        pageTitle: "Setting",
      },
      auth:true
    },

    {
      path: "/master-list",
      name: "master",
      component: () => import("@/views/pages/Setting/masterList.vue"),
      meta: {
        pageTitle: "Setting",
      },
      auth:true
    },
  ],
});

// ? For splash screen
// Remove afterEach hook if you are not using splash screen
router.afterEach((item) => {
  let auth=item.fullPath=="/"?false:true
  if(auth){
    let checkAccessToken=TokenService.getToken();
    if(!checkAccessToken){
      return router.replace({
        path:"/"
      })
  
   }
  }
  // Remove initial loading
  const appLoading = document.getElementById("loading-bg");
  if (appLoading) {
    appLoading.style.display = "none";
  }

});

export default router;
