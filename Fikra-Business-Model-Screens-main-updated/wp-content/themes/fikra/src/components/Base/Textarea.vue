<template>
	<div>
		<label :for="name" class="block mb-2 text-sm font-medium text-grey"> {{ label }} </label>

		<div class="relative w-full">
			<div
				class="absolute inset-y-0 flex items-center pl-3 pointer-events-none right-3"
				:class="[errorState ? 'bottom-7' : '']"
				v-if="icon">

				<img :src="_settings.tlink+`/src/assets/img/${name}.svg`" alt="Icon" class="w-5 h-5" />
			</div>
			<textarea
				@change="$emit('update:modelValue', $event.target.value)"
				:name="name"
				:id="name"
				class="bg-white border border-gray-300 text-grey sm:text-sm rounded-lg focus:ring-primary focus:border-primary block w-full py-2.5 outline-none"
				:class="[icon ? 'px-10' : 'px-2.5', errorState ? 'isError' : '']"
				:placeholder="placeholder"
        spellcheck="false">{{ modelValue }}</textarea>

			<p v-if="errorState" class="block mt-2 text-sm font-medium text-red-500">• {{ errorState }}</p>
		</div>
	</div>
</template>

<script setup>
	const { type, modelValue, name, placeholder } = defineProps({
		modelValue: { type: String },
		name: { type: String, required: true },
		placeholder: { type: String, required: true },
		label: { type: String, required: true },
		icon: { type: Boolean },
		errorState: { type: String },
	});
</script>
