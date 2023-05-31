@include('main/header')



<div class="modal" id="FileEditModal" tabindex="-1" role="dialog" aria-labelledby="ModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered " role="document">
        <div class="modal-content bg-dark text-light">
            <div class="modal-header">
                <h5 class="modal-title" id="FileName"></h5>

                <div>
                    <button type="button" onclick="SaveFile()" class="btn btn-small btn-outline-primary">
                        <span aria-hidden="true"><i class="fas fa-save"></i></span>
                    </button>
                    <button type="button" class="close btn btn-small btn-outline-danger" data-bs-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            <div class="modal-body">
                <div id="alertMask"></div>
                <div id="editor"></div>
            </div>
            <div class="modal-footer">
                <div class="float-left">
                    <div id="syntax"></div>
                </div>
                <div class="float-right">
                    Change the syntax highlighting:
                    <select id="syntax-select">
                        <option value="properties">config</option>
                        <option value="css">css</option>
                        <option value="html">HTML</option>
                        <option value="javascript">JavaScript</option>
                        <option value="json">JSON</option>
                        <option value="properties">properties</option>
                        <option value="python">Python</option>
                        <option value="sh">sh</option>
                        <option value="text" selected>text</option>
                        <option value="yaml">YAML</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- BODY -->
<main class="col-md-9 ms-sm-auto col-lg-10 col-xxl-11 px-md-4 p-4">

    <div class="row g-3">
        <div class="col-12">
            <div class="card bg-dark border-secondary">
                <div class="card-header  bg-dark text-light h1 text-center">Filemanager</div>
                <div class="card-body bg-dark text-light" >
                    <div id="FileMgr"></div>
                    @include('body/snippets/snip-files')
                    <div class="alert alert-outline">
                        To upload your files drop them in the filemanager.<br>
                        Max filesize: {{ ini_get("upload_max_filesize")}}<br>
                        Max amount of files: {{ ini_get("max_file_uploads")}}<br>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
</div>
</div>

<script>
    function ChangeDirectory(Path) {
        $.ajax({
            type: "PUT",
            url: "{{ route('filebrowser.fetch') }}",
            data: {
                cd: Path,
            },
            success: function(result) {
                $("#FileMgr").html(result);
            },
            error: function(error) {
                console.log(error);
            }
        });
    }

    function DeleteFile(File) {
        if (confirm(`Are you sure you want to delete ${File}?`)) {
            $.ajax({
                type: "DELETE",
                url: "{{ route('filebrowser.delete') }}",
                data: {
                    file: File,
                },
                success: function(result) {
                    $("#FileMgr").html(result);
                },
                error: function(error) {
                    alert(error);
                }
            });
        } else
            return false;
    }

    function RenameFile(File) {
        var NewFileName = prompt(`Please enter a new name for "${File}"`, File)
        $.ajax({
            type: "PATCH",
            url: "{{ route('filebrowser.rename') }}",
            data: {
                OldName: File,
                NewName: NewFileName,
            },
            success: function(result) {
                $("#FileMgr").html(result);
            },
            error: function(error) {
                alert(error);
            }
        });
    }

    function DuplicateFile(File) {
        var NewFileName = prompt(`Please enter a name for the duplicate of "${File}"`, `dupe-${File}`)
        if (NewFileName == File) {
            alert("Operation cannot been done!\nThis filename already exist!");
            return false;
        }
        $.ajax({
            type: "POST",
            url: "{{ route('filebrowser.duplicate') }}",
            data: {
                OldName: File,
                NewName: NewFileName,
            },
            success: function(result) {
                $("#FileMgr").html(result);
            },
            error: function(error) {
                alert(error);
            }
        });
    }

    function OpenFile(File) {
        $.ajax({
            type: "GET",
            url: "{{ route('filebrowser.showFile') }}",
            data: {
                FileName: File,
            },
            success: function(result) {
                $("#FileName").html(File);
                editor.setValue(atob(result.content));
                editor.session.setMode(
                    `ace/mode/${result.ext}`);
                $('#FileEditModal').modal('show');
                $("#syntax").html(`Highlighted syntax: ${result.ext}`);
                $("#alertMask").html("");
                $("#syntax-select").val(result.ext).change();
                //alert(result);
            },
            error: function(error) {
                alert(error);
            }
        });
    }

    function DownloadFile(File) {
        $.ajax({
            type: "GET",
            url: "{{ route('filebrowser.downloadFile') }}",
            data: {
                FileName: File,
            },
            success: function(result) {
                
                if (typeof result === 'object') {
                    result = JSON.stringify(result);
                }
                
                var blob = new Blob([result], {
                    type: "application/octetstream"
                });

                var isIE = false || !!document.documentMode;
                if (isIE) {
                    window.navigator.msSaveBlob(blob, File);
                } else {
                    var url = window.URL || window.webkitURL;
                    link = url.createObjectURL(blob);
                    var a = $("<a />");
                    a.attr("download", File);
                    a.attr("href", link);
                    $("body").append(a);
                    a[0].click();
                    $("body").remove(a);
                }
            },
            error: function(error) {
                alert(error);
            }
        });
    }

    function SaveFile() {
        $.ajax({
            type: "patch",
            url: "{{ route('filebrowser.saveFile') }}",
            data: {
                FileName: $("#FileName").html(),
                Content: editor.getValue(),
            },
            success: function(result) {
                $("#alertMask").html(result);
                //alert(result);
            },
            error: function(error) {
                alert(error);
            }
        });
    }
