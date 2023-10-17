<template>
	<div
		class="h-auto min-h-[80vh] flex flex-col items-center justify-center px-[20px]  md:px-[62px] lg:px-[220px]  mx-auto">
		<div class="flex flex-col w-full p-3">
			<div class="flex flex-col flex-1 overflow-hidden bg-white rounded-lg shadow-sm">
				<div class="flex items-center justify-start px-6 bm_img">
					<h1 class="w-[370px] text-[48px] font-medium text-center text-grey">أداة اختيار نموذج العمل التجاري</h1>
				</div>
				<div class="flex flex-col justify-start flex-1 p-8">
					<h3 class="mb-8 text-lg">
						هذه الخدمة تتيح لك معرفة نموذج العمل التجاري الأقرب لفكرتك الابتكارية عن طريق الإجابة عن بعض الأسئلة الخاصة بفكرة مشروعك
						و مساعدتك على التطور و الاطلاع على الرواد في مجالك، تعد نماذج الأعمال مهمة لكل من الشركات الجديدة والقائمة؛ فهي تساعدهم
						على جذب الاستثمار وتوظيف المواهب وتحفيز الإدارة والموظفين.
					</h3>
					<div class="flex flex-col items-start justify-center w-full max-w-lg mb-8 space-y-4">
						<h3 class="text-lg font-bold text-grey">خطوات العمل</h3>
						<div class="flex items-center justify-center">
							<div class="items-center justify-center hidden w-12 h-12 mx-1 rounded-full bg-primary md:flex">
								<img :src="_settings.tlink+'/src/assets/img/icon_1.svg'" class="h-7 w-7" alt="Icon" />
							</div>
							<p class="md:hidden text-primary">●</p>
							<div class="mx-3 text-lg font-medium text-grey">الإجابة على الأسئلة الاستكشافية</div>
						</div>
						<div class="flex items-center justify-center">
							<div class="items-center justify-center hidden w-12 h-12 mx-1 rounded-full bg-primary md:flex">
								<img :src="_settings.tlink+'/src/assets/img/icon_2.svg'" class="h-7 w-7" alt="Icon" />
							</div>
							<p class="md:hidden text-primary">●</p>
							<div class="mx-3 text-lg font-medium text-grey">الحصول على نماذج الأعمال المقترحة</div>
						</div>
						<div class="flex items-center justify-center">
							<div class="items-center justify-center hidden w-12 h-12 mx-1 rounded-full bg-primary md:flex">
								<img :src="_settings.tlink+'/src/assets/img/icon_3.svg'" class="h-7 w-7" alt="Icon" />
							</div>
							<p class="md:hidden text-primary">●</p>
							<div class="mx-3 text-lg font-medium text-grey">التعرف على تفاصيل كل نموذج عمل</div>
						</div>
						<div class="flex items-center justify-center">
							<div class="items-center justify-center hidden w-12 h-12 mx-1 rounded-full bg-primary md:flex">
								<img :src="_settings.tlink+'/src/assets/img/icon_4.svg'" class="h-7 w-7" alt="Icon" />
							</div>
							<p class="md:hidden text-primary">●</p>
							<div class="mx-3 text-lg font-medium text-grey">الاستفادة من المقترحات في خطتك التجارية القادمة</div>
						</div>
					</div>
					<router-link to="/create" class="w-1/2 py-2 text-center text-white rounded-full bg-primary">ابدأ</router-link>
				</div>
			</div>
		</div>
	</div>
</template>
