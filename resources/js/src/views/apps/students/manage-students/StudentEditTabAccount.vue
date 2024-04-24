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
    <form></form>

    <form>
      <vx-card title="Update Details" class="mb-base">
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
              disabled
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
            <span>Father Name</span>
          </div>
          <div class="vx-col sm:w-2/3 w-full">
            <vs-input
              v-validate="'required|alpha_spaces'"
              placeholder="Father's Name"
              name="father_name"
              v-model="data_local.father_name"
              class="w-full"
              data-vv-validate-on="blur"
            />
            <span
              class="text-danger text-sm"
              v-show="errors.has('father_name')"
              >{{ errors.first("father_name") }}</span
            >
          </div>
        </div>
        <div class="vx-row mb-6">
          <div class="vx-col sm:w-1/3 w-full">
            <span>Mother Name</span>
          </div>
          <div class="vx-col sm:w-2/3 w-full">
            <vs-input
              v-validate="'required|alpha_spaces'"
              placeholder="Mother's Name"
              name="mother_name"
              v-model="data_local.mother_name"
              class="w-full"
              data-vv-validate-on="blur"
            />
            <span
              class="text-danger text-sm"
              v-show="errors.has('mother_name')"
              >{{ errors.first("mother_name") }}</span
            >
          </div>
        </div>
        <div class="vx-row mb-6">
          <div class="vx-col sm:w-1/3 w-full">
            <span>Guardian Name</span>
          </div>
          <div class="vx-col sm:w-2/3 w-full">
            <vs-input
              v-validate="'alpha_spaces'"
              placeholder="Guardian Name"
              name="guardian"
              v-model="data_local.guardian"
              class="w-full"
              data-vv-validate-on="blur"
            />
            <span class="text-danger text-sm" v-show="errors.has('guardian')">{{
              errors.first("guardian")
            }}</span>
          </div>
        </div>
        <div class="vx-row mb-6" v-if="data_local.guardian">
          <div class="vx-col sm:w-1/3 w-full">
            <span>Relation with Guardian</span>
          </div>
          <div class="vx-col sm:w-2/3 w-full">
            <vs-input
              v-validate="'required|alpha_spaces'"
              placeholder="Relation with Guardian"
              name="relation"
              v-model="data_local.relation"
              class="w-full"
              data-vv-validate-on="blur"
            />
            <span class="text-danger text-sm" v-show="errors.has('relation')">{{
              errors.first("relation")
            }}</span>
          </div>
        </div>
        <div class="vx-row mb-6">
          <div class="vx-col sm:w-1/3 w-full">
            <span>Occupation</span>
          </div>
          <div class="vx-col sm:w-2/3 w-full">
            <vs-input
              v-validate="'required'"
              placeholder="Father/Guardian Occupation"
              name="occupation"
              v-model="data_local.occupation"
              class="w-full"
              data-vv-validate-on="blur"
            />
            <span
              class="text-danger text-sm"
              v-show="errors.has('occupation')"
              >{{ errors.first("occupation") }}</span
            >
          </div>
        </div>
        <div class="vx-row mb-6">
          <div class="vx-col sm:w-1/3 w-full">
            <span>Address</span>
          </div>
          <div class="vx-col sm:w-2/3 w-full">
            <vs-input
              v-validate="'required'"
              placeholder="Address"
              name="address"
              v-model="data_local.address"
              class="w-full"
              data-vv-validate-on="blur"
            />
            <span class="text-danger text-sm" v-show="errors.has('address')">{{
              errors.first("address")
            }}</span>
          </div>
        </div>
        <div class="vx-row mb-6">
          <div class="vx-col sm:w-1/3 w-full">
            <span>Is it a Staff's Child</span>
          </div>
          <div class="vx-col sm:w-2/3 w-full">
            <v-select
              v-model="data_local.staff_child"
              :clearable="false"
              :options="staffOptions"
              v-validate="'required'"
              name="staff_child"
              :dir="$vs.rtl ? 'rtl' : 'ltr'"
            />
            <span
              class="text-danger text-sm"
              v-show="errors.has('staff_child')"
              >{{ errors.first("staff_child") }}</span
            >
          </div>
        </div>
        <div class="vx-row mb-6" v-if="data_local.staff_child.value == 'yes'">
          <div class="vx-col sm:w-1/3 w-full">
            <span>Parent Type</span>
          </div>
          <div class="vx-col sm:w-2/3 w-full">
            <v-select
              v-model="data_local.parent_type"
              :clearable="false"
              :options="parentOptions"
              v-validate="'required'"
              name="parent_type"
              :dir="$vs.rtl ? 'rtl' : 'ltr'"
            />
            <span
              class="text-danger text-sm"
              v-show="errors.has('parent_type')"
              >{{ errors.first("parent_type") }}</span
            >
          </div>
        </div>
        <div class="vx-row mb-6" v-if="data_local.staff_child.value == 'yes'">
          <div class="vx-col sm:w-1/3 w-full">
            <span>Choose Parent</span>
          </div>
          <div class="vx-col sm:w-2/3 w-full">
            <v-select
              v-model="data_local.parent_id"
              :clearable="false"
              :options="teacher_data"
              v-validate="'required'"
              name="parent_id"
              :dir="$vs.rtl ? 'rtl' : 'ltr'"
            />
            <span
              class="text-danger text-sm"
              v-show="errors.has('parent_id')"
              >{{ errors.first("parent_id") }}</span
            >
          </div>
        </div>
        <div class="vx-row mb-6">
          <div class="vx-col sm:w-1/3 w-full">
            <span>Choose Gender</span>
          </div>
          <div class="vx-col sm:w-2/3 w-full">
            <v-select
              v-model="data_local.gender"
              :clearable="false"
              :options="genderOptions"
              v-validate="'required'"
              name="gender"
              :dir="$vs.rtl ? 'rtl' : 'ltr'"
            />
            <span class="text-danger text-sm" v-show="errors.has('gender')">{{
              errors.first("gender")
            }}</span>
          </div>
        </div>
        <div class="vx-row mb-6">
          <div class="vx-col sm:w-1/3 w-full">
            <span>Is Transfer Certificate Received?</span>
          </div>
          <div class="vx-col sm:w-2/3 w-full">
            <v-select
              v-model="data_local.transfer_certificate"
              :clearable="false"
              :options="transferOptions"
              v-validate="'required'"
              name="transfer_certificate"
              :dir="$vs.rtl ? 'rtl' : 'ltr'"
            />
            <span
              class="text-danger text-sm"
              v-show="errors.has('transfer_certificate')"
              >{{ errors.first("transfer_certificate") }}</span
            >
          </div>
        </div>
        <div class="vx-row mb-6">
          <div class="vx-col sm:w-1/3 w-full">
            <span>Is Migration Certificate Received?</span>
          </div>
          <div class="vx-col sm:w-2/3 w-full">
            <v-select
              v-model="data_local.migration_certificate"
              :clearable="false"
              :options="transferOptions"
              v-validate="'required'"
              name="migration_certificate"
              :dir="$vs.rtl ? 'rtl' : 'ltr'"
            />
            <span
              class="text-danger text-sm"
              v-show="errors.has('migration_certificate')"
              >{{ errors.first("migration_certificate") }}</span
            >
          </div>
        </div>
        <div class="vx-row mb-6">
          <div class="vx-col sm:w-1/3 w-full">
            <span>Is Birth Certificate Received?</span>
          </div>
          <div class="vx-col sm:w-2/3 w-full">
            <v-select
              v-model="data_local.birth_certificate"
              :clearable="false"
              :options="transferOptions"
              v-validate="'required'"
              name="birth_certificate"
              :dir="$vs.rtl ? 'rtl' : 'ltr'"
            />
            <span
              class="text-danger text-sm"
              v-show="errors.has('birth_certificate')"
              >{{ errors.first("birth_certificate") }}</span
            >
          </div>
        </div>
        <div class="vx-row mb-6">
          <div class="vx-col sm:w-1/3 w-full">
            <span>Is Mark Sheet Received?</span>
          </div>
          <div class="vx-col sm:w-2/3 w-full">
            <v-select
              v-model="data_local.marksheet_certificate"
              :clearable="false"
              :options="transferOptions"
              v-validate="'required'"
              name="marksheet_certificate"
              :dir="$vs.rtl ? 'rtl' : 'ltr'"
            />
            <span
              class="text-danger text-sm"
              v-show="errors.has('marksheet_certificate')"
              >{{ errors.first("marksheet_certificate") }}</span
            >
          </div>
        </div>
        <div class="vx-row mb-6">
          <div class="vx-col sm:w-1/3 w-full">
            <span>Is Aadhar Card Received?</span>
          </div>
          <div class="vx-col sm:w-2/3 w-full">
            <v-select
              v-model="data_local.adhaar_card_certificate"
              :clearable="false"
              :options="transferOptions"
              v-validate="'required'"
              name="adhaar_card_certificate"
              :dir="$vs.rtl ? 'rtl' : 'ltr'"
            />
            <span
              class="text-danger text-sm"
              v-show="errors.has('adhaar_card_certificate')"
              >{{ errors.first("adhaar_card_certificate") }}</span
            >
          </div>
        </div>
        <div class="vx-row mb-6">
          <div class="vx-col sm:w-1/3 w-full">
            <span>Date of Birth</span>
          </div>
          <div class="vx-col sm:w-2/3 w-full ml-auto">
            <div class="mt-4">
              <flat-pickr
                v-model="data_local.dob"
                :config="{ dateFormat: 'd F Y', maxDate: new Date() }"
                class="w-full"
                v-validate="'required'"
                name="dob"
              />
              <span class="text-danger text-sm" v-show="errors.has('dob')">{{
                errors.first("dob")
              }}</span>
            </div>
          </div>
        </div>
        <div class="vx-row mb-6">
          <div class="vx-col sm:w-1/3 w-full">
            <span>Date Of Admission</span>
          </div>
          <div class="vx-col sm:w-2/3 w-full ml-auto">
            <div class="mt-4">
              <flat-pickr
                v-model="data_local.joining_date"
                :config="{ dateFormat: 'd F Y', maxDate: new Date() }"
                class="w-full"
                v-validate="'required'"
                name="joining_date"
              />
              <span
                class="text-danger text-sm"
                v-show="errors.has('joining_date')"
                >{{ errors.first("joining_date") }}</span
              >
            </div>
          </div>
        </div>
        <div class="vx-row mb-6">
          <div class="vx-col sm:w-1/3 w-full">
            <span>Religion</span>
          </div>
          <div class="vx-col sm:w-2/3 w-full">
            <vs-input
              v-validate="'required'"
              placeholder="Religion"
              name="religion"
              v-model="data_local.religion"
              class="w-full"
              data-vv-validate-on="blur"
            />
            <span class="text-danger text-sm" v-show="errors.has('religion')">{{
              errors.first("religion")
            }}</span>
          </div>
        </div>
        <div class="vx-row mb-6">
          <div class="vx-col sm:w-1/3 w-full">
            <span>Category</span>
          </div>
          <div class="vx-col sm:w-2/3 w-full">
            <vs-radio v-model="data_local.category" vs-value="1" class="mr-4"
              >General</vs-radio
            >
            <vs-radio
              v-model="data_local.category"
              vs-value="2"
              class="mr-4"
              selected
              >OBC</vs-radio
            >
            <vs-radio v-model="data_local.category" vs-value="3" class="mr-4"
              >SC</vs-radio
            >
            <vs-radio v-model="data_local.category" vs-value="4">ST</vs-radio>
          </div>
        </div>
        <div class="vx-row mb-6">
          <div class="vx-col sm:w-1/3 w-full">
            <span>Nationality</span>
          </div>
          <div class="vx-col sm:w-2/3 w-full">
            <vs-input
              v-validate="'required'"
              placeholder="Nationality"
              name="nationality"
              v-model="data_local.nationality"
              class="w-full"
              data-vv-validate-on="blur"
            />
            <span
              class="text-danger text-sm"
              v-show="errors.has('nationality')"
              >{{ errors.first("nationality") }}</span
            >
          </div>
        </div>
        <div class="vx-row mb-6">
          <div class="vx-col sm:w-1/3 w-full">
            <span>Admission No.</span>
          </div>
          <div class="vx-col sm:w-2/3 w-full">
            <vs-input
              v-validate="'required'"
              placeholder="Admission No."
              name="admission_no"
              v-model="data_local.admission_no"
              class="w-full"
              data-vv-validate-on="blur"
            />
            <span
              class="text-danger text-sm"
              v-show="errors.has('admission_no')"
              >{{ errors.first("admission_no") }}</span
            >
          </div>
        </div>
        <div class="vx-row mb-6">
          <div class="vx-col sm:w-1/3 w-full">
            <span>Roll No.</span>
          </div>
          <div class="vx-col sm:w-2/3 w-full">
            <vs-input
              v-validate="'required'"
              placeholder="Roll No."
              name="roll_no"
              v-model="data_local.roll_no"
              class="w-full"
              data-vv-validate-on="blur"
            />
            <span class="text-danger text-sm" v-show="errors.has('roll_no')">{{
              errors.first("roll_no")
            }}</span>
          </div>
        </div>
        <div class="vx-row mb-6">
          <div class="vx-col sm:w-1/3 w-full">
            <span>Last School Name</span>
          </div>
          <div class="vx-col sm:w-2/3 w-full">
            <vs-input
              v-validate="'alpha_spaces'"
              placeholder="Last School Name"
              name="last_school"
              v-model="data_local.last_school"
              class="w-full"
              data-vv-validate-on="blur"
            />
            <span
              class="text-danger text-sm"
              v-show="errors.has('last_school')"
              >{{ errors.first("last_school") }}</span
            >
          </div>
        </div>
        <div class="vx-row mb-6">
          <div class="vx-col sm:w-1/3 w-full">
            <span>Status</span>
          </div>
          <div class="vx-col sm:w-2/3 w-full ml-auto">
            <div class="mt-4">
              <v-select
                v-model="status_local"
                :clearable="false"
                :options="statusOptions"
                v-validate="'required'"
                name="status"
                :dir="$vs.rtl ? 'rtl' : 'ltr'"
              />
              <span class="text-danger text-sm" v-show="errors.has('status')">{{
                errors.first("status")
              }}</span>
            </div>
          </div>
        </div>

        <div class="vx-row mb-6">
          <div class="vx-col sm:w-1/3 w-full">
            <span>Blocked</span>
          </div>
          <div class="vx-col sm:w-2/3 w-full ml-auto">
            <div class="mt-4">
              <v-select
                v-model="block_local"
                :clearable="false"
                :options="blockOptions"
                v-validate="'required'"
                name="is_blocked"
                :dir="$vs.rtl ? 'rtl' : 'ltr'"
              />
              <span
                class="text-danger text-sm"
                v-show="errors.has('is_blocked')"
                >{{ errors.first("is_blocked") }}</span
              >
            </div>
          </div>
        </div>
        <div class="vx-row mb-6">
          <div class="vx-col sm:w-1/3 w-full">
            <span>Select Class</span>
          </div>
          <div class="vx-col sm:w-2/3 w-full">
            <v-select
              v-model="data_local.student_class"
              :clearable="false"
              :options="class_data"
              v-validate="'required'"
              name="student_class"
              :dir="$vs.rtl ? 'rtl' : 'ltr'"
            />
            <span
              class="text-danger text-sm"
              v-show="errors.has('student_class')"
              >{{ errors.first("student_class") }}</span
            >
          </div>
        </div>
        <div class="vx-row mb-6">
          <div class="vx-col sm:w-1/3 w-full">
            <span>Adhaar Card Number</span>
          </div>
          <div class="vx-col sm:w-2/3 w-full">
            <vs-input
              v-validate="'required'"
              placeholder="Adhaar Card Number..."
              name="adhaar_card"
              v-model="data_local.adhaar_card"
              class="w-full"
              data-vv-validate-on="blur"
            />
            <span
              class="text-danger text-sm"
              v-show="errors.has('adhaar_card')"
              >{{ errors.first("adhaar_card") }}</span
            >
          </div>
        </div>
        <div class="vx-row">
          <div class="vx-col sm:w-2/3 w-full ml-auto">
            <vs-button
              class="mr-3 mb-2"
              :disabled="!validateForm"
              @click="submitForm"
              >Update</vs-button
            >
            <vs-button
              color="warning"
              type="border"
              class="mb-2"
              disabled
              @click="
                data_local.name = data_local.email = data_local.phone_number = data_local.password = data_local.password_confirm = data_local.staff_child = data_local.dob = data_local.mother_name = data_local.father_name =
                  '';
                check1 = false;
              "
              >Reset</vs-button
            >
          </div>
        </div>
      </vx-card>
    </form>
    <form>
      <vx-card title="Change Password" class="mb-base">
        <!-- Avatar -->
        <div class="vx-row mb-6">
          <div class="vx-col w-full">
            <vx-card no-shadow>
              <vs-input
                ref="password"
                type="password"
                data-vv-validate-on="blur"
                v-validate="'required|min:6'"
                name="password"
                label-placeholder="Password"
                placeholder="Password"
                v-model="password"
                class="w-full mt-6"
              />
              <span class="text-danger text-sm">{{
                errors.first("password")
              }}</span>

              <vs-input
                type="password"
                v-validate="'min:6|confirmed:password'"
                data-vv-validate-on="blur"
                data-vv-as="password"
                name="confirm_password"
                label-placeholder="Confirm Password"
                placeholder="Confirm Password"
                v-model="confirm_password"
                class="w-full mt-6"
              />
              <span class="text-danger text-sm">{{
                errors.first("confirm_password")
              }}</span>
              <!-- Save & Reset Button -->
              <div class="flex flex-wrap items-center justify-end">
                <vs-button class="ml-auto mt-2" @click="updatePassword"
                  >Save Changes</vs-button
                >
                <vs-button class="ml-4 mt-2" type="border" color="warning"
                  >Reset</vs-button
                >
              </div>
            </vx-card>
          </div>
        </div>
      </vx-card>
    </form>
  </div>
