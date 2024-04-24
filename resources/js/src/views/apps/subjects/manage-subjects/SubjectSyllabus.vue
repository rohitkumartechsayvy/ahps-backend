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
      <div
        slot="no-body"
        class="tabs-container px-6 pt-6"
        v-if="syllabusData.syllabus"
      >
        <div class="vx-row">
          <div class="vx-col lg:w-1/2">
            <h2 class="inline-block">Download Syllabus</h2>
            <a
              v-if="syllabusData.syllabus"
              :href="syllabusData.syllabus"
              class="text-center"
              download
            >
              <vs-button type="filled" class="my-5 ml-2">
                <feather-icon icon="DownloadIcon" svgClasses="w-5 h-5" />
              </vs-button>
            </a>
          </div>
        </div>
        <div class="vx-row">
          <div class="vx-col lg:w-1/2">
            <label class="vs-input--label">Change Syllabus</label>
            <vs-input
              v-on:change="onImageChange"
              class="mt-4 w-full"
              v-model="syllabus"
              type="file"
              :dir="$vs.rtl ? 'rtl' : 'ltr'"
            />
            <span class="text-danger text-sm" v-show="errors.has('syllabus')">{{
              errors.first("syllabus")
            }}</span>
          </div>
        </div>
        <div class="vx-row">
          <div class="vx-col w-full">
            <div class="my-8">
              <vs-button
                class="ml-auto mt-2"
                @click="save_changes"
                :disabled="!validateForm"
                >Update Syllabus</vs-button
              >
            </div>
          </div>
        </div>
      </div>
      <div slot="no-body" class="tabs-container px-6 pt-6" v-else>
        <div class="vx-row">
          <div class="vx-col lg:w-1/2">
            <label class="vs-input--label">Upload Syllabus</label>
            <vs-input
              v-on:change="onImageChange"
              class="mt-4 w-full"
              v-model="syllabus"
              type="file"
              :dir="$vs.rtl ? 'rtl' : 'ltr'"
            />
            <span class="text-danger text-sm" v-show="errors.has('syllabus')">{{
              errors.first("syllabus")
            }}</span>
          </div>
        </div>
        <div class="vx-row">
          <div class="vx-col w-full">
            <div class="my-8">
              <vs-button
                class="ml-auto mt-2"
                @click="save_changes"
                :disabled="!validateForm"
                >Save Changes</vs-button
              >
            </div>
          </div>
        </div>
      </div>
    </vx-card>
  </div>
</template>

<script>
import SubjectEditTabAccount from "./SubjectEditTabAccount.vue";
import UploadAutomatic from "./UploadAutomatic.vue";
// Store Module
import moduleSubjectManagement from "@/store/subject-management/moduleSubjectManagement.js";
import moduleSyllabusManagement from "@/store/syllabus-management/moduleSyllabusManagement.js";
import vSelect from "vue-select";
export default {
  components: {
    SubjectEditTabAccount,
    vSelect,
    UploadAutomatic,
  },
  data() {
    return {
      subject_data: null,
      subject_not_found: false,
      activeTab: 1,
      syllabus_data: [],
      subject_id: "",
      image: null,
      syllabus: null,
    };
  },
  computed: {
    syllabusData() {
      console.log(this.$store.state.syllabusManagement.syllabuses);
      this.syllabus_data = this.$store.state.syllabusManagement.syllabuses;
      console.log(
        "this.$store.state.syllabusManagement.syllabuses",
        this.$store.state.syllabusManagement.syllabuses
      );
      return this.$store.state.syllabusManagement.syllabuses;
    },
    userInfo() {
      return this.$store.state.AppActiveUser;
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
    showDeleteSuccess() {
      this.$vs.notify({
        color: "success",
        title: "User Deleted",
        text: "The selected user was successfully deleted",
      });
    },
    onImageChange(e) {
      console.log("e.target.files[0]", e.target.files[0]);
      this.image = e.target.files[0];
      console.log("e.target.files[0]", e.target.files[0]);
      this.syllabus = URL.createObjectURL(this.image);
      console.log("syllabus", this.syllabus);
    },
    save_changes() {
      const formData = new FormData();
      formData.append("syllabus", this.image);
      formData.append("class_id", this.$route.params.classId);
      this.$store
        .dispatch("syllabusManagement/saveSyllabus", formData)
        .then(() => {
          // this.showDeleteSuccess();
          this.$vs.loading.close();
          this.$vs.notify({
            color: "success",
            title: "Syllabus Updated",
            text: "Syllabus Updated Successfully!",
          });
        })
        .catch((err) => {
          console.error(err);
        });
      // this.showDeleteSuccess();
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
    this.$store.dispatch(
      "syllabusManagement/fetchClassSyllabus",
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
