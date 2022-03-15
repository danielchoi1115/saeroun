const { defineConfig } = require('@vue/cli-service')
module.exports = defineConfig({
  transpileDependencies: true,
})

// const fs = require('fs')

// module.exports = {
//   devServer: {
//     https: {
//       key: fs.readFileSync('/usr/share/saeroun/saeroun-web/ssl/domain.com.key'),
//       cert: fs.readFileSync(
//         '/usr/share/saeroun/saeroun-web/ssl/domain.com.crt',
//       ),
//       ca: fs.readFileSync('/usr/share/saeroun/saeroun-web/ssl/rootca.crt'),
//     },
//   },
// }
module.exports = {
  devServer: {
    proxy: {
      '^/api': {
        target: 'http://127.0.0.1:5002',
        changeOrigin: true,
        secure: false,
        pathRewrite: { '^/api': '/api' },
        logLevel: 'debug',
      },
    },
  },
}
