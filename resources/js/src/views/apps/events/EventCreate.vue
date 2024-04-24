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
          <div class="vx-col w-full">
            <span>Event Images</span>
          </div>
          <div class="vx-row w-full" id="gallery_div" ref="gallery_div"></div>
          <div class="vx-col sm:w-2/3 w-full">
            <div class="flex items-start flex-col sm:flex-row">
              <div class="flex flex-wrap items-center mb-base">
                <div class="mt-5">
                  <vue-upload-multiple-image
                    :dragText="'Upload Files'"
                    :browseText="'(or) Select'"
                    :primaryText="'Default'"
                    :markIsPrimaryText="'Set as default'"
                    :popupText="'This image will be displayed as the default'"
                    :dropText="'Drop your files here ...'"
                    @upload-success="uploadImageSuccess"
                    @before-remove="beforeRemove"
                    @edit-image="editImage"
                    :data-images="images"
                  ></vue-upload-multiple-image>
                </div>
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
import UploadService from "./../../../services/UploadFilesService";
import vSelect from "vue-select";
import flatPickr from "vue-flatpickr-component";
import "flatpickr/dist/flatpickr.css";
import axios from "./../../../axios";
export default {
  components: {
    vSelect,
    flatPickr,
    VueUploadMultipleImage,
  },
  data() {
    return {
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
  methods: {
    capitalize(str) {
      return str;
    },
    confirmDeleteRecord() {
      this.$vs.dialog({
        type: "confirm",
        color: "danger",
        title: "Confirm Delete",
        text: `You are about to delete "${this.event_data.title}"`,
        accept: this.deleteRecord,
        acceptText: "Delete",
      });
    },
    deleteRecord() {
      /* Below two lines are just for demo purpose */
      this.$router.push({ name: "app-event-list" });
      this.showDeleteSuccess();
    },
    showDeleteSuccess() {
      this.$vs.notify({
        color: "success",
        title: "Student Profile Deleted",
        text: "The selected student profile was successfully deleted",
      });
    },
    submitForm(e) {
      /* eslint-disable */
      if (!this.validateForm) return;
      let formData_new = new FormData();
      let obj = {
        title: this.data_local.title,
        desc: this.data_local.desc,
        gallery: this.gallery_arr,
        created_by: this.$store.state.AppActiveUser.id,
      };
      /*
      console.log(this.formData);
      formData_new.append("gallery", this.formData);
      formData_new.append("title", this.title);
      formData_new.append("desc", this.desc);
      formData_new.append("created_by", this.$store.state.AppActiveUser.id); */
      // this.formData.append("image", this.image);
      // this.formData.append("title", this.title);
      // this.formData.append("desc", this.desc);
      // this.formData.append("created_by", this.$store.state.AppActiveUser.id);
      // console.log("this");
      // console.log(this.formData);
      this.$store
        .dispatch("eventManagement/createEvent", obj)
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
              title: "Event Created Successfully!",
              text: res.data.message,
            });
            this.$router.push({ name: "manage-events" });
          }
          // this.$vs.notify({
          //   color: "success",
          //   title: "Event created",
          //   text: "Event created successfully!",
          // });
        })
        .catch((err) => {
          console.error(err);
        });
      // Here will go your API call for updating data
      // You can get data in "this.data_local"
      /* eslint-enable */
    },
    update_avatar() {
      // You can update avatar Here
      // For reference you can check dataList example
      // We haven't integrated it here, because data isn't saved in DB
    },
    onImageChange(e) {
      let gallery = e.target.files;
      let html = "";
      let formData_new = new FormData();
      if (gallery && gallery.length > 0) {
        gallery.forEach((key, element) => {
          let path = URL.createObjectURL(element);
          formData_new.append(`gallery[${key}]`, element, element.name);
          html += `<div class="vx-col sm:w-1/4 md:w-1/4 lg:w-1/4"><img src="${path}" class="img-fluid gallery-image"></div>`;
        });
      }
      // let new_data = $(html);
      this.$refs["gallery_div"].innerHTML = html;
      this.formData = formData_new;
      // console.log(html);

      // formData.append("id", this.data_local.id);
      // formData.append("id", this.data_local.id);
      // formData.append("id", this.data_local.id);
      // this.$store
      //   .dispatch("eventManagement/uploadImage", formData)
      //   .then((res) => {
      //     this.$vs.notify({
      //       color: "success",
      //       title: "Image created",
      //       text: "Image updated successfully!",
      //     });
      //   })
      //   .catch((err) => {
      //     console.error(err);
      //   });
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
.gallery-image {
  max-width: 100%;
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
