import { createRouter, createWebHistory } from "vue-router";

import TheLanding from "./views/TheLanding.vue";
import TheForm from "./views/TheForm.vue";
import TheDocuments from "./views/TheDocuments.vue";

const router = createRouter({
	history: createWebHistory(),

	routes: [
		{ path: "/", component: TheLanding },
		{ path: "/create", component: TheForm },
		{ path: "/docs", component: TheDocuments },
	],
});

export default router;
