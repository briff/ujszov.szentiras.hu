define ['common'], ->

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