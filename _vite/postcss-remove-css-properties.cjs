/**
 * Custom PostCSS plugin to remove specific CSS properties
 * - grid-gapプロパティを削除
 * - -moz-fit-contentプロパティを削除
 */
module.exports = () => {
  return {
    postcssPlugin: "remove-css-properties",
    Declaration(decl) {
      if (decl.prop === "grid-gap") {
        decl.remove();
      }
      if (decl.prop === "width" && decl.value.trim().includes("-moz-fit-content")) {
        decl.remove();
      }
    },
  };
};

module.exports.postcss = true;
