require('jquery')

$corpusSelector = $("select[name='corpus']")
$bookSelector = $("select[name='book']")
$chapterSelector = $("select[name='chapter']")
$verseSelector = $("select[name='verse']")

updateSelectors = (bookId, chapter = null) ->
  $.getJSON "/chapter-length/#{bookId}/#{if chapter is null then 1 else chapter}", [], (bookLengthResponse) ->
    bookLength = bookLengthResponse.bookLength
    chapterLength = bookLengthResponse.chapterLength
    if chapter is null
      $chapterSelector.append("<option value='#{option}' #{ option == 1 ? 'selected' }>#{option}</option>" for option in [1..bookLength])
    $verseSelector.empty().append("<option value='#{option}' #{ option == 1 ? 'selected' }>#{option}</option>" for option in [1..chapterLength])

$bookSelector.change (e) ->
  $chapterSelector.empty()
  $verseSelector.empty()
  updateSelectors $bookSelector.val()

$chapterSelector.change (e) ->
  $verseSelector.empty()
  updateSelectors $bookSelector.val(), $chapterSelector.val()

$corpusSelector.change (e) ->
  $bookSelector.empty()
  $chapterSelector.empty()
  $verseSelector.empty()
  corpus = parseInt($corpusSelector.val())
  $.getJSON "/corpus/#{corpus}", [], (booksResponse) ->
    $bookSelector.append("<option value='#{book.konyv_id}' #{ book.konyv_id == 1 ? 'selected' }'>#{book.nev}</option>") for book in booksResponse['books']
    updateSelectors(corpus * 100+1)

$('#searchFormDisplay').click (e) ->
  $('#searchFormDisplay').hide()
  $('#chooserForm').show(300)

$('#btnCorpusInfo').click ->
  location.assign "/corpus-info/" + $corpusSelector.val()
  false