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
      :active.sync="user_not_found"
    >
      <span>User record with id: {{ $route.params.userId }} not found. </span>
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
            <span>Name</span>
          </div>
          <div class="vx-col sm:w-2/3 w-full">
            <vs-input
              v-validate="'required|alpha_spaces'"
              placeholder="Name"
              name="name"
              v-model="data_local.name"
              class="w-full"
              data-vv-validate-on="blur"
            />
            <span class="text-danger text-sm" v-show="errors.has('name')">{{
              errors.first("name")
            }}</span>
          </div>
        </div>
        <div class="vx-row mb-6">
          <div class="vx-col sm:w-1/3 w-full">
            <span>Email</span>
          </div>
          <div class="vx-col sm:w-2/3 w-full">
            <vs-input
              v-validate="'required|email'"
              placeholder="Email"
              name="email"
              class="w-full"
              type="email"
              v-model="data_local.email"
              data-vv-validate-on="blur"
            />
            <span class="text-danger text-sm" v-show="errors.has('email')">{{
              errors.first("email")
            }}</span>
          </div>
        </div>
        <div class="vx-row mb-6">
          <div class="vx-col sm:w-1/3 w-full">
            <span>Mobile</span>
          </div>
          <div class="vx-col sm:w-2/3 w-full">
            <vs-input
              v-validate="{ required: true, regex: '^([0-9]+)$' }"
              placeholder="Mobile"
              class="w-full"
              name="phone_number"
              v-model="data_local.phone_number"
              data-vv-validate-on="blur"
            />
            <span
              class="text-danger text-sm"
              v-show="errors.has('phone_number')"
              >{{ errors.first("phone_number") }}</span
            >
          </div>
        </div>
        <div class="vx-row mb-6">
          <div class="vx-col sm:w-1/3 w-full">
            <span>Password</span>
          </div>
          <div class="vx-col sm:w-2/3 w-full">
            <vs-input
              class="w-full"
              type="password"
              name="password"
              v-validate="'min:6'"
              v-model="data_local.password"
            />
            <span class="text-danger text-sm" v-show="errors.has('password')">{{
              errors.first("password")
            }}</span>
          </div>
        </div>
        <div class="vx-row mb-6">
          <div class="vx-col sm:w-1/3 w-full">
            <span>Confirm Password</span>
          </div>
          <div class="vx-col sm:w-2/3 w-full">
            <vs-input
              class="w-full"
              type="password"
              name="confirm_password"
              v-validate="'min:6'"
              v-model="data_local.confirm_password"
              data-vv-as="password"
            />
            <span
              class="text-danger text-sm"
              v-show="errors.has('confirm_password')"
              >{{ errors.first("confirm_password") }}</span
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
                data_local.name = data_local.email = data_local.phone_number = data_local.password = data_local.password_confirm =
                  '';
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
import moduleAccountantManagement from "@/store/accountant-management/moduleAccountantManagement.js";

export default {
  data() {
    return {
      data_local: {
        email: "",
        name: "",
        password: "",
        confirm_password: "",
        phone_number: "",
      },
      user_data: null,
      user_not_found: false,
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
  },
  methods: {
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
      this.$router.push({ name: "app-user-list" });
      this.showDeleteSuccess();

      /* UnComment below lines for enabling true flow if deleting user */
      // this.$store.dispatch("userManagement/removeRecord", this.user_data.id)
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
        this.$store
          .dispatch("accountantManagement/saveAccountant", this.data_local)
          .then((res) => {
            console.log("res", res);
            if (res.data.response) {
              this.$vs.notify({
                color: "success",
                title: "Information Updated",
                text: "Accountant Created successfully!",
              });
              this.$router.push({ path: "/manage-accountants" });
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
    if (!moduleAccountantManagement.isRegistered) {
      this.$store.registerModule(
        "accountantManagement",
        moduleAccountantManagement
      );
      moduleAccountantManagement.isRegistered = true;
    }
    const userId = this.$route.params.userId;
    this.$store
      .dispatch("accountantManagement/fetchUser", userId)
      .then((res) => {
        this.user_data = res.data;
      })
      .catch((err) => {
        if (err.response.status === 404) {
          this.user_not_found = true;
          return;
        }
        console.error(err);
      });
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
