<!-- =========================================================================================
  File Name: UserList.vue
  Description: User List page
  ----------------------------------------------------------------------------------------
  Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
========================================================================================== -->

<template>
  <div>
    <div class="vx-card p-6">
      <div class="flex flex-wrap items-center">
        <!-- ITEMS PER PAGE -->
        <div class="flex-grow">
          <vs-dropdown vs-trigger-click class="cursor-pointer">
            <div
              class="p-4 border border-solid d-theme-border-grey-light rounded-full d-theme-dark-bg cursor-pointer flex items-center justify-between font-medium"
            >
              <span class="mr-2"
                >{{
                  currentPage * paginationPageSize - (paginationPageSize - 1)
                }}
                -
                {{
                  ChargesData.length - currentPage * paginationPageSize > 0
                    ? currentPage * paginationPageSize
                    : ChargesData.length
                }}
                of {{ ChargesData.length }}</span
              >
              <feather-icon icon="ChevronDownIcon" svgClasses="h-4 w-4" />
            </div>
            <!-- <vs-button class="btn-drop" type="line" color="primary" icon-pack="feather" icon="icon-chevron-down"></vs-button> -->
            <vs-dropdown-menu>
              <vs-dropdown-item @click="gridApi.paginationSetPageSize(10)">
                <span>10</span>
              </vs-dropdown-item>
              <vs-dropdown-item @click="gridApi.paginationSetPageSize(50)">
                <span>50</span>
              </vs-dropdown-item>
              <vs-dropdown-item @click="gridApi.paginationSetPageSize(100)">
                <span>100</span>
              </vs-dropdown-item>
              <vs-dropdown-item @click="gridApi.paginationSetPageSize(500)">
                <span>500</span>
              </vs-dropdown-item>
            </vs-dropdown-menu>
          </vs-dropdown>
        </div>

        <!-- TABLE ACTION COL-2: SEARCH & EXPORT AS CSV -->
        <vs-input
          class="sm:mr-4 mr-0 sm:w-auto w-full sm:order-normal order-3 sm:mt-0 mt-4"
          v-model="searchQuery"
          @input="updateSearchQuery"
          placeholder="Search..."
        />
        <!-- <vs-button class="mb-4 md:mb-0" @click="gridApi.exportDataAsCsv()">Export as CSV</vs-button> -->

        <!-- ACTION - DROPDOWN -->
        <vs-dropdown vs-trigger-click class="cursor-pointer">
          <div
            class="p-3 shadow-drop rounded-lg d-theme-dark-light-bg cursor-pointer flex items-end justify-center text-lg font-medium w-32"
          >
            <span class="mr-2 leading-none">Actions</span>
            <feather-icon icon="ChevronDownIcon" svgClasses="h-4 w-4" />
          </div>

          <vs-dropdown-menu>
            <vs-dropdown-item>
              <span class="flex items-center">
                <feather-icon
                  icon="TrashIcon"
                  svgClasses="h-4 w-4"
                  class="mr-2"
                />
                <span>Delete</span>
              </span>
            </vs-dropdown-item>

            <vs-dropdown-item>
              <span class="flex items-center">
                <feather-icon
                  icon="ArchiveIcon"
                  svgClasses="h-4 w-4"
                  class="mr-2"
                />
                <span>Archive</span>
              </span>
            </vs-dropdown-item>

            <vs-dropdown-item>
              <span class="flex items-center">
                <feather-icon
                  icon="FileIcon"
                  svgClasses="h-4 w-4"
                  class="mr-2"
                />
                <span>Print</span>
              </span>
            </vs-dropdown-item>

            <vs-dropdown-item>
              <span class="flex items-center">
                <feather-icon
                  icon="SaveIcon"
                  svgClasses="h-4 w-4"
                  class="mr-2"
                />
                <span>CSV</span>
              </span>
            </vs-dropdown-item>
          </vs-dropdown-menu>
        </vs-dropdown>
      </div>

      <!-- AgGrid Table -->
      <ag-grid-vue
        ref="agGridTable"
        :components="components"
        :gridOptions="gridOptions"
        class="ag-theme-material w-100 my-4 ag-grid-table"
        :columnDefs="columnDefs"
        :defaultColDef="defaultColDef"
        :rowData="ChargesData"
        rowSelection="multiple"
        colResizeDefault="shift"
        :animateRows="true"
        :floatingFilter="true"
        :pagination="true"
        :paginationPageSize="paginationPageSize"
        :suppressPaginationPanel="true"
        :enableRtl="$vs.rtl"
      ></ag-grid-vue>

      <vs-pagination :total="totalPages" :max="7" v-model="currentPage" />
    </div>
  </div>
</template>

<script>
import { AgGridVue } from "ag-grid-vue";
import "@sass/vuexy/extraComponents/agGridStyleOverride.scss";
import vSelect from "vue-select";

// Store Module
import moduleFeeVoucherManagement from "@/store/fee-voucher-management/moduleFeeVoucherManagement.js";

