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
      <span>Student record with id: {{ $route.params.id }} not found.</span>
      <span>
        <span>Check</span>
      </span>
    </vs-alert>

    <div id="user-data" v-if="student_data">
      <vx-card title="Account" class="mb-base">
        <!-- Avatar -->
        <div class="vx-row">
          <!-- Avatar Col -->
          <div class="vx-col" id="avatar-col">
            <div class="img-container mb-4">
              <img
                :src="
                  student_data.profile_picture
                    ? student_data.profile_picture
                    : require(`@assets/images/logo/placeholder.jpg`)
                "
                class="rounded w-full"
              />
            </div>
          </div>

          <!-- Information - Col 1 -->
          <div class="vx-col flex-1" id="account-info-col-1">
            <table>
              <tr>
                <td class="font-semibold">Name</td>
                <td>{{ student_data.name }}</td>
              </tr>
              <tr>
                <td class="font-semibold">Email</td>
                <td>{{ student_data.email }}</td>
              </tr>
              <tr>
                <td class="font-semibold">Phone Number</td>
                <td>
                  {{
                    student_data.phone_number ? student_data.phone_number : "-"
                  }}
                </td>
              </tr>
              <tr>
                <td class="font-semibold">Father Name</td>
                <td>
                  {{
                    student_data.father_name ? student_data.father_name : "-"
                  }}
                </td>
              </tr>
              <tr>
                <td class="font-semibold">Mother Name</td>
                <td>
                  {{
                    student_data.mother_name ? student_data.mother_name : "-"
                  }}
                </td>
              </tr>
              <tr>
                <td class="font-semibold">Address</td>
                <td>
                  {{ student_data.address ? student_data.address : "-" }}
                </td>
              </tr>
              <tr>
                <td class="font-semibold">Date of Birth</td>
                <td>
                  {{ student_data.dob ? student_data.dob : "-" }}
                </td>
              </tr>
              <tr>
                <td class="font-semibold">Gender</td>
                <td>
                  {{
                    student_data.gender.label ? student_data.gender.label : "-"
                  }}
                </td>
              </tr>
              <tr>
                <td class="font-semibold">Nationality</td>
                <td>
                  {{
                    student_data.nationality ? student_data.nationality : "-"
                  }}
                </td>
              </tr>
              <tr>
                <td class="font-semibold">Category</td>
                <td>
                  {{
                    student_data.category
                      ? student_data.category == 1
                        ? "General"
                        : student_data.category == 2
                        ? "OBC"
                        : student_data.category == 3
                        ? "SC"
                        : "ST"
                      : "-"
                  }}
                </td>
              </tr>
              <tr>
                <td class="font-semibold">Guardian</td>
                <td>
                  {{ student_data.guardian ? student_data.guardian : "-" }}
                </td>
              </tr>
              <tr>
                <td class="font-semibold">Relation with guardian if any</td>
                <td>
                  {{ student_data.relation ? student_data.relation : "-" }}
                </td>
              </tr>
              <tr>
                <td class="font-semibold">Parent/Guardian Occupation</td>
                <td>
                  {{ student_data.occupation ? student_data.occupation : "-" }}
                </td>
              </tr>
              <tr>
                <td class="font-semibold">Adhaar Card</td>
                <td>
                  {{
                    student_data.adhaar_card ? student_data.adhaar_card : "-"
                  }}
                </td>
              </tr>
            </table>
            <router-link
              :to="{
                path: `/student-attendance/${student_data.id}`,
              }"
            >
              <vs-button
                icon-pack="feather"
                icon="icon-chevrons-right"
                icon-after
                class="shadow-md w-25 lg:mt-0 my-4"
              >
                View Student Attendance
              </vs-button>
            </router-link>
          </div>
          <!-- /Information - Col 1 -->

          <!-- Information - Col 2 -->
          <div class="vx-col flex-1" id="account-info-col-2">
            <table>
              <tr>
                <td class="font-semibold">Status</td>
                <td>{{ student_data.status }}</td>
              </tr>
              <tr>
                <td class="font-semibold">Role</td>
                <td>{{ student_data.user_type }}</td>
              </tr>
              <tr>
                <td class="font-semibold">Block Status</td>
                <td>{{ student_data.is_blocked }}</td>
              </tr>
              <tr>
                <td class="font-semibold">Current Class</td>
                <td>
                  {{
                    student_data.current_class_name
                      ? student_data.current_class_name
                      : "-"
                  }}
                </td>
              </tr>
              <tr>
                <td class="font-semibold">Admission Number</td>
                <td>
                  {{
                    student_data.admission_no ? student_data.admission_no : "-"
                  }}
                </td>
              </tr>
              <tr>
                <td class="font-semibold">Roll No.</td>
                <td>
                  {{ student_data.roll_no ? `#${student_data.roll_no}` : "-" }}
                </td>
              </tr>
              <tr>
                <td class="font-semibold">Joining Date</td>
                <td>
                  {{
                    student_data.joining_date ? student_data.joining_date : "-"
                  }}
                </td>
              </tr>
              <tr>
                <td class="font-semibold">Last School</td>
                <td>
                  {{
                    student_data.last_school ? student_data.last_school : "-"
                  }}
                </td>
              </tr>
              <tr>
                <td class="font-semibold">Transfer Certificate Received?</td>
                <td>
                  {{
                    student_data.transfer_certificate
                      ? student_data.transfer_certificate.label
                      : "-"
                  }}
                </td>
              </tr>
              <tr>
                <td class="font-semibold">Migration Certificate Received?</td>
                <td>
                  {{
                    student_data.migration_certificate
                      ? student_data.migration_certificate.label
                      : "-"
                  }}
                </td>
              </tr>
              <tr>
                <td class="font-semibold">Birth Certificate Received?</td>
                <td>
                  {{
                    student_data.birth_certificate
                      ? student_data.birth_certificate.label
                      : "-"
                  }}
                </td>
              </tr>
              <tr>
                <td class="font-semibold">Marksheet Received?</td>
                <td>
                  {{
                    student_data.marksheet_certificate
                      ? student_data.marksheet_certificate.label
                      : "-"
                  }}
                </td>
              </tr>
              <tr>
                <td class="font-semibold">Adhaar Card Received?</td>
                <td>
                  {{
                    student_data.adhaar_card_certificate
                      ? student_data.adhaar_card_certificate.label
                      : "-"
                  }}
                </td>
              </tr>
            </table>
            <router-link
              :to="{
                path: `/fee-details/${student_data.id}`,
              }"
            >
              <vs-button
                icon-pack="feather"
                icon="icon-chevrons-right"
                icon-after
                class="shadow-md w-25 lg:mt-0 my-4"
                >View Student's Fee Details</vs-button
              ></router-link
            >
          </div>
          <!-- /Information - Col 2 -->
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
                name: 'student-edit',
                params: { studentId: $route.params.studentId },
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
      </vx-card>
    </div>
  </div>
