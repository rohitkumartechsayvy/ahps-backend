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
    <vx-card title="Enter Details" class="mb-base">
      <div class="vx-row mb-6">
        <div class="vx-col sm:w-1/3 w-full">
          <span>Exam Title</span>
        </div>
        <div class="vx-col sm:w-2/3 w-full">
          <vs-input
            v-validate="'required|alpha_spaces'"
            placeholder="Title"
            name="exam_title"
            v-model="data_local.exam_title"
            class="w-full"
            data-vv-validate-on="blur"
          />
          <span class="text-danger text-sm" v-show="errors.has('exam_title')">{{
            errors.first("exam_title")
          }}</span>
        </div>
      </div>
      <div class="vx-row mb-6">
        <div class="vx-col sm:w-1/3 w-full">
          <span>Exam Type</span>
        </div>
        <div class="vx-col sm:w-2/3 w-full">
          <v-select
            v-model="data_local.exam_type"
            :closeOnSelect="true"
            :options="examTypeOptions"
            v-validate="'required'"
            name="exam_type"
            :dir="$vs.rtl ? 'rtl' : 'ltr'"
          />
          <span class="text-danger text-sm" v-show="errors.has('exam_type')">{{
            errors.first("exam_type")
          }}</span>
        </div>
      </div>
      <div class="vx-row mb-6">
        <div class="vx-col sm:w-1/3 w-full">
          <span>Exam Month</span>
        </div>
        <div class="vx-col sm:w-2/3 w-full">
          <flat-pickr
            v-model="data_local.exam_month"
            :config="{ dateFormat: 'M, Y' }"
            class="w-full"
            v-validate="'required'"
            name="to"
          />
          <span class="text-danger text-sm" v-show="errors.has('to')">{{
            errors.first("to")
          }}</span>
        </div>
      </div>
      <div class="vx-row mb-6">
        <div class="vx-col sm:w-1/3 w-full">
          <span>Exam Status</span>
        </div>
        <div class="vx-col sm:w-2/3 w-full">
          <v-select
            v-model="data_local.exam_status"
            :closeOnSelect="true"
            :options="statusOptions"
            v-validate="'required'"
            name="exam_status"
            :dir="$vs.rtl ? 'rtl' : 'ltr'"
          />
          <span
            class="text-danger text-sm"
            v-show="errors.has('exam_status')"
            >{{ errors.first("exam_status") }}</span
          >
        </div>
      </div>
      <div class="vx-row">
        <div class="vx-col sm:w-2/3 w-full ml-auto">
          <vs-button
            class="ml-auto mt-2"
            @click="save_changes"
            :disabled="!validateForm"
            >Save Changes</vs-button
          >
          <vs-button
            color="warning"
            type="border"
            class="mb-2"
            @click="
              data_local.exam_type = data_local.exam_status = exam_title = exam_month = null;
              check1 = false;
            "
            >Reset</vs-button
          >
        </div>
      </div>
    </vx-card>
  </div>
</template>

<script>
import vSelect from "vue-select";
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
        { label: "Active", value: 1 },
        { label: "Inactive", value: 2 },
      ],
      examTypeOptions: [
        { label: "Monthly", value: 1 },
        { label: "Quarterly", value: 2 },
        { label: "Annaully", value: 3 },
      ],
    };
  },
  computed: {
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
        exam_type: this.data_local.exam_type.value,
        exam_status: this.data_local.exam_status.value,
        exam_title: this.data_local.exam_title,
        exam_month: this.data_local.exam_month,
      };
      this.$store
        .dispatch("examManagement/updateExam", obj)
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
        .dispatch("examManagement/updateClass", this.data_local)
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
