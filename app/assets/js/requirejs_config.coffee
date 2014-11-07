require.config(
  baseUrl: '/js'
  paths:
    jquery: [
      "//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min"
      "lib/jquery.min"
    ]

    bootstrap: "lib/bootstrap.min"
    app_modules: 'app_bundle'

  shim:
    bootstrap: ['jquery']

  deps: ['app_modules', 'jquery', 'bootstrap']
)