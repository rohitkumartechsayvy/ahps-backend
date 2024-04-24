<template>
  <vx-card no-shadow>
    <form>
      <!-- Img Row -->
      <div class="flex flex-wrap items-center mb-base">
        <vs-avatar :src="this.profile_picture" size="70px" class="mr-4 mb-4" />
        <div>
          <input
            type="file"
            name="profile_picture"
            class="form-control"
            v-on:change="onImageChange"
          />
          <p class="text-sm mt-2">Allowed JPG, GIF or PNG. Max size of 800kB</p>
        </div>
      </div>
      <!-- Info -->
      <vs-input
        class="w-full mb-base"
        label-placeholder="Name"
        v-model="this.name"
      ></vs-input>
      <vs-input
        disabled
        class="w-full"
        label-placeholder="Email"
        v-model="this.email"
      ></vs-input>
      <!-- Save & Reset Button -->
      <div class="flex flex-wrap items-center justify-end">
        <vs-button class="ml-auto mt-2" @click="save_changes">
          Save Changes
        </vs-button>
      </div>
    </form>
  </vx-card>
</template>

<script>
export default {
  data() {
    return {
      name: this.$store.state.AppActiveUser.name,
      email: this.$store.state.AppActiveUser.email,
      profile_picture: this.$store.state.AppActiveUser.profile_picture,
      user_id: this.$store.state.AppActiveUser.id,
    };
  },
  computed: {
    activeUserInfo() {
      return this.$store.state.AppActiveUser;
    },
  },
  methods: {
    save_changes() {
      // if (!this.validateForm) return;
      console.log("enter", this.user_id);
      const formData = new FormData();
      formData.append("myFile", this.image, this.image.name);
      formData.append("name", this.name);
      this.$store
        .dispatch("userManagement/saveUser2", formData)
        .then((res) => {
          console.log('console.log("form");', res);
          if (res && res.data.statusCode == 200) {
            this.$vs.notify({
              color: "success",
              title: "Image created",
              text: "Profile Updated successfully!",
            });
          }
        })
        .catch((err) => {
          console.error(err);
        });
    },
    onImageChange(e) {
      this.image = e.target.files[0];
      this.profile_picture = URL.createObjectURL(this.image);
      console.log("this.profile_picture", this.profile_picture);
    },
  },
};
</script>
