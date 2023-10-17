<template>
	<div class="flex flex-col h-auto py-20">
		<div v-if="!outputInfoReady" class="grid w-[85%] md:w-[77.5%] xl:w-[57.6%] grid-cols-10 gap-3 mx-auto">
			<StepProgressBar :progress="step" />
			<TheStaticInfo />
			<div class="col-span-full md:col-span-6 p-8 bg-white rounded-[10px]">
				<FromOne v-show="step === 1" @validSubmission="appendData" />
				<FormTwo v-show="step === 2" @validSubmission="appendData" @moveBack="goToPrevStep" />
				<FormThree v-show="step === 3" @validSubmission="appendData" @moveBack="goToPrevStep" />
				<BusinessModelCreation v-if="step === 4" />
			</div>
		</div>
		<OutpuBusinessModels v-else :output="outputData" />
	</div>
</template>

<script setup>
	import StepProgressBar from "../components/FormPage/StepProgressBar.vue";
	import TheStaticInfo from "../components/FormPage/TheStaticInfo.vue";
	import FromOne from "../components/FormPage/FromOne.vue";
	import FormTwo from "../components/FormPage/FormTwo.vue";
	import FormThree from "../components/FormPage/FormThree.vue";
	import BusinessModelCreation from "../components/FormPage/BusinessModelCreation.vue";
	import OutpuBusinessModels from "../components/FormPage/OutpuBusinessModels.vue";
	import { ref } from "vue";
  import axios from 'axios';

	const step = ref(1);
	const completeInfo = ref({
		formOne: null,
		formTwo: null,
		formThree: null,
	});
	const outputInfoReady = ref(false);
	// const outputData = ref([
	// 	{
	// 		id: "bm1",
	// 		nameAR: "اسم النموذج",
	// 		nameEN: "Subscription Business Model",
	// 		imgURL:
	// 			"https://img.freepik.com/premium-vector/document-file-with-check-mark-concept-flat-vector-illustration_776222-3.jpg",
	// 		viewLink:
	// 			"https://img.freepik.com/premium-vector/document-file-with-check-mark-concept-flat-vector-illustration_776222-3.jpg",
	// 		downloadLink:
	// 			"https://img.freepik.com/premium-vector/document-file-with-check-mark-concept-flat-vector-illustration_776222-3.jpg",
	// 	},
	// 	{
	// 		id: "bm2",
	// 		nameAR: "اسم النموذج",
	// 		nameEN: "Subscription Business Model",
	// 		imgURL:
	// 			"https://img.freepik.com/premium-vector/document-file-with-check-mark-concept-flat-vector-illustration_776222-3.jpg",
	// 		viewLink:
	// 			"https://img.freepik.com/premium-vector/document-file-with-check-mark-concept-flat-vector-illustration_776222-3.jpg",
	// 		downloadLink:
	// 			"https://img.freepik.com/premium-vector/document-file-with-check-mark-concept-flat-vector-illustration_776222-3.jpg",
	// 	},
	// 	{
	// 		id: "bm3",
	// 		nameAR: "اسم النموذج",
	// 		nameEN: "Subscription Business Model",
	// 		imgURL:
	// 			"https://img.freepik.com/premium-vector/document-file-with-check-mark-concept-flat-vector-illustration_776222-3.jpg",
	// 		viewLink:
	// 			"https://img.freepik.com/premium-vector/document-file-with-check-mark-concept-flat-vector-illustration_776222-3.jpg",
	// 		downloadLink:
	// 			"https://img.freepik.com/premium-vector/document-file-with-check-mark-concept-flat-vector-illustration_776222-3.jpg",
	// 	},
	// 	{
	// 		id: "bm4",
	// 		nameAR: "اسم النموذج",
	// 		nameEN: "Subscription Business Model",
	// 		imgURL:
	// 			"https://img.freepik.com/premium-vector/document-file-with-check-mark-concept-flat-vector-illustration_776222-3.jpg",
	// 		viewLink:
	// 			"https://img.freepik.com/premium-vector/document-file-with-check-mark-concept-flat-vector-illustration_776222-3.jpg",
	// 		downloadLink:
	// 			"https://img.freepik.com/premium-vector/document-file-with-check-mark-concept-flat-vector-illustration_776222-3.jpg",
	// 	},
	// ]);
let outputData = ref({});
	function appendData(formId, data) {
		completeInfo.value[formId] = data;
		step.value = step.value + 1;
		window.scrollTo(0, 0);
		if (step.value === 4) fetchBMs();
	}

	function goToPrevStep() {
		step.value = step.value - 1;
	}

	function fetchBMs() {
		//! HERE WE CALL AN AJAX CALL TO FETCH RESULTS AND STORE THEM IN THE outputData Variable
    let set = JSON.parse(_settings);

    const apiUrl = set.tdomain+'/wp-json/fikra/v1/add-order';

    // Make a GET request to the custom API endpoint using Axios
    axios.post(apiUrl,{'order_data':completeInfo.value})
        .then(response => {
          // Handle the response data
          // Perform further actions with the response data as needed
          console.log(response.data)
          outputInfoReady.value = true;
          outputData = response.data.outputData
        })
        .catch(error => {
          // Handle any errors that occur during the API call
          console.log(error)
        });

		// setTimeout(() => {
		// 	outputInfoReady.value = true;
		// }, 5000);
	}
</script>
