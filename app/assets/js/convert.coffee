define ['common'], ->
  $('li.file').click ->
    $('input[name="fajl_text"]').val($(this).data('path'))