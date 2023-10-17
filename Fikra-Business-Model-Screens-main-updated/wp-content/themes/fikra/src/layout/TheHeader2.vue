<template>
	<header>

		<nav class="bg-white border-gray-200 px-1 md:px-6 py-2.5">
			<div class="flex flex-wrap items-center justify-between max-w-screen-xl mx-auto">
				<a :href="_settings.url" class="flex items-center">
					<img :src="_settings.logo" class="h-14 xl:h-20" alt="Logo" />
				</a>
				<div class="flex items-center lg:order-2">
<!--					<a href="#" class="px-5 py-2 text-white rounded-full linearBG" style="display: none">تسجيل الدخول</a>-->
					<button
						@click="toggle_menu('mobile-menu-2')"
						type="button"
						class="inline-flex items-center p-2 ml-1 text-sm text-gray-500 rounded-lg lg:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200"
						aria-controls="mobile-menu-2"
						aria-expanded="false">
						<span class="sr-only">Open main menu</span>
						<svg id="m1" class=" w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
							<path
								fill-rule="evenodd"
								d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
								clip-rule="evenodd"></path>
						</svg>
						<svg id="m2" class="hidden m2 w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
							<path
								fill-rule="evenodd"
								d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
								clip-rule="evenodd"></path>
						</svg>
					</button>
				</div>
				<div  data-te-collapse-item class="items-center justify-between hidden w-full lg:flex lg:w-auto lg:order-1" id="mobile-menu-2">
					<ul class="flex mmenu flex-col mt-4 font-medium text-grey lg:flex-row-reverse lg:items-center lg:space-x-7">
          <a href="https://fikra-app.qewamx.com/login" target="_blank" class="loginBtn   w-fit py-2 px-12 mx-1 text-center text-white rounded-full bg-primary hover:bg-[#307094] transition-all duration-300 font-light"> تسجيل الدخول </a>

						<li v-for="item in _settings.top_menu">
							<a :href="item.url" class="block ">{{ item.title  }}</a>
						</li>

<!--            <a href="https://fikra-app.qewamx.com/login" target="_blank" class="loginBtn loginBtn-m  w-fit py-2 px-12 mx-1 text-center text-white rounded-full bg-primary hover:bg-[#307094] transition-all duration-300 font-light"> تسجيل الدخول </a>-->

          </ul>
				</div>
			</div>
		</nav>

	</header>

</template>

<style scoped>
	.linearBG {
		background: linear-gradient(90deg, #007598 21.23%, #019390 75.88%);
	}
</style>

<script>
export default {
  inject: ['globalData'],
  methods: {
    toggle_menu(id) {
      console.log('Button clicked')
      var myDiv = document.getElementById(id);
      myDiv.classList.toggle("hidden");

      var m1 = document.getElementById('m1');
      m1.classList.toggle("hidden");

      var m2 = document.getElementById('m2');
      m2.classList.toggle("hidden");
    }
  }
}


</script>