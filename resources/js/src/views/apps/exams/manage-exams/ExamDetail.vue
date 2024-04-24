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
      :active.sync="exam_not_found"
    >
      <span>Exam record with id: {{ $route.params.examId }} not found. </span>
      <span>
        <span>Check </span
        ><router-link
          :to="{ name: 'page-exam-list' }"
          class="text-inherit underline"
          >All Exams</router-link
        >
      </span>
    </vs-alert>

    <div id="user-data" v-if="this.exam_data">
      <vx-card title="Exam Details" class="mb-base">
        <!-- Avatar -->
        <div class="vx-row">
          <!-- Information - Col 1 -->
          <div class="vx-col flex-1" id="account-info-col-1">
            <table>
              <tr>
                <td class="font-semibold">Exam Title</td>
                <td>{{ this.exam_data.exam_title }}</td>
              </tr>
              <tr>
                <td class="font-semibold">Exam Type</td>
                <td>
                  <span class="text-capitalize">{{
                    this.exam_data.exam_type
                  }}</span>
                </td>
              </tr>
              <tr>
                <td class="font-semibold">Exam Month</td>
                <td>
                  <span class="text-capitalize">{{
                    this.exam_data.exam_month
                  }}</span>
                </td>
              </tr>
              <tr>
                <td class="font-semibold">Status</td>
                <td>{{ this.exam_data.exam_status }}</td>
              </tr>
            </table>

            <vs-table class="bordered" stripe>
              <template slot="thead" class="bg-primary" border>
                <vs-td class="text-center font-semibold"
                  ><h5 class="py-3">Class</h5></vs-td
                >
                <vs-td class="text-center font-semibold">
                  <h5 class="py-3 font-semibold">Subjects</h5>
                </vs-td>
                <vs-td class="text-center font-semibold">
                  <h5 class="py-3 font-semibold">Class Incharge</h5>
                </vs-td>
                <vs-td class="text-center font-semibold">
                  <h5 class="py-3 font-semibold">Actions</h5>
                </vs-td>
              </template>
              <template v-if="activeUserInfo.user_type == 'teacher'">
                <vs-tr v-for="(subjectMark, index) in classesData" :key="index">
                  <template v-if="subjectMark.incharge_id == activeUserInfo.id">
                    <vs-td class="text-center py-5 align-middle font-semibold">
                      {{ subjectMark.class_name }}
                    </vs-td>
                    <vs-td class="text-center py-5 align-middle">
                      <vs-list>
                        <vs-list-item
                          v-for="(listItem, index) in subjectMark.subjects"
                          :key="index"
                          :title="listItem.subject_name"
                        ></vs-list-item>
                      </vs-list>
                    </vs-td>
                    <vs-td class="text-center py-5 align-middle">
                      {{ subjectMark.class_incharge }}
                    </vs-td>
                    <vs-td class="text-center py-5 align-middle text-success">
                      <router-link
                        :to="`/exam-students/${exam_data.id}/${subjectMark.id}`"
                      >
                        <feather-icon
                          icon="EyeIcon"
                          color="success"
                          svgClasses="h-4 w-4"
                        ></feather-icon>
                      </router-link>
                    </vs-td>
                  </template>
                </vs-tr>
              </template>
              <template v-else>
                <vs-tr v-for="(subjectMark, index) in classesData" :key="index">
                  <template>
                    <vs-td class="text-center py-5 align-middle font-semibold">
                      {{ subjectMark.class_name }}
                    </vs-td>
                    <vs-td class="text-center py-5 align-middle">
                      <vs-list>
                        <vs-list-item
                          v-for="(listItem, index) in subjectMark.subjects"
                          :key="index"
                          :title="listItem.subject_name"
                        ></vs-list-item>
                      </vs-list>
                    </vs-td>
                    <vs-td class="text-center py-5 align-middle">
                      {{ subjectMark.class_incharge }}
                    </vs-td>
                    <vs-td class="text-center py-5 align-middle text-success">
                      <router-link
                        :to="`/exam-students/${exam_data.id}/${subjectMark.id}`"
                      >
                        <feather-icon
                          icon="EyeIcon"
                          color="success"
                          svgClasses="h-4 w-4"
                        ></feather-icon>
                      </router-link>
                    </vs-td>
                  </template>
                </vs-tr>
              </template>
            </vs-table>
          </div>
          <!-- /Information - Col 1 -->
        </div>
      </vx-card>
    </div>
  </div>
