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
      :active.sync="user_not_found"
    >
      <span
        >Teacher record with id: {{ $route.params.teacherId }} not found.
      </span>
      <span>
        <span>Check </span
        ><router-link
          :to="{ name: 'manage-teachers' }"
          class="text-inherit underline"
          >All Teachers</router-link
        >
      </span>
    </vs-alert>

    <div id="user-data">
      <vx-card title="Time Table" class="mb-base">
        <!-- Avatar -->
        <div class="vx-row">
          <vx-card code-toggler>
            <br />

            <vs-table stripe>
              <!-- <template slot="thead">
                <vs-th>Interval</vs-th>
                <vs-th :key="indextr" v-for="(tr, indextr) in day_data">
                  <vs-td>
                    {{ indextr }}
                    {{ tr.label }}
                  </vs-td>
                </vs-th>
              </template> -->

              <template>
                <vs-th :key="indextr3" v-for="(tr3, indextr3) in day_data">
                  <vs-td>
                    {{ tr3.label }}
                  </vs-td>
                </vs-th>
                <vs-tr :key="indextr" v-for="(tr, indextr) in hour_data">
                  <vs-td :key="indextr2" v-for="(tr2, indextr2) in day_data">
                    <span>
                      {{ tr.label ? tr.label : "-" }}
                      {{ getRecord(tr.value, tr2.value) }}
                    </span>
                  </vs-td>
                </vs-tr>
              </template>
            </vs-table>
          </vx-card>
        </div>
      </vx-card>
    </div>
  </div>
</template>

<script>
import moduleUserManagement from "@/store/user-management/moduleUserManagement.js";
import moduleClassManagement from "@/store/class-management/moduleClassManagement.js";
import moduleStudentManagement from "@/store/student-management/moduleStudentManagement.js";
import moduleSubjectManagement from "@/store/subject-management/moduleSubjectManagement.js";
import moduleTimeTableManagement from "@/store/timetable-management/moduleTimeTableManagement.js";
export default {
  data() {
    return {
      user_data: null,
      user_not_found: false,
      teacher_data: [],
      subject_data: [],
      class_data: [],
      day_data: [],
      hour_data: [],
      record: [],
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
    getRecord(hour_id, day_id) {
      let obj = {
        hour_id: hour_id,
        day_id: day_id,
        teacher_id: this.$route.params.teacherId,
      };
      this.$store
        .dispatch("timetableManagement/getRecord", obj)
        .then((res) => {
          console.log("timetableManagement/createTimeTable", res.data.response);
          this.record = res.data.response;
        })
        .catch((err) => {
          console.error(err);
        });
    },
    hourData() {
      this.$store
        .dispatch("timetableManagement/fetchHours")
        .then((res) => {
          console.log("res.data.response", res.data.response);
          this.hour_data = res.data.response.map((hour) => ({
            label: `${hour.from} - ${hour.to}`,
            value: hour.id,
          }));
        })
        .catch((err) => {
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
    dayData() {
      this.$store
        .dispatch("timetableManagement/fetchDays")
        .then((res) => {
          console.log("day_data", res.data.response);
          this.day_data = res.data.response.map((day) => ({
            label: `${day.day}`,
            value: day.id,
          }));
        })
        .catch((err) => {
          console.error(err);
        });
    },
    createTimeTable() {
      console.log(this.$route.params.teacherId);
      this.$store
        .dispatch(
          "timetableManagement/createTimeTable",
          this.$route.params.teacherId
        )
        .then((res) => {
          console.log("timetableManagement/createTimeTable", res.data.response);
          this.record = res.data.response;
        })
        .catch((err) => {
          console.error(err);
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
    if (!moduleStudentManagement.isRegistered) {
      this.$store.registerModule("studentManagement", moduleStudentManagement);
      moduleStudentManagement.isRegistered = true;
    }
    if (!moduleClassManagement.isRegistered) {
      this.$store.registerModule("classManagement", moduleClassManagement);
      moduleClassManagement.isRegistered = true;
    }
    if (!moduleSubjectManagement.isRegistered) {
      this.$store.registerModule("subjectManagement", moduleSubjectManagement);
      moduleSubjectManagement.isRegistered = true;
    }
    if (!moduleTimeTableManagement.isRegistered) {
      this.$store.registerModule(
        "timetableManagement",
        moduleTimeTableManagement
      );
      moduleTimeTableManagement.isRegistered = true;
    }
    this.hourData();
    this.dayData();
    this.createTimeTable();
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
