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
      :active.sync="subject_not_found"
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

    <vx-card v-if="subject_data">
      <div slot="no-body" class="tabs-container px-6 pt-6">
        <vs-tabs v-model="activeTab" class="tab-action-btn-fill-conatiner">
          <vs-tab label="Edit Subject" icon-pack="feather" icon="icon-user">
            <div class="tab-text">
              <subject-edit-tab-account class="mt-4" :data="subject_data" />
            </div>
          </vs-tab>
        </vs-tabs>
      </div>
    </vx-card>
  </div>
</template>

<script>
import SubjectEditTabAccount from "./SubjectEditTabAccount.vue";

// Store Module
import moduleSubjectManagement from "@/store/subject-management/moduleSubjectManagement.js";

export default {
  components: {
    SubjectEditTabAccount,
  },
  data() {
    return {
      subject_data: null,
      subject_not_found: false,

      /*
        This property is created for fetching latest data from API when tab is changed

        Please check it's watcher
      */
      activeTab: 0,
    };
  },
  watch: {
    activeTab() {
      this.fetch_subject_data(this.$route.params.subjectId);
    },
  },
  methods: {
    fetch_subject_data(subjectId) {
      this.$store
        .dispatch("subjectManagement/fetchSubject", subjectId)
        .then((res) => {
          console.log(res);
          this.subject_data = res.data.response;
        })
        .catch((err) => {
          if (err.response.status === 400) {
            this.subject_not_found = true;
            return;
          }
          console.error(err);
        });
    },
  },
  created() {
    // Register Module subjectManagement Module
    if (!moduleSubjectManagement.isRegistered) {
      this.$store.registerModule("subjectManagement", moduleSubjectManagement);
      moduleSubjectManagement.isRegistered = true;
    }
    this.fetch_subject_data(this.$route.params.subjectId);
  },
};
</script>
