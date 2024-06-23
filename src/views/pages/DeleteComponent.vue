<template>
  <b-icon
    icon="trash"
    aria-hidden="true"
    class="cursor-pointer"
    font-scale="1.2"
    v-if="type && id"
    @click="deleteData"
  ></b-icon>
</template>

<script>
import ToastificationContent from "@core/components/toastification/ToastificationContent.vue";
import { DeleteData } from "@/apiServices/DashboardServices";

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
      ],
    };
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
