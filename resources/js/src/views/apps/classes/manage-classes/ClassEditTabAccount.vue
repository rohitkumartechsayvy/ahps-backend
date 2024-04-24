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
    <div class="vx-row mb-6">
      <div class="vx-col sm:w-1/3 w-full">
        <span>Class Name</span>
      </div>
      <div class="vx-col sm:w-2/3 w-full">
        <vs-input
          v-validate="'required'"
          placeholder="Class Name"
          name="class_name"
          v-model="data_local.class_name"
          class="w-full"
          data-vv-validate-on="blur"
        />
        <span class="text-danger text-sm" v-show="errors.has('class_name')">{{
          errors.first("class_name")
        }}</span>
      </div>
    </div>
    <div class="vx-row mb-6">
      <div class="vx-col sm:w-1/3 w-full">
        <span>Select Class Incharge</span>
      </div>
      <div class="vx-col sm:w-2/3 w-full">
        <v-select
          v-model="data_local.class_incharge"
          :clearable="false"
          :options="teacher_data"
          v-validate="'required'"
          name="class_incharge"
          :dir="$vs.rtl ? 'rtl' : 'ltr'"
        />
        <span
          class="text-danger text-sm"
          v-show="errors.has('class_incharge')"
          >{{ errors.first("class_incharge") }}</span
        >
      </div>
    </div>
    <div class="vx-row mb-6">
      <div class="vx-col sm:w-1/3 w-full">
        <span>Assign Subjects</span>
      </div>
      <div class="vx-col sm:w-2/3 w-full">
        <v-select
          multiple
          v-model="data_local.subjects"
          :clearable="false"
          :options="subject_data"
          v-validate="'required'"
          name="subjects[]"
          :dir="$vs.rtl ? 'rtl' : 'ltr'"
        />
        <span class="text-danger text-sm" v-show="errors.has('subjects[]')">{{
          errors.first("subjects[]")
        }}</span>
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

    <!-- <hr class="my-5" />
    <h2>Manage Class's Monthly Fee</h2>
    <div class="vx-row mt-5">
      <div
        v-for="item in months"
        :key="item.id"
        class="inline-flex items-center vx-col w-full"
      >
        <div class="vx-row w-full">
          <div class="vx-col xl:w-1/5 lg:w-1/5 md:w-1/5">
            <h5 class="pt-3">{{ item.month }}</h5>
          </div>
          <div class="vx-col xl:w-1/3 lg:w-1/3 md:w-1/3">
            <vs-input
              class="w-full mt-4"
              label="Monthly Fee"
              v-model="fee_array[item.id]"
              type="text"
              v-validate="'required|numeric'"
              name="monthly_fee[]"
            />
          </div>
          <div class="vx-col xl:w-1/3 lg:w-1/3 md:w-1/3">
            <vs-button
              class="ml-auto mt-2"
              @click="save_fee(item.id, fee_array[item.id])"
              :disabled="!validateFeeForm"
              >Update</vs-button
            >
          </div>
        </div>
      </div>
      <div class="vx-col w-full"></div>
    </div> -->
  </div>
</template>

