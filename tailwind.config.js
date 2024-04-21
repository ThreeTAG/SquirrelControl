/** @type {string[]} */
const usedColors = ['blue', 'red', 'green']
const safeList = [];
for (let usedColorsKey in usedColors) {
    for(let i = 0; i < 9; i++) {
        safeList.push('bg-' + usedColors[usedColorsKey] + '-' + (i === 0 ? 50 : i * 100));
    }
}

module.exports = {
    safelist: safeList,
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {},
    },
    plugins: [],
}
