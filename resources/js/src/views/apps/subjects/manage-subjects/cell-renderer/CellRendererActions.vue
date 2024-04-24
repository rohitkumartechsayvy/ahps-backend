<template>
  <div
    :style="{ direction: $vs.rtl ? 'rtl' : 'ltr' }"
    v-if="this.$route.params.classId"
  >
    <feather-icon
      icon="Edit3Icon"
      svgClasses="h-5 w-5 mr-4 hover:text-primary cursor-pointer"
      @click="editMarks"
    />
  </div>
  <div :style="{ direction: $vs.rtl ? 'rtl' : 'ltr' }" v-else>
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
      this.$router.push(`/subject-edit/` + this.params.data.id).catch(() => {});
    },
    editMarks() {
      this.$router
        .push(
          `/subject-marks/${this.$route.params.classId}/${this.params.data.id}`
        )
        .catch(() => {});
    },
    confirmDeleteRecord() {
      this.$vs.dialog({
        type: "confirm",
        color: "danger",
        title: "Confirm Delete",
        text: `Are you sure you want to delete "${this.params.data.subject_name}"?`,
        accept: this.deleteRecord,
        acceptText: "Delete",
      });
    },
    deleteRecord() {
      /* Below two lines are just for demo purpose */
      // this.showDeleteSuccess();

      /* UnComment below lines for enabling true flow if deleting user */
      this.$store
        .dispatch("subjectManagement/removeRecord", this.params.data.id)
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
