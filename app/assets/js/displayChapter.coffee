define ['common'], ->

  $ ->
    if ($("#selectedVerse").length>0)
      $('html, body').animate
        scrollTop: $("#selectedVerse").offset().top-20,
        1000

  showPopover = ->
    popoverHeader = """
            <span class="word">#{$(this).data('unic')}</span> <i>#{$(this).data('mj')}</i>
            <button type="button" class="close"><span aria-hidden="true" style="padding-left: 10px"><sup>&times;</sup></span><span class="sr-only">Bezár</span></button>
            <br><small>#{$(this).data('szf')}, #{$(this).data('elem')}</small>
      """
    popoverContent = """
          <div class="wordPopover" id="pop#{$(this).data('wordid')}">
                      <span class="word">#{$(this).data('szal')}</span><br /><br />
              <a id="a#{$(this).data('wordid')}" href="/details" class="btn btn-default btn-sm">Részletek</a>
              </div>
        """
    wordId = $(this).data("wordid");
    popLink = this;
    $(this).on 'shown.bs.popover', ->
      $("#a"+wordId).click ->
        $(popLink).popover('hide')
        $(".modal-content").load "/details/"+wordId
        $("#detailsModal").modal('show')
        false
      $closeButton = $(".popover-title .close", $("div#pop#{ wordId }").parent().parent())
      $closeButton.click ->
        $(popLink).popover('hide')
    $(this).popover(
      placement: "auto top"
      trigger: "manual"
      html: true
      title: popoverHeader
      content: popoverContent
    ).popover('toggle')
    false

  resetWord = ($wordDetailsDiv) ->
    if ($wordDetailsDiv.length>0)
      word = $('span.word:first', $wordDetailsDiv).text()
      span = """
        <span class="word">#{word}</span>
      """
      $wordDetailsDiv.parent().hide(400);
      $wordDetailsDiv.parent().html(span)
      $wordDetailsDiv.parent().show(400);
  replaceWord = ($word) ->
    $word.fadeOut(
      complete: ->
        div = """
            <div class="panel panel-default wordDetails">
                <div class="panel-body">
                  <span class="word">#{$word.data('unic')}</span> <i>#{$word.data('mj')}</i>
                  <!--<button type="button" class="close"><span aria-hidden="true" style="padding-left: 10px"><sup>&times;</sup></span><span class="sr-only">Bezár</span></button>-->
                  <div><small>#{$word.data('szf')}, #{$word.data('elem')}</small></div>
                  <div><span class="greek">#{$word.data('szal')}</span> <small><i>#{$word.data('dict-mj')}</i></small></div>
                  <div><span class="greek"><small>#{$word.data('dict-valt')}</small></span></div>
                </div>
            </div>
          """
        $word.html(div);
        $word.show(500);
    );
  $words = $('a.word')
  $words.click (wordClickEvent) ->
    resetWord($('div.wordDetails'))
    replaceWord($(this))
    false
  $verseNums = $('a[data-poload]');
  $verseNums.click (verseNumEvent) ->
    e=$(this);
    if (!e.data('cache'))
      $.get(e.data('poload'), (d) ->
        e.data('cache', d.text);
        e.popover(
          html: true
          trigger: "manual"
          content: """
              <button data-verse-id="#{e.data('verse-id')}" type="button" class="close"><sup>&times;</sup></button>
              <div>#{d.text}</div>
              <div style="border-top: 1px solid #ccc; padding-top:4px">
                <button data-verse-id="#{e.data('verse-id')}" type="button" class="btn btn-default btn-xs byWords">Szavanként</button>
                <a target="_blank" href="#{d.canonicalUrl}"><span style="white-space: nowrap; padding-left:5px; float:right;"><small>#{d.canonicalRef}</small></span></a>
              </div>
            """
          placement: "auto top"
        ).popover('toggle')
        $("button[data-verse-id='#{e.data('verse-id')}'].byWords").click ->
          $("sup[data-verse-id='#{e.data('verse-id')}']").toggleClass('hidden')
        $("button[data-verse-id='#{e.data('verse-id')}'].close").click ->
          e.popover('hide')
      )
    else
      e.popover('toggle')
      $("button[data-verse-id='#{e.data('verse-id')}'].byWords").click ->
        $("sup[data-verse-id='#{e.data('verse-id')}']").toggleClass('hidden')
      $("button[data-verse-id='#{e.data('verse-id')}'].close").click ->
        e.popover('hide')
    false