</script>

<!-- Drag&Drop upload -->
<script>
    function UploadFiles(files) {
     
        var pwd = $("#FilePath").html();
        var formData = new FormData();
        formData.append("Path", pwd);

        for (var i = 0; i < files.length; i++) {
            formData.append('files[]', files[i]);
        }

        $.ajax({
            type: 'POST',
            url: '{{ route('filebrowser.uploadFiles') }}',
            data: formData, 
            contentType: false,
            processData: false,
            success: function(result) {
                // Handle the success response
                $("#FileMgr").html(result);
                console.log('Files uploaded successfully!');
            },
            error: function(error) {
                // Handle the error response
                alert(JSON.stringify(error));
                console.log('Error uploading files:', error);
            }
        });

    }

    function Init_D_N_D() {
        var dropZone = $('#FileMgr')[0];

        dropZone.addEventListener('dragover', function(event) {
            event.preventDefault();
            dropZone.classList.add('dragover');
        });

        dropZone.addEventListener('dragleave', function(event) {
            event.preventDefault();
            dropZone.classList.remove('dragover');
        });

        dropZone.addEventListener('drop', function(event) {
            event.preventDefault();
            dropZone.classList.remove('dragover');
            var files = event.dataTransfer.files;
            UploadFiles(files);
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        Init_D_N_D();
    });
</script>


<!-- Ace Fileeditor -->
<script src="/assets/dist/vendor/ace/src-noconflict/ace.js"></script>
<script>
    var editor = ace.edit("editor");
    editor.setTheme("ace/theme/monokai");
    editor.session.setMode("ace/mode/yaml");
    editor.session.setUseSoftTabs(true);
    editor.setOptions({
        navigateWithinSoftTabs: true,
        showInvisibles: true
    });
    editor.session.setTabSize(4);
    editor.readOnly = false;
    editor.commands.addCommand({
        name: "saveFile",
        bindKey: {
            win: "Ctrl-S",
            mac: "Command-S"
        },
        exec: SaveFile
    });

    function updateEditorMode() {
        var mode = document.getElementById("syntax-select").value;
        editor.session.setMode("ace/mode/" + mode);
    }

    // Event listener for dropdown selection change
    document.getElementById("syntax-select").addEventListener("change", function() {
        updateEditorMode();
    });
</script>

<!-- BODY -->

@include('main/footer')
