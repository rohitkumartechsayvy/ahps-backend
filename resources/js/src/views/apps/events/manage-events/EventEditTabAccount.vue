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
      <vx-card title="Create Event" class="mb-base">
        <!-- Avatar -->
        <div class="vx-row mb-6">
          <div class="vx-col sm:w-1/3 w-full">
            <span>Event Title</span>
          </div>
          <div class="vx-col sm:w-2/3 w-full">
            <vs-input
              v-validate="'required|alpha_spaces'"
              placeholder="Name"
              name="title"
              v-model="data_local.title"
              class="w-full"
              data-vv-validate-on="blur"
            />
            <span class="text-danger text-sm" v-show="errors.has('title')">{{
              errors.first("title")
            }}</span>
          </div>
        </div>
        <div class="vx-row mb-6">
          <div class="vx-col sm:w-1/3 w-full">
            <span>Event Desc</span>
          </div>
          <div class="vx-col sm:w-2/3 w-full">
            <vs-textarea
              name="desc"
              v-validate="'required|alpha_spaces'"
              v-model="data_local.desc"
            />
            <span class="text-danger text-sm" v-show="errors.has('desc')">{{
              errors.first("desc")
            }}</span>
          </div>
        </div>
        <div class="vx-row mb-6">
          <div class="vx-col sm:w-1/3 w-full">
            <span>Created By</span>
          </div>
          <div class="vx-col sm:w-2/3 w-full">
            {{ data_local.name }}
          </div>
        </div>
        <div class="vx-row mb-6">
          <div class="vx-col sm:w-1/3 w-full">
            <span>Approval Status</span>
          </div>
          <div class="vx-col sm:w-2/3 w-full">
            {{
              data_local.approved_by
                ? `Approved By ${data_local.approved_by_name}`
                : "Pending"
            }}
          </div>
        </div>
        <div class="vx-row mb-6" v-if="this.data.gallery">
          <div class="vx-col w-full">
            <span>Event Images</span>
          </div>
          <div class="vx-row w-full" id="gallery_div" ref="gallery_div"></div>
          <div class="vx-col sm:w-2/3 w-full">
            <div class="flex items-start flex-col sm:flex-row">
              <div
                class="mt-5 px-4 vx-col lg:w-1/4"
                v-for="(item, grp_index) in images"
                :key="grp_index"
              >
                <img :src="`/${item}`" :class="'img-fluid w-full'" />
              </div>
            </div>
          </div>
        </div>
        <div class="vx-row">
          <div class="vx-col sm:w-2/3 w-full ml-auto">
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
                data_local.title = data_local.desc = '';
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
import moduleEventManagement from "@/store/event-management/moduleEventManagement.js";
import VueUploadMultipleImage from "vue-upload-multiple-image";
import vSelect from "vue-select";
import flatPickr from "vue-flatpickr-component";
import "flatpickr/dist/flatpickr.css";
export default {
  components: {
    vSelect,
    flatPickr,
    VueUploadMultipleImage,
  },
  props: {
    data: {
      type: Object,
      required: true,
    },
  },
  data() {
    return {
      data_local: JSON.parse(JSON.stringify(this.data)),
      gallery_arr: [],
      formData: {},
      images: this.data.gallery ? this.data.gallery.split(",") : null,
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
    validateForm() {
      console.log("images", this.images);
      return (
        !this.errors.any() &&
        this.data_local.title !== "" &&
        this.data_local.desc !== ""
      );
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
    deleteRecord() {
      /* Below two lines are just for demo purpose */
      this.$store
        .dispatch("eventManagement/removeEvent", this.data_local.id)
        .then(() => {
          this.$router.push({
            name: "manage-events",
          });
          this.showDeleteSuccess();
        })
        .catch((err) => {
          console.error(err);
        });
    },
    showDeleteSuccess() {
      this.$vs.notify({
        color: "success",
        title: "Student Profile Deleted",
        text: "The selected student profile was successfully deleted",
      });
    },
    submitForm() {
      console.log("data_local", this.$validator.validateAll());
      console.log("data_local", this.data_local);
      this.$validator.validateAll();
      let obj = {
        id: this.$route.params.eventId,
        title: this.data_local.title,
        desc: this.data_local.desc,
      };
      if (!this.errors.any()) {
        this.$store
          .dispatch("eventManagement/updateEvent", obj)
          .then((res) => {
            console.log("res", res);
            if (res.data.response) {
              this.$vs.notify({
                color: "success",
                title: "Information Updated",
                text: "Event Updated Successfully!",
              });
              this.$router.push({ path: "/manage-events" });
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
    uploadImageSuccess(formData, index, fileList) {
      console.log("data", formData, index, fileList);
      this.formData = formData;
      // Upload image api
      axios
        .post("/api/v1/upload", formData)
        .then((response) => {
          console.log("response", response);
          this.gallery_arr.splice(index, 0, response.data.response);
          // this.gallery_arr.insert(index, response.data.response);
          console.log("gallery_arr", this.gallery_arr);
        })
        .catch((err) => {
          console.error(err);
        });
      // this.$store
      //   .dispatch("eventManagement/createEvent", this.formData)
      //   .then((res) => {
      //     console.log("res", res);
      //     // this.$router.push({ name: "manage-events" });
      //     // this.$vs.notify({
      //     //   color: "success",
      //     //   title: "Event created",
      //     //   text: "Event created successfully!",
      //     // });
      //   })
      //   .catch((err) => {
      //     console.error(err);
      //   });
    },
    beforeRemove(index, done, fileList) {
      console.log("index", index, fileList);
      var r = confirm("remove image");
      if (r == true) {
        delete this.gallery_arr[index];
        console.log("Remove", this.gallery_arr);
        done();
      } else {
      }
    },
    editImage(formData, index, fileList) {
      console.log("edit data", formData, index, fileList);
    },
  },
  created() {
    // Register Module UserManagement Module
    if (!moduleEventManagement.isRegistered) {
      this.$store.registerModule("eventManagement", moduleEventManagement);
      moduleEventManagement.isRegistered = true;
    }
    console.log("moduleEventManagement", moduleEventManagement);
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
