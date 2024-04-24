<template>
  <div
    class="the-navbar__user-meta flex items-center"
    v-if="activeUserInfo.name"
  >
    <div class="text-right leading-tight hidden sm:block">
      <p class="font-semibold">{{ activeUserInfo.name }}</p>
      <small>Available</small>
    </div>

    <vs-dropdown vs-custom-content vs-trigger-click class="cursor-pointer">
      <div class="con-img ml-3">
        <img
          v-if="activeUserInfo.profile_picture"
          key="onlineImg"
          :src="`${activeUserInfo.profile_picture}`"
          alt="user-img"
          width="40"
          height="40"
          class="rounded-full shadow-md cursor-pointer block"
        />
      </div>

      <vs-dropdown-menu class="vx-navbar-dropdown">
        <ul style="min-width: 9rem">
          <li
            class="flex py-2 px-4 cursor-pointer hover:bg-primary hover:text-white"
            @click="$router.push('/manage-account').catch(() => {})"
          >
            <span class="ml-2">Manage Account</span>
          </li>
          <li
            class="flex py-2 px-4 cursor-pointer hover:bg-primary hover:text-white"
            @click="logout"
          >
            <feather-icon icon="LogOutIcon" svgClasses="w-4 h-4" />
            <span class="ml-2">Log out</span>
          </li>
        </ul>
      </vs-dropdown-menu>
    </vs-dropdown>
  </div>
</template>

<script>
import axios from "axios";
export default {
  data() {
    return {};
  },
  computed: {
    activeUserInfo() {
      return this.$store.state.AppActiveUser;
    },
  },
  methods: {
    logout() {
      // console.log("Weblogout", response);
      if (localStorage.getItem("userInfo")) {
        console.log("first", localStorage.getItem("accessToken"));
        localStorage.removeItem("userInfo");
        localStorage.removeItem("menu");
        localStorage.removeItem("super_admin_menu");
        localStorage.removeItem("subadmin_menu");
        localStorage.removeItem("accountant_menu");
        localStorage.removeItem("teacher_menu");
        localStorage.removeItem("student_menu");
        console.log("then", localStorage.getItem("accessToken"));
        location.reload();
        this.$router.push({ path: "login" });
      } else {
        localStorage.removeItem("userInfo");
        localStorage.removeItem("menu");
        localStorage.removeItem("super_admin_menu");
        localStorage.removeItem("subadmin_menu");
        localStorage.removeItem("accountant_menu");
        localStorage.removeItem("teacher_menu");
        localStorage.removeItem("student_menu");
        location.reload();
        this.$router.push({ path: "login" });
      }
      // axios
      //   .get("/api/auth/logout")
      //   .then((response) => {})
      //   .catch((error) => {
      //     location.reload();
      //   });
    },
  },
};
</script>