// Cell Renderer
import CellRendererLink from "./cell-renderer/CellRendererLink.vue";
import CellRendererName from "./cell-renderer/CellRendererName.vue";
import CellRendererStatus from "./cell-renderer/CellRendererStatus.vue";
import CellRendererVerified from "./cell-renderer/CellRendererVerified.vue";
import CellRendererVoucherActions from "./cell-renderer/CellRendererVoucherActions.vue";
import CellRendererPay from "./cell-renderer/CellRendererPay.vue";
// import FeatherIcon from "./../FeatherIcon";
import FeatherIcon from "../../../../components/FeatherIcon.vue";
export default {
  components: {
    AgGridVue,
    vSelect,

    // Cell Renderer
    CellRendererLink,
    CellRendererName,
    CellRendererPay,
    CellRendererStatus,
    CellRendererVerified,
    CellRendererVoucherActions,
    FeatherIcon,
  },
  data() {
    return {
      readMore: false,
      searchQuery: "",

      // AgGrid
      gridApi: null,
      gridOptions: {},
      defaultColDef: {
        sortable: true,
        resizable: true,
        suppressMenu: true,
      },
      columnDefs: [
        {
          headerName: "ID",
          field: "id",
          width: 125,
          filter: true,
          checkboxSelection: true,
          headerCheckboxSelectionFilteredOnly: true,
          headerCheckboxSelection: true,
        },
        {
          headerName: "Student ID",
          field: "student_id",
          filter: true,
          width: 210,
        },
        {
          headerName: "Student Name",
          field: "student_name",
          filter: true,
          width: 210,
        },
        {
          headerName: "Class",
          field: "class_name",
          filter: true,
          width: 210,
        },
        {
          headerName: "Total Fee",
          field: "total_fee",
          filter: true,
          width: 210,
        },
        {
          headerName: "Fee Month",
          field: "fee_month",
          filter: true,
          width: 210,
        },
        {
          headerName: "Fee Status",
          field: "fee_status",
          filter: true,
          width: 210,
          cellRendererFramework: "CellRendererStatus",
        },
        {
          headerName: "Due Date",
          field: "due_date",
          filter: true,
          width: 210,
        },
        {
          headerName: "Pay",
          field: "transactions",
          width: 150,
          cellRendererFramework: "CellRendererPay",
        },
        {
          headerName: "Print",
          field: "transactions",
          width: 150,
          cellRendererFramework: "CellRendererVoucherActions",
        },
      ],

      // Cell Renderer Components
      components: {
        CellRendererLink,
        CellRendererStatus,
        CellRendererPay,
        CellRendererVerified,
        CellRendererVoucherActions,
      },
    };
  },
  watch: {},
  computed: {
    ChargesData() {
      console.log(this.$store.state.feeVoucherManagement.vouchers);
      return this.$store.state.feeVoucherManagement.vouchers;
    },
    paginationPageSize() {
      if (this.gridApi) return this.gridApi.paginationGetPageSize();
      else return 10;
    },
    totalPages() {
      if (this.gridApi) return this.gridApi.paginationGetTotalPages();
      else return 0;
    },
    currentPage: {
      get() {
        if (this.gridApi) return this.gridApi.paginationGetCurrentPage() + 1;
        else return 1;
      },
      set(val) {
        this.gridApi.paginationGoToPage(val - 1);
      },
    },
  },
  methods: {
    showPaymentSuccess() {
      this.$vs.loading.close();
      this.$vs.notify({
        color: "success",
        title: "Payment Done!",
        text: "Payment Done Successfully!",
      });
      store
        .dispatch(
          "feeVoucherManagement/fetchStudentVouchers",
          this.$route.params.studentId
        )
        .catch((err) => {
          console.error(err);
        });
    },
    showPaymentError() {
      this.$vs.loading.close();
      this.$vs.notify({
        title: "Error",
        text: "Something Went Wrong While Making Payment!",
        iconPack: "feather",
        icon: "icon-alert-circle",
        color: "danger",
      });
    },
    setColumnFilter(column, val) {
      const filter = this.gridApi.getFilterInstance(column);
      let modelObj = null;

      if (val !== "all") {
        modelObj = { type: "equals", filter: val };
      }

      filter.setModel(modelObj);
      this.gridApi.onFilterChanged();
    },
    resetColFilters() {
      // Reset Grid Filter
      this.gridApi.setFilterModel(null);
      this.gridApi.onFilterChanged();
      this.$refs.filterCard.removeRefreshAnimation();
    },
    updateSearchQuery(val) {
      this.gridApi.setQuickFilter(val);
    },
  },
  mounted() {
    this.gridApi = this.gridOptions.api;

    /* =================================================================
      NOTE:
      Header is not aligned properly in RTL version of agGrid table.
      However, we given fix to this issue. If you want more robust solution please contact them at gitHub
    ================================================================= */
    if (this.$vs.rtl) {
      const header = this.$refs.agGridTable.$el.querySelector(
        ".ag-header-container"
      );
      header.style.left = `-${String(
        Number(header.style.transform.slice(11, -3)) + 9
      )}px`;
    }
  },
  created() {
    if (!moduleFeeVoucherManagement.isRegistered) {
      this.$store.registerModule(
        "feeVoucherManagement",
        moduleFeeVoucherManagement
      );
      moduleFeeVoucherManagement.isRegistered = true;
    }
    this.$store
      .dispatch(
        "feeVoucherManagement/fetchStudentVouchers",
        this.$route.params.studentId
      )
      .catch((err) => {
        console.error(err);
      });
  },
};
</script>

<style lang="scss">
#page-user-list {
  .user-list-filters {
    .vs__actions {
      position: absolute;
      right: 0;
      top: 50%;
      transform: translateY(-58%);
    }
  }
}
</style>
