require('jquery')

if $("#updaterJobsTable").length > 0

  rowRefresher = ($row) ->
    $.ajax
      url: '/technikai/status/'+$row.data('id')
      method: 'GET'
      success: (data) ->
        $row.children(".jobLines").html(data.lines)
        if data.completed
          $row.removeClass("inProgress")
          $row.children(".jobCompleted").children(".fa-refresh").hide()
          $row.children(".jobCompleted").children('.glyphicon').removeClass("glyphicon-unchecked")
          $row.children(".jobCompleted").children('.glyphicon').addClass("glyphicon-check")
          if data.failed
            $row.addClass("danger")
          else
            $row.addClass("success")
        else
          setTimeout( ->
            rowRefresher($row, data)
          , 2000)

  $(".inProgress").each ->
    $row = $(this)
    rowRefresher($row)
