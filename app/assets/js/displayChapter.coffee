define ['bootstrap'], ->
  $words = $('a.word')
  $words.click (e) ->
    $(this).popover('toggle')
    wordId = $(this).data("wordid");
    popLink = this;
    $(this).on 'shown.bs.popover', ->
      $("#a"+wordId).click ->
        $(popLink).popover('hide')
        $(".modal-content").load "/text/details/"+wordId
        $("#detailsModal").modal('show')
        false

  $verseNums = $('a[data-poload]');
  $verseNums.click ->
    e=$(this);
    if (!e.data('cache'))
      $.get(e.data('poload'), (d) ->
        e.data('cache', d.text);
        e.popover({ content: d.text, placement: "auto top" }).popover('toggle')
      )
    else
      e.popover('toggle')
