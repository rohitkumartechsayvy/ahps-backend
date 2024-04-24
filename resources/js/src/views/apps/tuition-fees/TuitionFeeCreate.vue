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
      <vx-card title="Enter Charges" class="mb-base">
        <!-- Avatar -->
        <div class="vx-row">
          <div class="vx-col lg:w-1/2">
            <div class="vx-row mb-6">
              <div class="vx-col sm:w-1/3 w-full">
                <span>Title</span>
              </div>
              <div class="vx-col sm:w-2/3 w-full">
                <vs-input
                  v-validate="'required|alpha_spaces'"
                  placeholder="Title"
                  name="title"
                  v-model="data_local.title"
                  class="w-full"
                  data-vv-validate-on="blur"
                />
                <span
                  class="text-danger text-sm"
                  v-show="errors.has('title')"
                  >{{ errors.first("title") }}</span
                >
              </div>
            </div>
          </div>
          <div class="vx-col lg:w-1/2">
            <div v-for="item in class_data" :key="item.value" class="mb-base">
              <vx-input-group>
                <template slot="prepend">
                  <div class="prepend-text bg-primary">
                    <span>{{ item.label }}</span>
                  </div>
                </template>
                <vs-input
                  v-validate="'required|numeric'"
                  placeholder="0.00"
                  :name="`fee_charges[${item.value}]`"
                  v-model="data_local.fee_charges[item.value]"
                  class="w-full"
                  data-vv-validate-on="blur"
                  :vs-value="data_local.fee_charges[item.amount]"
                />
              </vx-input-group>
              <span
                class="text-danger text-sm"
                v-show="errors.has(`fee_charges[${item.value}]`)"
                >{{ errors.first(`fee_charges[${item.value}]`) }}</span
              >
            </div>
          </div>
        </div>

        <div class="vx-row">
          <div class="vx-col sm:w-2/3 w-full ml-auto">
            <vx-input-group />
            <vs-button
              class="mr-3 mb-2"
              @click="submitForm"
              :disabled="!validateForm"
              >Submit</vs-button
            >
            <vs-button
              color="warning"
              type="border"
              class="mb-2"
              @click="
                data_local.title = '';
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
import moduleTuitionFeeManagement from "@/store/tuition-fee-management/moduleTuitionFeeManagement.js";
import { ValidationProvider, ValidationObserver, extend } from "vee-validate";
import flatPickr from "vue-flatpickr-component";
import "flatpickr/dist/flatpickr.css";
import { BInputGroup, BFormInput } from "bootstrap-vue";
import VxInputGroup from "@/components/vx-input-group/VxInputGroup";
// import { required, regex, between, decimals } from "vee-validate/dist/rules";
export default {
  components: {
    ValidationProvider,
    ValidationObserver,
    flatPickr,
    BFormInput,
    BInputGroup,
    VxInputGroup,
  },
  data() {
    return {
      data_local: {
        title: "",
        fee_charges: {},
      },
      class_data: [],
      session_data: null,
      session_not_found: false,
    };
  },
  computed: {
    validateForm() {
      return !this.errors.any() && this.data_local.title !== "";
    },
  },
  methods: {
    submitForm() {
      this.$validator.validateAll().then((result) => {
        if (result) {
          this.$store
            .dispatch("tuitionFeeManagement/saveTuitionFee", this.data_local)
            .then((res) => {
              console.log("res", res);
              if (
                res &&
                res.data.message.errors &&
                res.data.message.errors.length > 0
              ) {
                this.$vs.loading.close();
                this.$vs.notify({
                  title: "Error",
                  text: res.data.message.errors,
                  iconPack: "feather",
                  icon: "icon-alert-circle",
                  color: "danger",
                });
              } else {
                this.$vs.loading.close();
                this.$vs.notify({
                  color: "success",
                  title: "Information Updated!",
                  text: res.data.message,
                });
              }
              this.$router.push({ path: "/manage-tuition-fees" });
            })
            .catch((err) => {
              console.log("err", err);
            });
        } else {
          if (
            this.$validator.errors.items &&
            this.$validator.errors.items.length > 0
          ) {
            let errors = this.$validator.errors.items;
            errors.forEach((element, key) => {
              if (errors[key].rule == "required") {
                errors[key].msg = "Above Fee Field is required.";
              } else {
                errors[key].msg = "Please enter valid amount of fee.";
              }
            });
          }
        }
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
  },
  created() {
    // Register Module UserManagement Module
    if (!moduleTuitionFeeManagement.isRegistered) {
      this.$store.registerModule(
        "tuitionFeeManagement",
        moduleTuitionFeeManagement
      );
      moduleTuitionFeeManagement.isRegistered = true;
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
@import "@sass/vuexy/components/vxInputGroup.scss";
</style>
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
