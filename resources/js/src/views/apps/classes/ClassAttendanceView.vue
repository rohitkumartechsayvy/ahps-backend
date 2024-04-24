<template>
  <div id="simple-calendar-app">
    <div class="vx-card no-scroll-content">
      <div class="vx-row">
        <div class="vx-col lg:w-1/2 p-5" v-if="this.attendance_data.length > 0">
          <div class="vx-col w-full">
            <h4 class="p-4">Class Attendance on {{ this.attendance_date }}</h4>
          </div>
          <div
            class="vx-row py-3 p-5"
            v-for="(item, index) in attendance_data"
            :key="index"
          >
            <div class="vx-col lg:w-1/3">
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
            </div>
            <div class="vx-col lg:w-1/5">
              <div class="flex items-center mt-4">
                <vs-radio
                  type="radio"
                  :color="'success'"
                  v-if="item.attendance_status == 'present'"
                />
                <vs-radio
                  type="radio"
                  :color="'danger'"
                  v-if="item.attendance_status == 'absent'"
                />
                <vs-radio
                  type="radio"
                  :color="'warning'"
                  v-if="item.attendance_status == 'leave'"
                />
                <vs-radio
                  type="radio"
                  :color="'primary'"
                  v-if="item.attendance_status == 'half_day'"
                />
              </div>
            </div>
          </div>
        </div>
        <div class="vx-col w-full p-5" v-else>
          <div class="vx-row">
            <div class="vx-col lg:w-1/3 p-5">
              <flat-pickr
                v-model="from_attendance"
                :config="{ dateFormat: 'Y-m-d', maxDate: new Date() }"
                class="w-full"
                v-validate="'required'"
                name="from_attendance"
              />
            </div>
            <div class="vx-col lg:w-1/3 p-5">
              <flat-pickr
                v-model="to_attendance"
                :config="{ dateFormat: 'Y-m-d', maxDate: new Date() }"
                class="w-full"
                v-validate="'required'"
                name="to_attendance"
              />
            </div>
            <div class="vx-col lg:w-1/3 p-5">
              <vs-button
                :color="'success'"
                class="w-full"
                @click="fetchAttendance"
                accept-text="Proceed"
              >
                Fetch Attendance
              </vs-button>
            </div>
          </div>
        </div>
      </div>
      <div class="vx-row">
        <div class="vx-col w-full p-5">
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

    <!-- ADD EVENT -->
    <vs-prompt
      class="calendar-event-dialog"
      title="Add Event"
      accept-text="Add Event"
      @accept="addEvent"
      :is-valid="validForm"
      :active.sync="activePromptAddEvent"
    >
      <div class="calendar__label-container flex">
        <vs-chip
          v-if="labelLocal != 'none'"
          class="text-white"
          :class="'bg-' + labelColor(labelLocal)"
          >{{ labelLocal }}</vs-chip
        >

        <vs-dropdown
          vs-custom-content
          vs-trigger-click
          class="ml-auto my-2 cursor-pointer"
        >
          <feather-icon
            icon="TagIcon"
            svgClasses="h-5 w-5"
            class="cursor-pointer"
            @click.prevent
          ></feather-icon>

          <vs-dropdown-menu style="z-index: 200001">
            <vs-dropdown-item
              v-for="(label, index) in calendarLabels"
              :key="index"
              @click="labelLocal = label.value"
            >
              <div
                class="h-3 w-3 inline-block rounded-full mr-2"
                :class="'bg-' + label.color"
              ></div>
              <span>{{ label.text }}</span>
            </vs-dropdown-item>

            <vs-dropdown-item @click="labelLocal = 'none'">
              <div
                class="h-3 w-3 mr-1 inline-block rounded-full mr-2 bg-primary"
              ></div>
              <span>None</span>
            </vs-dropdown-item>
          </vs-dropdown-menu>
        </vs-dropdown>
      </div>

      <vs-input
        name="event-name"
        v-validate="'required'"
        class="w-full"
        label-placeholder="Event Title"
        v-model="title"
      ></vs-input>
      <div class="my-4">
        <small class="date-label">Start Date</small>
        <datepicker
          :language="$vs.rtl ? langHe : langEn"
          name="start-date"
          v-model="startDate"
          :disabled="disabledFrom"
        ></datepicker>
      </div>
      <div class="my-4">
        <small class="date-label">End Date</small>
        <datepicker
          :language="$vs.rtl ? langHe : langEn"
          :disabledDates="disabledDatesTo"
          name="end-date"
          v-model="endDate"
        ></datepicker>
      </div>
      <vs-input
        name="event-url"
        v-validate="'url'"
        class="w-full mt-6"
        label-placeholder="Event URL"
        v-model="url"
        :color="!errors.has('event-url') ? 'success' : 'danger'"
      ></vs-input>
    </vs-prompt>

    <!-- EDIT EVENT -->
    <vs-prompt
      class="calendar-event-dialog"
      title="Edit Event"
      accept-text="Submit"
      cancel-text="Remove"
      button-cancel="border"
      @cancel="removeEvent"
      @accept="editEvent"
      :is-valid="validForm"
      :active.sync="activePromptEditEvent"
    >
      <div class="calendar__label-container flex">
        <vs-chip
          v-if="labelLocal != 'none'"
          class="text-white"
          :class="'bg-' + labelColor(labelLocal)"
          >{{ labelLocal }}</vs-chip
        >

        <vs-dropdown vs-custom-content class="ml-auto my-2 cursor-pointer">
          <feather-icon
            icon="TagIcon"
            svgClasses="h-5 w-5"
            @click.prevent
          ></feather-icon>

          <vs-dropdown-menu style="z-index: 200001">
            <vs-dropdown-item
              v-for="(label, index) in calendarLabels"
              :key="index"
              @click="labelLocal = label.value"
            >
              <div
                class="h-3 w-3 inline-block rounded-full mr-2"
                :class="'bg-' + label.color"
              ></div>
              <span>{{ label.text }}</span>
            </vs-dropdown-item>

            <vs-dropdown-item @click="labelLocal = 'none'">
              <div
                class="h-3 w-3 mr-1 inline-block rounded-full mr-2 bg-primary"
              ></div>
              <span>None</span>
            </vs-dropdown-item>
          </vs-dropdown-menu>
        </vs-dropdown>
      </div>

      <vs-input
        name="event-name"
        v-validate="'required'"
        class="w-full"
        label-placeholder="Event Title"
        v-model="title"
      ></vs-input>
      <div class="my-4">
        <small class="date-label">Start Date</small>
        <datepicker
          :language="$vs.rtl ? langHe : langEn"
          :disabledDates="disabledDatesFrom"
          name="start-date"
          v-model="startDate"
        ></datepicker>
      </div>
      <div class="my-4">
        <small class="date-label">End Date</small>
        <datepicker
          :language="$vs.rtl ? langHe : langEn"
          :disabledDates="disabledDatesTo"
          name="end-date"
          v-model="endDate"
        ></datepicker>
      </div>
      <vs-input
        name="event-url"
        v-validate="'url'"
        class="w-full mt-6"
        label-placeholder="Event URL"
        v-model="url"
        :color="!errors.has('event-url') ? 'success' : 'danger'"
      ></vs-input>
    </vs-prompt>
  </div>
