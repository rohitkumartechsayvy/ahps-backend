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
      title="No Students!"
      v-if="studentsData.length == 0"
    >
      <span>No Students Yet Registered in this Class.</span>
    </vs-alert>

    <div id="user-data" v-if="studentsData.length > 0">
      <vx-card title="Class" class="mb-base">
        <!-- Avatar -->
        <div class="vx-row">
          <!-- Information - Col 1 -->
          <div class="vx-col flex-1" id="account-info-col-1">
            <vs-table class="bordered" stripe>
              <template slot="thead" class="bg-primary" border>
                <vs-td class="text-center font-semibold"
                  ><h5 class="py-3">#ID</h5></vs-td
                >
                <vs-td class="text-center font-semibold">
                  <h5 class="py-3 font-semibold">Name</h5>
                </vs-td>
                <vs-td class="text-center font-semibold">
                  <h5 class="py-3 font-semibold">Father Name</h5>
                </vs-td>
                <vs-td class="text-center font-semibold">
                  <h5 class="py-3 font-semibold">Report Card</h5>
                </vs-td>
              </template>
              <template>
                <vs-tr v-for="(student, index) in studentsData" :key="index">
                  <vs-td class="text-center py-5 align-middle font-semibold">
                    {{ student.id }}
                  </vs-td>
                  <vs-td class="text-center py-5 align-middle">
                    {{ student.name }}
                  </vs-td>
                  <vs-td class="text-center py-5 align-middle">
                    {{ student.father_name }}
                  </vs-td>
                  <vs-td class="text-center py-5 align-middle text-success">
                    <router-link
                      :to="`/report-card/${student.id}`"
                      v-if="student.report_genrated == 0"
                    >
                      <feather-icon
                        icon="EditIcon"
                        color="success"
                        svgClasses="h-4 w-4"
                      ></feather-icon>
                    </router-link>
                    <router-link
                      :to="`/download-report-card/${exam_id}/${student.id}`"
                      v-else
                    >
                      <vs-button
                        class="mb-base mx-auto"
                        icon-pack="feather"
                        icon="icon icon-file"
                        >Print</vs-button
                      >
                    </router-link>
                  </vs-td>
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
import moduleClassManagement from "@/store/class-management/moduleClassManagement.js";
import CellRendererLink from "./../../students/manage-students/cell-renderer/CellRendererLink.vue";
import CellRendererName from "./../../students/manage-students/cell-renderer/CellRendererName.vue";
import CellRendererStatus from "./../../students/manage-students/cell-renderer/CellRendererStatus.vue";
import CellRendererVerified from "./../../students/manage-students/cell-renderer/CellRendererVerified.vue";
import CellRendererActions from "./../../students/manage-students/cell-renderer/CellRendererActions.vue";
import flatPickr from "vue-flatpickr-component";
import "flatpickr/dist/flatpickr.css";
export default {
  components: {
    AgGridVue,
    vSelect,
    flatPickr,
    // Cell Renderer
    CellRendererLink,
    CellRendererName,
    CellRendererStatus,
    CellRendererVerified,
    CellRendererActions,
  },
  data() {
    return {
      exam_id: null,
      attendance_data: [],
      class_data: null,
      class_not_found: false,
      // Filter Options
      roleFilter: { label: "All", value: "all" },
      roleOptions: [
        { label: "All", value: "all" },
        { label: "Admin", value: "admin" },
        { label: "User", value: "user" },
      ],
      attendance_date: "",
      statusFilter: { label: "All", value: "all" },
      statusOptions: [
        { label: "All", value: "all" },
        { label: "Active", value: "active" },
        { label: "Inactive", value: "Inactive" },
        { label: "Blocked", value: "blocked" },
      ],

      isVerifiedFilter: { label: "All", value: "all" },
      isVerifiedOptions: [
        { label: "All", value: "all" },
        { label: "Yes", value: "yes" },
        { label: "No", value: "no" },
      ],

      departmentFilter: { label: "All", value: "all" },
      departmentOptions: [
        { label: "All", value: "all" },
        { label: "Sales", value: "sales" },
        { label: "Development", value: "development" },
        { label: "Management", value: "management" },
      ],

      searchQuery: "",

      // AgGrid
      gridApi: null,
      gridOptions: {},
      defaultColDef: {
        sortable: true,
        resizable: true,
        suppressMenu: true,
      },
      activePromptAddEvent: false,
      columnDefs: [
        {
          headerName: "ID",
          field: "user_id",
          width: 125,
          filter: true,
          checkboxSelection: true,
          headerCheckboxSelectionFilteredOnly: true,
          headerCheckboxSelection: true,
        },
        {
          headerName: "Name",
          field: "name",
          filter: true,
          width: 210,
          cellRendererFramework: "CellRendererLink",
        },
        {
          headerName: "Email",
          field: "email",
          filter: true,
          width: 225,
        },
        {
          headerName: "Role",
          field: "user_type",
          filter: true,
          width: 150,
          cellRendererFramework: "CellRendererStatus",
        },
        {
          headerName: "Status",
          field: "status",
          filter: true,
          width: 150,
          cellRendererFramework: "CellRendererStatus",
        },
        {
          headerName: "Blocked",
          field: "is_blocked",
          filter: true,
          width: 150,
        },
      ],

      // Cell Renderer Components
      components: {
        CellRendererLink,
        CellRendererStatus,
        CellRendererVerified,
        CellRendererActions,
      },
    };
  },
  mounted() {
    this.gridApi = this.gridOptions.api;

    /* =================================================================
      NOTE:
      Header is not aligned properly in RTL version of agGrid table.
      However, we given fix to this issue. If you want more robust solution please contact them at gitHub
    ================================================================= */
    if (this.$vs.rtl) {
      const header = this.$refs.agGridTable.$el.querySelector(
        ".ag-header-container"
      );
      header.style.left = `-${String(
        Number(header.style.transform.slice(11, -3)) + 9
      )}px`;
    }
  },
  computed: {
    validForm() {
      return this.attendance_date !== "" && this.attendance_date !== null;
    },
    studentsData() {
      return this.$store.state.classManagement.class_students;
    },
    paginationPageSize() {
      if (this.gridApi) return this.gridApi.paginationGetPageSize();
      else return 10;
    },
    totalPages() {
      if (this.gridApi) return this.gridApi.paginationGetTotalPages();
      else return 0;
    },
    currentPage: {
      get() {
        if (this.gridApi) return this.gridApi.paginationGetCurrentPage() + 1;
        else return 1;
      },
      set(val) {
        this.gridApi.paginationGoToPage(val - 1);
      },
    },
  },
  methods: {
    printInvoice() {
      window.print();
    },
    confirmDeleteRecord() {
      this.$vs.dialog({
        type: "confirm",
        color: "danger",
        title: "Confirm Delete",
        text: `Are you sure you want to delete "${this.class_data.class_name}"?`,
        accept: this.deleteRecord,
        acceptText: "Delete",
      });
    },
    openAddNewEvent() {
      this.activePromptAddEvent = true;
    },
    deleteRecord() {
      /* Below two lines are just for demo purpose */
      // this.$router.push({ name: "manage-users" });
      // this.showDeleteSuccess();

      /* UnComment below lines for enabling true flow if deleting user */
      this.$store
        .dispatch("classManagement/removeRecord", this.class_data.id)
        .then(() => {
          this.$router.push({ name: "/manage-classes" });
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

      // Reset Filter Options
      this.roleFilter = this.statusFilter = this.isVerifiedFilter = this.departmentFilter = {
        label: "All",
        value: "all",
      };

      this.$refs.filterCard.removeRefreshAnimation();
    },
    updateSearchQuery(val) {
      this.gridApi.setQuickFilter(val);
    },
    fetchAttendance() {
      console.log("attendance date", this.attendance_date);
      let attObj = {
        date: this.attendance_date,
        class_id: this.$route.params.classId,
      };
      this.$store
        .dispatch("classManagement/fetchAttendance", attObj)
        .then((res) => {
          console.log(res.data.response);
          this.attendance_data = res.data.response;
        })
        .catch((err) => {
          if (err.response.status === 404) {
            this.class_not_found = true;
            return;
          }
          console.error(err);
        });
    },
  },
  created() {
    // Register Module UserManagement Module
    if (!moduleClassManagement.isRegistered) {
      this.$store.registerModule("classManagement", moduleClassManagement);
      moduleClassManagement.isRegistered = true;
    }
    this.exam_id = this.$route.params.examId;
    const classId = this.$route.params.classId;
    this.$store
      .dispatch("classManagement/fetchClass", classId)
      .then((res) => {
        console.log(res.data.response);
        this.class_data = res.data.response;
      })
      .catch((err) => {
        if (err.response.status === 404) {
          this.class_not_found = true;
          return;
        }
        console.error(err);
      });
    this.$store
      .dispatch("classManagement/fetchClassStudents", classId)
      .then((res) => {
        console.log(res.data.response);
      })
      .catch((err) => {
        if (err.response.status === 404) {
          this.class_not_found = true;
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
.vs-table--not-data {
  display: none;
}
</style>