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
    <vx-card>
      <div slot="no-body" class="tabs-container px-6 pt-6">
        <vs-tabs class="tab-action-btn-fill-conatiner">
          <vs-tab label="Send A Message" icon-pack="feather" icon="icon-user">
            <div class="tab-text">
              <send-notification-tab class="mt-4" />
            </div>
          </vs-tab>
        </vs-tabs>
      </div>
    </vx-card>
  </div>
</template>

<script>
import SendNotificationTab from "./SendNotificationTab.vue";

// Store Module
import moduleNotiManagement from "@/store/noti-management/moduleNotiManagement.js";
export default {
  components: {
    SendNotificationTab,
  },
  created() {
    // Register Module NotiManagement Module
    if (!moduleNotiManagement.isRegistered) {
      this.$store.registerModule("NotiManagement", moduleNotiManagement);
      moduleNotiManagement.isRegistered = true;
    }
  },
};
</script>
