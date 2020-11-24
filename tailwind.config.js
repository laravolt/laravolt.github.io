module.exports = {
    purge: {
        content: [
            'source/**/*.html',
            'source/**/*.md',
            'source/**/*.js',
            'source/**/*.php',
            'source/**/*.vue',
        ],
        options: {
            whitelist: [
                /language/,
                /hljs/,
                /mce/,
                /markdown/,
            ],
        },
    },
    theme: {
        extend: {
        },
    },
}