</template>

<script>
import moduleClassManagement from "@/store/class-management/moduleClassManagement.js";
import moduleUserManagement from "@/store/user-management/moduleUserManagement.js";
import moduleStudentManagement from "@/store/student-management/moduleStudentManagement.js";
import vSelect from "vue-select";
import flatPickr from "vue-flatpickr-component";
import "flatpickr/dist/flatpickr.css";
export default {
  components: {
    vSelect,
    flatPickr,
  },
  props: {
    data: {
      type: Object,
      required: true,
    },
  },
  data() {
    console.log("this.data", this.data);
    return {
      data_local: JSON.parse(JSON.stringify(this.data)),
      teacher_data: [],
      class_data: [],
      user_data: null,
      staffOptions: [
        { label: "Yes", value: "yes" },
        { label: "No", value: "no" },
      ],
      genderOptions: [
        { label: "Male", value: "male" },
        { label: "Female", value: "female" },
        { label: "Other", value: "other" },
      ],
      transferOptions: [
        { label: "Yes", value: "yes" },
        { label: "No", value: "no" },
      ],
      parentOptions: [
        { label: "Father", value: "father_id" },
        { label: "Mother", value: "mother_id" },
      ],
      statusOptions: [
        { label: "Active", value: "active" },
        { label: "Inactive", value: "inactive" },
      ],
      blockOptions: [
        { label: "Blocked", value: "blocked" },
        { label: "Unblocked", value: "unblocked" },
      ],
      password: "",
      confirm_password: "",
    };
  },
  computed: {
    validateForm() {
      if (
        this.data_local.name === null ||
        this.data_local.name === "" ||
        this.data_local.email === null ||
        this.data_local.email === "" ||
        this.data_local.phone_number === null ||
        this.data_local.phone_number === "" ||
        this.data_local.father_name === null ||
        this.data_local.father_name === "" ||
        this.data_local.mother_name === null ||
        this.data_local.mother_name === "" ||
        this.data_local.password === null ||
        this.data_local.password === "" ||
        this.data_local.staff_child.value === null ||
        this.data_local.staff_child.value === "" ||
        this.data_local.admission_no === null ||
        this.data_local.admission_no === "" ||
        this.data_local.category === null ||
        this.data_local.category === "" ||
        this.data_local.occupation === null ||
        this.data_local.occupation === "" ||
        this.data_local.address === null ||
        this.data_local.address === "" ||
        this.data_local.joining_date === null ||
        this.data_local.joining_date === "" ||
        this.data_local.last_school === null ||
        this.data_local.last_school === "" ||
        this.data_local.nationality === null ||
        this.data_local.nationality === "" ||
        this.data_local.religion === null ||
        this.data_local.religion === "" ||
        this.data_local.roll_no === null ||
        this.data_local.roll_no === "" ||
        this.data_local.adhaar_card === null ||
        this.data_local.adhaar_card === "" ||
        this.data_local.gender.value === null ||
        this.data_local.gender.value === "" ||
        this.data_local.dob === null ||
        this.data_local.dob === "" ||
        this.data_local.student_class.value === null ||
        this.data_local.student_class.value === "" ||
        this.data_local.adhaar_card_certificate.value === null ||
        this.data_local.adhaar_card_certificate.value === "" ||
        this.data_local.birth_certificate.value === null ||
        this.data_local.birth_certificate.value === "" ||
        this.data_local.marksheet_certificate.value === null ||
        this.data_local.marksheet_certificate.value === "" ||
        this.data_local.migration_certificate.value === null ||
        this.data_local.migration_certificate.value === "" ||
        this.data_local.transfer_certificate.value === null ||
        this.data_local.transfer_certificate.value === "" ||
        this.data_local.adhaar_card === null ||
        this.data_local.adhaar_card === ""
      ) {
        console.log("this.data_local.name");
        console.log(this.data_local.name);
        console.log("this.data_local.email");
        console.log(this.data_local.email);
        console.log("this.data_local.phone_number");
        console.log(this.data_local.phone_number);
        console.log("this.data_local.father_name");
        console.log(this.data_local.father_name);
        console.log("this.data_local.mother_name");
        console.log(this.data_local.mother_name);
        console.log("this.data_local.password");
        console.log(this.data_local.password);
        console.log("this.data_local.staff_child.value");
        console.log(this.data_local.staff_child.value);
        console.log("this.data_local.admission_no");
        console.log(this.data_local.admission_no);
        console.log("this.data_local.category");
        console.log(this.data_local.category);
        console.log("this.data_local.guardian");
        console.log(this.data_local.guardian);
        console.log("this.data_local.occupation");
        console.log(this.data_local.occupation);
        console.log("this.data_local.address");
        console.log(this.data_local.address);
        console.log("this.data_local.joining_date");
        console.log(this.data_local.joining_date);
        console.log("this.data_local.last_school");
        console.log(this.data_local.last_school);
        console.log("this.data_local.nationality");
        console.log(this.data_local.nationality);
        console.log("this.data_local.religion");
        console.log(this.data_local.religion);
        console.log("this.data_local.roll_no");
        console.log(this.data_local.roll_no);
        console.log("this.data_local.adhaar_card");
        console.log(this.data_local.adhaar_card);
        console.log("this.data_local.gender.value");
        console.log(this.data_local.gender.value);
        console.log("this.data_local.dob");
        console.log(this.data_local.dob);
        console.log("this.data_local.student_class.value");
        console.log(this.data_local.student_class.value);
        console.log("this.data_local.adhaar_card_certificate.value");
        console.log(this.data_local.adhaar_card_certificate.value);
        console.log("this.data_local.birth_certificate.value");
        console.log(this.data_local.birth_certificate.value);
        console.log("this.data_local.marksheet_certificate.value");
        console.log(this.data_local.marksheet_certificate.value);
        console.log("this.data_local.migration_certificate.value");
        console.log(this.data_local.migration_certificate.value);
        console.log("this.data_local.transfer_certificate.value");
        console.log(this.data_local.transfer_certificate.value);
        console.log("this.data_local.adhaar_card");
        console.log(this.data_local.adhaar_card);
        return false;
      } else {
        return true;
      }
    },
    userAddress() {
      let str = "";
      for (const field in this.user_data.location) {
        str += `${field} `;
      }
      return str;
    },
    status_local: {
      get() {
        return {
          label: this.capitalize(this.data_local.status),
          value: this.data_local.status,
        };
      },
      set(obj) {
        this.data_local.status = obj.value;
      },
    },
    block_local: {
      get() {
        return {
          label: this.capitalize(this.data_local.is_blocked),
          value: this.data_local.is_blocked,
        };
      },
      set(obj) {
        this.data_local.is_blocked = obj.value;
      },
    },
    staff_local: {
      get() {
        return {
          label: this.capitalize(this.data_local.staff_child),
          value: this.data_local.staff_child,
        };
      },
      set(obj) {
        this.data_local.staff_child = obj.value;
      },
    },
    parent_local: {
      get() {
        return {
          label: this.capitalize(this.data_local.parent_type),
          value: this.data_local.parent_type,
        };
      },
      set(obj) {
        this.data_local.parent_type = obj.value;
      },
    },
  },
  methods: {
    capitalize(str) {
      console.log("str", str);
      return str.slice(0, 1).toUpperCase() + str.slice(1, str.length);
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
    classData() {
      console.log("classData");
      this.$store
        .dispatch("classManagement/fetchClasses")
        .then((res) => {
          console.log("res.data.response", res.data.response);
          this.class_data = res.data.response.map((class_data) => ({
            label: `${class_data.class_name}`,
            value: class_data.id,
          }));
        })
        .catch((err) => {
          console.error(err);
        });
    },
    deleteRecord() {
      /* Below two lines are just for demo purpose */
      this.$router.push({ name: "app-user-list" });
      this.showDeleteSuccess();
    },
    showDeleteSuccess() {
      this.$vs.notify({
        color: "success",
        title: "Student Profile Deleted",
        text: "The selected student profile was successfully deleted",
      });
    },
    teachersData() {
      console.log("teachersData");
      this.$store
        .dispatch("studentManagement/fetchTeachers")
        .then((res) => {
          console.log("res.data.response", res.data.response);
          this.teacher_data = res.data.response.map((user) => ({
            label: `${user.name}`,
            value: user.user_id,
          }));
        })
        .catch((err) => {
          console.error(err);
        });
    },
    submitForm() {
      console.log("data_local", this.$validator.validateAll());
      console.log("data_local", this.data_local);
      this.$validator.validateAll();
      let obj = {
        student_id: this.$route.params.studentId,
        name: this.data_local.name,
        email: this.data_local.email,
        phone_number: this.data_local.phone_number,
        father_name: this.data_local.father_name,
        mother_name: this.data_local.mother_name,
        password: this.data_local.password,
        staff_child: this.data_local.staff_child.value == "yes" ? 2 : 1,
        admission_no: this.data_local.admission_no,
        category: this.data_local.category,
        guardian: this.data_local.guardian,
        occupation: this.data_local.occupation,
        address: this.data_local.address,
        joining_date: this.data_local.joining_date,
        last_school: this.data_local.last_school,
        nationality: this.data_local.nationality,
        relation: this.data_local.relation,
        religion: this.data_local.religion,
        roll_no: this.data_local.roll_no,
        adhaar_card: this.data_local.adhaar_card,
        gender:
          this.data_local.gender.value == "male" ||
          this.data_local.gender.value == "Male"
            ? 2
            : this.data_local.gender.value == "female" ||
              this.data_local.gender.value == "Female"
            ? 1
            : this.data_local.gender.value == "other" ||
              this.data_local.gender.value == "Other"
            ? 3
            : null,
        father_id:
          this.data_local.parent_type &&
          this.data_local.parent_type == "father_id"
            ? this.data_local.parent_id
            : null,
        mother_id:
          this.data_local.parent_type &&
          this.data_local.parent_type == "mother_id"
            ? this.data_local.parent_id
            : null,
        dob: this.data_local.dob,
        student_class: this.data_local.student_class.value,
        adhaar_card: this.data_local.adhaar_card,
        adhaar_card_certificate:
          this.data_local.adhaar_card_certificate.value == "yes" ||
          this.data_local.adhaar_card_certificate.value == "Yes"
            ? 2
            : 1,
        birth_certificate:
          this.data_local.birth_certificate.value == "yes" ||
          this.data_local.birth_certificate.value == "Yes"
            ? 2
            : 1,
        marksheet_certificate:
          this.data_local.marksheet_certificate.value == "yes" ||
          this.data_local.marksheet_certificate.value == "Yes"
            ? 2
            : 1,
        migration_certificate:
          this.data_local.migration_certificate.value == "yes" ||
          this.data_local.migration_certificate.value == "Yes"
            ? 2
            : 1,
        transfer_certificate:
          this.data_local.transfer_certificate.value == "yes" ||
          this.data_local.transfer_certificate.value == "Yes"
            ? 2
            : 1,
        adhaar_card: this.data_local.adhaar_card,
        status: this.status_local.value,
        is_blocked: this.block_local.value,
      };
      console.log("obvvkfkvj", obj);
      if (!this.errors.any()) {
        this.$store
          .dispatch("studentManagement/updateStudent", obj)
          .then((res) => {
            console.log("res", res);
            if (res.data.response) {
              this.$vs.notify({
                color: "success",
                title: "Information Updated",
                text: "Student Profile Updated successfully!",
              });
              this.$router.push({ path: "/manage-students" });
            } else {
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
    updatePassword() {
      // if (!this.validateForm) return;
      let obj = {
        password: this.password,
        email: this.data_local.email,
      };
      this.$store
        .dispatch("userManagement/updateNewPassword", obj)
        .then((res) => {
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
              title: "Password Updated",
              text: res.data.message,
            });
            this.password = "";
            this.confirm_password = "";
          }
        })
        .catch((err) => {
          console.error(err);
        });
    },
  },

  created() {
    // Register Module UserManagement Module
    // if (!moduleStudentManagement.isRegistered) {
    //   this.$store.registerModule("studentManagement", moduleStudentManagement);
    //   moduleStudentManagement.isRegistered = true;
    // }
    if (!moduleClassManagement.isRegistered) {
      this.$store.registerModule("classManagement", moduleClassManagement);
      moduleClassManagement.isRegistered = true;
    }
    if (!moduleUserManagement.isRegistered) {
      this.$store.registerModule("userManagement", moduleUserManagement);
      moduleUserManagement.isRegistered = true;
    }

    this.teachersData();
    this.classData();
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
