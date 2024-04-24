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
      title="Class Not Found"
      :active.sync="class_not_found"
    >
      <span>Class record with id: {{ $route.params.id }} not found.</span>
    </vs-alert>

    <div id="user-data" v-if="class_data">
      <vx-card title="Class" class="mb-base">
        <!-- Avatar -->
        <div class="vx-row">
          <!-- Information - Col 1 -->
          <div class="vx-col flex-1" id="account-info-col-1">
            <table>
              <tr>
                <td class="font-semibold">Class Name</td>
                <td>{{ class_data.class_name }}</td>
              </tr>
            </table>
            <router-link
              :to="{ path: `/class-attendance/${this.$route.params.classId}` }"
            >
              <vs-button
                icon-pack="feather"
                icon="icon-chevrons-right"
                :color="'success'"
                icon-after
                class="shadow-md w-25 lg:mt-0 mt-4"
                >View Class Attendance</vs-button
              >
            </router-link>
            <router-link
              :to="{ path: `/mark-attendance/${this.$route.params.classId}` }"
              v-if="class_data.incharge == this.$store.state.AppActiveUser.id"
            >
              <vs-button
                icon-pack="feather"
                icon="icon-chevrons-right"
                :color="'success'"
                icon-after
                class="mt-4 shadow-md w-25"
                >Mark Today's Attendance</vs-button
              >
            </router-link>
            <router-link
              :to="{ path: `/subject-marks/${this.$route.params.classId}` }"
              v-if="
                class_data.incharge == this.$store.state.AppActiveUser.id ||
                this.$store.state.AppActiveUser.user_type == 'super_admin' ||
                this.$store.state.AppActiveUser.user_type == 'subadmin'
              "
            >
              <vs-button
                icon-pack="feather"
                icon="icon-chevrons-right"
                :color="'success'"
                icon-after
                class="mt-4 shadow-md w-25"
                >View Class Subjects</vs-button
              >
            </router-link>
            <router-link
              :to="{ path: `/subject-syllabus/${this.$route.params.classId}` }"
            >
              <vs-button
                icon-pack="feather"
                icon="icon-chevrons-right"
                :color="'success'"
                icon-after
                class="mt-4 shadow-md w-25"
                >View Subject Syllabus</vs-button
              >
            </router-link>
            <router-link
              :to="{ path: `/class-assignments/${this.$route.params.classId}` }"
            >
              <vs-button
                icon-pack="feather"
                icon="icon-chevrons-right"
                :color="'success'"
                icon-after
                class="mt-4 shadow-md w-25"
                >View Class Homework</vs-button
              >
            </router-link>
          </div>
          <!-- /Information - Col 1 -->
          <!-- /Information - Col 2 -->
          <div
            class="vx-col w-full flex mt-5"
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
                name: 'class-edit',
                params: { classId: $route.params.classId },
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
      <vs-prompt
        class="calendar-event-dialog"
        title="Choose Date"
        @accept="fetchAttendance"
        accept-text="Proceed"
        :is-valid="validForm"
        :active.sync="activePromptAddEvent"
      >
        <flat-pickr
          v-model="attendance_date"
          :config="{ dateFormat: 'Y-m-d', maxDate: new Date() }"
          class="w-full"
          v-validate="'required'"
          name="attendance_date"
        />
      </vs-prompt>
      <div class="vx-card p-6">
        <div class="flex flex-wrap items-center">
          <!-- ITEMS PER PAGE -->
          <div class="flex-grow">
            <vs-dropdown vs-trigger-click class="cursor-pointer">
              <div
                class="p-4 border border-solid d-theme-border-grey-light rounded-full d-theme-dark-bg cursor-pointer flex items-center justify-between font-medium"
              >
                <span class="mr-2"
                  >{{
                    currentPage * paginationPageSize - (paginationPageSize - 1)
                  }}
                  -
                  {{
                    studentsData.length - currentPage * paginationPageSize > 0
                      ? currentPage * paginationPageSize
                      : studentsData.length
                  }}
                  of {{ studentsData.length }}</span
                >
                <feather-icon icon="ChevronDownIcon" svgClasses="h-4 w-4" />
              </div>
              <!-- <vs-button class="btn-drop" type="line" color="primary" icon-pack="feather" icon="icon-chevron-down"></vs-button> -->
              <vs-dropdown-menu>
                <vs-dropdown-item @click="gridApi.paginationSetPageSize(10)">
                  <span>10</span>
                </vs-dropdown-item>
                <vs-dropdown-item @click="gridApi.paginationSetPageSize(50)">
                  <span>50</span>
                </vs-dropdown-item>
                <vs-dropdown-item @click="gridApi.paginationSetPageSize(100)">
                  <span>100</span>
                </vs-dropdown-item>
                <vs-dropdown-item @click="gridApi.paginationSetPageSize(500)">
                  <span>500</span>
                </vs-dropdown-item>
              </vs-dropdown-menu>
            </vs-dropdown>
          </div>

          <!-- TABLE ACTION COL-2: SEARCH & EXPORT AS CSV -->
          <vs-input
            class="sm:mr-4 mr-0 sm:w-auto w-full sm:order-normal order-3 sm:mt-0 mt-4"
            v-model="searchQuery"
            @input="updateSearchQuery"
            placeholder="Search..."
          />
          <!-- <vs-button class="mb-4 md:mb-0" @click="gridApi.exportDataAsCsv()">Export as CSV</vs-button> -->

          <!-- ACTION - DROPDOWN -->
          <vs-dropdown vs-trigger-click class="cursor-pointer">
            <div
              class="p-3 shadow-drop rounded-lg d-theme-dark-light-bg cursor-pointer flex items-end justify-center text-lg font-medium w-32"
            >
              <span class="mr-2 leading-none">Actions</span>
              <feather-icon icon="ChevronDownIcon" svgClasses="h-4 w-4" />
            </div>

            <vs-dropdown-menu>
              <vs-dropdown-item>
                <span class="flex items-center">
                  <feather-icon
                    icon="TrashIcon"
                    svgClasses="h-4 w-4"
                    class="mr-2"
                  />
                  <span>Delete</span>
                </span>
              </vs-dropdown-item>

              <vs-dropdown-item>
                <span class="flex items-center">
                  <feather-icon
                    icon="ArchiveIcon"
                    svgClasses="h-4 w-4"
                    class="mr-2"
                  />
                  <span>Archive</span>
                </span>
              </vs-dropdown-item>

              <vs-dropdown-item>
                <span class="flex items-center">
                  <feather-icon
                    icon="FileIcon"
                    svgClasses="h-4 w-4"
                    class="mr-2"
                  />
                  <span>Print</span>
                </span>
              </vs-dropdown-item>

              <vs-dropdown-item>
                <span class="flex items-center">
                  <feather-icon
                    icon="SaveIcon"
                    svgClasses="h-4 w-4"
                    class="mr-2"
                  />
                  <span>CSV</span>
                </span>
              </vs-dropdown-item>
            </vs-dropdown-menu>
          </vs-dropdown>
        </div>
        <!-- AgGrid Table -->
        <ag-grid-vue
          ref="agGridTable"
          :components="components"
          :gridOptions="gridOptions"
          class="ag-theme-material w-100 my-4 ag-grid-table"
          :columnDefs="columnDefs"
          :defaultColDef="defaultColDef"
          :rowData="studentsData"
          rowSelection="multiple"
          colResizeDefault="shift"
          :animateRows="true"
          :floatingFilter="true"
          :pagination="true"
          :paginationPageSize="paginationPageSize"
          :suppressPaginationPanel="true"
          :enableRtl="$vs.rtl"
        ></ag-grid-vue>

        <vs-pagination :total="totalPages" :max="7" v-model="currentPage" />
      </div>
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
      else return 500;
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
</style>