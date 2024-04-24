<template>
  <vx-card no-shadow>
    <vs-input
      class="w-full mb-base"
      type="password"
      label-placeholder="Old Password"
      v-model="old_password"
    />
    <!-- <vs-input
      class="w-full mb-base"
      type="password"
      label-placeholder="New Password"
      v-model="new_password"
    />
    <vs-input
      class="w-full mb-base"
      type="password"
      label-placeholder="Confirm Password"
      v-model="confirm_new_password"
    /> -->

    <vs-input
      ref="password"
      type="password"
      data-vv-validate-on="blur"
      v-validate="'required|min:6'"
      name="password"
      label-placeholder="Password"
      placeholder="Password"
      v-model="password"
      class="w-full mt-6"
    />
    <span class="text-danger text-sm">{{ errors.first("password") }}</span>

    <vs-input
      type="password"
      v-validate="'min:6|confirmed:password'"
      data-vv-validate-on="blur"
      data-vv-as="password"
      name="confirm_password"
      label-placeholder="Confirm Password"
      placeholder="Confirm Password"
      v-model="confirm_password"
      class="w-full mt-6"
    />
    <span class="text-danger text-sm">{{
      errors.first("confirm_password")
    }}</span>
    <!-- Save & Reset Button -->
    <div class="flex flex-wrap items-center justify-end">
      <vs-button class="ml-auto mt-2" @click="updatePassword"
        >Save Changes</vs-button
      >
      <vs-button class="ml-4 mt-2" type="border" color="warning"
        >Reset</vs-button
      >
    </div>
  </vx-card>
</template>

<script>
import store from "./../../../store/store";
export default {
  data() {
    return {
      old_password: "",
      password: "",
      confirm_password: "",
    };
  },
  computed: {
    activeUserInfo() {
      return store.state.AppActiveUser;
    },
  },
  methods: {
    updatePassword() {
      // if (!this.validateForm) return;
      let obj = {
        old_password: this.old_password,
        password: this.password,
        email: store.state.AppActiveUser.email,
      };
      this.$store
        .dispatch("userManagement/updatePassword", obj)
        .then((res) => {
          if (
            res &&
            res.data.message.errors &&
            res.data.message.errors.length > 0
          ) {
            this.$vs.loading.close();
            this.$vs.notify({
              title: "Error",
              text: res.data.message.errors,
              iconPack: "feather",
              icon: "icon-alert-circle",
              color: "danger",
            });
          } else {
            this.$vs.loading.close();
            this.$vs.notify({
              color: "success",
              title: "Password Updated",
              text: res.data.message,
            });
          }
        })
        .catch((err) => {
          console.error(err);
        });
    },
  },
};
</script>
