<template>
	<div class="w-[90%] md:w-[80%] lg:w-[60%] mx-auto result-templates"
  :class="{ 'show-all-templates': showAllTemplates }">
		<h1 class="mb-8 text-3xl font-bold md:text-4xl">نماذج العمل المقترحة</h1>
		<div
			v-for="bm in output"
			:key="bm.id"
			class="flex flex-col items-center justify-center px-6 py-8 mb-6 bg-white rounded-lg shadow-sm md:flex-row md:items-start result-template"
    >
			<img :src="bm.imgURL" alt="img" class="mb-4 h-44 aspect-video rounded-xl md:mb-0 md:ml-8" />

			<div class="flex flex-col w-[65%]">
				<p class="text-[#344054]">اسم النموذج</p>
				<h3 class="text-[#1C1C1C] font-bold text-[22px]">{{ bm.nameAR }}</h3>
				<p class="text-[#1C1C1C] font-semibold text-[20px]">{{ bm.nameEN }}</p>
				<div class="flex flex-col items-center justify-between w-full md:mt-5 md:flex-row">
					<a
						:href="bm.viewLink"
						target="_blank"
						class="w-full py-2 mx-2 mt-6 text-center bg-white border rounded-full text-primary border-primary">
						عرض الملف
					</a>
					<a
              :href="bm.downloadLink"
						download="Business Model"
						class="w-full py-2 mx-2 mt-6 text-center text-white rounded-full bg-primary"
						>تحميل الملف</a
					>
				</div>
			</div>
		</div>

		<div class="flex items-center justify-center w-full">
			<a
				target="_blank"
        v-if="output.length > 3"
        @click="showAll"
				class="px-4 moretemplates py-2 mx-2 mt-6 text-center font-bold border rounded-full w-full md:w-max text-[#3C3C3C] border-[#3C3C3C]">
				عرض باقي نماذج الأعمال
			</a>
		</div>
	</div>
</template>

<script setup>
import { ref } from "vue";
const showAllTemplates = ref(false);

	const props = defineProps({
		output: {
			type: Array,
			required: true,
		},
	});
  function showAll(){
    showAllTemplates.value = true;
  }
</script>
