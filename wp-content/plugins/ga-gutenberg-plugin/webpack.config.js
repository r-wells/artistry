module.exports = {
    entry: './blocks/index.js',
    output: {
        path: __dirname,
        filename: 'block.build.js',
    },
    module: {
        rules: [
            {
                test: /.js$/,
                loader: "babel-loader",
                exclude: /node_modules/
            }
        ]
    }
}