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
      :active.sync="class_not_found"
    >
      <span>User record with id: {{ $route.params.classId }} not found. </span>
      <span>
        <span>Check </span
        ><router-link
          :to="{ name: 'page-user-list' }"
          class="text-inherit underline"
          >All Users</router-link
        >
      </span>
    </vs-alert>
    <form>
      <vx-card title="Enter Details" class="mb-base">
        <!-- Avatar -->
        <div class="vx-row mb-6">
          <div class="vx-col sm:w-1/3 w-full">
            <span>Class Name</span>
          </div>
          <div class="vx-col sm:w-2/3 w-full">
            <vs-input
              v-validate="'required'"
              placeholder="Class Name"
              name="class_name"
              v-model="data_local.class_name"
              class="w-full"
              data-vv-validate-on="blur"
            />
            <span
              class="text-danger text-sm"
              v-show="errors.has('class_name')"
              >{{ errors.first("class_name") }}</span
            >
          </div>
        </div>
        <div class="vx-row mb-6">
          <div class="vx-col sm:w-1/3 w-full">
            <span>Select Class Incharge</span>
          </div>
          <div class="vx-col sm:w-2/3 w-full">
            <v-select
              v-model="data_local.class_incharge"
              :clearable="false"
              :options="teacher_data"
              v-validate="'required'"
              name="class_incharge"
              :dir="$vs.rtl ? 'rtl' : 'ltr'"
            />
            <span
              class="text-danger text-sm"
              v-show="errors.has('class_incharge')"
              >{{ errors.first("class_incharge") }}</span
            >
          </div>
        </div>
        <div class="vx-row mb-6">
          <div class="vx-col sm:w-1/3 w-full">
            <span>Assign Subjects</span>
          </div>
          <div class="vx-col sm:w-2/3 w-full">
            <v-select
              multiple
              v-model="data_local.subjects"
              :clearable="false"
              :options="subject_data"
              v-validate="'required'"
              name="subjects[]"
              :dir="$vs.rtl ? 'rtl' : 'ltr'"
            />
            <span
              class="text-danger text-sm"
              v-show="errors.has('subjects[]')"
              >{{ errors.first("subjects[]") }}</span
            >
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
                data_local.class_name = '';
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
import vSelect from "vue-select";
import { ValidationProvider, ValidationObserver, extend } from "vee-validate";
// import { required, regex, between, decimals } from "vee-validate/dist/rules";
export default {
  components: {
    vSelect,
    ValidationProvider,
    ValidationObserver,
  },
  data() {
    return {
      data_local: {
        class_name: "",
        class_incharge: null,
        subjects: [],
      },
      class_data: null,
      class_not_found: false,
      teacher_data: [],
      subject_data: [],
    };
  },
  computed: {
    userAddress() {
      let str = "";
      for (const field in this.class_data.location) {
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
        text: `You are about to delete "${this.class_data.username}"`,
        accept: this.deleteRecord ? this.deleteRecord : null,
        acceptText: "Delete",
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
          console.log("res.data.response", res.data.response);
          this.subject_data = res.data.response.map((subject) => ({
            label: `${subject.subject_name}`,
            value: subject.id,
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

      /* UnComment below lines for enabling true flow if deleting user */
      // this.$store.dispatch("userManagement/removeRecord", this.class_data.id)
      //   .then(()   => { this.$router.push({name:'app-user-list'}); this.showDeleteSuccess() })
      //   .catch(err => { console.error(err)       })
    },
    showDeleteSuccess() {
      this.$vs.notify({
        color: "success",
        title: "User Deleted",
        text: "The selected user was successfully deleted",
      });
    },
    submitForm() {
      console.log("data_local", this.$validator.validateAll());
      this.$validator.validateAll();
      if (!this.errors.any()) {
        let current_user = localStorage.getItem("userInfo");
        console.log(this.$store.state.AppActiveUser.id);
        let request_obj = {
          class_name: this.data_local.class_name,
          class_incharge: this.data_local.class_incharge.value,
          subjects: this.data_local.subjects,
          changed_by: this.$store.state.AppActiveUser.id,
        };
        this.$store
          .dispatch("classManagement/saveClass", request_obj)
          .then((res) => {
            console.log("res", res);
            if (res.data.response) {
              this.$vs.notify({
                color: "success",
                title: "Information Updated",
                text: "Class Created successfully!",
              });
              this.$router.push({ name: "manage-classes" });
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
    if (!moduleClassManagement.isRegistered) {
      this.$store.registerModule("classManagement", moduleClassManagement);
      moduleClassManagement.isRegistered = true;
    }
    if (!moduleStudentManagement.isRegistered) {
      this.$store.registerModule("studentManagement", moduleStudentManagement);
      moduleStudentManagement.isRegistered = true;
    }
    if (!moduleSubjectManagement.isRegistered) {
      this.$store.registerModule("subjectManagement", moduleSubjectManagement);
      moduleSubjectManagement.isRegistered = true;
    }
    this.teachersData();
    this.subjectsData();
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
