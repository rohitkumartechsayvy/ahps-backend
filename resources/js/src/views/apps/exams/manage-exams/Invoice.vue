<!-- =========================================================================================
    File Name: Invoice.vue
    Description: Invoice Page
    ----------------------------------------------------------------------------------------
    Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
      Author: Pixinvent
    Author URL: http://www.themeforest.net/user/pixinvent
========================================================================================== -->


<template>
  <div id="invoice-page" v-if="exam_data">
    <div class="flex flex-wrap items-center justify-between">
      <vx-input-group class="mb-base mr-3"> </vx-input-group>
      <div class="flex items-center">
        <vs-button
          class="mb-base mr-3"
          type="border"
          icon-pack="feather"
          icon="icon icon-download"
          >Download</vs-button
        >
        <vs-button
          class="mb-base mr-3"
          icon-pack="feather"
          icon="icon icon-file"
          @click="printInvoice"
          >Print</vs-button
        >
      </div>
    </div>

    <vx-card id="invoice-container">
      <div class="container-fluid">
        <div class="container">
          <vs-row class="text-center">
            <div class="vs-col w-full">
              <img
                :src="require(`@assets/images/logo/logo1.png`)"
                class="rounded w-full side_logo"
              />
            </div>
            <div class="vs-col w-full">
              <p>
                <span class="font-bold font-weight-bold" style="font-size: 40px"
                  >Achievers Hub Public School Dharamshala</span
                >
                <br />
                <span class=" "> </span>
                <br />
              </p>
            </div>
          </vs-row>
          <div class="card-border">
            <vs-row>
              <vs-col
                vs-type="flex"
                vs-justify="center"
                vs-align="center"
                vs-w="8"
                class="p-4 sm:p-2"
              >
                <table class="table borderless w-full">
                  <tr>
                    <th>Enrolment#:</th>
                    <th>{{ exam_data.student_id }}</th>
                  </tr>

                  <tr>
                    <th width="30%">Student Name:</th>
                    <th class="text-uppercase">
                      {{ exam_data.student_details.name }} /
                      {{ exam_data.student_details.father_name }}
                    </th>
                  </tr>
                  <tr>
                    <th>Class</th>
                    <th>{{ exam_data.class_name }}</th>
                  </tr>
                  <tr>
                    <th>Roll #</th>
                    <th>{{ exam_data.student_id }}</th>
                  </tr>
                </table>
              </vs-col>
              <vs-col
                vs-type="flex"
                vs-justify="center"
                vs-align="center"
                vs-w="4"
                class="p-4 sm:p-2"
              >
                <h4 class="font-bold">
                  <span class="fa fa-info"></span> Annual Performance
                </h4>
                <div
                  style="
                    border-radius: 52px;
                    background: lightblue;
                    border: 2px solid blue;
                    padding: 8px 0px 8px 52px;
                    width: 196px;
                    height: 70px;
                  "
                >
                  <h2 style="font-weight: 400; font-size: 32px">
                    {{ exam_data.obtained_grade }}
                  </h2>
                </div>
              </vs-col>
            </vs-row>
            <h3 class="text-center m-0">
              <i
                ><u>{{ exam_data.exam_details.exam_title }}</u></i
              >
            </h3>
            <vs-row>
              <vs-col
                vs-type="flex"
                vs-justify="center"
                vs-align="center"
                vs-w="12"
                class="p-4 sm:p-2"
              >
                <div class="logo-school">
                  <img
                    :src="require(`@assets/images/logo/logo1.png`)"
                    class="rounded w-full side_logo"
                  />
                </div>
                <vs-table class="table table-bordered subject-table w-full">
                  <template slot="thead">
                    <vs-th class="font-semibold text-center">Sr#</vs-th>
                    <vs-th class="font-semibold text-center">Subject</vs-th>
                    <vs-th class="font-semibold text-center">Total Marks</vs-th>
                    <vs-th class="font-semibold text-center"
                      >Passing Marks</vs-th
                    >
                    <vs-th class="font-semibold text-center"
                      >Obtained Marks</vs-th
                    >
                    <vs-th class="font-semibold text-center">Max Grade</vs-th>
                    <vs-th class="font-semibold text-center"
                      >Passing Grade</vs-th
                    >
                    <vs-th class="font-semibold text-center"
                      >Obtained Grade</vs-th
                    >
                    <vs-th class="font-semibold text-center">Pass/Fail</vs-th>
                  </template>
                  <tbody
                    v-for="(item, index) in this.exam_data.logs"
                    :key="index"
                  >
                    <tr>
                      <td class="text-center">{{ index + 1 }}</td>
                      <td>{{ item.subject }}</td>
                      <td class="text-center">{{ item.subject_max_marks }}</td>
                      <td class="text-center">
                        {{ item.subject_passing_marks }}
                      </td>
                      <td class="text-center">
                        {{ item.subject_obtained_marks }}
                      </td>
                      <td class="text-center">{{ item.subject_max_grade }}</td>
                      <td class="text-center">
                        {{ item.subject_passing_grade }}
                      </td>
                      <td class="text-center">
                        {{ item.subject_obtained_grade }}
                      </td>
                      <td class="text-center">
                        <span class="text-success">{{
                          item.subject_obtained_position
                        }}</span>
                      </td>
                    </tr>
                  </tbody>
                  <tfoot>
                    <tr>
                      <th class="text-center py-4">Total</th>
                      <th></th>
                      <th class="text-center py-4">
                        {{ exam_data.total_marks }}
                      </th>
                      <th class="text-center py-4"></th>
                      <th class="text-center py-4">
                        {{ exam_data.obtained_marks }}
                      </th>
                      <th class="text-center py-4"></th>
                      <th class="text-center py-4"></th>
                      <th class="text-center py-4">
                        {{ exam_data.obtained_grade }}
                      </th>
                      <th class="text-center py-4">
                        <span class="text-success">Pass</span>
                      </th>
                    </tr>
                  </tfoot>
                </vs-table>
              </vs-col>
            </vs-row>
            <br />
          </div>
          <vs-row>
            <vs-col vs-align="left" vs-w="4" class="p-4 sm:p-2">
              <br />
              <h4>Ms. Vandana Sharma</h4>
              <br />
              <h4 class="font-bold text-primary">Class Incharge</h4>
            </vs-col>
            <vs-col vs-align="left" vs-w="4" class="p-4 sm:p-2">
              <br />
              <h4>Ms. Vandana Sharma</h4>
              <br />
              <h4 class="font-bold">Principal Sign</h4>
            </vs-col>
            <vs-col vs-align="right" vs-w="4" class="p-4 sm:p-2">
              <br />
              <h4 class="display-block">Ms. Vandana Sharma</h4>
              <br />
              <h4 class="font-bold">Vice Principal Sign</h4>
            </vs-col>
          </vs-row>
        </div>
      </div>
    </vx-card>
  </div>
  <vx-card id="invoice-container" v-else>
    <div class="container-fluid">
      <div class="container">
        <vs-row class="text-center">
          <div class="vs-col w-full">
            <h1>
              <h1>No Report Card Generated For You Yet.</h1>
            </h1>
          </div>
        </vs-row>
      </div>
    </div>
  </vx-card>
