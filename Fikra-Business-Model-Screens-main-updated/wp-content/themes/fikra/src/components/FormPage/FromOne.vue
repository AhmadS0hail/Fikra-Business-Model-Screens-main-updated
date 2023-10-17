
<template>
  <form @submit="onSubmit">
    <div class="mb-20 space-y-4 md:space-y-6">
      <h2 class="text-[#1C1C1C] text-xl font-bold">المعلومات الشخصية</h2>
      <!-- Name -->
      <BaseInput
          type="text"
          name="name"
          label="الاسم الثلاثي *"
          placeholder="يرجى كتابة الاسم هنا"
          v-model="name"
          :icon="true"
          :errorState="errors.name">
      </BaseInput>
      <!-- Phone Number -->
      <div>
        <label class="block mb-2 text-sm font-medium text-grey">رقم الجوال *</label>
        <vue-tel-input
            dir="ltr"
            :class="{ isError: invalidPhoneNumber }"
            v-model="phone"
            v-bind="phoneOptions"
            @on-input="checkPhone">
          <template #icon-right> <img :src="_settings.tlink+'/src/assets/img/phone.svg'" alt="Icon" class="w-5" /></template>
          <template #arrow-icon> <span class="icon arrow-downward"></span></template>
        </vue-tel-input>
        <p v-if="invalidPhoneNumber" class="block mt-2 text-sm font-medium text-red-500">* رقم الجوال غير صحيح</p>
      </div>
      <!-- Email -->
      <BaseInput
          type="email"
          name="email"
          label="البريد الالكتروني *"
          placeholder="اكتب البريد الالكتروني هنا"
          v-model="email"
          :errorState="errors.email">
      </BaseInput>
    </div>
    <div class="mb-8 space-y-4 md:space-y-6">
      <h2 class="text-[#1C1C1C] text-xl font-bold">معلومات المشروع</h2>
      <!-- Project Name -->
      <BaseInput
          type="text"
          name="project"
          label="اسم المشروع"
          placeholder="اكتب اسم المشروع هنا"
          v-model="project"
          :errorState="errors.project">
      </BaseInput>
      <!-- Project Type Option -->
      <div>
        <BaseTextarea
            name="about"
            label="نبذة عن المشروع*"
            placeholder="اكتب نبذة عن المشروع"
            v-model="about"
            :errorState="errors.about">
        </BaseTextarea>
      </div>

     </div>
    <button type="submit" class="w-full py-2 mt-6 text-center text-white rounded-full bg-primary">التالي</button>
  </form>
</template>

<script setup>
import BaseInput from "../Base/Input.vue";
import BaseTextarea from "../Base/Textarea.vue";
import { projectDomains } from "../../utils/formQuestions";
import { useField, useForm } from "vee-validate";
import { firstFormSchema } from "../../utils/zodSchema";
import { ref } from "vue";
import axios from "axios";

const emit = defineEmits(["validSubmission"]);

const { handleSubmit, errors } = useForm({
  validationSchema: firstFormSchema,
});

const { value: name } = useField("name");
const { value: email } = useField("email");
const { value: project } = useField("project");
const { value: about } = useField("about");

// Phone Related Login Initialization
const phone = ref(null);
const errorStates = ref({});
const results = ref({});
let formFirstQuestions = ref({});

const phoneOptions = {
  mode: "international",
  defaultCountry: "SA",
  // Hide Israel From Counrty Options
  ignoredCountries: ["IL"],
  autoDefaultCountry: false,
  validCharactersOnly: true,
  autoFormat: false,
  inputOptions: {
    autocomplete: "off",
    maxlength: 25,
    placeholder: "000000000",
  },
  dropdownOptions: {
    showFlags: true,
    showDialCodeInSelection: true,
  },
};
const invalidPhoneNumber = ref(false);

// Project Type Related Login Initialization
const projectDomain = ref(null);
const unSelectedprojectDomain = ref(false);

// Change the selection error state
function toggleSelectErrorState() {
  unSelectedprojectDomain.value = false;
}

