<template>
  <vs-chip class="ag-grid-cell-chip">
    <router-link
      :to="url"
      @click.stop.prevent
      class="text-inherit hover:text-primary"
      >View TimeTable</router-link
    >
  </vs-chip>
</template>

<script>
export default {
  name: "CellRendererTimeTable",
  computed: {
    url() {
      return "/teacher-timetable/" + this.params.data.user_id;
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
