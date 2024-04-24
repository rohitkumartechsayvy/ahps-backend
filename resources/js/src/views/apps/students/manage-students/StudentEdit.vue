<!-- =========================================================================================
  File Name: UserEdit.vue
  Description: User Edit Page
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
========================================================================================== -->

<template>
  <div id="page-user-edit">
    <vs-alert
      color="danger"
      title="User Not Found"
      :active.sync="student_not_found"
    >
      <span>Student record with id: {{ $route.params.id }} not found.</span>
      <span>
        <span>Check</span>
        <router-link
          :to="{ name: 'page-user-list' }"
          class="text-inherit underline"
          >All Students</router-link
        >
      </span>
    </vs-alert>

    <vx-card v-if="student_data">
      <div slot="no-body" class="tabs-container px-6 pt-6">
        <vs-tabs v-model="activeTab" class="tab-action-btn-fill-conatiner">
          <vs-tab label="Account" icon-pack="feather" icon="icon-user">
            <div class="tab-text">
              <student-edit-tab-account class="mt-4" :data="student_data" />
            </div>
          </vs-tab>
        </vs-tabs>
      </div>
    </vx-card>
  </div>
</template>

<script>
import StudentEditTabAccount from "./StudentEditTabAccount.vue";
import moment from "moment";
// Store Module
import moduleStudentManagement from "@/store/student-management/moduleStudentManagement.js";

export default {
  components: {
    StudentEditTabAccount,
  },
  data() {
    return {
      student_data: null,
      student_not_found: false,

      /*
        This property is created for fetching latest data from API when tab is changed

        Please check it's watcher
      */
      activeTab: 0,
    };
  },
  watch: {
    activeTab() {
      this.fetch_student_data(this.$route.params.studentId);
    },
  },
  methods: {
    fetch_student_data(studentId) {
      this.$store
        .dispatch("studentManagement/fetchStudent", studentId)
        .then((res) => {
          console.log("res.data.response", res.data.response);
          this.student_data = res.data.response;
          let student_class = {
            label: null,
            value: null,
          };
          let parent_id = {
            label: null,
            value: null,
          };
          student_class.value = this.student_data.current_class_id;
          student_class.label = this.student_data.current_class_name;
          this.student_data.student_class = student_class;
          if (this.student_data.mother_id || this.student_data.father_id) {
          }
          console.log("this.student_data", this.student_data);
        })
        .catch((err) => {
          console.log("err", err);
          if (err.response.status === 404) {
            this.student_not_found = true;
            return;
          }
          console.error(err);
        });
    },
  },
  created() {
    // Register Module UserManagement Module
    if (!moduleStudentManagement.isRegistered) {
      this.$store.registerModule("studentManagement", moduleStudentManagement);
      moduleStudentManagement.isRegistered = true;
    }
    this.fetch_student_data(this.$route.params.studentId);
  },
};
</script>
