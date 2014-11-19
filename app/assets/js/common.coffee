require.config(
  baseUrl: '/js'
  paths:
    jquery: [
      "//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min"
      "lib/jquery.min"
    ]

    bootstrap: "lib/bootstrap.min"

  shim:
    bootstrap: ['jquery']
)

define ['bootstrap', 'jquery', 'menu'], ->