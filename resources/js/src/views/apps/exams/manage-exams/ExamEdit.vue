<!-- =========================================================================================
  File Name: UserEdit.vue
  Description: User Edit Page
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
========================================================================================== -->

<template>
  <div id="page-class-edit">
    <vs-alert
      color="danger"
      title="Class Not Found"
      :active.sync="exam_not_found"
    >
      <span>Class record with id: {{ $route.params.id }} not found.</span>
      <span>
        <span>Check</span>
        <router-link
          :to="{ name: 'page-class-list' }"
          class="text-inherit underline"
          >All Classes</router-link
        >
      </span>
    </vs-alert>

    <vx-card v-if="exam_data">
      <div slot="no-body" class="tabs-container px-6 pt-6">
        <vs-tabs v-model="activeTab" class="tab-action-btn-fill-conatiner">
          <vs-tab label="Edit Exam" icon-pack="feather" icon="icon-user">
            <div class="tab-text">
              <exam-edit-tab-account class="mt-4" :data="exam_data" />
            </div>
          </vs-tab>
        </vs-tabs>
      </div>
    </vx-card>
  </div>
</template>

<script>
import ExamEditTabAccount from "./ExamEditTabAccount.vue";
import flatPickr from "vue-flatpickr-component";
import "flatpickr/dist/flatpickr.css";
// Store Module
import moduleExamManagement from "@/store/exam-management/moduleExamManagement.js";

export default {
  components: {
    ExamEditTabAccount,
  },
  data() {
    return {
      exam_data: null,
      exam_not_found: false,

      /*
        This property is created for fetching latest data from API when tab is changed

        Please check it's watcher
      */
      activeTab: 0,
    };
  },
  watch: {
    activeTab() {
      this.fetch_exam_data(this.$route.params.examId);
    },
  },
  methods: {
    fetch_exam_data(examId) {
      this.$store
        .dispatch("examManagement/fetchExam", examId)
        .then((res) => {
          console.log(res);
          this.exam_data = res.data.response;
          let obj = {};
          let type_obj = {};
          if (this.exam_data.exam_status == "active") {
            obj = {
              value: 1,
              label: "Active",
            };
          } else {
            obj = {
              value: 2,
              label: "Inactive",
            };
          }
          this.exam_data.exam_status = obj;
          if (this.exam_data.exam_type == "monthly") {
            type_obj = {
              value: 1,
              label: "Monthly",
            };
          }
          if (this.exam_data.exam_type == "quarterly") {
            type_obj = {
              value: 2,
              label: "Quarterly",
            };
          } else {
            type_obj = {
              value: 3,
              label: "Annually",
            };
          }
          this.exam_data.exam_type = type_obj;
        })
        .catch((err) => {
          if (err.response.status === 404) {
            this.exam_not_found = true;
            return;
          }
          console.error(err);
        });
    },
  },
  created() {
    // Register Module examManagement Module
    if (!moduleExamManagement.isRegistered) {
      this.$store.registerModule("examManagement", moduleExamManagement);
      moduleExamManagement.isRegistered = true;
    }
    this.fetch_exam_data(this.$route.params.examId);
  },
};
</script>
