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
        >Charges record with id: {{ $route.params.chargeId }} not found.
      </span>
      <span>
        <span>Check </span
        ><router-link
          :to="{ name: 'manage-tuition-fees' }"
          class="text-inherit underline"
          >All Charges</router-link
        >
      </span>
    </vs-alert>

    <div id="user-data" v-if="this.charge_data">
      <vx-card class="mb-base">
        <!-- Avatar -->
        <div class="vx-row">
          <div class="vx-col lg:w-1/2">
            <h3 class="mb-5">
              {{ this.charge_data.fee_details.title }} Charges per Class
            </h3>
            <div
              v-for="item in this.charge_data.fee_charges"
              :key="item.class_id"
              class="mb-base"
            >
              <vx-input-group>
                <template slot="prepend">
                  <div class="prepend-text bg-primary">
                    <span>{{ item.class_name }}</span>
                  </div>
                </template>
                <vs-input
                  v-validate="'required|numeric'"
                  placeholder="0.00"
                  class="w-full"
                  disabled
                  data-vv-validate-on="blur"
                  :value="item.monthly_fee"
                />
              </vx-input-group>
            </div>
            <div
              class="vx-col w-full flex"
              id="account-manage-buttons"
              v-if="
                this.$store.state.AppActiveUser.user_type == 'super_admin' ||
                this.$store.state.AppActiveUser.user_type == 'subadmin'
              "
            >
              <vs-button
                icon-pack="feather"
                icon="icon-edit"
                class="mr-4"
                :to="{
                  name: 'charges-edit',
                  params: { chargeId: $route.params.chargeId },
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
          <!-- /Information - Col 1 -->
        </div>
      </vx-card>
    </div>
  </div>
</template>

<script>
import moduleTuitionFeeManagement from "@/store/tuition-fee-management/moduleTuitionFeeManagement.js";

export default {
  data() {
    return {
      charge_data: null,
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
        text: `Are you sure you want to delete "${this.charge_data.fee_details.title}"?`,
        accept: this.deleteRecord,
        acceptText: "Delete",
      });
    },
    deleteRecord() {
      /* Below two lines are just for demo purpose */
      this.$store
        .dispatch(
          "tuitionFeeManagement/removeRecord",
          this.charge_data.fee_details.id
        )
        .then((res) => {
          this.$router.push({ name: "manage-tuition-fees" });
          this.showDeleteSuccess();
        })
        .catch((err) => {
          if (err.response.status === 404) {
            this.user_not_found = true;
            return;
          }
          console.error(err);
        });
    },
    showDeleteSuccess() {
      this.$vs.notify({
        color: "success",
        title: "Charges Deleted",
        text: "The selected charges was successfully deleted",
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

    const chargeId = this.$route.params.chargeId;
    this.$store
      .dispatch("tuitionFeeManagement/fetchCharge", chargeId)
      .then((res) => {
        this.charge_data = res.data.response;
        console.log("charge_data", this.charge_data);
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
