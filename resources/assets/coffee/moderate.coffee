require('jquery')

$('a.delete').click ->
  id = $(this).data('message')
  if $(this).data('hidden') == 0
    if (confirm("Biztos törlöd a(z) #{id}. számú üzenetet?"))
      $(this).parent().submit()
      false
  else
    $(this).parent().submit()
    false