<script>
import vSelect from "vue-select";
import moduleClassManagement from "@/store/class-management/moduleClassManagement.js";
import moduleStudentManagement from "@/store/student-management/moduleStudentManagement.js";
import moduleSubjectManagement from "@/store/subject-management/moduleSubjectManagement.js";
import axios from "axios";
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
      data_local: {
        class_name: "",
        subjects: [],
        class_incharge: {
          label: null,
          value: null,
        },
      },
      teacher_data: [],
      subject_data: [],
      months: [],
      fee_array: [],
    };
  },
  computed: {
    validateForm() {
      return !this.errors.any();
    },
    validateFeeForm() {
      return !this.errors.any();
    },
  },
  methods: {
    teachersData() {
      this.$store
        .dispatch("studentManagement/fetchTeachers")
        .then((res) => {
          console.log("res.data.response", res.data.response);
          this.teacher_data = res.data.response.map((user) => ({
            label: `${user.name}`,
            value: user.user_id,
          }));
        })
        .catch((err) => {
          console.error(err);
        });
    },
    subjectsData() {
      this.$store
        .dispatch("subjectManagement/fetchSubjects")
        .then((res) => {
          console.log("res.data.response", res.data.response);
          this.subject_data = res.data.response.map((subject) => ({
            label: `${subject.subject_name}`,
            value: subject.id,
          }));
        })
        .catch((err) => {
          console.error(err);
        });
    },
    capitalize(str) {
      return str.slice(0, 1).toUpperCase() + str.slice(1, str.length);
    },
    save_changes() {
      /* eslint-disable */
      if (!this.validateForm) return;
      console.log("data_local", this.data_local);
      let request_obj = {
        id: this.$route.params.classId,
        class_name: this.data_local.class_name,
        class_incharge: this.data_local.class_incharge.value,
        changed_by: this.$store.state.AppActiveUser.id,
        subjects: this.data_local.subjects,
      };
      this.$store
        .dispatch("classManagement/updateClass", request_obj)
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
    delete() {
      /* eslint-disable */
      if (!this.validateForm) return;
      console.log("data_local", this.data_local);
      this.$store
        .dispatch("classManagement/updateClass", this.data_local)
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
    get_months() {
      this.$store
        .dispatch("classManagement/getMonths")
        .then((res) => {
          this.months = res.data.response;
        })
        .catch((err) => {
          if (err.response.status === 404) {
            this.user_not_found = true;
            return;
          }
          console.error(err);
        });
    },
    fetch_class() {
      this.$store
        .dispatch("classManagement/fetchClass", this.$route.params.classId)
        .then((res) => {
          console.log(this.$route.params.classId);
          if (res.data.statusCode === 200) {
            console.log("dvdvvrvrdata", res);
            console.log("before", this.data_local);
            this.data_local.class_name = res.data.response.class_name;
            this.data_local.class_incharge.value = res.data.response.teacher_id;
            this.data_local.class_incharge.label =
              res.data.response.teacher_name;
            if (
              res.data.response.subjects &&
              res.data.response.subjects.length > 0
            ) {
              let subs = res.data.response.subjects;
              this.data_local.subjects = subs.map((subject) => ({
                label: `${subject.subject_name}`,
                value: subject.id,
              }));
            }
            console.log("after", this.data_local);
          }
        })
        .catch((err) => {
          if (err.response.status === 404) {
            this.user_not_found = true;
            return;
          }
          console.error(err);
        });
    },
    fetch_monthly_fee() {
      this.$store
        .dispatch("classManagement/getMonthlyFee", this.$route.params.classId)
        .then((res) => {
          let monthly_fee_array = [];
          let whole_response = res.data.response;
          if (whole_response.length > 0) {
            whole_response.forEach((element) => {
              monthly_fee_array[element.month_id] = element.monthly_fee;
            });
          }
          this.fee_array = monthly_fee_array;
        })
        .catch((err) => {
          if (err.response.status === 404) {
            this.user_not_found = true;
            return;
          }
          console.error(err);
        });
    },
    save_fee(month_id, amount) {
      console.log("month_id", month_id);
      console.log("amount", amount);
      let obj = {
        month_id: month_id,
        monthly_fee: amount,
        class_id: this.$route.params.classId,
      };
      this.$store
        .dispatch("classManagement/updateFee", obj)
        .then((res) => {
          if (res && res.data.statusCode == 200) {
            this.$vs.notify({
              color: "success",
              title: "Information Updated",
              text: "Class Fee Updated successfully!",
            });
          }
        })
        .catch((err) => {
          if (err.response.status === 404) {
            this.user_not_found = true;
            return;
          }
          console.error(err);
        });
    },
  },
  created() {
    if (!moduleStudentManagement.isRegistered) {
      this.$store.registerModule("studentManagement", moduleStudentManagement);
      moduleStudentManagement.isRegistered = true;
    }
    if (!moduleSubjectManagement.isRegistered) {
      this.$store.registerModule("subjectManagement", moduleSubjectManagement);
      moduleSubjectManagement.isRegistered = true;
    }
    this.get_months();
    this.fetch_monthly_fee();
    this.teachersData();
    this.fetch_class();
    this.subjectsData();
  },
};
</script>