</template>

<script>
import { AgGridVue } from "ag-grid-vue";
import "@sass/vuexy/extraComponents/agGridStyleOverride.scss";
import vSelect from "vue-select";
import moduleExamManagement from "@/store/exam-management/moduleExamManagement.js";
import moduleClassManagement from "@/store/class-management/moduleClassManagement.js";
import CellRendererClassActions from "./cell-renderer/CellRendererClassActions.vue";
import VxCard from "../../../../components/vx-card/VxCard.vue";
export default {
  components: { VxCard, AgGridVue, CellRendererClassActions },
  data() {
    return {
      searchQuery: "",
      exam_data: null,
      class_data: [],
      exam_not_found: false,
    };
  },
  computed: {
    classesData() {
      console.log(
        "this.$store.state.classManagement.classes",
        this.$store.state.classManagement.classes
      );
      return { ...this.$store.state.classManagement.classes };
    },
    activeUserInfo() {
      console.log(
        "this.$store.state.AppActievUser",
        this.$store.state.AppActiveUser
      );
      return this.$store.state.AppActiveUser;
    },
  },
  methods: {
    classData() {
      if (this.$store.state.AppActiveUser.user_type == "teacher") {
        this.$store
          .dispatch("classManagement/fetchAssignedClasses")
          .then((res) => {
            console.log("classes", res.data.response);
            this.class_data = res.data.response.map((class_data) => ({
              label: `${class_data.class_name}`,
              value: class_data.id,
            }));
          })
          .catch((err) => {
            console.error(err);
          });
      } else {
        this.$store
          .dispatch("classManagement/fetchClasses")
          .then((res) => {
            console.log("classes", res.data.response);
            this.class_data = res.data.response.map((class_data) => ({
              label: `${class_data.class_name}`,
              value: class_data.id,
            }));
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
        text: `You are about to delete "${this.exam_data.from}" - "${this.exam_data.to}"`,
        accept: this.deleteRecord,
        acceptText: "Delete",
      });
    },
    deleteRecord() {
      /* Below two lines are just for demo purpose */
      this.$router.push({ name: "app-exam-list" });
      this.showDeleteSuccess();

      /* UnComment below lines for enabling true flow if deleting user */
      // this.$store.dispatch("examManagement/removeRecord", this.exam_data.id)
      //   .then(()   => { this.$router.push({name:'app-user-list'}); this.showDeleteSuccess() })
      //   .catch(err => { console.error(err)       })
    },
    showDeleteSuccess() {
      this.$vs.notify({
        color: "success",
        title: "Exam Deleted",
        text: "The selected exam was successfully deleted",
      });
    },
    setColumnFilter(column, val) {
      const filter = this.gridApi.getFilterInstance(column);
      let modelObj = null;

      if (val !== "all") {
        modelObj = { type: "equals", filter: val };
      }

      filter.setModel(modelObj);
      this.gridApi.onFilterChanged();
    },
    resetColFilters() {
      // Reset Grid Filter
      this.gridApi.setFilterModel(null);
      this.gridApi.onFilterChanged();
      this.$refs.filterCard.removeRefreshAnimation();
    },
    updateSearchQuery(val) {
      this.gridApi.setQuickFilter(val);
    },
  },
  created() {
    // Register Module examManagement Module
    if (!moduleExamManagement.isRegistered) {
      this.$store.registerModule("examManagement", moduleExamManagement);
      moduleExamManagement.isRegistered = true;
    }
    if (!moduleClassManagement.isRegistered) {
      this.$store.registerModule("classManagement", moduleClassManagement);
      moduleClassManagement.isRegistered = true;
    }
    // if (this.$store.state.AppActiveUser.user_type == "teacher") {
    //   this.$store
    //     .dispatch("classManagement/fetchAssignedClasses")
    //     .catch((err) => {
    //       console.error(err);
    //     });
    // } else {
    this.$store.dispatch("classManagement/fetchClasses").catch((err) => {
      console.error(err);
    });
    // }

    const examId = this.$route.params.examId;
    this.$store
      .dispatch("examManagement/fetchExam", examId)
      .then((res) => {
        this.exam_data = res.data.response;
        console.log("exam_data", this.exam_data);
      })
      .catch((err) => {
        console.error(err);
      });
    this.classData();
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
.vs-table--not-data {
  display: none;
}
</style>
