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
      <vx-card title="Enter Details" class="mb-base">
        <div class="vx-row mb-6">
          <div class="vx-col sm:w-1/3 w-full">
            <span>Exam Title</span>
          </div>
          <div class="vx-col sm:w-2/3 w-full">
            <vs-input
              v-validate="'required|alpha_spaces'"
              placeholder="Title"
              name="exam_title"
              v-model="exam.exam_title"
              class="w-full"
              data-vv-validate-on="blur"
            />
            <span
              class="text-danger text-sm"
              v-show="errors.has('exam_title')"
              >{{ errors.first("exam_title") }}</span
            >
          </div>
        </div>
        <div class="vx-row mb-6">
          <div class="vx-col sm:w-1/3 w-full">
            <span>Exam Type</span>
          </div>
          <div class="vx-col sm:w-2/3 w-full">
            <v-select
              v-model="exam.exam_type"
              :closeOnSelect="true"
              :options="examTypeOptions"
              v-validate="'required'"
              name="exam_type"
              :dir="$vs.rtl ? 'rtl' : 'ltr'"
            />
            <span
              class="text-danger text-sm"
              v-show="errors.has('exam_type')"
              >{{ errors.first("exam_type") }}</span
            >
          </div>
        </div>
        <div class="vx-row mb-6">
          <div class="vx-col sm:w-1/3 w-full">
            <span>Exam Month</span>
          </div>
          <div class="vx-col sm:w-2/3 w-full">
            <flat-pickr
              v-model="exam.exam_month"
              :config="{ dateFormat: 'M, Y' }"
              class="w-full"
              v-validate="'required'"
              name="to"
            />
            <span class="text-danger text-sm" v-show="errors.has('to')">{{
              errors.first("to")
            }}</span>
          </div>
        </div>
        <div class="vx-row mb-6">
          <div class="vx-col sm:w-1/3 w-full">
            <span>Exam Status</span>
          </div>
          <div class="vx-col sm:w-2/3 w-full">
            <v-select
              v-model="exam.exam_status"
              :closeOnSelect="true"
              :options="statusOptions"
              v-validate="'required'"
              name="exam_status"
              :dir="$vs.rtl ? 'rtl' : 'ltr'"
            />
            <span
              class="text-danger text-sm"
              v-show="errors.has('exam_status')"
              >{{ errors.first("exam_status") }}</span
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
                exam.exam_type = exam.exam_status = exam_title = exam_month = null;
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
import moduleExamManagement from "@/store/exam-management/moduleExamManagement.js";
import { ValidationProvider, ValidationObserver, extend } from "vee-validate";
import flatPickr from "vue-flatpickr-component";
import "flatpickr/dist/flatpickr.css";
import vSelect from "vue-select";
// import { required, regex, between, decimals } from "vee-validate/dist/rules";
export default {
  components: {
    ValidationProvider,
    ValidationObserver,
    flatPickr,
    vSelect,
  },
  data() {
    return {
      exam: {
        exam_type: null,
        exam_status: null,
        exam_title: null,
        exam_month: null,
      },
      exam_data: null,
      exam_not_found: false,
      statusOptions: [
        { label: "Active", value: 1 },
        { label: "Inactive", value: 2 },
      ],
      examTypeOptions: [
        { label: "Monthly", value: 1 },
        { label: "Quarterly", value: 2 },
        { label: "Annaully", value: 3 },
      ],
    };
  },
  computed: {},
  methods: {
    submitForm() {
      console.log("exam", this.exam);
      this.$validator.validateAll();
      if (!this.errors.any()) {
        this.exam.exam_type = this.exam.exam_type.value;
        this.exam.exam_status = this.exam.exam_status.value;
        this.$store
          .dispatch("examManagement/saveExam", this.exam)
          .then((res) => {
            console.log("res", res);
            if (res.data.response) {
              this.$vs.notify({
                color: "success",
                title: "Information Updated",
                text: "Exam Created successfully!",
              });
              this.$router.push({ name: "manage-exams" });
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
    if (!moduleExamManagement.isRegistered) {
      this.$store.registerModule("examManagement", moduleExamManagement);
      moduleExamManagement.isRegistered = true;
    }
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
