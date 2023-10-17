<template>
	<footer class="bg-primary">
		<div class="mx-auto w-full max-w-screen-xl px-6 py-6 lg:py-8">
			<div class="md:flex md:justify-between">
				<div class="mb-6 md:mb-0">
					<a :href="_settings.url" class="flex items-center">
						<img :src="_settings.footer_logo" class="h-20" alt="Logo" />
					</a>
				</div>
				<div class="grid grid-cols-2 gap-8 sm:gap-6 sm:grid-cols-3">
					<div>
<!--						<h2 class="mb-3 d-none text-white font-medium">خدماتنا</h2>-->
						<ul class="text-gray-300 font-medium">

							<li class="mb-3"  v-for="item in _settings.footer_menu1">
								<a :href="item.url" class="hover:text-white hover:underline">{{ item.title  }}</a>
							</li>

						</ul>
					</div>
					<div>
<!--						<h2 class="mb-3 d-none text-white font-medium">مراجع</h2>-->
						<ul class="text-gray-300 font-medium">
              <li class="mb-3"  v-for="item in _settings.footer_menu3">
                <a :href="item.url" class="hover:text-white hover:underline">{{ item.title  }}</a>
              </li>
						</ul>
					</div>
					<div>
<!--						<h2 class="mb-3 d-none text-white font-medium">عامة</h2>-->
						<ul class="text-gray-300 font-medium">
              <li class="mb-3"  v-for="item in _settings.footer_menu2">
                <a :href="item.url" class="hover:text-white hover:underline">{{ item.title  }}</a>
              </li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div class="bg-white w-full">
			<div
				class="w-full max-w-screen-xl flex flex-col items-center justify-between space-y-4 mx-auto md:flex-row md:space-y-0 p-6">
				<span class="text-grey sm:text-center font-medium text-sm"
					> {{ _settings.copyright}}
				</span>
				<div class="flex justify-between items-center">
					<a :href="_settings.social.youtube" target="_blank" v-if="_settings.social.youtube">
						<img :src="_settings.tlink+'/src/assets/img/youtube.svg'" class="w-16 h-11" alt="" />
					</a>
          <a :href="_settings.social.linkedin" target="_blank" v-if="_settings.social.linkedin">
						<img :src="_settings.tlink+'/src/assets/img/linkedin.svg'" class="w-16 h-11" alt="" />
					</a>
          <a :href="_settings.social.twitter" target="_blank" v-if="_settings.social.twitter">
						<img :src="_settings.tlink+'/src/assets/img/x.svg'" class="w-16 h-11" alt="" />
					</a>
				</div>
				<span class="text-grey sm:text-center font-medium text-sm">{{ _settings.mobile}}</span>
			</div>
		</div>
	</footer>
</template>
