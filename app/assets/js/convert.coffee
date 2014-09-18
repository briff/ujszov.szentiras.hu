define ['jquery'], ->
  $('li.file').click ->
    $('input[name="fajl_text"]').val($(this).data('path'))