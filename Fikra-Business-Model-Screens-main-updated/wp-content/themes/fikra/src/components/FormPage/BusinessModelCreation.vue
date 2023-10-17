<template>
	<div class="flex flex-col items-center justify-center h-full">
		<span class="loader"></span>
		<p class="text-lg text-[#1C1C1C] leading-5 mb-2 mt-4">شكرًا</p>
		<p class="text-lg text-[#1C1C1C] leading-5 mb-4">يتم الآن إنشاء مقترحات نموذج العمل الابتكاري</p>
		<p class="text-[#1C1C1C] leading-5 mb-4 text-sm">يرجى الانتظار...</p>
	</div>
</template>

<script setup></script>

<style scoped>
	.loader {
		width: 48px;
		height: 48px;
		display: inline-block;
		position: relative;
	}
	.loader::after,
	.loader::before {
		content: "";
		box-sizing: border-box;
		width: 48px;
		height: 48px;
		border-radius: 50%;
		background: #1c1c1c;
		position: absolute;
		left: 0;
		top: 0;
		animation: animloader 2s linear infinite;
	}
	.loader::after {
		animation-delay: 1s;
	}

	@keyframes animloader {
		0% {
			transform: scale(0);
			opacity: 1;
		}
		100% {
			transform: scale(1);
			opacity: 0;
		}
	}
</style>
