abbrevs = require('./abbrevs.js')

scrollToElement = (element) ->
  $('div.textDisplay').animate
    scrollTop: $(element).offsetParent().scrollTop()+$(element).offset().top - 140, # todo: this is calculated from the top of window, should be made responsive
    1000

detailTemplate = """
          <div class="panel panel-default wordDetails">
              <div class="panel-heading">
                <span class="word">{{ unic }}</span> - {{ mj }}
                  <div><small>{{{ szf }}} {{{ elem }}}</small></div>
              </div>
              <div class="panel-body">
                <div><span class="word">{{ szal }}</span> - {{{ dictMj }}}</div>
                {{#dictValt}}
                <div class="variants"><small>Változatok:</small> {{{ dictValt }}}</div>
                {{/dictValt}}
                {{#lj}}
                <div class="footnote"><small>{{{ lj }}}</small></div>
                {{/lj}}
                <div class="concordance"><small>Konkordancia betöltése <i class="fa fa-spinner fa-spin"></i></small></div>
              </div>
          </div>
        """

concordanceTemplate =
  main: """
      <small>
        <ul class="list-unstyled">
          <li>{{^first}}
            Ez az első előfordulás.
          {{/first}}
          {{#first}}
            <li>Első azonos szótári alakú szó: {{> link }}</li>
          {{/first}}
          {{#previous}}
            <li>Előző azonos szótári alakú szó: {{> link }}</li>
          {{/previous}}
          {{#next}}
            <li>Következő azonos szótári alakú szó: {{> link }}</li>
          {{/next}}
          {{#previousAlphabetic}}
            <li>Abc-rendben előző szóalak: {{> link }}</li>
          {{/previousAlphabetic}}
          {{#nextAlphabetic}}
            <li>Abc-rendben következő szóalak: {{> link }}</li>
          {{/nextAlphabetic}}
          </li>
        </ul>
      </small>
    """
  partials:
    link: """
        <a href="{{ linkText }}">{{bookName}} {{ chapter }},{{ verse }}<sub>{{ wordNum }}</sub></a>
      """

quickTranslation = """
  <div class="greek">{{#words}}{{ unic }} {{/words}}
  </div>
  """

loadConcordance = (wordId) ->
  $.get "/text/concordance/#{wordId}", (result) ->

    addLink = (concordance) ->
      if concordance.chapter == $("#chapterTitle").data('chapter') and concordance.bookId == $("#chapterTitle").data('book')
        concordance.linkText = "#!#{ concordance.id }"
      else
        concordance.linkText = "/text/#{ concordance.id }"
      return concordance

    concordanceFragment = Hogan.compile(concordanceTemplate.main).render( {
      result: result
      first: if parseInt(result.first.id) == wordId then null else addLink(result.first)
      previous: addLink(result.previous) if result.previous
      next: addLink(result.next) if result.next
      nextAlphabetic: addLink(result.nextAlphabetic) if result.nextAlphabetic
      previousAlphabetic: addLink(result.previousAlphabetic) if result.previousAlphabetic
    }, concordanceTemplate.partials)
    $("div.concordance").html(concordanceFragment);

replaceWord = ($word) ->
  $('a.word.mark').removeClass('mark')
  $word.addClass('mark')
  wordId = $word.data('wordid');
  div = Hogan.compile(detailTemplate).render({
    lj : $word.data('lj')
    mj: $word.data('mj')
    dictMj: $word.data('dict-mj')
    unic : $word.data('unic')
    szal : $word.data('szal')
    dictValt: $word.data('dict-valt')
    elem: $word.data('elem')
    szf: $word.data('szf')
  });
  $(".detailsDisplay").html(div)
  $("abbr.literature").tooltip(
    container: 'body'
    title: ->
      abbrevs.literature[$(this).text().toUpperCase()]
  )
  $("abbr.morph").tooltip(
    container: 'body'
    title: ->
      text = abbrevs.morphs[$(this).text()];
      if text
        if text.latin
          text.latin + (if text.hungarian then ' ('+text.hungarian+' )' else '')
        else
          text.hungarian
  )
  $("a.ref").each ->
    a = $(this)
    a.append('<i class="fa fa-spinner fa-spin"></i>');
    $.get a.data('poload'), (d) ->
      a.popover(
        container: 'body'
        html: true
        content: ->
          Hogan.compile(quickTranslation).render({
            words: d
          })
        trigger: 'hover'
        placement: 'top auto'
      )
      $('i', a).hide()
  loadConcordance(wordId)

handleWordClick = ($words) ->
    if $(".detailsDisplay").is ":visible"
      replaceWord($words)
    else
      showPopover($words)
    false

handleHashChange = ->
  if (window.location.hash.length>2)
    $word = $("a##{window.location.hash.substring(2)}")
    if $word and $word.length == 1
      handleWordClick($word)
      scrollToElement($word)

$ ->
  window.onpopstate = (e) ->
    if e.state
      $word =$("a##{e.state.wordId}")
      handleWordClick($word)
      scrollToElement($word)
      false

  window.onhashchange = ->
    handleHashChange()

  handleHashChange()
  scrollToElement($(".selectedVerse")) if ($(".selectedVerse").length>0)

$("select[name='verse']").change ->
  bookId = $("#chapterTitle").data('book')
  chapter = $("#chapterTitle").data('chapter')
  if bookId == parseInt($("select[name='book']").val()) and chapter == parseInt($("select[name='chapter']").val())
    $link = $("a[name='#{$(this).val()}']");
    $("span.verse.mark").removeClass("mark")
    $link.parent().parent().addClass('mark')
    scrollToElement($link)

showPopover = ($word) ->
  $('a.word.mark').removeClass('mark')
  $word.addClass('mark')
  wordId = $word.data("wordid");
  popLink = $word;
  $(".modal-content").load "/details/"+wordId
  $("#detailsModal").modal(
    backdrop: false
    show: true
  )
  loadConcordance(wordId)
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

$words = $('a.word')
$words.click ->
  $word = $(this)
  wordId = $word.data 'wordid'
  history.pushState({ wordId: wordId }, null, "#!#{wordId}")
  handleWordClick($word)

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

