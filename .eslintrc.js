module.exports = {
    "env": {
        "browser": true,
        "es2021": true,
        "node": true,
    },
    "extends": [
        "eslint:recommended",
        'plugin:vue/vue3-recommended',
        'plugin:vue/vue3-strongly-recommended',
        'plugin:vue/vue3-essential'
    ],
    "parserOptions": {
        "ecmaVersion": 12,
        "sourceType": "module"
    },
    "plugins": [
        "vue"
    ],
    "rules": {
        "vue/no-multiple-template-root": "off",
    }
};
