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
    <div id="user-data" v-if="user_data">
      <vx-card title="Fee Details" class="mb-base">
        <!-- Avatar -->
        <div class="vx-row">
          <!-- Avatar Col -->
          <div class="vx-col w-full">
            <h3 class="mb-4">
              {{ this.$store.state.AppActiveUser.name }}'s Joining Year: 2020
            </h3>
            <vs-table>
              <template slot="thead">
                <vs-th class="font-semibold">Fee Year</vs-th>
                <vs-th class="font-semibold">Fee Month</vs-th>
                <vs-th class="font-semibold">Amount</vs-th>
                <vs-th class="font-semibold">Fee Status</vs-th>
                <vs-th class="font-semibold">Actions</vs-th>
                <vs-th class="font-semibold">Payment Mode</vs-th>
              </template>
              <vs-tr>
                <vs-td>2020</vs-td>
                <vs-td>November</vs-td>
                <vs-td>1,200</vs-td>
                <vs-td>
                  <vs-chip :color="'success'" class="product-order-status"
                    >Paid</vs-chip
                  >
                </vs-td>
                <vs-td>NA</vs-td>
                <vs-td>Cash</vs-td>
              </vs-tr>
              <vs-tr>
                <vs-td>2020</vs-td>
                <vs-td>December</vs-td>
                <vs-td>1,200</vs-td>
                <vs-td>
                  <vs-chip :color="'success'" class="product-order-status"
                    >Paid</vs-chip
                  >
                </vs-td>
                <vs-td>NA</vs-td>
                <vs-td>Phonpe</vs-td>
              </vs-tr>
              <vs-tr>
                <vs-td>2020</vs-td>
                <vs-td>December</vs-td>
                <vs-td>1,200</vs-td>
                <vs-td>
                  <vs-chip :color="'danger'" class="product-order-status"
                    >Pending</vs-chip
                  >
                </vs-td>
                <vs-td>
                  <vs-button
                    v-if="
                      this.$store.state.AppActiveUser.user_type == 'student'
                    "
                    type="border"
                    :color="'success'"
                    >Make Payment</vs-button
                  >
                </vs-td>
                <vs-td>-</vs-td>
              </vs-tr>
            </vs-table>
          </div>
        </div>
      </vx-card>
    </div>
  </div>
</template>

<script>
import moduleUserManagement from "@/store/user-management/moduleUserManagement.js";
import store from "./../../../store/store";
export default {
  data() {
    return {
      user_data: null,
      user_not_found: false,
    };
  },
  computed: {
    userAddress() {
      let str = "";
      for (const field in this.user_data.location) {
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
        text: `You are about to delete "${this.user_data.username}"`,
        accept: this.deleteRecord,
        acceptText: "Delete",
      });
    },
    deleteRecord() {
      /* Below two lines are just for demo purpose */
      this.$router.push({ name: "app-user-list" });
      this.showDeleteSuccess();

      /* UnComment below lines for enabling true flow if deleting user */
      // this.$store.dispatch("userManagement/removeRecord", this.user_data.id)
      //   .then(()   => { this.$router.push({name:'app-user-list'}); this.showDeleteSuccess() })
      //   .catch(err => { console.error(err)       })
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
    // Register Module UserManagement Module
    if (!moduleUserManagement.isRegistered) {
      this.$store.registerModule("userManagement", moduleUserManagement);
      moduleUserManagement.isRegistered = true;
    }

    const userId = this.$route.params.userId;
    this.$store
      .dispatch("userManagement/fetchUser", userId)
      .then((res) => {
        this.user_data = res.data;
      })
      .catch((err) => {
        if (err.response.status === 404) {
          this.user_not_found = true;
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
