<!-- =========================================================================================
  File Name: UserEdit.vue
  Description: User Edit Page
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
========================================================================================== -->

<template>
  <div id="page-class-edit">
    <vx-card>
      <div slot="no-body" class="tabs-container px-6 pt-6">
        <vs-tabs v-model="activeTab" class="tab-action-btn-fill-conatiner">
          <vs-tab
            label="Create Class Homework"
            icon-pack="feather"
            icon="icon-user"
          >
            <label class="vs-input--label">Choose Subject</label>
            <v-select
              v-model="subject_id"
              :clearable="false"
              :options="subjectData"
              v-validate="'required'"
              name="subject_id"
              :dir="$vs.rtl ? 'rtl' : 'ltr'"
            />
            <span
              class="text-danger text-sm"
              v-show="errors.has('subject_id')"
              >{{ errors.first("subject_id") }}</span
            >
            <div class="vx-row">
              <div class="vx-col lg:w-1/2">
                <vs-input
                  v-if="this.subject_id.value"
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
              <div class="vx-col lg:w-1/2">
                <vs-textarea
                  v-if="this.subject_id.value"
                  class="mt-4 w-full"
                  v-model="assignment_message"
                  @keyup.enter="assignment_message = ''"
                  placeholder="Assignment Message"
                ></vs-textarea>
                <span
                  class="text-danger text-sm"
                  v-show="errors.has('assignment_message')"
                  >{{ errors.first("assignment_message") }}</span
                >
              </div>
            </div>
            <div class="vx-row">
              <div class="vx-col w-full">
                <div class="mt-8 flex flex-wrap items-center justify-end">
                  <vs-button
                    class="ml-auto mt-2"
                    @click="save_changes"
                    :disabled="!validateForm"
                    >Save Changes</vs-button
                  >
                </div>
              </div>
            </div>

            <div class="vx-row">
              <div class="vx-col w-full p-5">
                <div class="flex flex-wrap items-center">
                  <!-- ITEMS PER PAGE -->
                  <div class="flex-grow">
                    <vs-dropdown vs-trigger-click class="cursor-pointer">
                      <div
                        class="p-4 border border-solid d-theme-border-grey-light rounded-full d-theme-dark-bg cursor-pointer flex items-center justify-between font-medium"
                      >
                        <span class="mr-2"
                          >{{
                            currentPage * paginationPageSize -
                            (paginationPageSize - 1)
                          }}
                          -
                          {{
                            syllabusData.length -
                              currentPage * paginationPageSize >
                            0
                              ? currentPage * paginationPageSize
                              : syllabusData.length
                          }}
                          of {{ syllabusData.length }}</span
                        >
                        <feather-icon
                          icon="ChevronDownIcon"
                          svgClasses="h-4 w-4"
                        />
                      </div>
                      <!-- <vs-button class="btn-drop" type="line" color="primary" icon-pack="feather" icon="icon-chevron-down"></vs-button> -->
                      <vs-dropdown-menu>
                        <vs-dropdown-item
                          @click="gridApi.paginationSetPageSize(10)"
                        >
                          <span>10</span>
                        </vs-dropdown-item>
                        <vs-dropdown-item
                          @click="gridApi.paginationSetPageSize(50)"
                        >
                          <span>50</span>
                        </vs-dropdown-item>
                        <vs-dropdown-item
                          @click="gridApi.paginationSetPageSize(100)"
                        >
                          <span>100</span>
                        </vs-dropdown-item>
                        <vs-dropdown-item
                          @click="gridApi.paginationSetPageSize(500)"
                        >
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
                      <feather-icon
                        icon="ChevronDownIcon"
                        svgClasses="h-4 w-4"
                      />
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
                <ag-grid-vue
                  ref="agGridTable"
                  :components="components"
                  :gridOptions="gridOptions"
                  class="ag-theme-material w-100 my-4 ag-grid-table"
                  :columnDefs="columnDefs"
                  :defaultColDef="defaultColDef"
                  :rowData="syllabusData"
                  rowSelection="multiple"
                  colResizeDefault="shift"
                  :animateRows="true"
                  :floatingFilter="true"
                  :pagination="true"
                  :paginationPageSize="paginationPageSize"
                  :suppressPaginationPanel="true"
                  :enableRtl="$vs.rtl"
                ></ag-grid-vue>

                <vs-pagination
                  :total="totalPages"
                  :max="7"
                  v-model="currentPage"
                />
              </div>
            </div>
          </vs-tab>
        </vs-tabs>
      </div>
    </vx-card>
  </div>
</template>

