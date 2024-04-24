<template>
  <div :style="{ direction: $vs.rtl ? 'rtl' : 'ltr' }">
    <feather-icon
      icon="EyeIcon"
      svgClasses="h-5 w-5 mr-4 hover:text-primary cursor-pointer"
      @click="viewVoucher"
    />
    <vs-prompt
      size="lg"
      class="calendar-event-dialog"
      title="Fee Voucher"
      @accept="generatePDF"
      accept-text="Print Voucher"
      :active.sync="activePromptAddEvent"
    >
      <div class="con-exemple-prompt w-full position-relative" id="facture">
        <div class="container-fluid">
          <div class="row">
            <div class="fees-print-copy">
              <img
                src="http://www.ahpsdharamshala.com/images/logo.png"
                alt=""
              />
            </div>
            <div class="vs-col lg:w-1/3 sm:w-1/3">
              <h4>
                <b><u>Achievers Hub Public School</u></b>
                <br />
                <h2>+91-1892-222263</h2>
              </h4>
              <p>
                Dharamshala (H.P)
                <br />
                Website: <strong>www.ahpsDharamshala.com</strong>
                <br />
                E-mail: <strong>contact@ahpsDharamshala.com</strong>
                <span class="pull-right" style="transform: rotate(90deg)"
                  >Parent Copy</span
                >
                <br />
                <br />
                Fee Voucher # : <b>{{ this.params.data.voucher_detail.id }}</b>
                <br />
                Due Date : <b>{{ this.params.data.voucher_detail.due_date }}</b>
              </p>
              <table class="table-bordered">
                <tr>
                  <td>Name</td>
                  <th colSpan="2" class="text-uppercase">
                    {{
                      this.params.data.voucher_detail.student_details.name
                        ? this.params.data.voucher_detail.student_details.name
                        : ""
                    }}
                    /
                    {{
                      this.params.data.voucher_detail.student_details
                        .father_name
                    }}
                    <br />
                    Class: {{ this.params.data.voucher_detail.class_name }}
                  </th>
                </tr>
                <tr>
                  <td>Month</td>
                  <th colspan="2">
                    {{ this.params.data.voucher_detail.fee_month }}
                  </th>
                </tr>
                <tr>
                  <td colSpan="2">Student #ID</td>
                  <th>{{ this.params.data.voucher_detail.student_id }}</th>
                </tr>
                <tr
                  v-if="
                    this.params.data.voucher_detail.particulars &&
                    this.params.data.voucher_detail.particulars.length > 0
                  "
                >
                  <th>
                    No. {{ this.params.data.voucher_detail.particulars.length }}
                  </th>
                  <th>Particulars</th>
                  <th>Amount</th>
                </tr>
                <tr
                  v-for="(item, index) in this.params.data.voucher_detail
                    .particulars"
                  :key="index"
                >
                  <td>{{ index + 1 }}</td>
                  <td>{{ item.particulars }}</td>
                  <td>{{ item.amount }}</td>
                </tr>
                <tr>
                  <th colSpan="2">Current Month Fee</th>
                  <th>{{ this.params.data.voucher_detail.total_fee }}</th>
                </tr>

                <tr>
                  <th class="text-success" colSpan="2">Concession</th>
                  <th class="text-success">0.00</th>
                </tr>
                <tr>
                  <th class="text-danger" colSpan="2">Within Due Date Rs</th>
                  <th class="text-danger">
                    {{ this.params.data.voucher_detail.total_fee }}
                  </th>
                </tr>
                <tr>
                  <th class="text-danger" colSpan="2">Surcharge Rs</th>
                  <th class="text-danger">
                    {{ this.params.data.voucher_detail.late_fee }}
                  </th>
                </tr>
                <tr>
                  <th class="text-danger" colSpan="2">After Due Date Rs</th>
                  <th class="text-danger">
                    {{ this.params.data.voucher_detail.fee_after_due_date }}
                  </th>
                </tr>
                <tr>
                  <td colSpan="3">
                    <b>In Words: </b
                    ><span class="text-capitalize">{{
                      this.params.data.voucher_detail.in_words
                    }}</span>
                  </td>
                </tr>
                <tr>
                  <td colSpan="3" class="text-center">
                    <img
                      src="data:image/png;base64, iVBORw0KGgoAAAANSUhEUgAAAJAAAAAhAQMAAAAMHrArAAAABlBMVEX///8AAABVwtN+AAAAAXRSTlMAQObYZgAAAAlwSFlzAAAOxAAADsQBlSsOGwAAABtJREFUKJFj6N61GA5frHuxrnsXw6jQqBANhQASQ5134dyQlwAAAABJRU5ErkJggg=="
                      alt="barcode"
                    />
                  </td>
                </tr>
              </table>
              <p class="text-muted text-center">
                <small>Developed By: TechSayvy It Services</small>
              </p>
            </div>
            <div class="vs-col lg:w-1/3 sm:w-1/3 vl">
              <h4>
                <b><u>Achievers Hub Public School</u></b>
                <br />
                <h2>+91-1892-222263</h2>
              </h4>
              <p>
                Dharamshala (H.P)
                <br />
                Website: <strong>www.ahpsDharamshala.com</strong>
                <br />
                E-mail: <strong>contact@ahpsDharamshala.com</strong>
                <span class="pull-right" style="transform: rotate(90deg)"
                  >School Copy</span
                >
                <br />
                <br />
                Fee Voucher # : <b>{{ this.params.data.voucher_detail.id }}</b>
                <br />
                Due Date : <b>{{ this.params.data.voucher_detail.due_date }}</b>
              </p>
              <table class="table-bordered">
                <tr>
                  <td>Name</td>
                  <th colSpan="2" class="text-uppercase">
                    {{ this.params.data.voucher_detail.student_details.name }}
                    /
                    {{
                      this.params.data.voucher_detail.student_details
                        .father_name
                    }}
                    <br />
                    Class: {{ this.params.data.voucher_detail.class_name }}
                  </th>
                </tr>
                <tr>
                  <td>Month</td>
                  <th colspan="2">
                    {{ this.params.data.voucher_detail.fee_month }}
                  </th>
                </tr>
                <tr>
                  <td colSpan="2">Student #ID</td>
                  <th>{{ this.params.data.voucher_detail.student_id }}</th>
                </tr>
                <tr
                  v-if="
                    this.params.data.voucher_detail.particulars &&
                    this.params.data.voucher_detail.particulars.length > 0
                  "
                >
                  <th>
                    No. {{ this.params.data.voucher_detail.particulars.length }}
                  </th>
                  <th>Particulars</th>
                  <th>Amount</th>
                </tr>
                <tr
                  v-for="(item, index) in this.params.data.voucher_detail
                    .particulars"
                  :key="index"
                >
                  <td>{{ index + 1 }}</td>
                  <td>{{ item.particulars }}</td>
                  <td>{{ item.amount }}</td>
                </tr>
                <tr>
                  <th colSpan="2">Current Month Fee</th>
                  <th>{{ this.params.data.voucher_detail.total_fee }}</th>
                </tr>

                <tr>
                  <th class="text-success" colSpan="2">Concession</th>
                  <th class="text-success">0.00</th>
                </tr>
                <tr>
                  <th class="text-danger" colSpan="2">Within Due Date Rs</th>
                  <th class="text-danger">
                    {{ this.params.data.voucher_detail.total_fee }}
                  </th>
                </tr>
                <tr>
                  <th class="text-danger" colSpan="2">Surcharge Rs</th>
                  <th class="text-danger">
                    {{ this.params.data.voucher_detail.late_fee }}
                  </th>
                </tr>
                <tr>
                  <th class="text-danger" colSpan="2">After Due Date Rs</th>
                  <th class="text-danger">
                    {{ this.params.data.voucher_detail.fee_after_due_date }}
                  </th>
                </tr>
                <tr>
                  <td colSpan="3">
                    <b>In Words: </b
                    ><span class="text-capitalize">{{
                      this.params.data.voucher_detail.in_words
                    }}</span>
                  </td>
                </tr>
                <tr>
                  <td colSpan="3" class="text-center">
                    <img
                      src="data:image/png;base64, iVBORw0KGgoAAAANSUhEUgAAAJAAAAAhAQMAAAAMHrArAAAABlBMVEX///8AAABVwtN+AAAAAXRSTlMAQObYZgAAAAlwSFlzAAAOxAAADsQBlSsOGwAAABtJREFUKJFj6N61GA5frHuxrnsXw6jQqBANhQASQ5134dyQlwAAAABJRU5ErkJggg=="
                      alt="barcode"
                    />
                  </td>
                </tr>
              </table>
              <p class="text-muted text-center">
                <small>Developed By: TechSayvy It Services</small>
              </p>
            </div>
            <div class="vs-col lg:w-1/3 sm:w-1/3 vl">
              <h4>
                <b><u>Achievers Hub Public School</u></b>
                <br />
                <h2>+91-1892-222263</h2>
              </h4>
              <p>
                Dharamshala (H.P)
                <br />
                Website: <strong>www.ahpsDharamshala.com</strong>
                <br />
                E-mail: <strong>contact@ahpsDharamshala.com</strong>
                <span class="pull-right" style="transform: rotate(90deg)"
                  >Bank Copy</span
                >
                <br />
                <br />
                Fee Voucher # : <b>{{ this.params.data.voucher_detail.id }}</b>
                <br />
                Due Date : <b>{{ this.params.data.voucher_detail.due_date }}</b>
              </p>
              <table class="table-bordered">
                <tr>
                  <td>Name</td>
                  <th colSpan="2" class="text-uppercase">
                    {{ this.params.data.voucher_detail.student_details.name }}
                    /
                    {{
                      this.params.data.voucher_detail.student_details
                        .father_name
                    }}
                    <br />
                    Class: {{ this.params.data.voucher_detail.class_name }}
                  </th>
                </tr>
                <tr>
                  <td>Month</td>
                  <th colspan="2">
                    {{ this.params.data.voucher_detail.fee_month }}
                  </th>
                </tr>
                <tr>
                  <td colSpan="2">Student #ID</td>
                  <th>{{ this.params.data.voucher_detail.student_id }}</th>
                </tr>
                <tr
                  v-if="
                    this.params.data.voucher_detail.particulars &&
                    this.params.data.voucher_detail.particulars.length > 0
                  "
                >
                  <th>
                    No. {{ this.params.data.voucher_detail.particulars.length }}
                  </th>
                  <th>Particulars</th>
                  <th>Amount</th>
                </tr>
                <tr
                  v-for="(item, index) in this.params.data.voucher_detail
                    .particulars"
                  :key="index"
                >
                  <td>{{ index + 1 }}</td>
                  <td>{{ item.particulars }}</td>
                  <td>{{ item.amount }}</td>
                </tr>
                <tr>
                  <th colSpan="2">Current Month Fee</th>
                  <th>{{ this.params.data.voucher_detail.total_fee }}</th>
                </tr>

                <tr>
                  <th class="text-success" colSpan="2">Concession</th>
                  <th class="text-success">0.00</th>
                </tr>
                <tr>
                  <th class="text-danger" colSpan="2">Within Due Date Rs</th>
                  <th class="text-danger">
                    {{ this.params.data.voucher_detail.total_fee }}
                  </th>
                </tr>
                <tr>
                  <th class="text-danger" colSpan="2">Surcharge Rs</th>
                  <th class="text-danger">
                    {{ this.params.data.voucher_detail.late_fee }}
                  </th>
                </tr>
                <tr>
                  <th class="text-danger" colSpan="2">After Due Date Rs</th>
                  <th class="text-danger">
                    {{ this.params.data.voucher_detail.fee_after_due_date }}
                  </th>
                </tr>
                <tr>
                  <td colSpan="3">
                    <b>In Words: </b
                    ><span class="text-capitalize">{{
                      this.params.data.voucher_detail.in_words
                    }}</span>
                  </td>
                </tr>
                <tr>
                  <td colSpan="3" class="text-center">
                    <img
                      src="data:image/png;base64, iVBORw0KGgoAAAANSUhEUgAAAJAAAAAhAQMAAAAMHrArAAAABlBMVEX///8AAABVwtN+AAAAAXRSTlMAQObYZgAAAAlwSFlzAAAOxAAADsQBlSsOGwAAABtJREFUKJFj6N61GA5frHuxrnsXw6jQqBANhQASQ5134dyQlwAAAABJRU5ErkJggg=="
                      alt="barcode"
                    />
                  </td>
                </tr>
              </table>
              <p class="text-muted text-center">
                <small>Developed By: TechSayvy It Services</small>
              </p>
            </div>
          </div>
          <footer></footer>
        </div>
      </div>
    </vs-prompt>
  </div>
