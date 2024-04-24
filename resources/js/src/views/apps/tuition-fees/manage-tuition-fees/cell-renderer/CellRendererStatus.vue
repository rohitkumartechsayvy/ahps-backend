<template>
  <!-- <vs-chip class="ag-grid-cell-chip" :color="chipColor(params.value)">
    <span>{{ params.value }}</span>
  </vs-chip> -->
  <div class="">
    <p>
      Lorem<span v-if="readMore"></span>
      <span v-else>...</span>
    </p>

    <p v-show="readMore">
      Ligula ullamcorper malesuada proin libero nunc consequat interdum varius.
      Turpis egestas pretium aenean pharetra magna ac placerat. Sed egestas
      egestas fringilla phasellus faucibus scelerisque eleifend donec. Sed cras
      ornare arcu dui. Aliquam vestibulum morbi blandit cursus. Adipiscing elit
      ut aliquam purus sit amet. Aenean sed adipiscing diam donec adipiscing
      tristique risus nec. Ut etiam sit amet nisl purus in mollis. Eu mi
      bibendum neque egestas congue quisque egestas diam in. Pellentesque
      adipiscing commodo elit at imperdiet dui accumsan sit.
    </p>
    <button class="btn btn-success" @click="readMore = !readMore">
      <span v-if="readMore">Read Less</span>
      <span v-else>Read More</span>
    </button>
  </div>
</template>

<script>
export default {
  name: "CellRendererStatus",
  data() {
    return {
      readMore: false,
    };
  },
  computed: {
    chipColor() {
      return (value) => {
        if (value === "active") return "success";
        else if (value === "blocked") return "danger";
        else if (value === "deactivated") return "warning";
        else return "primary";
      };
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
