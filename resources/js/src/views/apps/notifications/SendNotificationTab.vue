<!-- =========================================================================================
  File Name: UserEditTabInformation.vue
  Description: User Edit Information Tab content
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
========================================================================================== -->

<template>
  <div id="user-edit-tab-info">
    <!-- Content Row -->
    <div class="vx-row">
      <div class="vx-col md:w-1/2 w-full">
        <vs-input
          class="w-full mt-4"
          label="Enter Message"
          v-validate="'required|alpha_spaces'"
          name="message"
          v-model="message"
          :dir="$vs.rtl ? 'rtl' : 'ltr'"
        />
        <span
          class="text-danger text-sm"
          v-show="errors.has('message')"
        >{{ errors.first('message') }}</span>
      </div>
    </div>
    <div class="vx-row">
      <div class="vx-col md:w-1/2 w-full mt-4">
        <div class="flex flex-wrap justify-between mb-3">
          <vs-button :disabled="!validateForm" @click="save_changes">Send Message</vs-button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import vSelect from "vue-select";
import moduleNotiManagement from "@/store/noti-management/moduleNotiManagement.js";
export default {
  components: {
    vSelect,
  },
  data() {
    return {
      message: null,
    };
  },
  computed: {
    validateForm() {
      return !this.errors.any() && this.message !== "";
    },
    activeUserInfo() {
      return this.$store.state.AppActiveUser;
    },
  },
  methods: {
    capitalize(str) {
      return str.slice(0, 1).toUpperCase() + str.slice(1, str.length);
    },
    save_changes() {
      /* eslint-disable */
      if (!this.validateForm) return;
      this.$store
        .dispatch("NotiManagement/saveNoti", this)
        .then((res) => {
          this.$vs.notify({
            color: "success",
            title: "Notification Sent!",
            text: "Notification sent to all the users successfully!",
          });
          this.message = "";
          this.$validator.reset();
        })
        .catch((err) => {
          if (err.response.status === 404) {
            this.user_not_found = true;
            return;
          }
          console.error(err);
        });
      // Here will go your API call for updating data
      // You can get data in "this.data_local"

      /* eslint-enable */
    },
  },
  created() {
    // Register Module NotiManagement Module
    if (!moduleNotiManagement.isRegistered) {
      this.$store.registerModule("NotiManagement", moduleNotiManagement);
      moduleNotiManagement.isRegistered = true;
    }
  },
};
</script>

