require.config(
  baseUrl: '/js'
  paths:
    jquery: [
      "//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min"
      "lib/jquery.min"
    ]

    'jquery.ui.widget': [
        "lib/jquery.ui.widget.min"
    ]

    dropzone: "lib/dropzone-amd-module.min"
    bootstrap: "lib/bootstrap.min"
    hogan: "lib/hogan-3.0.2.min.amd"

  shim:
    bootstrap: ['jquery']
    'jquery.ui.widget': ['jquery']
)

define ['bootstrap', 'jquery', 'hogan', 'menu'], ->