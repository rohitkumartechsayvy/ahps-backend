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
        <!-- Avatar -->
        <div class="vx-row mb-6">
          <div class="vx-col sm:w-1/3 w-full">
            <span>From</span>
          </div>
          <div class="vx-col sm:w-2/3 w-full">
            <flat-pickr
              v-model="data_local.from"
              :config="{ dateFormat: 'Y-m-d' }"
              class="w-full"
              v-validate="'required'"
              name="from"
            />
            <span class="text-danger text-sm" v-show="errors.has('from')">{{
              errors.first("from")
            }}</span>
          </div>
        </div>
        <div class="vx-row mb-6">
          <div class="vx-col sm:w-1/3 w-full">
            <span>To</span>
          </div>
          <div class="vx-col sm:w-2/3 w-full">
            <flat-pickr
              v-model="data_local.to"
              :config="{ dateFormat: 'Y-m-d' }"
              class="w-full"
              v-validate="'required'"
              name="to"
            />
            <span class="text-danger text-sm" v-show="errors.has('to')">{{
              errors.first("to")
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
                data_local.from = data_local.to = '';
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
import moduleSyllabusManagement from "@/store/syllabus-management/moduleSyllabusManagement.js";
import { ValidationProvider, ValidationObserver, extend } from "vee-validate";
import flatPickr from "vue-flatpickr-component";
import "flatpickr/dist/flatpickr.css";
// import { required, regex, between, decimals } from "vee-validate/dist/rules";
export default {
  components: {
    ValidationProvider,
    ValidationObserver,
    flatPickr,
  },
  data() {
    return {
      data_local: {
        from: "",
        to: "",
      },
      class_data: [],
      syllabus_data: null,
      syllabus_not_found: false,
    };
  },
  computed: {},
  methods: {
    submitForm() {
      console.log("data_local", this.data_local);
      this.$validator.validateAll();
      if (!this.errors.any()) {
        this.$store
          .dispatch("syllabusManagement/saveSyllabus", this.data_local)
          .then((res) => {
            console.log("res", res);
            if (res.data.response) {
              this.$vs.notify({
                color: "success",
                title: "Information Updated",
                text: "Syllabus Created successfully!",
              });
              this.$router.push({ path: "/manage-syllabuss" });
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
  },
  created() {
    // Register Module UserManagement Module
    if (!moduleSyllabusManagement.isRegistered) {
      this.$store.registerModule(
        "syllabusManagement",
        moduleSyllabusManagement
      );
      moduleSyllabusManagement.isRegistered = true;
    }
    if (!moduleClassManagement.isRegistered) {
      this.$store.registerModule("classManagement", moduleClassManagement);
      moduleClassManagement.isRegistered = true;
    }
    this.classData();
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
