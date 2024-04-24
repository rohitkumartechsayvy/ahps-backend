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

    <vx-card v-if="charge_data">
      <div slot="no-body" class="tabs-container px-6 pt-6">
        <vs-tabs v-model="activeTab" class="tab-action-btn-fill-conatiner">
          <vs-tab label="Edit Session" icon-pack="feather" icon="icon-user">
            <div class="tab-text">
              <tuition-fee-edit-tab-account class="mt-4" :data="charge_data" />
            </div>
          </vs-tab>
        </vs-tabs>
      </div>
    </vx-card>
  </div>
</template>

<script>
import TuitionFeeEditTabAccount from "./TuitionFeeEditTabAccount.vue";
// Store Module
import moduleTuitionFeeManagement from "@/store/tuition-fee-management/moduleTuitionFeeManagement.js";
import moduleClassManagement from "@/store/class-management/moduleClassManagement.js";
export default {
  components: {
    TuitionFeeEditTabAccount,
    moduleTuitionFeeManagement,
  },
  data() {
    return {
      charge_data: null,
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
      this.fetch_charge_data(this.$route.params.chargeId);
    },
  },
  methods: {
    fetch_charge_data(chargeId) {
      this.$store
        .dispatch("tuitionFeeManagement/fetchCharge", chargeId)
        .then((res) => {
          console.log(res);
          this.charge_data = res.data.response;
        })
        .catch((err) => {
          if (err.response.status === 404) {
            this.session_not_found = true;
            return;
          }
          console.error(err);
        });
    },
    classData() {
      this.$store
        .dispatch("classManagement/fetchClasses")
        .then((res) => {
          console.log("res.data.response", res.data.response);
          this.class_data = res.data.response.map((class_data) => ({
            label: `${class_data.class_name}`,
            value: class_data.id,
          }));
        })
        .catch((err) => {
          console.error(err);
        });
    },
  },
  created() {
    // Register Module tuitionFeeManagement Module
    if (!moduleTuitionFeeManagement.isRegistered) {
      this.$store.registerModule(
        "tuitionFeeManagement",
        moduleTuitionFeeManagement
      );
      moduleTuitionFeeManagement.isRegistered = true;
    }
    if (!moduleClassManagement.isRegistered) {
      this.$store.registerModule("classManagement", moduleClassManagement);
      moduleClassManagement.isRegistered = true;
    }
    this.classData();
    this.fetch_charge_data(this.$route.params.chargeId);
  },
};
</script>
