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
    <vs-alert color="danger" title="User Not Found" :active.sync="data_not_found">
      <span>Query record with id: {{ $route.params.id }} not found.</span>
      <span>
        <span>Check</span>
        <router-link :to="{name:'contact-queries'}" class="text-inherit underline">All Queries</router-link>
      </span>
    </vs-alert>

    <div id="user-data" v-if="query_data">
      <vx-card title="Account" class="mb-base">
        <!-- Avatar -->
        <div class="vx-row">
          <!-- Information - Col 1 -->
          <div class="vx-col flex-1" id="account-info-col-1">
            <table>
              <tr>
                <td class="font-semibold">Name</td>
                <td>{{ query_data.name }}</td>
              </tr>
              <tr>
                <td class="font-semibold">Email</td>
                <td>{{ query_data.email }}</td>
              </tr>
              <tr>
                <td class="font-semibold">Contact Number</td>
                <td>{{ query_data.contact_number }}</td>
              </tr>
            </table>
          </div>
          <!-- /Information - Col 1 -->

          <!-- Information - Col 2 -->
          <div class="vx-col flex-1" id="account-info-col-2">
            <table>
              <tr>
                <td class="font-semibold">UDID</td>
                <td>{{ query_data.UDID }}</td>
              </tr>
              <tr>
                <td class="font-semibold">Handset Model</td>
                <td>{{ query_data.model }}</td>
              </tr>
            </table>
          </div>
          <div class="vx-col w-full flex" id="account-info-col-1">
            <table>
              <tr>
                <td class="font-semibold">Query</td>
              </tr>
              <tr>
                <td>{{ query_data.message }}</td>
              </tr>
            </table>
          </div>
        </div>
      </vx-card>
    </div>
  </div>
</template>

<script>
import moduleContactManagement from "@/store/contact-management/moduleContactManagement.js";
export default {
  data() {
    return {
      query_data: null,
      data_not_found: false,
    };
  },
  computed: {
    userAddress() {
      let str = "";
      for (const field in this.query_data.location) {
        str += `${field} `;
      }
      return str;
    },
  },
  methods: {
    confirmDeleteRecord() {
      this.$vs.dialog({
        type: "confirm",
        color: "danger",
        title: "Confirm Delete",
        text: `You are about to delete "${this.query_data.first_name} ${this.query_data.last_name}"`,
        accept: this.deleteRecord,
        acceptText: "Delete",
      });
    },
    deleteRecord() {
      /* UnComment below lines for enabling true flow if deleting user */
      this.$store
        .dispatch("contactManagement/removeRecord", this.query_data.id)
        .then(() => {
          this.$router.push({ name: "manage-users" });
          this.showDeleteSuccess();
        })
        .catch((err) => {
          console.error(err);
        });
    },
    showDeleteSuccess() {
      this.$vs.notify({
        color: "success",
        title: "User Deleted",
        text: "The selected user was successfully deleted",
      });
    },
  },
  created() {
    // Register Module contactManagement Module
    if (!moduleContactManagement.isRegistered) {
      this.$store.registerModule("contactManagement", moduleContactManagement);
      moduleContactManagement.isRegistered = true;
    }

    const queryId = this.$route.params.queryId;
    this.$store
      .dispatch("contactManagement/fetchQuery", queryId)
      .then((res) => {
        console.log(res.data.response);
        this.query_data = res.data.response;
      })
      .catch((err) => {
        if (err.response.status === 404) {
          this.data_not_found = true;
          return;
        }
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

@media screen and (min-width: 1201px) and (max-width: 1211px),
  only screen and (min-width: 636px) and (max-width: 991px) {
  #account-info-col-1 {
    width: calc(100% - 12rem) !important;
  }
}
</style>
<style lang="scss" scpoped>
.ag-grid-cell-chip {
  &.vs-chip-success {
    background: rgba(var(--vs-success), 0.15);
    color: rgba(var(--vs-success), 1) !important;
    font-weight: 500;
  }
  &.vs-chip-warning {
    background: rgba(var(--vs-warning), 0.15);
    color: rgba(var(--vs-warning), 1) !important;
    font-weight: 500;
  }
  &.vs-chip-danger {
    background: rgba(var(--vs-danger), 0.15);
    color: rgba(var(--vs-danger), 1) !important;
    font-weight: 500;
  }
}
</style>