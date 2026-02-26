const removeCssProperties = require("./postcss-remove-css-properties.cjs");

module.exports = {
  plugins: [
    require("autoprefixer")({ grid: false }),
    require("css-declaration-sorter")({ order: "alphabetical" }),
    require("postcss-preset-env")({
      preserve: true,
      features: {
        "custom-properties": false,
        "nesting-rules": true,
        "gap-properties": { preserve: true },
        "logical-properties-and-values": false,
      },
      autoprefixer: false,
    }),
    require("postcss-discard-duplicates"),
    require("postcss-combine-media-query"),
    require("postcss-sort-media-queries")({ sort: "mobile-first" }),
    require("postcss-discard-comments"),
    removeCssProperties(),
  ],
};
