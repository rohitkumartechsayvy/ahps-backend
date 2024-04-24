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
      :active.sync="class_not_found"
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

    <vx-card v-if="class_data">
      <div slot="no-body" class="tabs-container px-6 pt-6">
        <vs-tabs v-model="activeTab" class="tab-action-btn-fill-conatiner">
          <vs-tab
            :label="`${class_data.class_name} Details`"
            icon-pack="feather"
            icon="icon-user"
          >
            <div class="tab-text">
              <class-edit-tab-account class="mt-4" :data="class_data" />
            </div>
          </vs-tab>
        </vs-tabs>
      </div>
    </vx-card>
  </div>
</template>

<script>
import ClassEditTabAccount from "./ClassEditTabAccount.vue";

// Store Module
import moduleClassManagement from "@/store/class-management/moduleClassManagement.js";

export default {
  components: {
    ClassEditTabAccount,
  },
  data() {
    return {
      class_data: null,
      class_not_found: false,

      /*
        This property is created for fetching latest data from API when tab is changed

        Please check it's watcher
      */
      activeTab: 0,
    };
  },
  watch: {
    activeTab() {
      this.fetch_class_data(this.$route.params.classId);
    },
  },
  methods: {
    fetch_class_data(classId) {
      this.$store
        .dispatch("classManagement/fetchClass", classId)
        .then((res) => {
          console.log(res);
          this.class_data = res.data.response;
        })
        .catch((err) => {
          if (err.response.status === 404) {
            this.class_not_found = true;
            return;
          }
          console.error(err);
        });
    },
  },
  created() {
    // Register Module classManagement Module
    if (!moduleClassManagement.isRegistered) {
      this.$store.registerModule("classManagement", moduleClassManagement);
      moduleClassManagement.isRegistered = true;
    }
    this.fetch_class_data(this.$route.params.classId);
  },
};
</script>
