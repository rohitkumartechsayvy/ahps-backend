<template>
  <div id="simple-calendar-app">
    <div class="vx-card no-scroll-content">
      <div class="vx-row mb-6 p-5">
        <div class="vx-col sm:w-1/6 md:w-1/6 lg:w-3/6 w-full">
          <span>Select Class</span>
        </div>
        <div class="vx-col sm:w-1/6 md:w-1/6 lg:w-3/6 w-full">
          <v-select
            v-model="class_id"
            :clearable="false"
            :options="class_data"
            v-validate="'required'"
            name="class_id"
            :dir="$vs.rtl ? 'rtl' : 'ltr'"
          />
          <span class="text-danger text-sm" v-show="errors.has('class_id')">{{
            errors.first("class_id")
          }}</span>
        </div>
        <div class="vx-col sm:w-1/6 md:w-1/6 lg:w-3/6 w-full">
          <vs-button class="mr-3 mb-2" @click="fetchTimeTable"
            >Get Timetable</vs-button
          >
        </div>
      </div>
      <vs-table class="bordered" :data="timetable_data" stripe>
        <template slot="thead" class="bg-primary" border>
          <vs-td class="text-center font-semibold"
            ><h5 class="py-3">Time</h5></vs-td
          >
          <vs-td
            class="text-center font-semibold"
            :key="indextr3"
            v-for="(tr3, indextr3) in day_data"
          >
            <h5 class="py-3 font-semibold">
              {{ tr3.label }}
            </h5>
          </vs-td>
        </template>
        <template>
          <vs-tr :key="indextr" v-for="(tr, indextr) in hour_data">
            <vs-td class="text-center py-5 align-middle font-semibold">
              {{ tr.label ? tr.label : "-" }}
            </vs-td>
            <vs-td
              class="text-center py-5 align-middle"
              :key="indextr2"
              v-for="(tr2, indextr2) in day_data"
            >
              <vs-button
                size="small"
                class="mr-3 py-2"
                @click="enablePrompt(tr.value, tr2.value)"
                color="success"
                v-if="timetable_data[tr.value][indextr2].length == 0"
              >
                Assign Schedule
              </vs-button>
              <div v-else>
                <div class="w-full bg-primary-light">
                  {{ timetable_data[tr.value][indextr2].hour }}
                </div>
                <p class="font-semibold">
                  {{
                    timetable_data[tr.value][indextr2].class_name
                      ? `${timetable_data[tr.value][indextr2].class_name} Class`
                      : ""
                  }}
                </p>
                <p class="text-primary font-semibold">
                  {{ timetable_data[tr.value][indextr2].subject_name }}
                </p>
                <p class="text-warning font-semibold">
                  {{ timetable_data[tr.value][indextr2].teacher_name }}
                </p>
                <feather-icon
                  icon="Edit3Icon"
                  svgClasses="h-5 w-5 mr-4 hover:text-primary cursor-pointer"
                  @click="
                    editRecordPrompt(
                      timetable_data[tr.value][indextr2].time_table_id,
                      tr.value,
                      tr2.value,
                      timetable_data[tr.value][indextr2].teacher_id,
                      timetable_data[tr.value][indextr2].subject_id,
                      timetable_data[tr.value][indextr2].teacher_name,
                      timetable_data[tr.value][indextr2].subject_name
                    )
                  "
                />
                <feather-icon
                  icon="Trash2Icon"
                  svgClasses="h-5 w-5 hover:text-danger cursor-pointer"
                  @click="
                    deleteRecord(
                      timetable_data[tr.value][indextr2].time_table_id
                    )
                  "
                />
              </div>
            </vs-td>
          </vs-tr>
        </template>
      </vs-table>

      <vs-prompt
        class="calendar-event-dialog"
        title="Assign Schedule"
        accept-text="Proceed"
        @accept="saveTimeTable"
        :is-valid="validForm"
        :active.sync="activePromptAddEvent"
      >
        <div class="vx-row mb-6">
          <div class="vx-col sm:w-1/3 w-full">
            <span>Choose Teacher</span>
          </div>
          <div class="vx-col sm:w-2/3 w-full">
            <v-select
              v-model="timetable.teacher_id"
              :clearable="false"
              :options="this.teacher_data"
              v-validate="'required'"
              name="teacher_id"
              :dir="$vs.rtl ? 'rtl' : 'ltr'"
            />
            <span
              class="text-danger text-sm"
              v-show="errors.has('teacher_id')"
              >{{ errors.first("teacher_id") }}</span
            >
          </div>
        </div>
        <div class="vx-row mb-6">
          <div class="vx-col sm:w-1/3 w-full">
            <span>Choose Subjects</span>
          </div>
          <div class="vx-col sm:w-2/3 w-full">
            <v-select
              v-model="timetable.subject_id"
              :clearable="false"
              :options="this.subject_data"
              v-validate="'required'"
              name="subject_id"
              :dir="$vs.rtl ? 'rtl' : 'ltr'"
            />
            <span
              class="text-danger text-sm"
              v-show="errors.has('subject_id')"
              >{{ errors.first("subject_id") }}</span
            >
          </div>
        </div>
      </vs-prompt>
      <vs-prompt
        class="calendar-event-dialog"
        title="Assign Schedule"
        accept-text="Proceed"
        @accept="updateTimeTable"
        :is-valid="validForm"
        :active.sync="activeEditPrompt"
      >
        <div class="vx-row mb-6">
          <div class="vx-col sm:w-1/3 w-full">
            <span>Choose Teacher</span>
          </div>
          <div class="vx-col sm:w-2/3 w-full">
            <v-select
              v-model="timetable.teacher_id"
              :clearable="false"
              :options="this.teacher_data"
              v-validate="'required'"
              name="teacher_id"
              :dir="$vs.rtl ? 'rtl' : 'ltr'"
            />
            <span
              class="text-danger text-sm"
              v-show="errors.has('teacher_id')"
              >{{ errors.first("teacher_id") }}</span
            >
          </div>
        </div>
        <div class="vx-row mb-6">
          <div class="vx-col sm:w-1/3 w-full">
            <span>Choose Subjects</span>
          </div>
          <div class="vx-col sm:w-2/3 w-full">
            <v-select
              v-model="timetable.subject_id"
              :clearable="false"
              :options="this.subject_data"
              v-validate="'required'"
              name="subject_id"
              :dir="$vs.rtl ? 'rtl' : 'ltr'"
            />
            <span
              class="text-danger text-sm"
              v-show="errors.has('subject_id')"
              >{{ errors.first("subject_id") }}</span
            >
          </div>
        </div>
      </vs-prompt>
    </div>
  </div>