// Validate Phone Number (Currently Only For Saudi Arabia)
function checkPhone(num) {
  num = convertArabicToEnglishNumber(num);
  if (num) {
    const pattern = /^(?:(?:\+|00)966)?5\d{8}$/;
    let trimmed = num.replace(/\s+/g, "").trim();
    if (!pattern.test(trimmed)) {
      invalidPhoneNumber.value = true;
    } else {
      invalidPhoneNumber.value = false;
    }
  }
}

function convertArabicToEnglishNumber(input) {
  let arabicDigits = ["٠", "١", "٢", "٣", "٤", "٥", "٦", "٧", "٨", "٩"];
  let englishDigits = ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9"];
  let output = "";

  // Loop through each character in the input
  for (let i = 0; i < input.length; i++) {
    let char = input.charAt(i);
    let index = arabicDigits.indexOf(char);

    // If the character is an Arabic digit, replace it with its English counterpart
    if (index !== -1) {
      output += englishDigits[index];
    } else {
      output += char;
    }
  }

  return output;
}


// Handle Invalid Form Submission (Check for Invalid Phone or Unselected Project Type)
function onInvalidSubmit() {
  // if (!projectDomain.value) {
  // 	unSelectedprojectDomain.value = true;
  // }

  if (!phone.value) {
    invalidPhoneNumber.value = true;
  }
}



// Handle Submission
const onSubmit = handleSubmit((values) => {
  // console.log("FORM ONE SUBMITTED");

  // // Check Project Type Selection
  // if (!projectDomain.value) {
  // 	unSelectedprojectDomain.value = true;
  // 	return;
  // }

  // Check Phone Number Entry
  if (!phone.value || invalidPhoneNumber.value) {
    invalidPhoneNumber.value = true;
    return;
  }


  // unSelectedprojectDomain.value = false;
  values.phone = phone.value;
  // values.projectDomain = projectDomain.value;

  emit("validSubmission", "formOne", values);
}, onInvalidSubmit);

const checkError = (optionId) => {
  if (results.value[optionId].length || results.value[optionId].id) errorStates.value[optionId] = false;
};

let set = JSON.parse(_settings);

const apiUrl = set.tdomain + '/wp-json/fikra/v1/questions';

// Make a GET request to the custom API endpoint using Axios
axios.get(apiUrl)
    .then(response => {
      // Handle the response data
      formFirstQuestions = response.data.formFirstQuestions
      // Perform further actions with the response data as needed
      // console.log(response.data)

      formFirstQuestions.forEach((el) => {
        if (el.type === "Multiple") {
          results.value[el.id] = [];
        }

        if (el.type === "Single") {
          results.value[el.id] = {};
        }

        errorStates.value[el.id] = false;
      });
    })
    .catch(error => {
      // Handle any errors that occur during the API call
      // this.error = error;
    });
</script>

<style>
.isError {
  border: 1px solid #fda29b !important;
  box-shadow: #fee4e2 0px 1px 0px, #fee4e2 0px 0px 8px !important;
}

.vue-tel-input {
  background-color: white !important;
  border: 1px solid rgb(209, 213, 219) !important;
  color: rgb(30, 30, 30) !important;
  border-radius: 8px !important;
  box-shadow: none !important;
  padding-right: 10px !important;
}

.vti__input {
  border-radius: 8px !important;
  padding: 8px !important;
}

.vti__dropdown {
  border-radius: 8px !important;
  width: 128px !important;
}

.vue-tel-input:has(.vti__input:focus) {
  border: 1px solid rgb(42, 100, 144) !important;
}

.vue-tel-input:has(.vti__dropdown.open) {
  border: 1px solid rgb(42, 100, 144) !important;
  border-radius: 8px !important;
}

.vue-tel-input.isError,
.vue-tel-input.isError:has(.vti__input:focus) {
  border: 1px solid #fda29b !important;
  box-shadow: #fee4e2 0px 1px 0px, #fee4e2 0px 0px 8px !important;
}

.vti__dropdown-list {
  width: 300px;
}

.icon.arrow-downward {
  box-sizing: border-box;
  height: 10px;
  width: 10px;
  margin-left: 12px;
  margin-bottom: 5px;
  border-style: solid;
  border-color: black;
  border-width: 0px 1px 1px 0px;
  transform: rotate(45deg);
  transition: border-width 150ms ease-in-out;
}

.icon.arrow-downward.active {
  transform: rotate(45deg);
}
</style>
