define ['common'], ->
  $("a#newMessage").click (e) ->
    $("#replyModal .modal-header").html("Új üzenet")
    $("#replyModal textarea#originalText").hide()
    $("#replyModal").modal('show')
    false
  $("a[data-message]").click (e) ->
    messageId = $(e.target).data('message')
    senderName = $(e.target).data('sender')
    messageText = $("#msg#{messageId}").html();
    $("#replyModal .modal-header").html("Válasz #{senderName} #{messageId}. számú üzenetére")
    $("#replyModal #originalText").html(messageText)
    $("#replyModal").modal('show')
    false
  $("#sendMessage").click ->
    hasError = false
    if ($("#name").val().length == 0)
      $("#name").parent().addClass("has-error")
      hasError = true

    if ($("#password").val() != "esik")
      $("#password").parent().addClass("has-error")
      hasError = true
    if (!hasError)
      $("#messageForm").submit()