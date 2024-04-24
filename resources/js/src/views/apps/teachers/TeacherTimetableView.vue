<template>
  <div id="simple-calendar-app">
    <div class="vx-card no-scroll-content">
      <vs-table class="bordered" :data="timetable_data" stripe>
        <template slot="thead" class="bg-primary" border>
          <vs-td class="text-center font-semibold"
            ><h5 class="py-3">Time</h5></vs-td
          >
          <vs-td
            class="text-center font-semibold"
            :key="indextr3"
            v-for="(tr3, indextr3) in day_data"
          >
            <h5 class="py-3 font-semibold">
              {{ tr3.label }}
            </h5>
          </vs-td>
        </template>
        <template>
          <vs-tr :key="indextr" v-for="(tr, indextr) in hour_data">
            <vs-td class="text-center py-5 align-middle font-semibold">
              {{ tr.label ? tr.label : "-" }}
            </vs-td>
            <vs-td
              class="text-center py-5 align-middle"
              :key="indextr2"
              v-for="(tr2, indextr2) in day_data"
            >
              <div class="w-full bg-primary-light">
                {{ timetable_data[tr.value][indextr2].hour }}
              </div>
              <p class="font-semibold">
                {{
                  timetable_data[tr.value][indextr2].class_name
                    ? `${timetable_data[tr.value][indextr2].class_name} Class`
                    : "-"
                }}
              </p>
              <p class="text-primary font-semibold">
                {{ timetable_data[tr.value][indextr2].subject_name }}
              </p>
              <p class="text-warning font-semibold">
                {{ timetable_data[tr.value][indextr2].teacher_name }}
              </p>
            </vs-td>
          </vs-tr>
        </template>
      </vs-table>
    </div>
  </div>
</template>

<script>
import moduleTimeTableManagement from "@/store/timetable-management/moduleTimeTableManagement.js";

export default {
  data() {
    return {
      day_data: [],
      hour_data: [],
      timetable_data: [],
    };
  },
  computed: {
    timeTables() {
      console.log("timetables", this.$store.state.timetableManagement);
    },
    validForm() {
      return (
        this.title !== "" &&
        this.startDate !== "" &&
        this.endDate !== "" &&
        Date.parse(this.endDate) - Date.parse(this.startDate) >= 0 &&
        !this.errors.has("event-url")
      );
    },
    windowWidth() {
      return this.$store.state.windowWidth;
    },
  },
  methods: {
    hourData() {
      this.$store
        .dispatch("timetableManagement/fetchHours")
        .then((res) => {
          console.log("res.data.response", res.data.response);
          this.hour_data = res.data.response.map((hour) => ({
            label: `${hour.from} - ${hour.to}`,
            value: hour.id,
          }));
        })
        .catch((err) => {
          console.error(err);
        });
    },
    dayData() {
      this.$store
        .dispatch("timetableManagement/fetchDays")
        .then((res) => {
          console.log("res.data.response", res.data.response);
          this.day_data = res.data.response.map((day) => ({
            label: `${day.day}`,
            value: day.id,
          }));
        })
        .catch((err) => {
          console.error(err);
        });
    },
  },
  created() {
    if (!moduleTimeTableManagement.isRegistered) {
      this.$store.registerModule(
        "timetableManagement",
        moduleTimeTableManagement
      );
      moduleTimeTableManagement.isRegistered = true;
    }
    this.$store
      .dispatch(
        "timetableManagement/fetchTeacherTimeTable",
        this.$route.params.teacherId
      )
      .then((res) => {
        this.timetable_data = res.data.response;
      })
      .catch((err) => {
        console.error(err);
      });
    this.hourData();
    this.dayData();
  },
};
</script>

<style lang="scss">
@import "@sass/vuexy/apps/simple-calendar.scss";
// .vs-table-text {
//   text-transform: uppercase;
//   text-align: center;
//   font-weight: 600;
// }
.vs-table--thead {
  th {
    padding-top: 0;
    padding-bottom: 0;

    .vs-table-text {
      text-transform: uppercase;
      font-weight: 600;
      * {
        text-align: center;
      }
    }
  }
  th.td-check {
    padding: 0 15px !important;
  }
  tr {
    background: none;
    box-shadow: none;
  }
}
.bg-primary-light {
  background-color: #75afee;
  color: white;
}
.vs-con-table.bordered {
  border: 1px solid #75afee;
  border-collapse: collapse;
  .vs-table--thead {
    background-color: $primary;
    * {
      color: white;
    }
  }
}
.vs-table--not-data {
  display: none;
}
</style>
