<!-- =========================================================================================
  File Name: UserView.vue
  Description: User View page
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
========================================================================================== -->

<template>
  <div id="page-user-view">
    <vs-alert
      color="danger"
      title="User Not Found"
      :active.sync="session_not_found"
    >
      <span
        >Session record with id: {{ $route.params.sessionId }} not found.
      </span>
      <span>
        <span>Check </span
        ><router-link
          :to="{ name: 'page-session-list' }"
          class="text-inherit underline"
          >All Sessions</router-link
        >
      </span>
    </vs-alert>

    <div id="user-data" v-if="this.session_data">
      <vx-card title="Session Details" class="mb-base">
        <!-- Avatar -->
        <div class="vx-row">
          <!-- Information - Col 1 -->
          <div class="vx-col flex-1" id="account-info-col-1">
            <table>
              <tr>
                <td class="font-semibold">From</td>
                <td>{{ this.session_data.from }}</td>
              </tr>
              <tr>
                <td class="font-semibold">To</td>
                <td>{{ this.session_data.to }}</td>
              </tr>
              <tr>
                <td class="font-semibold">Status</td>
                <td>{{ this.session_data.session_status }}</td>
              </tr>
            </table>
          </div>
          <!-- /Information - Col 1 -->
        </div>
      </vx-card>
    </div>
  </div>
</template>

<script>
import moduleSessionManagement from "@/store/session-management/moduleSessionManagement.js";

export default {
  data() {
    return {
      session_data: null,
      session_not_found: false,
    };
  },
  computed: {},
  methods: {
    confirmDeleteRecord() {
      this.$vs.dialog({
        type: "confirm",
        color: "danger",
        title: "Confirm Delete",
        text: `You are about to delete "${this.session_data.from}" - "${this.session_data.to}"`,
        accept: this.deleteRecord,
        acceptText: "Delete",
      });
    },
    deleteRecord() {
      /* Below two lines are just for demo purpose */
      this.$router.push({ name: "app-session-list" });
      this.showDeleteSuccess();

      /* UnComment below lines for enabling true flow if deleting user */
      // this.$store.dispatch("sessionManagement/removeRecord", this.session_data.id)
      //   .then(()   => { this.$router.push({name:'app-user-list'}); this.showDeleteSuccess() })
      //   .catch(err => { console.error(err)       })
    },
    showDeleteSuccess() {
      this.$vs.notify({
        color: "success",
        title: "Session Deleted",
        text: "The selected session was successfully deleted",
      });
    },
  },
  created() {
    // Register Module sessionManagement Module
    if (!moduleSessionManagement.isRegistered) {
      this.$store.registerModule("sessionManagement", moduleSessionManagement);
      moduleSessionManagement.isRegistered = true;
    }

    const sessionId = this.$route.params.sessionId;
    this.$store
      .dispatch("sessionManagement/fetchSession", sessionId)
      .then((res) => {
        this.session_data = res.data.response;
        console.log("session_data", this.session_data);
      })
      .catch((err) => {
        // if (err.response.status === 404) {
        //   this.session_not_found = true;
        //   return;
        // }
        console.error(err);
      });
  },
};
</script>

<style lang="scss">
#avatar-col {
  width: 10rem;
}

#page-user-view {
  table {
    td {
      vertical-align: top;
      min-width: 140px;
      padding-bottom: 0.8rem;
      word-break: break-all;
    }

    &:not(.permissions-table) {
      td {
        @media screen and (max-width: 370px) {
          display: block;
        }
      }
    }
  }
}

// #account-info-col-1 {
//   // flex-grow: 1;
//   width: 30rem !important;
//   @media screen and (min-width:1200px) {
//     & {
//       flex-grow: unset !important;
//     }
//   }
// }

@media screen and (min-width: 1201px) and (max-width: 1211px),
  only screen and (min-width: 636px) and (max-width: 991px) {
  #account-info-col-1 {
    width: calc(100% - 12rem) !important;
  }

  // #account-manage-buttons {
  //   width: 12rem !important;
  //   flex-direction: column;

  //   > button {
  //     margin-right: 0 !important;
  //     margin-bottom: 1rem;
  //   }
  // }
}
</style>
