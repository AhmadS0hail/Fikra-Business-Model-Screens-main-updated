<template>
	<form @submit.prevent="onSubmit">
		<MChoice
			v-for="question in formThreeQuestions"
			:key="question.id"
			:questionID="question.id"
			:questionType="question.type"
			:heading="question.heading"
			:subHeading="question.subHeading"
			:description="question.description"
			:options="question.options"
			:errorState="errorStates[question.id]"
			@updateErrorState="checkError"
			v-model:value="results[question.id]" />
		<div class="flex items-center justify-between w-full">
			<button
				type="button"
				class="w-full py-2 mx-1 mt-6 text-center bg-white border rounded-full text-primary border-primary"
				@click="emit('moveBack')">
				السابق
			</button>
			<button type="submit" class="w-full py-2 mx-1 mt-6 text-center text-white rounded-full bg-primary">إﻧﮭﺎء</button>
		</div>
	</form>
</template>

<script setup>
	import MChoice from "../Base/MChoice.vue";
	import { ref } from "vue";
	// import { formThreeQuestions } from "../../utils/formQuestions";
  import axios from 'axios';

	const emit = defineEmits(["validSubmission", "moveBack"]);

	const results = ref({});
	const errorStates = ref({});
	let formThreeQuestions = ref({});



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
			emit("validSubmission", "formThree", toSubmit);
		}
	};

  let set = JSON.parse(_settings);

  const apiUrl = set.tdomain+'/wp-json/fikra/v1/questions';


  // Make a GET request to the custom API endpoint using Axios
  axios.get(apiUrl)
      .then(response => {
        // Handle the response data
        formThreeQuestions = response.data.formThreeQuestions
        // Perform further actions with the response data as needed

        formThreeQuestions.forEach((el) => {
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
        this.error = error;
      });
</script>
