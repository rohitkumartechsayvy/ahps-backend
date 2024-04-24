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
    <div class="vx-row">
      <div class="vx-col w-full">
        <div class="flex items-start flex-col sm:flex-row">
          <div>
            <p class="text-lg font-medium mb-2 mt-4 sm:mt-0 text-capitalize">
              {{ data.first_name }} {{ data.last_name }}
            </p>
          </div>
        </div>
      </div>
    </div>

    <!-- Content Row -->
    <div class="vx-row">
      <div class="vx-col md:w-1/2 w-full">
        <vs-input
          class="w-full mt-4"
          label="Name"
          v-model="data_local.name"
          v-validate="'required|alpha'"
          name="name"
        />
        <span class="text-danger text-sm" v-show="errors.has('name')">{{
          errors.first("name")
        }}</span>

        <vs-input
          class="w-full mt-4"
          label="Email"
          v-model="data_local.email"
          type="email"
          v-validate="'required|email'"
          name="email"
        />
        <span class="text-danger text-sm" v-show="errors.has('email')">{{
          errors.first("email")
        }}</span>
      </div>

      <div class="vx-col md:w-1/2 w-full">
        <div class="mt-4">
          <label class="vs-input--label">Status</label>
          <v-select
            v-model="status_local"
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

        <div class="mt-4">
          <label class="vs-input--label">Role</label>
          <v-select
            v-model="role_local"
            :clearable="false"
            :options="roleOptions"
            v-validate="'required'"
            name="user_type"
            :dir="$vs.rtl ? 'rtl' : 'ltr'"
            :disabled="true"
          />
          <span class="text-danger text-sm" v-show="errors.has('user_type')">{{
            errors.first("user_type")
          }}</span>
        </div>

        <div class="mt-4">
          <label class="vs-input--label">Blocked</label>
          <v-select
            v-model="block_local"
            :clearable="false"
            :options="blockOptions"
            v-validate="'required'"
            name="is_blocked"
            :dir="$vs.rtl ? 'rtl' : 'ltr'"
          />
          <span class="text-danger text-sm" v-show="errors.has('is_blocked')">{{
            errors.first("is_blocked")
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
import moduleUserManagement from "@/store/user-management/moduleUserManagement.js";
export default {
  components: {
    vSelect,
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
      blockOptions: [
        { label: "Block", value: "yes" },
        { label: "Unblock", value: "no" },
      ],
      roleOptions: [
        { label: "Admin", value: "admin" },
        { label: "User", value: "user" },
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
    block_local: {
      get() {
        return {
          label: this.capitalize(this.data_local.is_blocked),
          value: this.data_local.is_blocked,
        };
      },
      set(obj) {
        this.data_local.is_blocked = obj.value;
      },
    },
    role_local: {
      get() {
        return {
          label: this.capitalize(this.data_local.user_type),
          value: this.data_local.user_type,
        };
      },
      set(obj) {
        this.data_local.user_type = obj.value;
      },
    },
    validateForm() {
      return !this.errors.any();
    },
  },
  methods: {
    capitalize(str) {
      return str.slice(0, 1).toUpperCase() + str.slice(1, str.length);
    },
    save_changes() {
      /* eslint-disable */
      if (!this.validateForm) return;
      console.log(this.data_local.id);
      this.$store
        .dispatch("userManagement/saveUser", this.data_local)
        .then((res) => {
          console.log("Notifications");
          this.$vs.notify({
            color: "success",
            title: "Information Updated",
            text: "User information updated successfully!",
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
