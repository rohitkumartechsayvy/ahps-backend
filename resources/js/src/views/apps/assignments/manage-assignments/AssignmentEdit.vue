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
      :active.sync="session_not_found"
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

    <vx-card v-if="session_data">
      <div slot="no-body" class="tabs-container px-6 pt-6">
        <vs-tabs v-model="activeTab" class="tab-action-btn-fill-conatiner">
          <vs-tab label="Edit Session" icon-pack="feather" icon="icon-user">
            <div class="tab-text">
              <session-edit-tab-account class="mt-4" :data="session_data" />
            </div>
          </vs-tab>
        </vs-tabs>
      </div>
    </vx-card>
  </div>
</template>

<script>
import SessionEditTabAccount from "./SessionEditTabAccount.vue";
import flatPickr from "vue-flatpickr-component";
import "flatpickr/dist/flatpickr.css";
// Store Module
import moduleSessionManagement from "@/store/session-management/moduleSessionManagement.js";

export default {
  components: {
    SessionEditTabAccount,
  },
  data() {
    return {
      session_data: null,
      session_not_found: false,

      /*
        This property is created for fetching latest data from API when tab is changed

        Please check it's watcher
      */
      activeTab: 0,
    };
  },
  watch: {
    activeTab() {
      this.fetch_session_data(this.$route.params.sessionId);
    },
  },
  methods: {
    fetch_session_data(sessionId) {
      this.$store
        .dispatch("sessionManagement/fetchSession", sessionId)
        .then((res) => {
          console.log(res);
          this.session_data = res.data.response;
        })
        .catch((err) => {
          if (err.response.status === 404) {
            this.session_not_found = true;
            return;
          }
          console.error(err);
        });
    },
  },
  created() {
    // Register Module sessionManagement Module
    if (!moduleSessionManagement.isRegistered) {
      this.$store.registerModule("sessionManagement", moduleSessionManagement);
      moduleSessionManagement.isRegistered = true;
    }
    this.fetch_session_data(this.$route.params.sessionId);
  },
};
</script>
