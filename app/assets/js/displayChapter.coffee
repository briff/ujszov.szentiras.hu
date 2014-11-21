define ['common', 'abbrevs'], (common, abbrevs) ->


  scrollToVerse = (verse) ->
    $('div.textDisplay').animate
      scrollTop: $(verse).offsetParent().scrollTop()+$(verse).offset().top - 140, # todo: this is calculated from the top of window, should be made responsive
      1000

  $ ->
    scrollToVerse($(".selectedVerse")) if ($(".selectedVerse").length>0)

  $("select[name='verse']").change ->
    $link = $("a[name='#{$(this).val()}']");
    $("span.verse.mark").removeClass("mark")
    $link.parent().parent().addClass('mark')
    scrollToVerse($link)

  showPopover = ($word) ->
    popoverHeader = """
            <span class="word">#{$word.data('unic')}</span> <i>#{$word.data('mj')}</i>
            <button type="button" class="close"><span aria-hidden="true" style="padding-left: 10px"><sup>&times;</sup></span><span class="sr-only">Bezár</span></button>
            <br><small>#{$word.data('szf')}, #{$word.data('elem')}</small>
      """
    popoverContent = """
          <div class="wordPopover" id="pop#{$word.data('wordid')}">
                      <span class="word">#{$word.data('szal')}</span><br /><br />
              <a id="a#{$word.data('wordid')}" href="/details" class="btn btn-default btn-sm">Részletek</a>
              </div>
        """
    wordId = $word.data("wordid");
    popLink = $word;
    $word.on 'shown.bs.popover', ->
      $("#a"+wordId).click ->
        $(popLink).popover('hide')
        $(".modal-content").load "/details/"+wordId
        $("#detailsModal").modal('show')
        false
      $closeButton = $(".popover-title .close", $("div#pop#{ wordId }").parent().parent())
      $closeButton.click ->
        $(popLink).popover('hide')
    $word.popover(
      placement: "auto top"
      trigger: "manual"
      html: true
      title: popoverHeader
      content: popoverContent
    ).popover('toggle')
    false

  resetWord = ($wordDetailsDiv) ->
    if ($wordDetailsDiv.length>0 and not $(".detailsDisplay").is ':visible')
      word = $('span.word:first', $wordDetailsDiv).text()
      span = """
        <span class="word">#{word}</span>
      """
      $parent = $wordDetailsDiv.parent()
      $parent.hide 400, ->
        $parent.html span
        $parent.show 400

  replaceWord = ($word) ->
    $('a.word.mark').removeClass('mark')
    $word.addClass('mark')
    div = """
            <div class="panel panel-default wordDetails">
                <div class="panel-heading">
                  <span class="word">#{$word.data('unic')}</span> - #{$word.data('mj')}
                    <div><small>#{$word.data('szf')}, #{$word.data('elem')}</small></div>
                </div>
                <div class="panel-body">
                  <div><span class="word">#{$word.data('szal')}</span> - #{$word.data('dict-mj')}</div>
                  <div><span class="word">#{$word.data('dict-valt')}</span></div>
                </div>
            </div>
          """
    $(".detailsDisplay").html(div)
    $("abbr").tooltip(
      container: 'body'
      title: ->
        abbrevs.abbrevs[$(this).text()]
    )

  $words = $('a.word')
  $words.click (wordClickEvent) ->
    if $(".detailsDisplay").is ":visible"
      replaceWord($(this))
    else
      showPopover($(this))
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
          container: "body"
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
