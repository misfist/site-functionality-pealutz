const glob = require('glob');
const path = require( 'path' );
const defaultConfig = require( '@wordpress/scripts/config/webpack.config' );

const indexFiles = glob.sync('./src/!(bindings)/index.js');
const bindingsIndexFiles = glob.sync('./src/bindings/**/index.js');

/**
 * Webpack config
 *
 * @see https://developer.wordpress.org/block-editor/packages/packages-scripts/#provide-your-own-webpack-config
 */
module.exports = {
	...defaultConfig,
	entry: {
		...defaultConfig.entry,
		index: [ ...indexFiles ],
		bindings: [ ...bindingsIndexFiles ]
	},
	output: {
		...defaultConfig.output,
		filename: '[name].js',
		path: path.resolve( __dirname, 'build' ),
	}
};
