define ['bootstrap'], ->

  $words = $('a.word')
  $words.click ->
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
        e.popover(
          html: true
          trigger: "manual"
          content: d.text +
            '<a target="_blank" href="'+d.canonicalUrl+'">'+d.canonicalRef+'</a>' +
           ' <button data-verse-id="'+e.data('verse-id')+'" type="button" class="btn btn-default btn-xs">Szavanként</button>'
          placement: "auto top"
        ).popover('toggle')
        $("button[data-verse-id='"+e.data('verse-id')+"']").click ->
          $("sup[data-verse-id='"+e.data('verse-id')+"']").toggle()
      )
    else
      e.popover('toggle')
      $("button[data-verse-id='"+e.data('verse-id')+"']").click ->
        $("sup[data-verse-id='"+e.data('verse-id')+"']").toggle()