</template>

<script>
import moduleClassManagement from "@/store/class-management/moduleClassManagement.js";
import moduleTimeTableManagement from "@/store/timetable-management/moduleTimeTableManagement.js";
import moduleStudentManagement from "@/store/student-management/moduleStudentManagement.js";
import moduleSubjectManagement from "@/store/subject-management/moduleSubjectManagement.js";
import vSelect from "vue-select";
export default {
  components: {
    vSelect,
  },
  data() {
    return {
      class_id: {
        label: null,
        value: null,
      },
      day_data: [],
      hour_data: [],
      timetable_data: [],
      teacher_data: [],
      subject_data: [],
      class_data: [],
      activePromptAddEvent: false,
      activeEditPrompt: false,
      timetable: {
        time_table_id: null,
        class_id: null,
        subject_id: {
          label: null,
          value: null,
        },
        teacher_id: {
          label: null,
          value: null,
        },
        hour_id: null,
        day_id: null,
      },
    };
  },
  computed: {
    timeTables() {
      console.log("timetables", this.$store.state.timetableManagement);
    },
    validForm() {
      return (
        this.timetable.subject_id !== "" && this.timetable.teacher_id !== ""
      );
    },
    windowWidth() {
      return this.$store.state.windowWidth;
    },
  },
  methods: {
    saveTimeTable() {
      this.$validator.validateAll();
      if (!this.errors.any()) {
        this.timetable.subject_id = this.timetable.subject_id.value;
        this.timetable.teacher_id = this.timetable.teacher_id.value;
        this.$store
          .dispatch("timetableManagement/saveTimeTable", this.timetable)
          .then((res) => {
            console.log("res", res);
            if (res.data.response) {
              this.$vs.notify({
                color: "success",
                title: "Information Updated",
                text: "Schedule Assigned successfully!",
              });
              this.$store
                .dispatch(
                  "timetableManagement/fetchTimeTable",
                  this.class_id.value
                )
                .then((res) => {
                  this.timetable_data = res.data.response;
                  this.timetable = {
                    class_id: null,
                    subject_id: {
                      label: null,
                      value: null,
                    },
                    teacher_id: {
                      label: null,
                      value: null,
                    },
                    hour_id: null,
                    day_id: null,
                  };
                })
                .catch((err) => {
                  console.error(err);
                });
              // this.$router.push({ name: "manage-timetables" });
            } else {
              // console.log("err", res.data.message);
              this.$vs.notify({
                title: "Error",
                text: res.data.message,
                iconPack: "feather",
                icon: "icon-alert-circle",
                color: "warning",
              });
            }
          })
          .catch((err) => {
            console.log("err", err);
          });
      }
    },
    // confirmDeleteRecord(timetable_id) {
    //   console.log(
    //     "dialog confirmation",
    //     this.$vs.dialog({
    //       type: "confirm",
    //       color: "danger",
    //       title: "Confirm Delete",
    //       text: `Are you sure you want to delete schedule?`,
    //       accept: this.deleteRecord(timetable_id),
    //       acceptText: "Delete",
    //     })
    //   );
    // },
    deleteRecord(timetable_id) {
      console.log("timetable_id", timetable_id);
      /* Below two lines are just for demo purpose */
      this.$store
        .dispatch("timetableManagement/removeRecord", timetable_id)
        .then((res) => {
          this.showDeleteSuccess();
          this.$store
            .dispatch("timetableManagement/fetchTimeTable", this.class_id.value)
            .then((res) => {
              this.timetable_data = res.data.response;
              this.timetable = {
                time_table_id: null,
                class_id: null,
                subject_id: null,
                teacher_id: null,
                hour_id: null,
                day_id: null,
              };
            })
            .catch((err) => {
              console.error(err);
            });
        })
        .catch((err) => {
          if (err.response.status === 404) {
            this.user_not_found = true;
            return;
          }
          console.error(err);
        });
    },
    showDeleteSuccess() {
      this.$vs.notify({
        color: "success",
        title: "Schedule Deleted",
        text: "The selected schedule was successfully deleted",
      });
    },
    updateTimeTable() {
      console.log("data_local", this.timetable);
      this.timetable.subject_id = this.timetable.subject_id.value;
      this.timetable.teacher_id = this.timetable.teacher_id.value;
      this.$store
        .dispatch("timetableManagement/updateTimetable", this.timetable)
        .then((res) => {
          if (
            res &&
            res.data.message.errors &&
            res.data.message.errors.length > 0
          ) {
            this.$vs.loading.close();
            this.$vs.notify({
              title: "Error",
              text: res.data.message.errors[0],
              iconPack: "feather",
              icon: "icon-alert-circle",
              color: "danger",
            });
          } else {
            this.$vs.loading.close();
            this.$vs.notify({
              color: "success",
              title: "Information Updated",
              text: res.data.message,
            });

            this.$store
              .dispatch(
                "timetableManagement/fetchTimeTable",
                this.class_id.value
              )
              .then((res) => {
                this.timetable_data = res.data.response;
                this.timetable = {
                  time_table_id: null,
                  class_id: null,
                  subject_id: {
                    label: null,
                    value: null,
                  },
                  teacher_id: {
                    label: null,
                    value: null,
                  },
                  hour_id: null,
                  day_id: null,
                };
              })
              .catch((err) => {
                console.error(err);
              });
          }
        })
        .catch((err) => {
          if (err.response.status === 404) {
            this.user_not_found = true;
            return;
          }
          console.error(err);
        });
    },
    enablePrompt(hour_id, day_id) {
      this.timetable.hour_id = hour_id;
      this.timetable.class_id = this.class_id.value;
      this.timetable.day_id = day_id;
      this.activePromptAddEvent = true;
    },
    classData() {
      console.log("this.$store", this.$store.state.AppActiveUser.user_type);
      this.$store
        .dispatch("classManagement/fetchClasses")
        .then((res) => {
          this.class_data = res.data.response.map((class_data) => ({
            label: `${class_data.class_name}`,
            value: class_data.id,
          }));
          this.class_id = this.class_data[0];
          this.$store
            .dispatch("timetableManagement/fetchTimeTable", this.class_id.value)
            .then((res2) => {
              this.timetable_data = res2.data.response;
            })
            .catch((err) => {
              console.error(err);
            });
        })
        .catch((err) => {
          console.error(err);
        });
    },
    editRecordPrompt(
      time_table_id,
      hour_id,
      day_id,
      teacher_id,
      subject_id,
      teacher_name,
      subject_name
    ) {
      this.timetable.time_table_id = time_table_id;
      this.timetable.hour_id = hour_id;
      this.timetable.class_id = this.class_id.value;
      this.timetable.day_id = day_id;
      this.timetable.teacher_id.value = teacher_id;
      this.timetable.teacher_id.label = teacher_name;
      this.timetable.subject_id.label = subject_name;
      this.timetable.subject_id.value = subject_id;
      this.activeEditPrompt = true;
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
    teachersData() {
      this.$store
        .dispatch("studentManagement/fetchTeachers")
        .then((res) => {
          this.teacher_data = res.data.response.map((user) => ({
            label: `${user.name}`,
            value: user.user_id,
          }));
          console.log("this.teacher_data ", this.teacher_data);
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
    fetchTimeTable() {
      this.$store
        .dispatch("timetableManagement/fetchTimeTable", this.class_id.value)
        .then((res) => {
          console.log("clicked");
          this.timetable_data = res.data.response;
        })
        .catch((err) => {
          console.error(err);
        });
    },
  },
  beforeDestroy() {
    this.$validator.pause();
  },
  created() {
    if (!moduleClassManagement.isRegistered) {
      this.$store.registerModule("classManagement", moduleClassManagement);
      moduleClassManagement.isRegistered = true;
    }
    if (!moduleStudentManagement.isRegistered) {
      this.$store.registerModule("studentManagement", moduleStudentManagement);
      moduleStudentManagement.isRegistered = true;
    }
    if (!moduleTimeTableManagement.isRegistered) {
      this.$store.registerModule(
        "timetableManagement",
        moduleTimeTableManagement
      );
      moduleTimeTableManagement.isRegistered = true;
    }
    if (!moduleSubjectManagement.isRegistered) {
      this.$store.registerModule("subjectManagement", moduleSubjectManagement);
      moduleSubjectManagement.isRegistered = true;
    }
    this.$store
      .dispatch("timetableManagement/fetchTimeTable", this.class_id.value)
      .then((res) => {
        this.timetable_data = res.data.response;
      })
      .catch((err) => {
        console.error(err);
      });
    this.hourData();
    this.dayData();
    this.teachersData();
    this.subjectsData();
    this.classData();
  },
};
</script>

<style lang="scss">
@import "@sass/vuexy/apps/simple-calendar.scss";
// .vs-table-text {
//   text-transform: uppercase;
//   text-align: center;
//   font-weight: 600;
// }
.vs-table--thead {
  th {
    padding-top: 0;
    padding-bottom: 0;

    .vs-table-text {
      text-transform: uppercase;
      font-weight: 600;
      * {
        text-align: center;
      }
    }
  }
  th.td-check {
    padding: 0 15px !important;
  }
  tr {
    background: none;
    box-shadow: none;
  }
}
.bg-primary-light {
  background-color: #75afee;
  color: white;
}
.vs-con-table.bordered {
  border: 1px solid #75afee;
  border-collapse: collapse;
  .vs-table--thead {
    background-color: $primary;
    * {
      color: white;
    }
  }
}
.vs-table--not-data {
  display: none;
}
</style>