</template>

<script>
import moduleStudentManagement from "@/store/student-management/moduleStudentManagement.js";
export default {
  data() {
    return {
      student_data: null,
      user_not_found: false,
    };
  },
  computed: {
    userAddress() {
      let str = "";
      for (const field in this.student_data.location) {
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
        text: `Are you sure you want to delete "${this.student_data.name}"?`,
        accept: this.deleteRecord,
        acceptText: "Delete",
      });
    },
    deleteRecord() {
      /* Below two lines are just for demo purpose */
      // this.$router.push({ name: "manage-users" });
      // this.showDeleteSuccess();
      console.log("this.student_data", this.student_data);
      /* UnComment below lines for enabling true flow if deleting user */
      this.$store
        .dispatch("studentManagement/removeRecord", this.student_data.id)
        .then(() => {
          this.$router.push({ name: "manage-students" });
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
    // Register Module UserManagement Module
    if (!moduleStudentManagement.isRegistered) {
      this.$store.registerModule("studentManagement", moduleStudentManagement);
      moduleStudentManagement.isRegistered = true;
    }

    const studentId = this.$route.params.studentId;
    this.$store
      .dispatch("studentManagement/fetchStudent", studentId)
      .then((res) => {
        console.log(res.data.response);
        this.student_data = res.data.response;
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