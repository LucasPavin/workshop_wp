const webpack = require("webpack");
const path = require("path");
const glob = require('glob');
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const CssMinimizerPlugin = require("css-minimizer-webpack-plugin");
const PurgecssPlugin = require('purgecss-webpack-plugin');
const purgecssWordpress = require('purgecss-with-wordpress');
const devMode = process.env.NODE_ENV !== "production";

/* Change it according to your development web server */
let PROXY = "http://one.wordpress.test/";
//let starter_child_entry = "../starter_child/src/js/app.js";
let starter_child_entry = "";

const PATHS = {
    src: path.join(__dirname, 'src')
};

let config = {
    target: 'web',
    entry: {
        admin: "./src/admin/js/app.js",
        app: starter_child_entry ? ["./src/js/app.js", starter_child_entry] : "./src/js/app.js",
    },
    output: {
        path: path.resolve(__dirname, "./"),
        filename: "./dist/[name].min.js",
        // assetModuleFilename: './dist/images/[hash][ext][query]'
    },
    module: {
      rules: [
        {
          test: /\.s[ac]ss$/i,
          use: [
            // fallback to style-loader in development
            {
                loader: MiniCssExtractPlugin.loader,
                // options: {
                //     publicPath: "./dist/",
                // },
            },
            // Translates CSS into CommonJS
            {
                loader: "css-loader",
                options: {
                    sourceMap: true,
                },
            },
            // Compiles Sass to CSS
            "sass-loader",
          ],
        },        
        {
            test: /\.(png|svg|jpg|jpeg|gif)$/i,
            type: 'asset/resource',
            generator: {
                filename: './dist/images/[hash][ext][query]'
            }            
        },
        {
            test: /\.(woff|woff2|eot|ttf|otf)$/i,
            type: 'asset/resource',
            generator: {
                filename: './dist/fonts/[hash][ext][query]'
            }
        },
      ],
    },
    optimization: {
        minimizer: [
          // For webpack@5 you can use the `...` syntax to extend existing minimizers (i.e. `terser-webpack-plugin`), uncomment the next line
          // `...`,
          new CssMinimizerPlugin({
            // minimizerOptions: {
            //   level: {
            //     1: {
            //       roundingPrecision: "all=3,px=5",
            //     },
            //   },
            // },
            // minify: CssMinimizerPlugin.cleanCssMinify,
            minimizerOptions: {
                restructure: false,
                debug: true
            },
            minify: CssMinimizerPlugin.cssoMinify,
          }),
        ],
    },
    plugins: [
        new MiniCssExtractPlugin({
            filename: "./dist/[name].min.css",
            chunkFilename: "[id].css",            
        }),
        // new PurgecssPlugin({
        //     paths: glob.sync(`${PATHS.src}/**/*`,  { nodir: true }),
        //     content: ['**/*.html'],
        //     css: ['**/*.css'],
        //     safelist: {
        //         standard: [...purgecssWordpress.safelist, /home-slider$/],
        //         deep: [/nav$/, /class$/],
        //     }
        // }),
        new webpack.ProvidePlugin({
            $: "jquery",
            jQuery: "jquery"
        })
    ],
    externals: [        
        {
            jquery: 'jQuery'
        }
    ],
    devServer: {
        // static: ['dist'],
        hot: true,
        open: true,
        watchFiles: ['./src/**/*', './dist/**/*'],
        //publicPath: "",
        //contentBase: path.resolve(__dirname, "dist"),
        // watchContentBase: true,
        host: 'localhost',
        port: '4000',        
        compress: true,
        static: {
            //directory: path.join(__dirname, 'dist'),
            //publicPath: '/wp-content/themes/starter/dist/',
            watch: true,
            serveIndex: true,
        },
        // devMiddleware: {
        //     index: false, // specify to enable root proxying
        // },
        proxy: {
            "/": {
                //context: () => true,
                target: PROXY,
                //pathRewrite: {"^/" : ""},
                secure: false,
                changeOrigin: true,
                autoRewrite: true,
                headers: {
                    'X-ProxiedBy-Webpack': true,
                },
            },
            
            // context: () => true,
            // target: PROXY,
            // changeOrigin: true,
        },
    },
    
  };

  module.exports = config;