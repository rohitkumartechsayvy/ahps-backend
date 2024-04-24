<template>
  <div class="flex items-center">
    <vs-chip
      class="ag-grid-cell-chip mt-5"
      :color="'success'"
      v-if="this.params.data.fee_status == 'paid'"
    >
      <span class="text-capitalize">{{
        this.params.data.voucher_detail.payment_mode
      }}</span>
    </vs-chip>
    <vs-button @click="payNow" id="rzp-button1" class="text-white" v-else
      >Pay</vs-button
    >
  </div>
</template>

<script>
import store from "./../../../../../store/store";
export default {
  name: "CellRendererPay",
  computed: {
    textColor() {
      console.log("transactions", this.params.data.total_fee);
    },
  },
  data() {
    return {
      activePromptAddEvent: false,
      voucher_data: [],
    };
  },
  methods: {
    payNow() {
      console.log("this.voucher_data", this.voucher_data);
      let vou_data = this.voucher_data;
      let newThis = this;
      var options = {
        key: "rzp_live_sqUn77hYRrDzwX",
        amount: this.params.data.total_fee * 100,
        name: this.$store.state.AppActiveUser.name,
        description: `Fee Payment By ${this.$store.state.AppActiveUser.name}`,
        image: `${this.$store.state.AppActiveUser.profile_picture}`,
        handler: function (response) {
          let obj = {
            voucher_id: vou_data.id,
            payment_id: response.razorpay_payment_id,
          };
          // res = store.dispatch("feeVoucherManagement/savePayment", obj);
          // newThis.showPaymentSuccess();
          newThis.$store
            .dispatch("feeVoucherManagement/savePayment", obj)
            .then((res) => {
              if (
                res &&
                res.data.message.errors &&
                res.data.message.errors.length > 0
              ) {
                newThis.showPaymentError();
              } else {
                newThis.showPaymentSuccess();
              }
            })
            .catch((err) => {
              console.error(err);
            });
        },
        prefill: {
          name: this.$store.state.AppActiveUser.name,
          email: this.$store.state.AppActiveUser.email,
        },
        notes: {
          address: "Hello World",
        },
        theme: {
          color: "#3b6ba8",
        },
      };
      var rzp1 = new Razorpay(options);
      rzp1.open();
    },
    showPaymentSuccess() {
      this.$vs.loading.close();
      this.$vs.notify({
        color: "success",
        title: "Payment Done!",
        text: "Payment Done Successfully!",
      });
      store
        .dispatch(
          "feeVoucherManagement/fetchStudentVouchers",
          this.$route.params.studentId
        )
        .catch((err) => {
          console.error(err);
        });
    },
    showPaymentError() {
      this.$vs.loading.close();
      this.$vs.notify({
        title: "Error",
        text: "Something Went Wrong While Making Payment!",
        iconPack: "feather",
        icon: "icon-alert-circle",
        color: "danger",
      });
    },
  },
  created() {
    this.voucher_data = this.params.data;
  },
};
</script>
