define ['bootstrap'], ->
  $words = $('a.word')
  $words.click (e) ->
    $(this).popover('toggle')
    wordId = $(this).data("wordid");
    popLink = this;
    $(this).on 'shown.bs.popover', ->
      $("#a"+wordId).click ->
        $(popLink).popover('hide')
        $(".modal-content").load "/text/details", ->
        $("#detailsModal").modal('show')
        false