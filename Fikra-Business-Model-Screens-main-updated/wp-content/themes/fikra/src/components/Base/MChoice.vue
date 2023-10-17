<template>
	<div class="mb-16 space-y-2">
		<h2 v-if="heading" class="text-[#1C1C1C] text-xl font-bold">{{ heading }}</h2>
		<p v-if="subHeading" class="text-[#344054] text-base font-normal">{{ subHeading }}</p>
		<div class="flex flex-wrap items-center justify-start">
			<div class="flex w-100 justify-start item-center min-w-[120px] m-2" v-for="option in options" :key="option">
			<span class="mcd">
        	<span>
            <input
                v-if="questionType === 'Multiple'"
                :id="option.id + questionID"
                type="checkbox"
                :value="option.value"
                :checked="value.includes(option.value)"
                @input="selectCheckbox(questionID, option.id, $event.target.checked)" />
				<input
            v-if="questionType === 'Single'"
            :id="option.id + questionID"
            type="radio"
            :value="option.value"
            :checked="option.id === value.id"
            @change="selectRadio(questionID, option)" />
          </span>
      </span>
				<label :for="option.id + questionID" class="text-[#042925] text-lg mx-2">
					{{ option.value }}
				</label>
			</div>
		</div>
		<p v-if="description" class="text-[#344054] text-base font-normal max-w-[90%] md:max-w-[74%]">
			{{ description }}
		</p>
		<p v-if="errorState" class="block mt-2 text-sm font-medium text-red-500">
			{{ questionType === "Multiple" ? "الرجاء اختيار خيار واحد على الاقل." : "الرجاء اختيار احد الخيارات الموجودة." }}
		</p>
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
		errorState: {
			type: Boolean,
			required: true,
		},
	});

	const selectCheckbox = (questionID, optionId, checked) => {
		let updatedValue = [...props.value];
		if (checked) {
			updatedValue.push(props.options.find((obj) => obj.id === optionId));
		} else {
			updatedValue.splice(
				updatedValue.findIndex((obj) => obj.id === optionId),
				1
			);
		}
		emits("update:value", updatedValue);
		emits("updateErrorState", questionID);
	};

	const selectRadio = (questionID, optionId) => {
		emits("update:value", optionId);
		emits("updateErrorState", questionID);
	};
</script>

<style scoped>
	input[type="checkbox"],
	input[type="radio"] {
		cursor: pointer;
		width: 16px;
		accent-color: #4882ae;
	}
</style>
