<!-- =========================================================================================
  File Name: UserEdit.vue
  Description: User Edit Page
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
========================================================================================== -->

<template>
  <div id="page-timetable-edit">
    <vs-alert
      color="danger"
      title="User Not Found"
      :active.sync="event_not_found"
    >
      <span>Timetable record with id: {{ $route.params.id }} not found.</span>
      <span>
        <span>Check</span>
        <router-link
          :to="{ name: 'page-timetable-list' }"
          class="text-inherit underline"
          >All Timetables</router-link
        >
      </span>
    </vs-alert>

    <vx-card v-if="event_data">
      <div slot="no-body" class="tabs-container px-6 pt-6">
        <vs-tabs v-model="activeTab" class="tab-action-btn-fill-conatiner">
          <vs-tab label="Account" icon-pack="feather" icon="icon-user">
            <div class="tab-text">
              <event-edit-tab-account class="mt-4" :data="event_data" />
            </div>
          </vs-tab>
        </vs-tabs>
      </div>
    </vx-card>
  </div>
</template>

<script>
import EventEditTabAccount from "./EventEditTabAccount.vue";
// Store Module
import moduleEventManagement from "@/store/event-management/moduleEventManagement.js";

export default {
  components: {
    EventEditTabAccount,
  },
  data() {
    return {
      event_data: null,
      event_not_found: false,
      data_local: {
        title: "",
        desc: "",
        gallery: [],
        item_img: null,
        created_by: null,
      },
      gallery_arr: [],
      formData: {},
      images: [],
      /*
        This property is created for fetching latest data from API when tab is changed

        Please check it's watcher
      */
      activeTab: 0,
    };
  },
  computed: {
    validateForm() {
      return (
        !this.errors.any() &&
        this.data_local.title !== "" &&
        this.data_local.desc !== ""
      );
    },
  },
  watch: {
    activeTab() {
      this.fetch_event_data(this.$route.params.eventId);
    },
  },
  methods: {
    fetch_event_data(eventId) {
      this.$store
        .dispatch("eventManagement/fetchEvent", eventId)
        .then((res) => {
          console.log(res);
          this.event_data = res.data.response;
          let class_id = {
            value: this.event_data.class_id,
            label: this.event_data.class_name,
          };
          let teacher_id = {
            value: this.event_data.teacher_id,
            label: this.event_data.name,
          };
          let subject_id = {
            value: this.event_data.subject_id,
            label: this.event_data.subject_name,
          };
          let day_id = {
            value: this.event_data.day_id,
            label: this.event_data.day,
          };
          let hour_id = {
            value: this.event_data.hour_id,
            label: `${this.event_data.from} - ${this.event_data.to}`,
          };
          this.event_data.class_id = class_id;
          this.event_data.teacher_id = teacher_id;
          this.event_data.subject_id = subject_id;
          this.event_data.day_id = day_id;
          this.event_data.hour_id = hour_id;
        })
        .catch((err) => {
          if (err.response.status === 404) {
            this.event_not_found = true;
            return;
          }
          console.error(err);
        });
    },
  },
  created() {
    // Register Module UserManagement Module
    if (!moduleEventManagement.isRegistered) {
      this.$store.registerModule("eventManagement", moduleEventManagement);
      moduleEventManagement.isRegistered = true;
    }
    this.fetch_event_data(this.$route.params.eventId);
  },
};
</script>
