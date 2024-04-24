<template>
  <vs-button
    class="ml-auto mt-2"
    :color="'danger'"
    @click="markPaid"
    v-if="ActiveUser.user_type == 'accountant' && params.value === 'pending'"
    >Mark Paid Via Cash</vs-button
  >
  <vs-chip class="ag-grid-cell-chip" :color="chipColor(params.value)" v-else>
    <span>{{ params.value }}</span>
  </vs-chip>
</template>
<script>
import store from "./../../../../../store/store";
export default {
  name: "CellRendererStatus",
  // props: {
  //   transactions: {
  //     required: true,
  //     type: Array,
  //   },
  // },
  computed: {
    chipColor() {
      return (value) => {
        if (value === "paid") return "success";
        else if (value === "pending") return "danger";
      };
    },
    ActiveUser() {
      return store.state.AppActiveUser;
    },
  },
  methods: {
    showPaymentSuccess() {
      this.$vs.loading.close();
      this.$vs.notify({
        color: "success",
        title: "Payment Updated!",
        text: "Payment Updated Successfully!",
      });
      this.$store
        .dispatch("feeVoucherManagement/fetchFeeVouchers")
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
    markPaid() {
      let obj = {
        voucher_id: this.params.data.id,
        accountant_id: store.state.AppActiveUser.id,
      };
      store
        .dispatch("feeVoucherManagement/cashPayment", obj)
        .then((res) => {
          if (
            res &&
            res.data.message.errors &&
            res.data.message.errors.length > 0
          ) {
            this.showPaymentError();
          } else {
            this.showPaymentSuccess();
          }
        })
        .catch((err) => {
          console.error(err);
        });
    },
  },
};
</script>

<style lang="scss" scpoped>
.ag-grid-cell-chip {
  &.vs-chip-success {
    background: rgba(var(--vs-success), 0.15);
    color: rgba(var(--vs-success), 1) !important;
    font-weight: 500;
  }
  &.vs-chip-warning {
    background: rgba(var(--vs-warning), 0.15);
    color: rgba(var(--vs-warning), 1) !important;
    font-weight: 500;
  }
  &.vs-chip-danger {
    background: rgba(var(--vs-danger), 0.15);
    color: rgba(var(--vs-danger), 1) !important;
    font-weight: 500;
  }
}
</style>
