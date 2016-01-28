require('jquery')

$('a.delete').click ->
  id = $(this).data('message')
  if (confirm("Biztos törlöd a(z) #{id}. számú üzenetet?"))
    $(this).parent().submit()
    false

