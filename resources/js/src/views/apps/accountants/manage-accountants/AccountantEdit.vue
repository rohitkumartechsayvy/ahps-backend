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
      :active.sync="accountant_not_found"
    >
      <span>User record with id: {{ $route.params.id }} not found.</span>
      <span>
        <span>Check</span>
        <router-link
          :to="{ name: 'page-user-list' }"
          class="text-inherit underline"
          >All Users</router-link
        >
      </span>
    </vs-alert>

    <vx-card v-if="accountant_data">
      <div slot="no-body" class="tabs-container px-6 pt-6">
        <vs-tabs v-model="activeTab" class="tab-action-btn-fill-conatiner">
          <vs-tab label="Account" icon-pack="feather" icon="icon-user">
            <div class="tab-text">
              <accountant-edit-tab-account
                class="mt-4"
                :data="accountant_data"
              />
            </div>
          </vs-tab>
        </vs-tabs>
      </div>
    </vx-card>
  </div>
</template>

<script>
import AccountantEditTabAccount from "./AccountantEditTabAccount.vue";

// Store Module
import moduleAccountantManagement from "@/store/accountant-management/moduleAccountantManagement.js";

export default {
  components: {
    AccountantEditTabAccount,
  },
  data() {
    return {
      accountant_data: null,
      accountant_not_found: false,

      /*
        This property is created for fetching latest data from API when tab is changed

        Please check it's watcher
      */
      activeTab: 0,
    };
  },
  watch: {
    activeTab() {
      this.fetch_accountant_data(this.$route.params.accountantId);
    },
  },
  methods: {
    fetch_accountant_data(accountantId) {
      this.$store
        .dispatch("accountantManagement/fetchAccountant", accountantId)
        .then((res) => {
          console.log(res);
          this.accountant_data = res.data.response;
        })
        .catch((err) => {
          if (err.response.status === 404) {
            this.accountant_not_found = true;
            return;
          }
          console.error(err);
        });
    },
  },
  created() {
    // Register Module UserManagement Module
    if (!moduleAccountantManagement.isRegistered) {
      this.$store.registerModule(
        "accountantManagement",
        moduleAccountantManagement
      );
      moduleAccountantManagement.isRegistered = true;
    }
    this.fetch_accountant_data(this.$route.params.accountantId);
  },
};
</script>
