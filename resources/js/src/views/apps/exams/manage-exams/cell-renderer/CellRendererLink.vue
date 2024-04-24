<template>
  <div class="flex items-center">
    <router-link
      v-if="this.$store.state.AppActiveUser.user_type != 'student'"
      :to="url"
      @click.stop.prevent
      class="text-inherit hover:text-primary"
      >{{ params.value }}</router-link
    >
    <template v-else>
      {{ params.value }}
    </template>
  </div>
</template>

<script>
export default {
  name: "CellRendererLink",
  computed: {
    url() {
      return "/exam-detail/" + this.params.data.id;
    },
  },
};
</script>