</template>

<script>
import { jsPDF } from "jspdf";
import html2canvas from "html2canvas";
import moment from "moment";
import VueHtmlToPaper from "vue-html-to-paper";
export default {
  name: "CellRendererVoucherActions",
  data() {
    return {
      activePromptAddEvent: false,
      voucher_data: [],
    };
  },
  methods: {
    viewVoucher() {
      console.log("viewing...");
      this.activePromptAddEvent = true;
    },
    generatePDF() {
      this.$htmlToPaper("facture");
    },
    editRecord() {
      this.$router
        .push(`/charges-edit/` + this.params.data.fee_details.id)
        .catch(() => {});
    },
    confirmDeleteRecord() {
      this.$vs.dialog({
        type: "confirm",
        color: "danger",
        title: "Confirm Delete",
        text: `Are you sure you want to delete "${this.params.data.fee_details.title}"?`,
        accept: this.deleteRecord,
        acceptText: "Delete",
      });
    },
    deleteRecord() {
      /* Below two lines are just for demo purpose */
      // this.showDeleteSuccess();

      /* UnComment below lines for enabling true flow if deleting user */
      this.$store
        .dispatch(
          "tuitionFeeManagement/removeRecord",
          this.params.data.fee_details.id
        )
        .then(() => {
          this.showDeleteSuccess();
        })
        .catch((err) => {
          console.error(err);
        });
    },
    showDeleteSuccess() {
      this.$vs.notify({
        color: "success",
        title: "Charges Deleted",
        text: "The selected charges was successfully deleted",
      });
    },
  },
  created() {
    // this.$store
    //   .dispatch("feeVoucherManagement/GetVoucherDetails", this.params.data.id)
    //   .then(async (res) => {
    //     this.voucher_data = await res.data.response;
    //     console.log("voucher res", this.voucher_data);
    //   })
    //   .catch((err) => {
    //     console.error(err);
    //   });
  },
};
</script>
<style>
.vs-dialog {
  max-width: 100% !important;
  margin: 0;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  height: 100vh;
  position: relative;
}
.con-vs-dialog .vs-dialog header {
  width: 100%;
}
.con-vs-dialog .vs-dialog footer {
  width: 100%;
}
.vs-table--not-data {
  display: none;
}
@media print {
  @page {
    size: landscape;
  }
}
.fees-print-copy img {
  position: absolute;
  transform: rotate(-5deg);
}
.fees-print-copy {
  opacity: 0.07;
}
.fees-print-copy img {
  position: absolute;
  transform: rotate(-5deg);
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  width: 50%;
}
.vl {
  border-left: 1px dashed;
  height: auto;
  padding-left: 20px;
}
table {
  width: 100%;
}
table td,
th {
  padding: 5px;
}
@media print {
  footer {
    page-break-after: always;
  }
  @page {
    margin: 15px 10px 0 10px;
  }
}
.pull-right {
  float: right !important;
  transform: rotate(90deg);
}
.text-capitalize {
  text-transform: capitalize;
}
</style>
