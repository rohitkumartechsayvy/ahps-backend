<!-- =========================================================================================
    File Name: Invoice.vue
    Description: Invoice Page
    ----------------------------------------------------------------------------------------
    Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
      Author: Pixinvent
    Author URL: http://www.themeforest.net/user/pixinvent
========================================================================================== -->


<template>
  <div id="invoice-page">
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
      <!-- INVOICE METADATA -->
      <div class="vx-row leading-loose p-base">
        <div class="vx-col w-1/2 mt-base">
          <img
            :src="require(`@assets/images/logo/logo.png`)"
            class="rounded w-20 logo_width"
          />
        </div>
        <div class="vx-col w-1/2 text-right">
          <h1>Invoice</h1>
          <div class="invoice__invoice-detail mt-6">
            <h6>INVOICE NO.</h6>
            <p>{{ invoiceDetails.invoiceNo }}</p>

            <h6 class="mt-4">INVOICE DATE</h6>
            <p>{{ invoiceDetails.invoiceDate | date(true) }}</p>
          </div>
        </div>
      </div>

      <!-- INVOICE FOOTER -->
      <div class="invoice__footer text-right p-base">
        <p class="mb-4">
          Transfer the amounts to the business amount below. Please include
          invoice number on your check.
        </p>
        <p>
          <span class="mr-8"
            >BANK: <span class="font-semibold">FTSBUS33</span></span
          >
          <span
            >IBAN:
            <span class="font-semibold"> G882-1111-2222-3333 </span></span
          >
        </p>
      </div>
    </vx-card>
  </div>
</template>

<script>
export default {
  data() {
    return {
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
};
</script>

<style lang="scss">
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
</style>
