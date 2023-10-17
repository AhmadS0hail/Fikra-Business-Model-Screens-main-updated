<template>
  <div class="mb-16 space-y-2">
    <h2 v-if="heading" class="text-[#1C1C1C] text-xl font-bold">{{ heading }}</h2>
    <p v-if="subHeading" class="text-[#344054] text-base font-normal">{{ subHeading }}</p>
    <div class="flex flex-wrap items-center justify-start">


      <select
          :class="{ isError: errorState }"
          :id="questionID"
          @change="selectV(questionID)"
          class="bg-white border border-gray-300 text-grey sm:text-sm rounded-lg focus:ring-primary focus:border-primary block w-full py-2.5 outline-none px-5"
      >
        <option value="">اختر من القائمة</option>
        <option v-for="option in options" :key="option" :value="option.id"   >{{ option.value }}</option>
      </select>


      <p v-if="errorState" class="block mt-2 text-sm font-medium text-red-500">هذا الحقل مطلوب</p>
    </div>


  </div>
</template>

<script setup>
const emits = defineEmits(["update:value", "updateErrorState"]);
const props = defineProps({
  questionID: {
    type: String,
    required: true,
  },
  questionType: {
    type: String,
    required: true,
  },
  heading: String,
  subHeading: String,
  description: String,
  value: {
    type: [Array, Object],
    required: true,
  },
  options: {
    type: Array,
    required: true,
  },
  options2: {
    type: Array,
    required: true,
  },
  errorState: {
    type: Boolean,
    required: true,
  },
});


const selectRadio = (questionID, optionId) => {
  emits("update:value", optionId);
  emits("updateErrorState", questionID);
};
const selectV = (questionID) => {
  var selectElement = document.getElementById(questionID);

  // Get the selected <option> element
  var selectedOption = selectElement.options[selectElement.selectedIndex];

  // Get the value of the selected option
  var selectedValue = selectedOption.value;
    let updatedValue = [...props.value];

      updatedValue[0] = (props.options.find((obj) => obj.id === selectedValue));

    emits("update:value", updatedValue);
    emits("updateErrorState", questionID);

 };
</script>


