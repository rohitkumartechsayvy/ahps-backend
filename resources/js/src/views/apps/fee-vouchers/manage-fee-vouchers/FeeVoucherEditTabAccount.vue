<!-- =========================================================================================
  File Name: UserEditTabInformation.vue
  Description: User Edit Information Tab content
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
========================================================================================== -->

<template>
  <div id="user-edit-tab-info">
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
                v-model="data_local.fee_details.title"
                class="w-full"
                data-vv-validate-on="blur"
              />
              <span class="text-danger text-sm" v-show="errors.has('title')">{{
                errors.first("title")
              }}</span>
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
                v-model="new_data.fee_charges[item.value]"
                class="w-full"
                data-vv-validate-on="blur"
                :value="data_local.fee_charges[item.value]"
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
            @click="save_changes"
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
  </div>
</template>

<script>
import vSelect from "vue-select";
import moduleSessionManagement from "@/store/session-management/moduleSessionManagement.js";
import flatPickr from "vue-flatpickr-component";
import "flatpickr/dist/flatpickr.css";
export default {
  components: {
    vSelect,
    flatPickr,
  },
  props: {
    data: {
      type: Object,
      required: true,
    },
  },
  data() {
    return {
      fee_data: [],
      data_local: JSON.parse(JSON.stringify(this.data)),
      statusOptions: [
        { label: "Active", value: "active" },
        { label: "Inactive", value: "inactive" },
      ],
      new_data: {
        id: null,
        title: "",
        fee_charges: {},
      },
      class_data: [],
    };
  },
  computed: {
    status_local: {
      get() {
        return {
          label: this.capitalize(this.data_local.status),
          value: this.data_local.status,
        };
      },
      set(obj) {
        this.data_local.status = obj.value;
      },
    },
    validateForm() {
      return !this.errors.any();
    },
  },
  methods: {
    capitalize(str) {
      console.log("str", str);
      if (!str) return "";
      str = str.toString();
      return str.charAt(0).toUpperCase() + str.slice(1);
      // return str.slice(0, 1).toUpperCase() + str.slice(1, str.length);
    },
    save_changes() {
      /* eslint-disable */
      if (!this.validateForm) return;
      this.new_data.title = this.data_local.fee_details.title;
      this.new_data.id = this.data_local.fee_details.id;
      console.log("fee_data", this.new_data.fee_charges);
      this.$store
        .dispatch("tuitionFeeManagement/updateCharge", this.new_data)
        .then((res) => {
          console.log("Notifications");
          this.$vs.notify({
            color: "success",
            title: "Information Updated",
            text: "Session information updated successfully!",
          });
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
    },
    confirmDeleteRecord() {
      this.$vs.dialog({
        type: "confirm",
        color: "danger",
        title: "Confirm Delete",
        text: `Are you sure you want to delete "${this.user_data.username}"?`,
        accept: this.deleteRecord,
        acceptText: "Delete",
      });
    },
    deleteRecord() {
      /* Below two lines are just for demo purpose */
      this.$store
        .dispatch(
          "tuitionFeeManagement/removeRecord",
          this.data_local.fee_details.id
        )
        .then((res) => {
          this.$router.push({ name: "manage-tuition-fees" });
          this.showDeleteSuccess();
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
        title: "User Deleted",
        text: "The selected user was successfully deleted",
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
    reset_data() {
      this.data_local = JSON.parse(JSON.stringify(this.data));
    },
    update_avatar() {
      // You can update avatar Here
      // For reference you can check dataList example
      // We haven't integrated it here, because data isn't saved in DB
    },
  },
  created() {
    let main_obj = this.data_local.fee_charges;
    main_obj.forEach((element) => {
      this.new_data.fee_charges[element.class_id] = element.monthly_fee;
    });
    console.log(
      "data_local.fee_details.title",
      this.data_local.fee_details.title
    );
    this.classData();
  },
};
</script>
