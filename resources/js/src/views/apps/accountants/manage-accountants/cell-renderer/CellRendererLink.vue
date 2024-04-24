<template>
  <div class="flex items-center">
    <vs-avatar
      :src="
        params.data.profile_picture
          ? params.data.profile_picture
          : require(`@assets/images/logo/placeholder.jpg`)
      "
      class="flex-shrink-0 mr-2"
      size="30px"
      @click="$router.push(url)"
    />
    <router-link
      :to="url"
      @click.stop.prevent
      class="text-inherit hover:text-primary"
      >{{ params.value }}</router-link
    >
  </div>
</template>

<script>
export default {
  name: "CellRendererLink",
  computed: {
    url() {
      return "/accountant-detail/" + this.params.data.user_id;
    },
  },
};
</script>
