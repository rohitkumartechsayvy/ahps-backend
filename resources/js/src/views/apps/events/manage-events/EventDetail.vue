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
      title="Event Not Found"
      :active.sync="event_not_found"
    >
      <span
        >Event record with id: {{ this.$route.params.eventId }} not found.</span
      >
      <span>
        <span>Check</span>
        <router-link
          :to="{ name: 'page-event-list' }"
          class="text-inherit underline"
          >All Events</router-link
        >
      </span>
    </vs-alert>

    <div id="user-data" v-if="event_data">
      <vx-card title="Event Details" class="mb-base">
        <!-- Avatar -->
        <div class="vx-row">
          <!-- Information - Col 1 -->
          <div class="vx-col flex-1" id="account-info-col-1">
            <table>
              <tr>
                <td class="font-semibold">Title</td>
                <td>{{ event_data.title }}</td>
              </tr>
              <tr>
                <td class="font-semibold">Description</td>
                <td>{{ event_data.desc }}</td>
              </tr>
              <tr>
                <td class="font-semibold">Created By</td>
                <td>{{ event_data.name }}</td>
              </tr>
              <tr>
                <td class="font-semibold">Approval Status</td>
                <td>
                  {{
                    event_data.approved_by
                      ? `Approved By ${event_data.approved_by_name}`
                      : "Pending"
                  }}
                </td>
              </tr>
            </table>
          </div>
          <!-- /Information - Col 1 -->
          <div class="vx-row mb-6" v-if="this.images && this.images.length > 0">
            <div class="vx-col w-full">
              <h4 class="pl-3">Event Images</h4>
            </div>
            <div class="vx-row w-full" id="gallery_div" ref="gallery_div"></div>
            <div class="vx-col sm:w-2/3 w-full">
              <div class="flex items-start flex-col sm:flex-row">
                <div
                  class="mt-5 px-4 vx-col lg:w-1/4"
                  v-for="(item, grp_index) in images"
                  :key="grp_index"
                >
                  <img :src="`/${item}`" :class="'img-fluid w-full'" />
                </div>
              </div>
            </div>
          </div>
          <!-- /Information - Col 2 -->
          <div
            v-if="
              this.$store.state.AppActiveUser.user_type == 'super_admin' ||
              this.$store.state.AppActiveUser.user_type == 'subadmin'
            "
          >
            <div
              class="vx-col w-full flex"
              id="account-manage-buttons"
              v-if="event_data.created_by != current_user.id"
            >
              <vs-button
                v-if="!event_data.approved_by"
                type="border"
                color="success"
                icon-pack="feather"
                @click="ApproveEvent"
                >Approve Event</vs-button
              >
              <vs-button
                v-else
                disabled
                color="success"
                icon-pack="feather"
                icon="icon-check"
                >Event Approved</vs-button
              >
            </div>
            <div class="vx-col w-full flex" id="account-manage-buttons" v-else>
              <vs-button
                icon-pack="feather"
                icon="icon-edit"
                class="mr-4"
                :to="{
                  name: 'event-edit',
                  params: { eventId: this.$route.params.eventId },
                }"
                >Edit</vs-button
              >
              <vs-button
                type="border"
                color="danger"
                icon-pack="feather"
                icon="icon-trash"
                @click="confirmDeleteRecord"
                >Delete</vs-button
              >
            </div>
          </div>
        </div>
      </vx-card>
    </div>
  </div>
</template>

<script>
import moduleEventManagement from "@/store/event-management/moduleEventManagement.js";
import store from "./../../../../store/store";
export default {
  data() {
    return {
      event_data: null,
      event_not_found: false,
      current_user: store.state.AppActiveUser,
    };
  },
  computed: {},
  watch: {
    activeTab() {
      this.fetch_event_data(this.$route.params.eventId);
    },
  },
  methods: {
    confirmDeleteRecord() {
      this.$vs.dialog({
        type: "confirm",
        color: "danger",
        title: "Confirm Delete",
        text: `Are you sure you want to delete "${this.event_data.title}"?`,
        accept: this.deleteRecord,
        acceptText: "Delete",
      });
    },
    ApproveEvent() {
      this.$vs.dialog({
        type: "confirm",
        color: "success",
        title: "Confirm Approval",
        text: `Are you sure you want to approve "${this.event_data.title}"?`,
        accept: this.approveRecord,
        acceptText: "Approve",
      });
    },
    approveRecord() {
      this.$store
        .dispatch("eventManagement/approveEvent", this.event_data)
        .then(() => {
          this.showApproveSuccess();
          this.$router.push({
            path: `/event-detail/${this.$route.params.eventId}`,
          });
        })
        .catch((err) => {
          console.error(err);
        });
    },
    deleteRecord() {
      /* Below two lines are just for demo purpose */
      // this.$router.push({ name: "manage-users" });
      // this.showDeleteSuccess();

      /* UnComment below lines for enabling true flow if deleting user */
      this.$store
        .dispatch("eventManagement/removeEvent", this.event_data.id)
        .then(() => {
          this.$router.push({
            name: "manage-events",
          });
          this.showDeleteSuccess();
        })
        .catch((err) => {
          console.error(err);
        });
    },
    showDeleteSuccess() {
      this.$vs.notify({
        color: "success",
        title: "Event Deleted",
        text: "The selected event was successfully deleted",
      });
    },
    showApproveSuccess() {
      this.$vs.notify({
        color: "success",
        title: "Event Approved",
        text: "The selected event was successfully approved",
      });
    },
    fetch_event_data(eventId) {
      this.$store
        .dispatch("eventManagement/fetchEvent", eventId)
        .then((res) => {
          console.log("res", res);
          this.event_data = res.data.response;
          this.images = this.event_data.gallery
            ? this.event_data.gallery.split(",")
            : null;
        })
        .catch((err) => {
          if (err.response.status === 404) {
            this.event_not_found = true;
            return;
          }
          console.error(err);
        });
    },
  },
  created() {
    // Register Module UserManagement Module
    if (!moduleEventManagement.isRegistered) {
      this.$store.registerModule("eventManagement", moduleEventManagement);
      moduleEventManagement.isRegistered = true;
    }
    this.fetch_event_data(this.$route.params.eventId);
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