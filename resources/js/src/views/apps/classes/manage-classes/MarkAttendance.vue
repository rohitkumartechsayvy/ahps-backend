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
    <div id="user-data">
      <vx-card v-if="!attendance_marked" class="mb-base">
        <!-- <div class="vx-row" v-if="!is_incharge">
          <div class="vx-col w-full">
            <vs-alert color="danger">
              <span>You do not have rights to mark this attendance!</span>
            </vs-alert>
          </div>
        </div> -->
        <div>
          <!-- Avatar -->
          <div class="vx-row my-2">
            <vs-col vs-w="1" class="p-4 sm:p-2 font-semibold">ID</vs-col>
            <vs-col vs-w="2" class="p-4 sm:p-2 font-semibold"
              >Student Name</vs-col
            >
            <vs-col vs-w="1" class="p-4 sm:p-2 font-semibold">Present</vs-col>
            <vs-col vs-w="1" class="p-4 sm:p-2 font-semibold">Absent</vs-col>
            <vs-col vs-w="1" class="p-4 sm:p-2 font-semibold">Leave</vs-col>
            <vs-col vs-w="1" class="p-4 sm:p-2 font-semibold"
              >Half Day Leave</vs-col
            >
          </div>
          <div class="vx-row">
            <div
              class="vx-col w-full"
              v-for="(item, index) in studentsData"
              :key="index"
            >
              <div class="vx-row my-2 py-3">
                <vs-col vs-w="1" class="p-4 sm:p-2">
                  <div class="flex items-center">
                    <h6 class="pl-2">{{ item.id }}</h6>
                  </div>
                </vs-col>
                <vs-col vs-w="2" class="p-4 sm:p-2">
                  <div class="flex items-center">
                    <vs-avatar
                      size="40px"
                      class="m-0 flex-shrink-0"
                      :src="
                        item.profile_picture
                          ? item.profile_picture
                          : require(`@assets/images/logo/placeholder.jpg`)
                      "
                    />
                    <h6 class="pl-2">{{ item.name }}</h6>
                  </div>
                </vs-col>
                <vs-col vs-w="1" class="p-4 sm:p-2">
                  <vs-radio
                    type="radio"
                    :color="'success'"
                    :vs-name="`attendance_array[${item.id}]`"
                    v-model="attendance_array[item.id]"
                    vs-value="present"
                  ></vs-radio>
                </vs-col>
                <vs-col vs-w="1" class="p-4 sm:p-2">
                  <vs-radio
                    type="radio"
                    :color="'danger'"
                    :vs-name="`attendance_array[${item.id}]`"
                    v-model="attendance_array[item.id]"
                    vs-value="absent"
                  />
                </vs-col>
                <vs-col vs-w="1" class="p-4 sm:p-2">
                  <vs-radio
                    type="radio"
                    :color="'warning'"
                    :vs-name="`attendance_array[${item.id}]`"
                    v-model="attendance_array[item.id]"
                    vs-value="leave"
                  />
                </vs-col>
                <vs-col vs-w="1" class="p-4 sm:p-2">
                  <vs-radio
                    type="radio"
                    :color="'primary'"
                    :vs-name="`attendance_array[${item.id}]`"
                    v-model="attendance_array[item.id]"
                    vs-value="half_day"
                  />
                </vs-col>
              </div>
              <div
                class="vx-row"
                v-if="index != Object.keys(studentsData).length - 1"
              >
                <div class="vx-col w-full">
                  <hr class="w-full" />
                </div>
              </div>
              <div class="vx-row" v-else>
                <div class="vx-col w-full">
                  <vs-button :color="'success'" @click="markAllPresent"
                    >Mark All Present</vs-button
                  >
                  <vs-button :color="'danger'" @click="markAllAbsent"
                    >Mark All Absent</vs-button
                  >
                  <vs-button
                    :color="'success'"
                    class="float-right"
                    @click="submitAtt"
                    >Update Attendance</vs-button
                  >
                </div>
              </div>
            </div>
          </div>
        </div>
      </vx-card>
      <vx-card v-else>
        <div class="vx-row">
          <div class="vx-col w-full">
            <vs-alert color="danger">
              <span>Today's Attendance Already Marked!</span>
            </vs-alert>
          </div>
        </div>
      </vx-card>
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
        >
        </ag-grid-vue>

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
import Present from "./attendance-cell-renderer/Present.vue";
import CellRendererName from "./attendance-cell-renderer/CellRendererName.vue";
import Absent from "./attendance-cell-renderer/Absent.vue";
import HalfDay from "./attendance-cell-renderer/HalfDay.vue";
import Leave from "./attendance-cell-renderer/Leave.vue";
import flatPickr from "vue-flatpickr-component";
import "flatpickr/dist/flatpickr.css";
export default {
  components: {
    AgGridVue,
    vSelect,
    flatPickr,
    // Cell Renderer
    Present,
    CellRendererName,
    Absent,
    HalfDay,
    Leave,
  },
  data() {
    return {
      all: false,
      selected_data: [],
      attendance_array: {},
      items: [
        { txt: "foo", val: 1 },
        { txt: "bar", val: 2 },
      ],
      comparisonvalue: 2,
      new_arr: [],
      attendance_data: [],
      class_data: null,
      is_incharge: false,
      attendance_marked: true,
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
          headerName: "Student Name",
          field: "name",
          filter: true,
          width: 210,
        },
        {
          headerName: "Present",
          field: "user_type",
          width: 150,
          cellRendererFramework: "Present",
        },
        {
          headerName: "Absent",
          field: "status",
          width: 150,
          cellRendererFramework: "Absent",
        },
        {
          headerName: "Half Day Leave",
          field: "transactions",
          width: 150,
          cellRendererFramework: "HalfDay",
        },
        {
          headerName: "Leave",
          field: "transactions",
          width: 150,
          cellRendererFramework: "Leave",
        },
      ],

      // Cell Renderer Components
      components: {
        Present,
        Absent,
        HalfDay,
        Leave,
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
    validAttendance() {
      console.log("gjhgjhj", this.attendance_array);
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
    checkAttendance() {
      let obj = {
        teacher_id: this.$store.state.AppActiveUser,
        class_id: this.$route.params.classId,
      };
      this.$store
        .dispatch("classManagement/checkAttendance", obj)
        .then((res) => {
          console.log(res.data.response);
          this.attendance_marked = res.data.response.attendance_marked;
          this.is_incharge = res.data.response.class_incharge;
        })
        .catch((err) => {
          console.error(err);
        });
    },
    markAllPresent() {
      let obj = {
        date: Math.round(+new Date() / 1000),
        class_id: this.$route.params.classId,
      };
      this.$store
        .dispatch("classManagement/markAllPresent", obj)
        .then((res) => {
          console.log(res.data.response);
          this.$router.push({
            path: `/class-detail/${this.$route.params.classId}`,
          });
          this.showSuccess();
        })
        .catch((err) => {
          console.error(err);
        });
    },
    markAllAbsent() {
      let obj = {
        date: Math.round(+new Date() / 1000),
        class_id: this.$route.params.classId,
      };
      this.$store
        .dispatch("classManagement/markAllAbsent", obj)
        .then((res) => {
          console.log(res.data.response);
          this.$router.push({
            path: `/class-detail/${this.$route.params.classId}`,
          });
          this.showSuccess();
        })
        .catch((err) => {
          console.error(err);
        });
    },
    submitAtt(student_id, status) {
      let obj = {
        attendance: this.attendance_array,
        date: Math.round(+new Date() / 1000),
        class_id: this.$route.params.classId,
      };
      this.$store
        .dispatch("classManagement/markAttendance", obj)
        .then((res) => {
          console.log(res.data.response);
          this.$router.push({
            path: `/class-detail/${this.$route.params.classId}`,
          });
          this.showSuccess();
        })
        .catch((err) => {
          console.error(err);
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
          this.$router.push({ name: "manage-users" });
          this.showSuccess();
        })
        .catch((err) => {
          console.error(err);
        });
    },
    showSuccess() {
      this.$vs.notify({
        color: "success",
        title: "Attendance Marked",
        text: "Attendance Marked Successfully!",
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
        this.attendance_data = res.data.response.map((subject) => ({
          id: `${subject.id}`,
          value: null,
        }));
      })
      .catch((err) => {
        if (err.response.status === 404) {
          this.class_not_found = true;
          return;
        }
        console.error(err);
      });
    this.checkAttendance();
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