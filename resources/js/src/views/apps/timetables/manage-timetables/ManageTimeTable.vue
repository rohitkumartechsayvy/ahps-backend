<!-- =========================================================================================
  File Name: UserList.vue
  Description: User List page
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
========================================================================================== -->

<template>
  <div id="page-user-list">
    <vx-card
      ref="filterCard"
      title="Filters"
      class="user-list-filters mb-8"
      actionButtons
      @refresh="resetColFilters"
      @remove="resetColFilters"
    >
      <div class="vx-row">
        <div class="vx-col md:w-1/4 sm:w-1/2 w-full">
          <label class="text-sm opacity-75">Class</label>
          <v-select
            :options="class_data"
            :clearable="false"
            :dir="$vs.rtl ? 'rtl' : 'ltr'"
            v-model="classFilter"
            class="mb-4 md:mb-0"
          />
        </div>
        <div class="vx-col md:w-1/4 sm:w-1/2 w-full">
          <label class="text-sm opacity-75">Teacher</label>
          <v-select
            :options="teacher_data"
            :clearable="false"
            :dir="$vs.rtl ? 'rtl' : 'ltr'"
            v-model="teacherFilter"
            class="mb-4 md:mb-0"
          />
        </div>
        <div class="vx-col md:w-1/4 sm:w-1/2 w-full">
          <label class="text-sm opacity-75">Subject</label>
          <v-select
            :options="subject_data"
            :clearable="false"
            :dir="$vs.rtl ? 'rtl' : 'ltr'"
            v-model="subjectFilter"
            class="mb-4 sm:mb-0"
          />
        </div>
        <div class="vx-col md:w-1/4 sm:w-1/2 w-full">
          <label class="text-sm opacity-75">Day</label>
          <v-select
            :options="day_data"
            :clearable="false"
            :dir="$vs.rtl ? 'rtl' : 'ltr'"
            v-model="dayFilter"
            class="mb-4 sm:mb-0"
          />
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
                  timetableData.length - currentPage * paginationPageSize > 0
                    ? currentPage * paginationPageSize
                    : timetableData.length
                }}
                of {{ timetableData.length }}</span
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
        :rowData="timetableData"
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
</template>

<script>
import { AgGridVue } from "ag-grid-vue";
import "@sass/vuexy/extraComponents/agGridStyleOverride.scss";
import vSelect from "vue-select";
import moduleClassManagement from "@/store/class-management/moduleClassManagement.js";
import moduleStudentManagement from "@/store/student-management/moduleStudentManagement.js";
import moduleSubjectManagement from "@/store/subject-management/moduleSubjectManagement.js";
// Store Module
import moduleTimeTableManagement from "@/store/timetable-management/moduleTimeTableManagement.js";

// Cell Renderer
import CellRendererLink from "./cell-renderer/CellRendererLink.vue";
import CellRendererName from "./cell-renderer/CellRendererName.vue";
import CellRendererStatus from "./cell-renderer/CellRendererStatus.vue";
import CellRendererVerified from "./cell-renderer/CellRendererVerified.vue";
import CellRendererActions from "./cell-renderer/CellRendererActions.vue";

export default {
  components: {
    AgGridVue,
    vSelect,

    // Cell Renderer
    CellRendererLink,
    CellRendererName,
    CellRendererStatus,
    CellRendererVerified,
    CellRendererActions,
  },
  data() {
    return {
      // Filter Options
      classFilter: { label: "All", value: "all" },
      classOptions: this.class_data,

      teacherFilter: { label: "All", value: "all" },
      teacherOptions: this.teacher_data,

      subjectFilter: { label: "All", value: "all" },
      subjectOptions: [],

      dayFilter: { label: "All", value: "all" },
      dayOptions: [],

      roleFilter: { label: "All", value: "all" },
      roleOptions: [
        { label: "All", value: "all" },
        { label: "Admin", value: "admin" },
        { label: "User", value: "user" },
      ],

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
      teacher_data: [],
      subject_data: [],
      class_data: [],
      day_data: [],
      hour_data: [],
      searchQuery: "",

      // AgGrid
      gridApi: null,
      gridOptions: {},
      defaultColDef: {
        sortable: true,
        resizable: true,
        suppressMenu: true,
      },
      columnDefs: [
        {
          headerName: "ID",
          field: "id",
          width: 125,
          filter: true,
          checkboxSelection: true,
          headerCheckboxSelectionFilteredOnly: true,
          headerCheckboxSelection: true,
        },
        {
          headerName: "Class",
          field: "class_name",
          filter: true,
          width: 210,
          cellRendererFramework: "CellRendererLink",
        },
        {
          headerName: "Actions",
          field: "transactions",
          width: 150,
          cellRendererFramework: "CellRendererActions",
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
  watch: {
    classFilter(obj) {
      this.setColumnFilter("class_name", obj.label);
    },
    subjectFilter(obj) {
      this.setColumnFilter("subject_name", obj.label);
    },
    teacherFilter(obj) {
      this.setColumnFilter("name", obj.label);
    },
    dayFilter(obj) {
      this.setColumnFilter("day", obj.label);
    },
  },
  computed: {
    timetableData() {
      console.log(this.$store.state.classManagement.classes);
      return this.$store.state.classManagement.classes;
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
    setColumnFilter(column, val) {
      console.log(column, val);
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
      this.classFilter = this.subjectFilter = this.teacherFilter = this.dayFilter = {
        label: "",
        value: "",
      };

      this.$refs.filterCard.removeRefreshAnimation();
    },
    updateSearchQuery(val) {
      this.gridApi.setQuickFilter(val);
    },
    teachersData() {
      this.$store
        .dispatch("studentManagement/fetchTeachers")
        .then((res) => {
          console.log("res.data.response", res.data.response);
          this.teacher_data = res.data.response.map((user) => ({
            label: `${user.name}`,
            value: user.user_id,
          }));
        })
        .catch((err) => {
          console.error(err);
        });
    },
    subjectsData() {
      this.$store
        .dispatch("subjectManagement/fetchSubjects")
        .then((res) => {
          console.log("subjecr.response", res.data.response);
          this.subject_data = res.data.response.map((subject) => ({
            label: `${subject.subject_name}`,
            value: subject.id,
          }));
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
          console.log("res.data.response", res.data.response);
          this.day_data = res.data.response.map((day) => ({
            label: `${day.day}`,
            value: day.id,
          }));
        })
        .catch((err) => {
          console.error(err);
        });
    },
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
  created() {
    if (!moduleTimeTableManagement.isRegistered) {
      this.$store.registerModule(
        "timetableManagement",
        moduleTimeTableManagement
      );
      moduleTimeTableManagement.isRegistered = true;
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
    this.$store.dispatch("timetableManagement/fetchTimetables").catch((err) => {
      console.error(err);
    });
    this.teachersData();
    this.classData();
    this.subjectsData();
    this.hourData();
    this.dayData();
  },
};
</script>

<style lang="scss">
#page-user-list {
  .user-list-filters {
    .vs__actions {
      position: absolute;
      right: 0;
      top: 50%;
      transform: translateY(-58%);
    }
  }
}
</style>
