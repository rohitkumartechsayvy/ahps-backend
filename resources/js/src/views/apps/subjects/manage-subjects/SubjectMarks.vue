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
            label="Edit Subject Marks"
            icon-pack="feather"
            icon="icon-user"
          >
            <vs-table class="bordered" stripe>
              <template slot="thead" class="bg-primary" border>
                <vs-td class="text-center font-semibold"
                  ><h5 class="py-3">Subject</h5></vs-td
                >
                <vs-td class="text-center font-semibold">
                  <h5 class="py-3 font-semibold">Max. Grades</h5>
                </vs-td>
                <vs-td class="text-center font-semibold">
                  <h5 class="py-3 font-semibold">Passing Grades</h5>
                </vs-td>
                <vs-td class="text-center font-semibold">
                  <h5 class="py-3 font-semibold">Max. Markes</h5>
                </vs-td>
                <vs-td class="text-center font-semibold">
                  <h5 class="py-3 font-semibold">Passing Markes</h5>
                </vs-td>
              </template>
              <template>
                <vs-tr v-for="(subjectMark, index) in subjectData" :key="index">
                  <vs-td class="text-center py-5 align-middle font-semibold">
                    {{ subjectMark.subject_name }}
                  </vs-td>
                  <vs-td class="text-center py-5 align-middle">
                    <v-select
                      :name="`subjectData[${subjectMark.subject_id}]['max_grade']`"
                      v-model="subjectMark.max_grade"
                      :clearable="false"
                      :options="gradeOptions"
                      v-validate="'required'"
                      :dir="$vs.rtl ? 'rtl' : 'ltr'"
                    />
                    <span
                      class="text-danger text-sm"
                      v-show="
                        errors.has(
                          `subjectData[${subjectMark.subject_id}]['max_grade']`
                        )
                      "
                      >{{
                        errors.first(
                          `subjectData[${subjectMark.subject_id}]['max_grade']`
                        )
                      }}</span
                    >
                  </vs-td>
                  <vs-td class="text-center py-5 align-middle">
                    <v-select
                      :name="`subjectData[${subjectMark.subject_id}]['passing_grade']`"
                      v-model="subjectMark.passing_grade"
                      :clearable="false"
                      :options="gradeOptions"
                      v-validate="'required'"
                      :dir="$vs.rtl ? 'rtl' : 'ltr'"
                    />
                    <span
                      class="text-danger text-sm"
                      v-show="
                        errors.has(
                          `subjectData[${subjectMark.subject_id}]['passing_grade']`
                        )
                      "
                      >{{
                        errors.first(
                          `subjectData[${subjectMark.subject_id}]['passing_grade']`
                        )
                      }}</span
                    >
                  </vs-td>
                  <vs-td class="text-center py-5 align-middle">
                    <vs-input
                      :name="`subjectData[${subjectMark.subject_id}]['max_marks']`"
                      class="mr-3 w-full"
                      v-validate="'required|numeric'"
                      v-model="subjectMark.max_marks"
                      data-vv-validate-on="blur"
                    ></vs-input>
                    <span
                      class="text-danger text-sm"
                      v-show="
                        errors.has(
                          `subjectData[${subjectMark.subject_id}]['max_marks']`
                        )
                      "
                      >{{
                        errors.first(
                          `subjectData[${subjectMark.subject_id}]['max_marks']`
                        )
                      }}</span
                    >
                  </vs-td>
                  <vs-td class="text-center py-5 align-middle">
                    <vs-input
                      :name="`subjectData[${subjectMark.subject_id}]['passing_marks']`"
                      class="mr-3 w-full"
                      v-validate="'required|numeric'"
                      v-model="subjectMark.passing_marks"
                      data-vv-validate-on="blur"
                    ></vs-input>
                    <span
                      class="text-danger text-sm"
                      v-show="
                        errors.has(
                          `subjectData[${subjectMark.subject_id}]['passing_marks']`
                        )
                      "
                      >{{
                        errors.first(
                          `subjectData[${subjectMark.subject_id}]['passing_marks']`
                        )
                      }}</span
                    >
                  </vs-td>
                </vs-tr>
              </template>
            </vs-table>
          </vs-tab>
        </vs-tabs>
        <div class="vx-row">
          <div class="vx-col w-full">
            <div class="flex flex-wrap items-center justify-end">
              <vs-button
                class="mx-auto mb-8"
                @click="save_changes"
                :disabled="!validateForm"
                >Save Changes</vs-button
              >
              <!-- <vs-button class="ml-4 mt-2" type="border" color="warning" @click="reset_data">Reset</vs-button> -->
            </div>
          </div>
        </div>
      </div>
    </vx-card>
  </div>
</template>

<script>
import SubjectEditTabAccount from "./SubjectEditTabAccount.vue";

// Store Module
import moduleSubjectManagement from "@/store/subject-management/moduleSubjectManagement.js";
import moduleExamManagement from "@/store/exam-management/moduleExamManagement.js";
import vSelect from "vue-select";
export default {
  components: {
    SubjectEditTabAccount,
    vSelect,
  },
  data() {
    return {
      subject_data: null,
      subject_not_found: false,
      gradeOptions: [
        { label: "A+", value: 1 },
        { label: "A", value: 2 },
        { label: "B", value: 3 },
        { label: "C", value: 4 },
        { label: "D", value: 5 },
        { label: "E", value: 6 },
      ],
      activeTab: 1,
    };
  },
  computed: {
    examsData() {
      console.log(this.$store.state.examManagement.exams);
      let exams = this.$store.state.examManagement.exams;
      return (this.exams_data = exams.map((exam) => ({
        label: `${exam.exam_title}`,
        value: exam.id,
      })));
    },
    subjectData() {
      console.log(
        "this.$store.state.subjectManagement.subjects",
        this.$store.state.subjectManagement.subjects
      );
      return { ...this.$store.state.subjectManagement.subjects };
    },
    validateForm() {
      return !this.errors.any();
    },
  },
  methods: {
    save_changes() {
      this.$validator.validateAll();
      if (!this.errors.any()) {
        this.$store
          .dispatch(
            "examManagement/saveExamLogs",
            this.$store.state.subjectManagement.subjects
          )
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
            }
          })
          .catch((err) => {
            if (err.response.status === 404) {
              this.user_not_found = true;
              return;
            }
            console.error(err);
          });
        // Here will go your API call for updating data
        // You can get data in "this.data_local"

        /* eslint-enable */
      }
    },
  },
  created() {
    // Register Module subjectManagement Module
    if (!moduleSubjectManagement.isRegistered) {
      this.$store.registerModule("subjectManagement", moduleSubjectManagement);
      moduleSubjectManagement.isRegistered = true;
    }
    if (!moduleExamManagement.isRegistered) {
      this.$store.registerModule("examManagement", moduleExamManagement);
      moduleExamManagement.isRegistered = true;
    }
    this.$store.dispatch("examManagement/fetchActiveExams");
    this.$store.dispatch(
      "subjectManagement/fetchClassSubjects",
      this.$route.params.classId
    );
  },
};
</script>
<style>
.vs-table--not-data {
  display: none;
}
.vs__dropdown-menu {
  position: relative;
}
</style>
