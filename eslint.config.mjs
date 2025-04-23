import { defineConfig } from "eslint/config";
import js from "@eslint/js";
import globals from "globals";


export default defineConfig([
  { 
    files: ["**/*.{js,mjs,cjs}"], plugins: { js }, 
    //Extends: ["js/recommended"] 
  },
  { files: ["**/*.{js,mjs,cjs}"], languageOptions: { globals: globals.browser } },
  {
    rules:{
      "camelcase": ["error", {"properties": "never"}],
      "eqeqeq": ["error", "always"],
      "no-unused-vars": "error",
       "no-empty": "error"
    }
  }
]);