<template>
  <form @submit.prevent="onSubmit">
    <div
        v-for="question in formTwoQuestions"
        :key="question.id"
    >

      <div v-if="question.inputType === 'select'">
        <div class="mb-16 space-y-2">

          <MSelect
              :questionID="question.id"
              :questionType="question.type"
              :heading="question.heading"
              :subHeading="question.subHeading"
              :description="question.description"
              :options="question.options"
              :options2="question.options2"
              :errorState="errorStates[question.id]"
              @updateErrorState="checkError"
              v-model:value="results[question.id]"
          >
          </MSelect>


        </div>
      </div>

      <div v-else>

        <MChoice
            :questionID="question.id"
            :questionType="question.type"
            :heading="question.heading"
            :subHeading="question.subHeading"
            :description="question.description"
            :options="question.options"
            :errorState="errorStates[question.id]"
            @updateErrorState="checkError"
            v-model:value="results[question.id]"/>
      </div>
    </div>

    <div class="flex items-center justify-between w-full">
      <button
          type="button"
          class="w-full py-2 mx-1 mt-6 text-center bg-white border rounded-full text-primary border-primary"
          @click="emit('moveBack')">
        السابق
      </button>
      <button type="submit" class="w-full py-2 mx-1 mt-6 text-center text-white rounded-full bg-primary">التالي</button>
    </div>
  </form>
</template>

<script setup>
import MChoice from "../Base/MChoice.vue";
import MSelect from "../Base/Select.vue";
import {ref} from "vue";
// import { formTwoQuestions } from "../../utils/formQuestions";
import axios from 'axios';

const emit = defineEmits(["validSubmission", "moveBack"]);

const results = ref({});
const errorStates = ref({});
let formTwoQuestions = ref({});

// Project Type Related Login Initialization
const projectDomain = ref(null);
const unSelectedprojectDomain = ref(false);
// Change the selection error state



const checkError = (optionId) => {
  if (results.value[optionId].length || results.value[optionId].id) errorStates.value[optionId] = false;
};

const onSubmit = () => {
  let toSubmit = {};
  let errorFound = false;


  Object.entries(results.value).forEach((el) => {
     if (Array.isArray(el[1]) && !el[1].length) {
      errorStates.value[el[0]] = true;
      errorFound = true;



     } else if (!Array.isArray(el[1]) && !el[1].id) {
      errorStates.value[el[0]] = true;
      errorFound = true;


     } else {
      if (Array.isArray(el[1])) {
        let temp = [];
        Object.values(el[1]).forEach((el) => temp.push(el.value));
        toSubmit[el[0]] = temp;
       } else {
        toSubmit[el[0]] = el[1].value;
       }



     }
  });

  if (!errorFound) {
    emit("validSubmission", "formTwo", toSubmit);
  }
};
let set = JSON.parse(_settings);

const apiUrl = set.tdomain + '/wp-json/fikra/v1/questions';

// Make a GET request to the custom API endpoint using Axios
axios.get(apiUrl)
    .then(response => {
      // Handle the response data
      formTwoQuestions = response.data.formTwoQuestions
      // Perform further actions with the response data as needed
      // console.log(response.data)

      formTwoQuestions.forEach((el) => {


        if (el.type === "Multiple"  || el.type === 'select') {
          results.value[el.id] = [];
        }

        if (el.type === "Single" ) {
          results.value[el.id] = {};
        }

        errorStates.value[el.id] = false;
      });
    })
    .catch(error => {
      // Handle any errors that occur during the API call
      this.error = error;
    });

</script>
