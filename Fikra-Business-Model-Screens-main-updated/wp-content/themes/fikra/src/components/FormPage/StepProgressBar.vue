<template>
	<div class="flex items-center justify-center pb-6 col-span-full">
		<div class="container">
			<ul class="progressbar">
				<li :class="[isActive(1) ? 'active' : '', progress === 1 ? 'font-bold text-lg' : '']">خطوة 1</li>
				<li :class="[isActive(2) ? 'active' : '', progress === 2 ? 'font-bold' : '']">خطوة 2</li>
				<li :class="[isActive(3) ? 'active' : '', progress === 3 ? 'font-bold' : '']">خطوة 3</li>
			</ul>
		</div>
	</div>
</template>

<script setup>
	const props = defineProps(["progress"]);

	function isActive(step) {
		return props.progress >= step;
	}
</script>

<style scoped>
	.container {
		width: 100%;
	}

	.progressbar {
		counter-reset: step;
	}

	.progressbar li {
		position: relative;
		list-style: none;
		float: right;
		width: 33.33%;
		text-align: center;
	}

	.progressbar li:before {
		content: "";
		counter-increment: step;
		width: 40px;
		height: 40px;
		border: 3px solid #4882ae;
		display: block;
		text-align: center;
		margin: 0 auto 5px auto;
		border-radius: 50%;
		background-color: #f5f5f7;
		line-height: 39px;
	}

	.progressbar li:after {
		content: "";
		position: absolute;
		width: 100%;
		height: 5px;
		background: #eaecf0;
		top: 20px;
		right: -50%;
		z-index: -1;
	}

	.progressbar li:first-child:after {
		content: none;
	}

	.progressbar li.active:before {
		background: #4882ae;
		content: "";
	}

  .progressbar li.active + li.active:after {
		background: #4882ae;
	}
</style>
