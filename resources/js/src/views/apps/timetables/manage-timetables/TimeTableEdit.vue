<!-- =========================================================================================
  File Name: UserEdit.vue
  Description: User Edit Page
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
========================================================================================== -->

<template>
  <div id="page-timetable-edit">
    <vs-alert
      color="danger"
      title="User Not Found"
      :active.sync="student_not_found"
    >
      <span>Timetable record with id: {{ $route.params.id }} not found.</span>
      <span>
        <span>Check</span>
        <router-link
          :to="{ name: 'page-timetable-list' }"
          class="text-inherit underline"
          >All Timetables</router-link
        >
      </span>
    </vs-alert>

    <vx-card v-if="timetable_data">
      <div slot="no-body" class="tabs-container px-6 pt-6">
        <vs-tabs v-model="activeTab" class="tab-action-btn-fill-conatiner">
          <vs-tab label="Account" icon-pack="feather" icon="icon-user">
            <div class="tab-text">
              <time-table-edit-tab-account
                class="mt-4"
                :data="timetable_data"
              />
            </div>
          </vs-tab>
        </vs-tabs>
      </div>
    </vx-card>
  </div>
</template>

<script>
import TimeTableEditTabAccount from "./TimeTableEditTabAccount.vue";

// Store Module
import moduleTimeTableManagement from "@/store/timetable-management/moduleTimeTableManagement.js";

export default {
  components: {
    TimeTableEditTabAccount,
  },
  data() {
    return {
      timetable_data: null,
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
      this.fetch_timetable_data(this.$route.params.timetableId);
    },
  },
  methods: {
    fetch_timetable_data(timetableId) {
      this.$store
        .dispatch("timetableManagement/fetchTimeTable", timetableId)
        .then((res) => {
          console.log(res);
          this.timetable_data = res.data.response;
          let class_id = {
            value: this.timetable_data.class_id,
            label: this.timetable_data.class_name,
          };
          let teacher_id = {
            value: this.timetable_data.teacher_id,
            label: this.timetable_data.name,
          };
          let subject_id = {
            value: this.timetable_data.subject_id,
            label: this.timetable_data.subject_name,
          };
          let day_id = {
            value: this.timetable_data.day_id,
            label: this.timetable_data.day,
          };
          let hour_id = {
            value: this.timetable_data.hour_id,
            label: `${this.timetable_data.from} - ${this.timetable_data.to}`,
          };
          this.timetable_data.class_id = class_id;
          this.timetable_data.teacher_id = teacher_id;
          this.timetable_data.subject_id = subject_id;
          this.timetable_data.day_id = day_id;
          this.timetable_data.hour_id = hour_id;
        })
        .catch((err) => {
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
    if (!moduleTimeTableManagement.isRegistered) {
      this.$store.registerModule(
        "timetableManagement",
        moduleTimeTableManagement
      );
      moduleTimeTableManagement.isRegistered = true;
    }
    this.fetch_timetable_data(this.$route.params.timetableId);
  },
};
</script>
