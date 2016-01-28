Dropzone = require('dropzone')

previewTemplate = """
  <div class="table table-striped" class="files dropzone-previews" id="previews">

  <div id="template" class="file-row">
    <div>
        <span class="preview"><img data-dz-thumbnail /></span>
    </div>
    <div>
        <p class="name" data-dz-name></p>
        <strong class="error text-danger" data-dz-errormessage></strong>
    </div>
    <div>
        <p class="size" data-dz-size></p>
        <div class="progress" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
          <div class="progress-bar" style="width:0%;" data-dz-uploadprogress></div>
        </div>
    </div>
    <div>
      <button class="btn btn-primary start">
          <i class="glyphicon glyphicon-upload"></i>
          <span>Feltöltés</span>
      </button>
    </div>
    <div>
    <form class="form" id="updateForm">
        <!--div class="checkbox">
            <label>
                <input id="general" name="general" type="checkbox" disabled>Általános frissítés
            </label>
        </div-->
        <button id="startUpdate" class="btn btn-default disabled">Frissítés indítása</button>
        <i id="spinner" class="fa fa-refresh"></i>
    </form>
  </div>
</div>

</div>
"""

dropzone = new Dropzone(document.body,
  url: "/technikai/upload"
  clickable: ".fileinput-button"
  autoQueue: false
  previewsContainer: "#previews"
  previewTemplate: previewTemplate
  uploadMultiple: false
  maxFiles: 1
  headers:
    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
)

dropzone.on "addedfile", (file) ->
  $(".start").click ->
    dropzone.enqueueFile(file)

dropzone.on "sending", (file) ->
  $(".start").attr('disabled', 'disabled')

dropzone.on "success", (file, response) ->
  $(".progress-bar").addClass "progress-bar-success"
  $("#updateForm input").removeAttr('disabled')
  $("#startUpdate").removeClass('disabled').prop("disabled", false)

  waitForJob = (queueJobId) ->
    $.ajax
      url: "/technikai/queue-job-status/#{queueJobId}"
      success: (data) ->
        if data.id
          window.location.href = "/technikai";
        else
          setTimeout( ->
            waitForJob(queueJobId)
          , 1000)




  $("#startUpdate").click ->
    $.ajax
      url: '/technikai/convert'
      method: 'POST'
      headers:
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      data:
        'file': response.fileName
        'general': true # $("#general").is(":checked")
      success: (response) ->
        $("#startUpdate").addClass("disabled").prop("disabled", true)
        $("#spinner").addClass("fa-spin")
        waitForJob(response.jobId)
    false


