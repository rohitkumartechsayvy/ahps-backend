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
      :active.sync="syllabus_not_found"
    >
      <span
        >Syllabus record with id: {{ $route.params.syllabusId }} not found.
      </span>
      <span>
        <span>Check </span
        ><router-link
          :to="{ name: 'page-syllabus-list' }"
          class="text-inherit underline"
          >All Syllabuss</router-link
        >
      </span>
    </vs-alert>

    <div id="user-data" v-if="this.syllabus_data">
      <vx-card title="Syllabus Details" class="mb-base">
        <!-- Avatar -->
        <div class="vx-row">
          <!-- Information - Col 1 -->
          <div class="vx-col flex-1" id="account-info-col-1">
            <table>
              <tr>
                <td class="font-semibold">From</td>
                <td>{{ this.syllabus_data.from }}</td>
              </tr>
              <tr>
                <td class="font-semibold">To</td>
                <td>{{ this.syllabus_data.to }}</td>
              </tr>
              <tr>
                <td class="font-semibold">Status</td>
                <td>{{ this.syllabus_data.syllabus_status }}</td>
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
import moduleSyllabusManagement from "@/store/syllabus-management/moduleSyllabusManagement.js";

export default {
  data() {
    return {
      syllabus_data: null,
      syllabus_not_found: false,
    };
  },
  computed: {},
  methods: {
    confirmDeleteRecord() {
      this.$vs.dialog({
        type: "confirm",
        color: "danger",
        title: "Confirm Delete",
        text: `You are about to delete "${this.syllabus_data.from}" - "${this.syllabus_data.to}"`,
        accept: this.deleteRecord,
        acceptText: "Delete",
      });
    },
    deleteRecord() {
      /* Below two lines are just for demo purpose */
      this.$router.push({ name: "app-syllabus-list" });
      this.showDeleteSuccess();

      /* UnComment below lines for enabling true flow if deleting user */
      // this.$store.dispatch("syllabusManagement/removeRecord", this.syllabus_data.id)
      //   .then(()   => { this.$router.push({name:'app-user-list'}); this.showDeleteSuccess() })
      //   .catch(err => { console.error(err)       })
    },
    showDeleteSuccess() {
      this.$vs.notify({
        color: "success",
        title: "Syllabus Deleted",
        text: "The selected syllabus was successfully deleted",
      });
    },
  },
  created() {
    // Register Module syllabusManagement Module
    if (!moduleSyllabusManagement.isRegistered) {
      this.$store.registerModule(
        "syllabusManagement",
        moduleSyllabusManagement
      );
      moduleSyllabusManagement.isRegistered = true;
    }

    const syllabusId = this.$route.params.syllabusId;
    this.$store
      .dispatch("syllabusManagement/fetchSyllabus", syllabusId)
      .then((res) => {
        this.syllabus_data = res.data.response;
        console.log("syllabus_data", this.syllabus_data);
      })
      .catch((err) => {
        // if (err.response.status === 404) {
        //   this.syllabus_not_found = true;
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
