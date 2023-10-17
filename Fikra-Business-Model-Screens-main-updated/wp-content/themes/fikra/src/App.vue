<template>
	<the-header />
	<router-view />
	<the-footer />
</template>

<script>
	import TheHeader from "./layout/TheHeader.vue";
	import TheFooter from "./layout/TheFooter.vue";
	export default {
		components: {
			TheHeader,
			TheFooter,
		},
	};
</script>
