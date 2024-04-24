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
      :active.sync="assignment_not_found"
    >
      <span
        >Assignment record with id: {{ $route.params.assignmentId }} not found.
      </span>
      <span>
        <span>Check </span
        ><router-link
          :to="{ name: 'page-assignment-list' }"
          class="text-inherit underline"
          >All Assignments</router-link
        >
      </span>
    </vs-alert>

    <div id="user-data" v-if="this.assignment_data">
      <vx-card title="Assignment Details" class="mb-base">
        <!-- Avatar -->
        <div class="vx-row">
          <!-- Information - Col 1 -->
          <div class="vx-col flex-1" id="account-info-col-1">
            <table>
              <tr>
                <td class="font-semibold">Subject Name</td>
                <td>{{ this.assignment_data.subject_name }}</td>
              </tr>
              <tr>
                <td class="font-semibold">Uploaded By</td>
                <td>{{ this.assignment_data.uploaded_by }}</td>
              </tr>
              <tr>
                <td class="font-semibold">Uploaded On</td>
                <td>{{ this.assignment_data.uploaded_on }}</td>
              </tr>
              <tr>
                <td class="font-semibold">Instructions</td>
                <td>{{ this.assignment_data.assignment_message }}</td>
              </tr>
            </table>
          </div>
          <div
            class="vx-col flex-2"
            id="account-info-col-1"
            v-if="ActiveUserInfo.user_type == 'student'"
          >
            <vx-card v-if="this.assignment_submitted == 'false'">
              <div slot="no-body" class="tabs-container px-6 pt-6">
                <vs-tabs
                  v-model="activeTab"
                  class="tab-action-btn-fill-conatiner"
                >
                  <vs-tab
                    label="Submit Assignments"
                    icon-pack="feather"
                    icon="icon-user"
                  >
                    <div class="vx-row">
                      <div class="vx-col w-full">
                        <vs-input
                          v-on:change="onImageChange"
                          class="mt-4 w-full"
                          v-model="assignment"
                          type="file"
                          :name="`assignment`"
                          :dir="$vs.rtl ? 'rtl' : 'ltr'"
                        />
                        <span
                          class="text-danger text-sm"
                          v-show="errors.has('assignment')"
                          >{{ errors.first("assignment") }}</span
                        >
                      </div>
                    </div>
                    <div class="vx-row">
                      <div class="vx-col w-full">
                        <div
                          class="mt-8 flex flex-wrap items-center justify-end"
                        >
                          <vs-button
                            class="ml-auto mt-2"
                            @click="save_changes"
                            :disabled="!validateForm"
                            >Save Changes</vs-button
                          >
                        </div>
                      </div>
                    </div>
                  </vs-tab>
                </vs-tabs>
              </div>
            </vx-card>

            <vx-card v-else>
              <div slot="no-body" class="tabs-container px-6 pt-6">
                <vs-tabs
                  v-model="activeTab"
                  class="tab-action-btn-fill-conatiner"
                >
                  <vs-tab
                    label="Your Submitted Assignment"
                    icon-pack="feather"
                    icon="icon-user"
                  >
                    <div class="vx-row">
                      <div class="vx-col w-full">
                        <a
                          v-if="this.submitted_data.submitted_assignment"
                          :href="`/${this.submitted_data.submitted_assignment}`"
                          class="text-center"
                          download
                        >
                          <vs-button type="filled">
                            <feather-icon
                              icon="DownloadIcon"
                              svgClasses="w-5 h-5"
                            />
                            Download
                          </vs-button>
                        </a>
                      </div>
                    </div>
                  </vs-tab>
                </vs-tabs>
              </div>
            </vx-card>
          </div>
          <div class="vx-col w-full" id="account-info-col-1" v-else>
            <div class="vx-row">
              <!-- Information - Col 1 -->
              <div class="vx-col w-full" id="account-info-col-1">
                <h4 class="my-3 text-success">
                  Students with Submitted Assignments ({{
                    this.assignment_data.submitted_students.length
                  }})
                </h4>
                <vs-table
                  v-if="this.assignment_data.submitted_students.length > 0"
                >
                  <template slot="thead">
                    <vs-th class="font-semibold">Student ID</vs-th>
                    <vs-th class="font-semibold">Student Name</vs-th>
                    <vs-th class="font-semibold">Assignment</vs-th>
                    <vs-th class="font-semibold">Submitted On</vs-th>
                  </template>
                  <vs-tr
                    v-for="(item, index) in this.assignment_data
                      .submitted_students"
                    :key="index"
                  >
                    <vs-td>{{ item.id }}</vs-td>
                    <vs-td>{{ item.name }}</vs-td>
                    <vs-td
                      ><a
                        v-if="item.submitted_assignment"
                        :href="item.submitted_assignment"
                        class="text-center"
                        target="_blank"
                      >
                        <vs-button type="filled">
                          <feather-icon icon="EyeIcon" svgClasses="w-5 h-5">
                            View
                          </feather-icon>
                        </vs-button>
                      </a>
                    </vs-td>
                    <vs-td>{{ item.submitted_on }}</vs-td>
                  </vs-tr>
                </vs-table>
                <div v-else>
                  <h4>No Students have submitted their assignments yet!</h4>
                </div>
              </div>
            </div>
            <div class="vx-row">
              <div class="vx-col w-full mt-4" id="account-info-col-1">
                <h4 class="my-3 text-danger">
                  Students with Pending Assignments ({{
                    this.assignment_data.pending_students.length
                  }})
                </h4>
                <vs-table
                  v-if="this.assignment_data.pending_students.length > 0"
                >
                  <template slot="thead">
                    <vs-th class="font-semibold">Student ID</vs-th>
                    <vs-th class="font-semibold">Student Name</vs-th>
                  </template>
                  <vs-tr
                    v-for="(item2, index2) in this.assignment_data
                      .pending_students"
                    :key="index2"
                  >
                    <vs-td>{{ item2.id }}</vs-td>
                    <vs-td>{{ item2.name }}</vs-td>
                  </vs-tr>
                </vs-table>
                <div v-else>
                  <h4>No Students are pending with assignments!</h4>
                </div>
              </div>
            </div>
          </div>
          <!-- /Information - Col 1 -->
        </div>
      </vx-card>
    </div>
  </div>
