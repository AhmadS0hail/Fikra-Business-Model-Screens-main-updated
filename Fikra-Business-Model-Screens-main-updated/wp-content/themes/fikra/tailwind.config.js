/** @type {import('tailwindcss').Config} */
module.exports = {
	content: ["./index.html", "./src/**/*.{vue,js,ts,jsx,tsx}"],
	theme: {
		screens: {
			sm: "480px",
			md: "768px",
			lg: "1130px",
			xl: "1440px",
		},
		extend: {
			colors: {
				primary: "#2A6490",
				secondary: "#007598",
				mainBG: "#F7F8FC",
				grey: "#1E1E1E",
			},
		},
	},
	plugins: [],
};
