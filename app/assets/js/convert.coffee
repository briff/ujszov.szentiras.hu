define ['common'], (common)->
  require ['dropzone'], (Dropzone) ->

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
            <div class="checkbox">
                <label>
                    <input id="general" name="general" type="checkbox" disabled>Általános frissítés
                </label>
            </div>
            <button id="startUpdate" class="btn btn-default disabled">Frissítés indítása</button>
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
    )
    dropzone.on "addedfile", (file) ->
      $(".start").click ->
        dropzone.enqueueFile(file)

    dropzone.on "sending", (file) ->
      $(".start").attr('disabled', 'disabled')

    dropzone.on "success", (file, response) ->
      $(".progress-bar").addClass "progress-bar-success"
      $("#updateForm input").removeAttr('disabled')
      $("#startUpdate").removeClass('disabled')
      $("#startUpdate").click ->
        $.post '/technikai/convert', {
          data:
            'file': response.fileName
            'general': $("#general").is(":checked")
        }
        false