</template>

<script>
import moduleAssignmentManagement from "@/store/assignment-management/moduleAssignmentManagement.js";

export default {
  data() {
    return {
      assignment_data: null,
      assignment_not_found: false,
      assignment: null,
      assignment_submitted: "false",
      submitted_data: null,
      activeTab: 1,
    };
  },
  computed: {
    ActiveUserInfo() {
      console.log(
        "this.$store.state.AppActiveUser",
        this.$store.state.AppActiveUser
      );
      return this.$store.state.AppActiveUser;
    },
    validateForm() {
      if (!this.assignment) {
        return false;
      } else {
        return true;
      }
    },
    checkAssignment() {},
  },
  methods: {
    onImageChange(e) {
      this.image = e.target.files[0];
      console.log("this.image", this.image);
    },
    // checkAssignment() {
    //   let obj = {
    //     assignment_id: this.$route.params.assignmentId,
    //     student_id: ActiveUserInfo.id,
    //   };
    //   this.$store
    //     .dispatch("assignmentManagement/checkAssignment", obj)
    //     .then((res) => {
    //       console.log("assignment res", res);
    //       if (
    //         res &&
    //         res.data.message.errors &&
    //         res.data.message.errors.length > 0
    //       ) {
    //         this.assignment_submitted = false;
    //       } else {
    //         if (res.data.response) {
    //           this.assignment_submitted = true;
    //         } else {
    //           this.assignment_submitted = false;
    //         }
    //       }
    //     })
    //     .catch((err) => {
    //       console.error(err);
    //     });
    // },
    save_changes() {
      if (this.image) {
        const formData = new FormData();
        formData.append("submitted_assignment", this.image);
        formData.append("assignment_id", this.$route.params.assignmentId);
        formData.append("student_id", this.$store.state.AppActiveUser.id);
        console.log("formData", formData);
        this.$store
          .dispatch("assignmentManagement/submitAssignment", formData)
          .then((res) => {
            if (
              res &&
              res.data.message.errors &&
              res.data.message.errors.length > 0
            ) {
              this.$vs.loading.close();
              this.$vs.notify({
                title: "Error",
                text: res.data.message.errors,
                iconPack: "feather",
                icon: "icon-alert-circle",
                color: "danger",
              });
            } else {
              this.$vs.loading.close();
              this.$vs.notify({
                color: "success",
                title: "Assignment Uploaded Successfully!",
                text: res.data.message,
              });
              let obj = {
                classId: this.$route.params.classId,
                userId: this.$store.state.AppActiveUser.id,
              };
              this.$store.dispatch(
                "syllabusManagement/fetchClassAssignments",
                obj
              );
            }
          })
          .catch((err) => {
            console.error(err);
          });
      }
    },
    confirmDeleteRecord() {
      this.$vs.dialog({
        type: "confirm",
        color: "danger",
        title: "Confirm Delete",
        text: `You are about to delete "${this.assignment_data.from}" - "${this.assignment_data.to}"`,
        accept: this.deleteRecord,
        acceptText: "Delete",
      });
    },
    deleteRecord() {
      /* Below two lines are just for demo purpose */
      this.$router.push({ name: "app-assignment-list" });
      this.showDeleteSuccess();

      /* UnComment below lines for enabling true flow if deleting user */
      // this.$store.dispatch("assignmentManagement/removeRecord", this.assignment_data.id)
      //   .then(()   => { this.$router.push({name:'app-user-list'}); this.showDeleteSuccess() })
      //   .catch(err => { console.error(err)       })
    },
    showDeleteSuccess() {
      this.$vs.notify({
        color: "success",
        title: "Assignment Deleted",
        text: "The selected assignment was successfully deleted",
      });
    },
  },
  created() {
    // Register Module assignmentManagement Module
    if (!moduleAssignmentManagement.isRegistered) {
      this.$store.registerModule(
        "assignmentManagement",
        moduleAssignmentManagement
      );
      moduleAssignmentManagement.isRegistered = true;
    }

    const assignmentId = this.$route.params.assignmentId;
    this.$store
      .dispatch("assignmentManagement/fetchAssignment", assignmentId)
      .then((res) => {
        this.assignment_data = res.data.response;
        console.log("assignment_data", this.assignment_data);
      })
      .catch((err) => {
        // if (err.response.status === 404) {
        //   this.assignment_not_found = true;
        //   return;
        // }
        console.error(err);
      });

    let obj = {
      assignment_id: this.$route.params.assignmentId,
      student_id: this.$store.state.AppActiveUser.id,
    };
    this.$store
      .dispatch("assignmentManagement/checkAssignment", obj)
      .then((res) => {
        console.log("res res", res);
        if (
          res &&
          res.data.message.errors &&
          res.data.message.errors.length > 0
        ) {
          this.assignment_submitted = "false";
        } else {
          if (res.data.response) {
            this.submitted_data = res.data.response;
            this.assignment_submitted = "true";
          } else {
            this.assignment_submitted = "false";
          }
        }
      })
      .catch((err) => {
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
.vs-table--not-data {
  display: none;
}
</style>