</template>

<script>
import moduleClassManagement from "@/store/class-management/moduleClassManagement.js";
import { CalendarView, CalendarViewHeader } from "vue-simple-calendar";
import moduleCalendar from "@/store/calendar/moduleCalendar.js";
require("vue-simple-calendar/static/css/default.css");
import moment from "moment";
import { AgGridVue } from "ag-grid-vue";
import "@sass/vuexy/extraComponents/agGridStyleOverride.scss";
import Datepicker from "vuejs-datepicker";
import { en, he } from "vuejs-datepicker/src/locale";
import flatPickr from "vue-flatpickr-component";
import "flatpickr/dist/flatpickr.css";
import CellRendererLink from "./../students/manage-students/cell-renderer/CellRendererLink.vue";
import CellRendererName from "./../students/manage-students/cell-renderer/CellRendererName.vue";
import Present from "./manage-classes/cell-renderer/Present.vue";
import Absent from "./manage-classes/cell-renderer/Absent.vue";
import Leave from "./manage-classes/cell-renderer/Leave.vue";
import HalfDay from "./manage-classes/cell-renderer/HalfDay.vue";
import CellRendererVerified from "./../students/manage-students/cell-renderer/CellRendererVerified.vue";
import CellRendererActions from "./../students/manage-students/cell-renderer/CellRendererActions.vue";
export default {
  components: {
    AgGridVue,
    CalendarView,
    CalendarViewHeader,
    Datepicker,
    flatPickr,
    Present,
    Absent,
    Leave,
    HalfDay,
    CellRendererLink,
    CellRendererVerified,
    CellRendererActions,
  },
  data() {
    return {
      weekday: [1, 2, 3, 4, 5],
      showDate: new Date(),
      disabledFrom: false,
      from_attendance: moment(new Date()).format("YYYY-MM-DD"),
      to_attendance: moment(new Date()).format("YYYY-MM-DD"),
      attendance_date: moment(new Date()).format("YYYY-MM-DD"),
      attendance_data: [],
      id: 0,
      title: "",
      startDate: "",
      endDate: "",
      labelLocal: "none",
      present: 0,
      absent: 0,
      leave: 0,
      half_day: 0,
      langHe: he,
      langEn: en,

      url: "",
      calendarView: "month",

      activePromptAddEvent: false,
      activePromptEditEvent: false,

      calendarViewTypes: [
        {
          label: "Month",
          val: "month",
        },
        {
          label: "Week",
          val: "week",
        },
        {
          label: "Year",
          val: "year",
        },
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
          field: "student_id",
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
          headerName: "Total Days",
          field: "total",
          filter: true,
          width: 225,
        },
        {
          headerName: "Present",
          field: "present",
          filter: true,
          width: 150,
          cellRendererFramework: "Present",
        },
        {
          headerName: "Absent",
          field: "absent",
          filter: true,
          width: 150,
          cellRendererFramework: "Absent",
        },
        {
          headerName: "Full Day Leave",
          field: "leave",
          filter: true,
          width: 150,
          cellRendererFramework: "Leave",
        },
        {
          headerName: "Half Day Leave",
          field: "half_day",
          filter: true,
          width: 150,
          cellRendererFramework: "HalfDay",
        },
      ],
      // Cell Renderer Components
      components: {
        CellRendererLink,
        Present,
        Absent,
        Leave,
        HalfDay,
        CellRendererVerified,
        CellRendererActions,
      },
    };
  },
  computed: {
    simpleCalendarEvents() {
      return this.$store.state.calendar.events;
    },
    validForm() {
      return (
        this.title !== "" &&
        this.startDate !== "" &&
        this.endDate !== "" &&
        Date.parse(this.endDate) - Date.parse(this.startDate) >= 0 &&
        !this.errors.has("event-url")
      );
    },
    disabledDatesTo() {
      return { to: new Date(this.startDate) };
    },
    disabledDatesFrom() {
      return { from: new Date(this.endDate) };
    },
    calendarLabels() {
      return this.$store.state.calendar.eventLabels;
    },
    labelColor() {
      return (label) => {
        if (label === "present") return "success";
        else if (label === "leave") return "warning";
        else if (label === "absent") return "danger";
        else if (label === "none") return "primary";
      };
    },
    windowWidth() {
      return this.$store.state.windowWidth;
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
    addEvent() {
      const obj = {
        title: this.title,
        startDate: this.startDate,
        endDate: this.endDate,
        label: this.labelLocal,
        url: this.url,
      };
      obj.classes = `event-${this.labelColor(this.labelLocal)}`;
      this.$store.dispatch("calendar/addEvent", obj);
    },
    updateMonth(val) {
      this.showDate = this.$refs.calendar.getIncrementedPeriod(val);
    },
    clearFields() {
      this.title = this.endDate = this.url = "";
      this.id = 0;
      this.labelLocal = "none";
    },
    promptAddNewEvent(date) {
      this.disabledFrom = false;
      this.addNewEventDialog(date);
    },
    addNewEventDialog(date) {
      this.clearFields();
      this.startDate = date;
      this.endDate = date;
      this.activePromptAddEvent = true;
    },
    openAddNewEvent(date) {
      this.disabledFrom = true;
      this.addNewEventDialog(date);
    },
    openEditEvent(event) {
      const e = this.$store.getters["calendar/getEvent"](event.id);
      this.id = e.id;
      this.title = e.title;
      this.startDate = e.startDate;
      this.endDate = e.endDate;
      this.url = e.url;
      this.labelLocal = e.label;
      this.activePromptEditEvent = true;
    },
    editEvent() {
      const obj = {
        id: this.id,
        title: this.title,
        startDate: this.startDate,
        endDate: this.endDate,
        label: this.labelLocal,
        url: this.url,
      };
      obj.classes = `event-${this.labelColor(this.labelLocal)}`;
      this.$store.dispatch("calendar/editEvent", obj);
    },
    removeEvent() {
      this.$store.dispatch("calendar/removeEvent", this.id);
    },
    eventDragged(event, date) {
      this.$store.dispatch("calendar/eventDragged", { event, date });
    },
    fetchAttendance() {
      console.log("attendance date", this.attendance_date);
      let attObj = {
        date: this.attendance_date,
        class_id: this.$route.params.classId,
        from_date: this.from_attendance,
        to_date: this.to_attendance,
      };
      this.$store
        .dispatch("classManagement/fetchAttendance", attObj)
        .then((res) => {
          // console.log(
          //   "res.data.response.attendance_details",
          //   res.data.response.attendance_details.attendance_details
          // );
          // if (
          //   res.data.response.attendance_details &&
          //   res.data.response.attendance_details.length > 0
          // ) {
          //   this.attendance_data = res.data.response.attendance_details;
          //   this.present = res.data.response.present;
          //   this.absent = res.data.response.absent;
          //   this.leave = res.data.response.leave;
          //   this.half_day = res.data.response.half_day;
          // } else {
          //   this.attendance_data = [];
          //   this.present = 0;
          //   this.absent = 0;
          //   this.leave = 0;
          //   this.half_day = 0;
          // }
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
    this.$store.registerModule("calendar", moduleCalendar);
    this.$store.dispatch("calendar/fetchEvents");
    this.$store.dispatch("calendar/fetchEventLabels");
    if (!moduleClassManagement.isRegistered) {
      this.$store.registerModule("classManagement", moduleClassManagement);
      moduleClassManagement.isRegistered = true;
    }
    let attObj = {
      date: this.attendance_date,
      class_id: this.$route.params.classId,
      from_date: this.from_attendance,
      to_date: this.to_attendance,
    };
    this.$store
      .dispatch("classManagement/fetchAttendance", attObj)
      .then((res) => {
        console.log(
          "res.data.response.attendance_details",
          res.data.response.attendance_details.attendance_details
        );
        if (
          res.data.response.attendance_details.attendance_details &&
          res.data.response.attendance_details.attendance_details.length > 0
        ) {
          this.attendance_data =
            res.data.response.attendance_details.attendance_details;
          this.present = res.data.response.attendance_details.present;
          this.absent = res.data.response.attendance_details.absent;
          this.leave = res.data.response.attendance_details.leave;
        } else {
          this.attendance_data = [];
          this.present = 0;
          this.absent = 0;
          this.leave = 0;
        }
      })
      .catch((err) => {
        if (err.response.status === 404) {
          this.class_not_found = true;
          return;
        }
        console.error(err);
      });
  },
  beforeDestroy() {
    this.$store.unregisterModule("calendar");
  },
};
</script>

<style lang="scss">
@import "@sass/vuexy/apps/simple-calendar.scss";
</style>