</template>

<script>
import moduleExamManagement from "@/store/exam-management/moduleExamManagement.js";
export default {
  data() {
    return {
      exam_data: [],
      mailTo: "",
      companyDetails: {
        name: "Microsion Technologies Pvt. Ltd.",
        addressLine1: "9 N. Sherwood Court",
        addressLine2: "Elyria, OH",
        zipcode: "94203",
        mailId: "hello@pixinvent.net",
        mobile: "+91 999 999 9999",
      },
      recipientDetails: {
        fullName: "Peter Stark",
        addressLine1: "8577 West West Drive ",
        addressLine2: "Holbrook, NY",
        zipcode: "90001",
        mailId: "peter@mail.com",
        mobile: "+91 988 888 8888",
      },
      invoiceDetails: {
        invoiceNo: "001/2019",
        invoiceDate: "Mon Dec 10 2018 07:46:00 GMT+0000 (GMT)",
      },
      invoiceData: {
        tasks: [
          {
            id: 1,
            task: "Website Redesign",
            hours: 60,
            rate: 15,
            amount: 90000,
          },
          {
            id: 2,
            task: "Newsletter template design",
            hours: 20,
            rate: 12,
            amount: 24000,
          },
        ],
        subtotal: 114000,
        discountPercentage: 5,
        discountedAmount: 5700,
        total: 108300,
      },
    };
  },
  computed: {},
  methods: {
    printInvoice() {
      window.print();
    },
  },
  components: {},
  mounted() {
    this.$emit("setAppClasses", "invoice-page");
  },
  created() {
    // Register Module examManagement Module
    if (!moduleExamManagement.isRegistered) {
      this.$store.registerModule("examManagement", moduleExamManagement);
      moduleExamManagement.isRegistered = true;
    }
    const examId = this.$route.params.examId;
    const studentId = this.$route.params.studentId;
    let obj = {
      exam_id: examId,
      student_id: studentId,
    };
    this.$store
      .dispatch("examManagement/fetchStudentReportCard", obj)
      .then((res) => {
        this.exam_data = res.data.response;
        console.log("exam_data", this.exam_data);
      })
      .catch((err) => {
        console.error(err);
      });
    this.classData();
  },
};
</script>

<style lang="scss" media="print">
@media print {
  .invoice-page {
    * {
      visibility: hidden;
    }

    #content-area {
      margin: 0 !important;
    }

    .vs-con-table {
      .vs-con-tbody {
        overflow: hidden !important;
      }
    }

    #invoice-container,
    #invoice-container * {
      visibility: visible;
    }
    #invoice-container {
      position: absolute;
      left: 0;
      top: 0;
      box-shadow: none;
    }
    .logo_width {
      width: 100px;
    }
  }
}

@page {
  size: auto;
}
.borderless tr th {
  border: none !important;
  padding: 3px !important;
}

.subject-table tr td {
  padding: 3px !important;
}

.logo-school img {
  position: absolute;
  transform: rotate(-5deg);
}

.logo-school {
  opacity: 0.1;
}

.card-border {
  border: 3px solid rosybrown;
  border-radius: 10px;
  padding: 10px;
}

@media print {
}
@page {
  size: A4;
}

@media print {
  * {
    -webkit-print-color-adjust: exact !important;
    /*Chrome, Safari */
    color-adjust: exact !important;
    /*Firefox*/
  }

  footer {
    page-break-after: always;
  }
}
@media print {
  .d-print-none {
    display: none;
  }
}
.vs-table--not-data {
  display: none;
}
</style>
