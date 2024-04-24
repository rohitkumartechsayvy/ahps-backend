<template>
  <div :style="{ direction: $vs.rtl ? 'rtl' : 'ltr' }">
    <feather-icon
      icon="Edit3Icon"
      svgClasses="h-5 w-5 mr-4 hover:text-primary cursor-pointer"
      @click="editRecord"
    />
    <feather-icon
      icon="Trash2Icon"
      svgClasses="h-5 w-5 hover:text-danger cursor-pointer"
      @click="confirmDeleteRecord"
    />
  </div>
</template>

<script>
export default {
  name: "CellRendererActions",
  methods: {
    editRecord() {
      this.$router
        .push(`/accountant-edit/` + this.params.data.user_id)
        .catch(() => {});
    },
    confirmDeleteRecord() {
      this.$vs.dialog({
        type: "confirm",
        color: "danger",
        title: "Confirm Delete",
        text: `Are you sure you want to delete "${this.params.data.name}"?`,
        accept: this.deleteRecord,
        acceptText: "Delete",
      });
    },
    deleteRecord() {
      /* Below two lines are just for demo purpose */
      // this.showDeleteSuccess();

      /* UnComment below lines for enabling true flow if deleting user */
      this.$store
        .dispatch("accountantManagement/removeRecord", this.params.data.user_id)
        .then(() => {
          this.showDeleteSuccess();
        })
        .catch((err) => {
          console.error(err);
        });
    },
    showDeleteSuccess() {
      this.$vs.notify({
        color: "success",
        title: "Accountant Deleted",
        text: "The selected accountant was successfully deleted",
      });
    },
  },
};
</script>
