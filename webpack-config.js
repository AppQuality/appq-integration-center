// Require path.
const path = require("path");
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const { CleanWebpackPlugin } = require("clean-webpack-plugin");
const BrowserSyncPlugin = require("browser-sync-webpack-plugin");

const cssLoaderByEnv = MiniCssExtractPlugin.loader; // mode !== 'production' ? 'style-loader' : MiniCssExtractPlugin.loader;

const browserSyncPaths = [
  "**/*.{php,js,ts,scss}",
  "!./vendors",
  "!./node_modules",
  "!./yarn-error.log",
  "!./package.json",
  "!./webpack.config.js",
];

const srcPath = path.resolve(__dirname, "src");
const alias = {
  "@scripts": `${srcPath}/scripts`,
  // '@images': `${srcPath}/assets/images`,
  // "@fonts": `${srcPath}/font`,
  "@styles": `${srcPath}/styles`,
};

// Configuration object.
const config = {
  // Create the entry points.
  // One for frontend and one for the admin area.
  entry: {
    // frontend and admin will replace the [name] portion of the output config below.
    // frontend: "./src/scripts/loader_frontend.js",
    admin: "./src/admin/scripts/_loader.js",
  },

  resolve: {
    extensions: [".tsx", ".ts", ".js"],
    alias: alias,
  },

  // Create the output files.
  // One for each of our entry points.
  output: {
    // [name] allows for the entry object keys to be used as file names.
    filename: "js/[name].js",
    // Specify the path to the JS files.
    path: path.resolve(__dirname, "assets"),
  },

  // Setup a loader to transpile down the latest and great JavaScript so older browsers
  // can understand it.
  module: {
    rules: [
      {
        // Look for any .js files.
        test: /\.js$/,
        // Exclude the node_modules folder.
        exclude: /node_modules/,
        // Use babel loader to transpile the JS files.
        loader: "babel-loader",
      },
      // {
      //   test: /\.(png|svg|jpg|gif)$/,
      //   use: [
      //     {
      //       loader: "file-loader",
      //       options: {
      //         name: "img/[name].[ext]",
      //       },
      //     },
      //   ],
      // },
      // {
      //   test: /\.(woff|woff2|ttf|eot|otf)$/,
      //   use: [
      //     {
      //       loader: "file-loader",
      //       options: {
      //         name: "[folder]/[name].[ext]",
      //         outputPath: "./font/",
      //         publicPath: "../font/",
      //       },
      //     },
      //   ],
      // },
      {
        test: /\.(css|s[ac]ss)$/i,
        use: [
          // fallback to style-loader in development
          cssLoaderByEnv,
          "css-loader",
          "sass-loader",
        ],
      },
    ],
  },
  plugins: [
    new CleanWebpackPlugin(),
    new MiniCssExtractPlugin({
      // Options similar to the same options in webpackOptions.output
      // both options are optional
      filename: "css/[name].css",
      chunkFilename: "css/[id].css",
    }),
    new BrowserSyncPlugin({
      host: "localhost",
      port: 8002,
      files: browserSyncPaths,
      reloadDelay: 500,
    }),
  ],
};

// Export the config object.
module.exports = config;
