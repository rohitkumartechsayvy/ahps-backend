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
    <!-- Avatar Row -->
    <!-- Content Row -->
    <div class="vx-row">
      <div class="vx-col md:w-1/2 w-full mb-5">
        <label class="text-sm">Birth Date</label>
        <flat-pickr
          v-model="data_local.from"
          :config="{ dateFormat: 'Y-m-d' }"
          class="w-full"
          v-validate="'required'"
          name="to"
        />
        <span class="text-danger text-sm" v-show="errors.has('from')">{{
          errors.first("from")
        }}</span>
      </div>
    </div>

    <div class="vx-row">
      <div class="vx-col md:w-1/2 w-full">
        <label class="text-sm">Birth Date</label>
        <flat-pickr
          v-model="data_local.to"
          :config="{ dateFormat: 'Y-m-d' }"
          class="w-full"
          v-validate="'required'"
          name="to"
        />
        <span class="text-danger text-sm" v-show="errors.has('to')">{{
          errors.first("to")
        }}</span>
      </div>
    </div>
    <div class="vx-row">
      <div class="vx-col md:w-1/2 w-full">
        <div class="mt-4">
          <label class="vs-input--label">Status</label>
          <v-select
            class="text-capitalize"
            v-model="data_local.session_status"
            :clearable="false"
            :options="statusOptions"
            v-validate="'required'"
            name="status"
            :dir="$vs.rtl ? 'rtl' : 'ltr'"
          />
          <span class="text-danger text-sm" v-show="errors.has('status')">{{
            errors.first("status")
          }}</span>
        </div>
      </div>
    </div>
    <!-- Save & Reset Button -->
    <div class="vx-row">
      <div class="vx-col w-full">
        <div class="mt-8 flex flex-wrap items-center justify-end">
          <vs-button
            class="ml-auto mt-2"
            @click="save_changes"
            :disabled="!validateForm"
            >Save Changes</vs-button
          >
          <!-- <vs-button class="ml-4 mt-2" type="border" color="warning" @click="reset_data">Reset</vs-button> -->
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import vSelect from "vue-select";
import moduleSessionManagement from "@/store/session-management/moduleSessionManagement.js";
import flatPickr from "vue-flatpickr-component";
import "flatpickr/dist/flatpickr.css";
export default {
  components: {
    vSelect,
    flatPickr,
  },
  props: {
    data: {
      type: Object,
      required: true,
    },
  },
  data() {
    return {
      data_local: JSON.parse(JSON.stringify(this.data)),
      statusOptions: [
        { label: "Active", value: "active" },
        { label: "Inactive", value: "inactive" },
      ],
    };
  },
  computed: {
    status_local: {
      get() {
        return {
          label: this.capitalize(this.data_local.status),
          value: this.data_local.status,
        };
      },
      set(obj) {
        this.data_local.status = obj.value;
      },
    },
    validateForm() {
      return !this.errors.any();
    },
  },
  methods: {
    capitalize(str) {
      console.log("str", str);
      if (!str) return "";
      str = str.toString();
      return str.charAt(0).toUpperCase() + str.slice(1);
      // return str.slice(0, 1).toUpperCase() + str.slice(1, str.length);
    },
    save_changes() {
      /* eslint-disable */
      if (!this.validateForm) return;
      console.log("data_local", this.data_local);
      let obj = {
        id: this.data_local.id,
        from: this.data_local.from,
        to: this.data_local.to,
        session_status: this.data_local.session_status.value,
      };
      this.$store
        .dispatch("sessionManagement/updateSession", obj)
        .then((res) => {
          console.log("Notifications");
          this.$vs.notify({
            color: "success",
            title: "Information Updated",
            text: "Session information updated successfully!",
          });
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
    delete() {
      /* eslint-disable */
      if (!this.validateForm) return;
      console.log("data_local", this.data_local);
      this.$store
        .dispatch("sessionManagement/updateClass", this.data_local)
        .then((res) => {
          console.log("Notifications");
          this.$vs.notify({
            color: "success",
            title: "Information Updated",
            text: "Class information updated successfully!",
          });
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
    reset_data() {
      this.data_local = JSON.parse(JSON.stringify(this.data));
    },
    update_avatar() {
      // You can update avatar Here
      // For reference you can check dataList example
      // We haven't integrated it here, because data isn't saved in DB
    },
  },
};
</script>
