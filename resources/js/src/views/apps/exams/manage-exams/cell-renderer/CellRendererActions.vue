<template>
  <div
    :style="{ direction: $vs.rtl ? 'rtl' : 'ltr' }"
    v-if="
      this.$store.state.AppActiveUser.user_type == 'super_admin' ||
      this.$store.state.AppActiveUser.user_type == 'subadmin'
    "
  >
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
  <div
    :style="{ direction: $vs.rtl ? 'rtl' : 'ltr' }"
    v-else-if="this.$store.state.AppActiveUser.user_type == 'student'"
  >
    <feather-icon
      icon="Edit3Icon"
      svgClasses="h-5 w-5 mr-4 hover:text-primary cursor-pointer"
      @click="getStudentRecord"
    />
  </div>
  <div :style="{ direction: $vs.rtl ? 'rtl' : 'ltr' }" v-else>
    <feather-icon
      icon="EyeIcon"
      svgClasses="h-5 w-5 mr-4 hover:text-primary cursor-pointer"
      @click="viewRecord"
    />
  </div>
</template>

<script>
export default {
  name: "CellRendererActions",
  methods: {
    editRecord() {
      this.$router.push(`/exam-edit/` + this.params.data.id).catch(() => {});
    },
    getStudentRecord() {
      this.$router
        .push(
          `/download-report-card/${this.params.data.id}/${this.$store.state.AppActiveUser.id}`
        )
        .catch(() => {});
    },
    viewRecord() {
      this.$router.push(`/exam-detail/` + this.params.data.id).catch(() => {});
    },
    confirmDeleteRecord() {
      this.$vs.dialog({
        type: "confirm",
        color: "danger",
        title: "Confirm Delete",
        text: `Are you sure you want to delete "${this.params.data.from}" - "${this.params.data.to}"?`,
        accept: this.deleteRecord,
        acceptText: "Delete",
      });
    },
    deleteRecord() {
      /* Below two lines are just for demo purpose */
      // this.showDeleteSuccess();

      /* UnComment below lines for enabling true flow if deleting user */
      this.$store
        .dispatch("examManagement/removeRecord", this.params.data.id)
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
        title: "Subject Deleted",
        text: "The selected subject was successfully deleted",
      });
    },
  },
};
</script>
