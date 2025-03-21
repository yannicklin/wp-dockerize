import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import sassGlobImports from "vite-plugin-sass-glob-import";
import path from "path";

export default defineConfig({
  plugins: [
    sassGlobImports(),
    laravel({
      hotFile: "public/hot",
      input: [
        "resources/styles/app.scss",
        "resources/scripts/app.ts",
        "resources/scripts/default-blocks.ts",
        "resources/scripts/block-names.ts",
        "resources/scripts/editor.ts",
      ],
      refresh: true,
    }),
  ],
  resolve: {
    alias: {
      "@": path.resolve(__dirname, "./resources/scripts"),
    },
  },
});
