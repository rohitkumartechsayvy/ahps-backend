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
    <form>
      <vx-card title="Generate Time Table" class="mb-base">
        <!-- Avatar -->
        <div class="vx-row mb-6">
          <div class="vx-col sm:w-1/3 w-full">
            <span>Select Class</span>
          </div>
          <div class="vx-col sm:w-2/3 w-full">
            <v-select
              v-model="data_local.class_id"
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
        </div>
        <div class="vx-row mb-6">
          <div class="vx-col sm:w-1/3 w-full">
            <span>Choose Teacher</span>
          </div>
          <div class="vx-col sm:w-2/3 w-full">
            <v-select
              v-model="data_local.teacher_id"
              :clearable="false"
              :options="teacher_data"
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
              v-model="data_local.subject_id"
              :clearable="false"
              :options="subject_data"
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
        <div class="vx-row mb-6">
          <div class="vx-col sm:w-1/3 w-full">
            <span>Choose Day</span>
          </div>
          <div class="vx-col sm:w-2/3 w-full">
            <v-select
              v-model="data_local.day_id"
              :clearable="false"
              :options="day_data"
              v-validate="'required'"
              name="day_id"
              :dir="$vs.rtl ? 'rtl' : 'ltr'"
            />
            <span class="text-danger text-sm" v-show="errors.has('day_id')">{{
              errors.first("day_id")
            }}</span>
          </div>
        </div>
        <div class="vx-row mb-6">
          <div class="vx-col sm:w-1/3 w-full">
            <span>Choose Interval</span>
          </div>
          <div class="vx-col sm:w-2/3 w-full">
            <v-select
              v-model="data_local.hour_id"
              :clearable="false"
              :options="hour_data"
              v-validate="'required'"
              name="hour_id"
              :dir="$vs.rtl ? 'rtl' : 'ltr'"
            />
            <span class="text-danger text-sm" v-show="errors.has('hour_id')">{{
              errors.first("hour_id")
            }}</span>
          </div>
        </div>
        <div class="vx-row">
          <div class="vx-col sm:w-2/3 w-full ml-auto">
            <vs-button class="mr-3 mb-2" @click="submitForm">Submit</vs-button>
            <vs-button
              color="warning"
              type="border"
              class="mb-2"
              @click="
                data_local.name = data_local.email = data_local.phone_number = data_local.password = data_local.password_confirm = data_local.staff_child = data_local.dob = data_local.mother_name = data_local.father_name =
                  '';
                check1 = false;
              "
              >Reset</vs-button
            >
          </div>
        </div>
      </vx-card>
    </form>
  </div>
</template>

<script>
import moduleClassManagement from "@/store/class-management/moduleClassManagement.js";
import moduleStudentManagement from "@/store/student-management/moduleStudentManagement.js";
import moduleSubjectManagement from "@/store/subject-management/moduleSubjectManagement.js";
import moduleTimeTableManagement from "@/store/timetable-management/moduleTimeTableManagement.js";
import vSelect from "vue-select";
import flatPickr from "vue-flatpickr-component";
import "flatpickr/dist/flatpickr.css";
export default {
  components: {
    vSelect,
    flatPickr,
  },
  data() {
    return {
      data_local: {
        class_id: null,
        subject_id: null,
        hour_id: null,
        day_id: null,
        teacher_id: null,
      },
      teacher_data: [],
      subject_data: [],
      class_data: [],
      day_data: [],
      hour_data: [],
    };
  },
  computed: {
    userAddress() {
      let str = "";
      for (const field in this.user_data.location) {
        str += `${field} `;
      }
      return str;
    },
    staff_local: {
      get() {
        return {
          label: this.capitalize(this.data_local.staff_child),
          value: this.data_local.staff_child,
        };
      },
      set(obj) {
        this.data_local.staff_child = obj.value;
      },
    },
    parent_local: {
      get() {
        return {
          label: this.capitalize(this.data_local.parent_type),
          value: this.data_local.parent_type,
        };
      },
      set(obj) {
        this.data_local.parent_type = obj.value;
      },
    },
  },
  methods: {
    capitalize(str) {
      return str;
    },
    confirmDeleteRecord() {
      this.$vs.dialog({
        type: "confirm",
        color: "danger",
        title: "Confirm Delete",
        text: `You are about to delete "${this.user_data.username}"`,
        accept: this.deleteRecord,
        acceptText: "Delete",
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
    deleteRecord() {
      /* Below two lines are just for demo purpose */
      this.$router.push({ name: "app-user-list" });
      this.showDeleteSuccess();
    },
    showDeleteSuccess() {
      this.$vs.notify({
        color: "success",
        title: "Student Profile Deleted",
        text: "The selected student profile was successfully deleted",
      });
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
    submitForm() {
      console.log("data_local", this.$validator.validateAll());
      console.log("data_local", this.data_local);
      this.$validator.validateAll();
      if (!this.errors.any()) {
        let obj = {
          class_id: this.data_local.class_id.value,
          teacher_id: this.data_local.teacher_id.value,
          subject_id: this.data_local.subject_id.value,
          day_id: this.data_local.day_id.value,
          hour_id: this.data_local.hour_id.value,
        };
        this.$store
          .dispatch("timetableManagement/saveTimeTable", obj)
          .then((res) => {
            console.log("res", res);
            if (res.data.response) {
              this.$vs.notify({
                color: "success",
                title: "Information Updated",
                text: "Student Profile Created successfully!",
              });
              this.$router.push({ path: "manage-timetables" });
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
  },
  created() {
    // Register Module UserManagement Module
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
    if (!moduleTimeTableManagement.isRegistered) {
      this.$store.registerModule(
        "timetableManagement",
        moduleTimeTableManagement
      );
      moduleTimeTableManagement.isRegistered = true;
    }

    console.log("moduleStudentManagement", moduleStudentManagement);
    this.teachersData();
    this.classData();
    this.subjectsData();
    this.hourData();
    this.dayData();
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
</style>
