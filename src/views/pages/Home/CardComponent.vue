<template>
  <div class="card card--front" @click="onEdit">
    <div class="row display-flex mb-1 alignmentClass">
      <img src="@/assets/images/pages/medicallogo.png" style="height: 40px" />
      <h6 class="fontFamily font-size2">
        Medical Information & Scan QR More Detail
      </h6>
    </div>
    <div class="row">
      <div class="col-4 qr_code p-0">
        <qrcode-vue
          :size="qrSize"
          level="H"
          :value="qrValue + unique_id"
          style="padding: 5px"
        >
        </qrcode-vue>
      </div>
      <div class="col-7 crddetails">
        <div class="d-flex alignmentClass mb-5px">
          <h6 class="fontFamily">Name:</h6>
          <h6 class="fontFamily" style="color: #fff">
            <div
              class="ml-1"
              style="
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;
                width: 130px;
                text-align: right;
              "
            >
              {{ getname("Full Name") }}
            </div>
          </h6>
        </div>
        <div class="d-flex alignmentClass mb-5px">
          <h6 class="fontFamily">Blood:</h6>
          <h6 class="fontFamily ml-1" style="color: #fff">
            {{ getname("Blood Group") }}
          </h6>
        </div>
        <div class="d-flex alignmentClass mb-5px">
          <h6 class="fontFamily">Height:</h6>
          <h6 class="fontFamily ml-1" style="color: #fff">
            {{ getname("Height") }}
          </h6>
        </div>
        <div class="d-flex alignmentClass mb-5px">
          <h6 class="fontFamily">Weight:</h6>
          <h6 class="fontFamily ml-1" style="color: #fff">
            {{ getname("Weight") }}
          </h6>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import QrcodeVue from "qrcode.vue";

export default {
  props: {
    data: Object,
    unique_id: String,
  },
  components: {
    QrcodeVue,
  },
  data() {
    return {
      BASE_URL: process.env.VUE_APP_BASEURL,
      qrSize: 90,
      qrValue: null,
    };
  },
  mounted() {
    this.qrValue = window.location.origin + "/afterscan?qrId=";
  },
  methods: {
    getname(type) {
      console.log(this.data);
      let checkData = this.data.filter((z) => z.label == type);
      console.log(checkData);
      return checkData.length ? checkData[0].vModelValue || "-" : "-";
    },

    async onEdit() {
      this.$router.push({
        name: "qrdetails",
        query: { qrId: this.unique_id },
      });
    },
  },
};
</script>

<style scoped>
.alignmentClass {
  justify-content: space-between;
  /* justify-content: center; */
  align-items: center;
}
.mb-5px {
  margin-bottom: 5px;
}
.fontFamily {
  font-family: math;
  font-weight: 500;
  line-height: 1.2;
  color: #cfd4da;
}
.font-size2 {
  font-size: 13px;
}
.qr_code {
  background: #fff;
  /* padding: 10px; */
  height: 100px;
}
.crddetails {
  border-left: 1px solid #fff;
  padding: 0px 10px;
  color: #fff;
  margin-left: 20px;
  /* background: #bc9393; */
}
.scan {
  font-size: 12px;
  padding-top: 2px;
  width: 45%;
  text-align: center;
}
.card:hover {
  transform: scale(1.1);
  z-index: 99999;
  transition: 0.2s;
  background: black;
}
.card {
  font: 16px/1.5 "Helvetica Neue", Helvetica, sans-serif;
  position: relative;
  display: inline-block;
  vertical-align: middle;
  width: 346px;
  height: 180px;
  text-align: left;
  padding: 12px 30px;
  margin-bottom: 50px;
  color: #fff;
  border-radius: 20px;
  box-sizing: border-box;
  background: url("../../../assets/images/pages/backgroundImage.jpg") no-repeat
    0 0 #141819;
  cursor: pointer;
  margin: 5px;
}
.card__number {
  font-size: 26px;
  padding: 27px 0 20px;
  text-align: center;
}
.card__expiry-date {
  font-size: 14px;
  padding-bottom: 20px;
  text-align: center;
}
.card__owner {
  text-align: left;
}
.card__logo {
  position: absolute;
  right: 20px;
  bottom: 20px;
}
.card__strip {
  background: #000;
  height: 50px;
  margin-bottom: 30px;
}
.card__signature {
  float: left;
  width: 65%;
  height: 40px;
  margin-left: 10px;
  background: #999;
}

.card--front {
  font-size: 16px;
  font-family: "OCRA";
  text-shadow: 0 1px 1px rgba(0, 0, 0, 0.6);
}

.panel {
  width: 600px;
  margin: 0 auto;
  margin-bottom: 50px;
  text-align: center;
}
</style>
