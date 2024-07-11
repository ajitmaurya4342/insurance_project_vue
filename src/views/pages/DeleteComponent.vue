<template>
  <b-icon
    icon="trash"
    aria-hidden="true"
    class="cursor-pointer"
    :font-scale="type == 'insurance_policy' ? 1.5 : 1.2"
    v-if="type && id && isAdmin"
    @click="deleteData"
  ></b-icon>
</template>

<script>
import ToastificationContent from "@core/components/toastification/ToastificationContent.vue";
import { DeleteData } from "@/apiServices/DashboardServices";
import { UserService } from "@/apiServices/storageService";

export default {
  props: {
    type: "",
    id: "",
    getData: {
      type: Function,
    },
  },
  data() {
    return {
      data: [
        {
          page: "user",
          table_name: "users",
          key: "user_id",
        },
        {
          page: "fuel",
          table_name: "ms_fuel_type",
          key: "fuel_id",
        },
        {
          page: "insurance_type",
          table_name: "ms_insurance_type",
          key: "it_id",
        },
        {
          page: "product_type",
          table_name: "ms_fp_tp_type",
          key: "fp_id",
        },
        {
          page: "vehicle_type",
          table_name: "ms_vehicle",
          key: "vehicle_id",
        },
        {
          page: "payment",
          table_name: "ms_payment_mode",
          key: "pm_id",
        },
        {
          page: "bank",
          table_name: "ms_bank_department",
          key: "bd_id",
        },
        {
          page: "company",
          table_name: "ms_company_type",
          key: "ct_id",
        },
        {
          page: "customer",
          table_name: "ms_customer",
          key: "cust_id",
        },
        {
          page: "agent",
          table_name: "ms_agent",
          key: "agent_id",
        },
        {
          page: "insurance_policy",
          table_name: "ms_insurance_policy",
          key: "insurance_id",
        },
        {
          page: "add_credit_note_agent",
          table_name: "add_credit_note_agent",
          key: "a_ref_id",
        },
        {
          page: "add_credit_note_company",
          table_name: "add_credit_note_company",
          key: "c_ref_id",
        },
      ],
    };
  },

  computed:{
    isAdmin() {
      let userDetail = JSON.parse(UserService.getUserProfile());
      return userDetail.user_type=='admin';
    },
  },

  beforeMount() {},

  methods: {
    deleteData() {
      let filterData = this.data.filter((z) => {
        return z.page == this.type;
      });

      if (filterData.length) {
        this.$bvModal
          .msgBoxConfirm(`Are you sure you want to delete?`, {
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
              try {
                const response = await DeleteData({
                  ...filterData[0],
                  id: this.id,
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
                  this.getData();
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
          })
          .catch((err) => {
            // An error occurred
          });
      }
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