<script>
import { AgGridVue } from "ag-grid-vue";
import "@sass/vuexy/extraComponents/agGridStyleOverride.scss";
import SubjectEditTabAccount from "./SubjectEditTabAccount.vue";
import UploadAutomatic from "./UploadAutomatic.vue";
import flatPickr from "vue-flatpickr-component";
import "flatpickr/dist/flatpickr.css";
// Store Module
import "vue2-dropzone/dist/vue2Dropzone.min.css";
import moduleSubjectManagement from "@/store/subject-management/moduleSubjectManagement.js";
import moduleSyllabusManagement from "@/store/syllabus-management/moduleSyllabusManagement.js";
// Cell Renderer
import CellRendererLink from "./cell-renderer/CellRendererLink.vue";
import CellRendererName from "./cell-renderer/CellRendererName.vue";
import CellRendererStatus from "./cell-renderer/CellRendererStatus.vue";
import CellRendererVerified from "./cell-renderer/CellRendererVerified.vue";
import vSelect from "vue-select";
export default {
  components: {
    AgGridVue,
    // Cell Renderer
    CellRendererLink,
    CellRendererName,
    CellRendererStatus,
    CellRendererVerified,
    SubjectEditTabAccount,
    vSelect,
    flatPickr,
    UploadAutomatic,
  },
  data() {
    return {
      subject_data: null,
      subject_not_found: false,
      activeTab: 1,
      assignments_data: [],
      subject_id: {
        label: null,
        value: null,
      },
      assignment: null,
      assignment_message: null,
      image: [],
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
          field: "id",
          width: 125,
          filter: true,
          checkboxSelection: true,
          headerCheckboxSelectionFilteredOnly: true,
          headerCheckboxSelection: true,
        },
        {
          headerName: "Subject Name",
          field: "subject_name",
          filter: true,
          width: 210,
        },
        {
          headerName: "Homework",
          field: "assignment",
          width: 225,
          cellRendererFramework: "CellRendererStatus",
        },
        {
          headerName: "Message",
          field: "assignment_message",
          filter: true,
          width: 150,
        },
        {
          headerName: "Uploaded By",
          field: "uploaded_by",
          filter: true,
          width: 150,
        },
      ],

      // Cell Renderer Components
      components: {
        CellRendererLink,
        CellRendererName,
        CellRendererStatus,
        CellRendererVerified,
      },
    };
  },
  watch: {},
  computed: {
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
    syllabusData() {
      console.log(this.$store.state.syllabusManagement.assignments);
      this.assignments_data = this.$store.state.syllabusManagement.assignments;
      return this.$store.state.syllabusManagement.assignments;
    },
    subjectData() {
      console.log(
        "this.$store.state.subjectManagement.subjects",
        this.$store.state.subjectManagement.subjects
      );
      let subjects = this.$store.state.subjectManagement.subjects;
      return subjects.map((subject) => ({
        label: `${subject.subject_name}`,
        value: subject.subject_id,
      }));
    },
    validateForm() {
      if (!this.subject_id.value || !this.assignment_message) {
        return false;
      } else {
        return true;
      }
    },
    windowWidth() {
      return this.$store.state.windowWidth;
    },
    studentsData() {
      return this.$store.state.classManagement.class_students;
    },
  },
  methods: {
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
    onImageChange(e) {
      this.image = e.target.files[0];
      console.log("this.image", this.image);
    },
    fileAdded(res) {
      console.log("res", res);
    },
    uploadProgress(rtuploadProgress) {
      console.log("rtuploadProgress", rtuploadProgress);
    },
    fileAdded(res) {
      console.log("res", res);
    },
    save_changes() {
      if (this.image) {
        const formData = new FormData();
        formData.append("assignment", this.image);
        formData.append("subject_id", this.subject_id.value);
        formData.append("class_id", this.$route.params.classId);
        formData.append("assignment_message", this.assignment_message);
        formData.append("uploaded_by", this.$store.state.AppActiveUser.id);
        console.log("formData", formData);
        this.$store.dispatch("syllabusManagement/saveAssignment", formData);
      }
    },
    confirmDeleteRecord(syllabus_id) {
      this.$vs.dialog({
        type: "confirm",
        color: "danger",
        title: "Confirm Delete",
        text: `You are about to delete thsi syllabus`,
        accept: this.deleteRecord(syllabus_id),
        acceptText: "Delete",
      });
    },
    deleteRecord(syllabus_id) {
      /* Below two lines are just for demo purpose */
      this.$store
        .dispatch("syllabusManagement/removeRecord", syllabus_id)
        .then(() => {
          this.$store.dispatch(
            "syllabusManagement/fetchClassSyllabus",
            this.$route.params.classId
          );
          this.showDeleteSuccess();
        })
        .catch((err) => {
          console.error(err);
        });

      /* UnComment below lines for enabling true flow if deleting user */
      // this.$store.dispatch("userManagement/removeRecord", this.params.data.id)
      //   .then(()   => { this.showDeleteSuccess() })
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
    // Register Module subjectManagement Module
    if (!moduleSubjectManagement.isRegistered) {
      this.$store.registerModule("subjectManagement", moduleSubjectManagement);
      moduleSubjectManagement.isRegistered = true;
    }
    if (!moduleSyllabusManagement.isRegistered) {
      this.$store.registerModule(
        "syllabusManagement",
        moduleSyllabusManagement
      );
      moduleSyllabusManagement.isRegistered = true;
    }
    let obj = {
      classId: this.$route.params.classId,
      userId: this.$store.state.AppActiveUser.id,
    };
    this.$store.dispatch("subjectManagement/fetchTeacherSubjects", obj);
    this.$store.dispatch("syllabusManagement/fetchClassAssignments", obj);
  },
};
</script>
<style lang="scss">
.vs-table--not-data {
  display: none;
}
.vs__dropdown-menu {
  position: relative;
}
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
