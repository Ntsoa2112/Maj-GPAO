
<?php
include_once('header.inc.php');
include_once('php/common.php');
?>

<div id="mcorps">
    <div id="head">

        <?php
        include('baniR.php');
        include('headMen.php');
        if ((isset($_SESSION['error_msg'])) && (!empty($_SESSION['error_msg']))) {
            echo $_SESSION['error_msg'] . '<br>';
        }
        ?>
    </div>

    <div id="content">
        <center>
            <h1 CLASS="title message">GESTION DES CONSIGNES</h1>
            <hr/>
            <?php
            $c = new Cnx();
            ?>

            <div id="content_centre">


                <div class="container-fluid">

                    <div class="row" >
                        <div class="col-lg-8">
                            <div class="row" >
                                <div class="col-sm-6">

                                    <select class="form-control" id="client" placeholder="CLIENT"><option value="" disabled selected style="display: none;">CLIENT</option>
                                        <option value=""></option>
                                        <?php
                                        echo $c->getLstClient();
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row" >
                                <div id="lst_consigne"></div>
                            </div>
                        </div>
                        <div class="col-lg-4" id="upload_zone">

                            <article id="zone-upload" <?php if ($_SESSION['id_droit'] == 1) echo 'style="display:none"' ?>>
                                <span>Glisser ici le fichier pour l'ajouter aux consigne <br>
                                    <br><i>(optez pour un nommage explicite de vos fichiers, le format pdf et word sont conseillé!)</i>
                                    <br><i>seul celui qui a ajouté la consigne peut le supprimer</i></span>
                                <div id="holder" class="col-sm-12">
                                </div>
                                <p id="upload" class="hidden"><label>Drag & drop not supported, but you can still upload via this input field:<br><input type="file"></label></p>
                                <p id="filereader">File API & FileReader API not supported</p>
                                <p id="formdata">XHR2's FormData is not supported</p>
                                <p id="progress">XHR2's upload progress isn't supported</p>
                                <p id="p_bar"><progress id="uploadprogress" min="0" max="100" value="0">0</progress></p>
                                <p></p>
                            </article>
                        </div>
                    </div>
                </div>
                <hr/>
                <br>
            </div>
            <hr/>
        </center>
    </div>
    <?php
    include('footer.php');
    ?>
</div>
<input type="text" id="droitUser" style="display:none" value=" <?php echo $_SESSION['id_droit']; ?>" />
<div id="root">
    <div id="handle"></div>
    <div id="divflottant"></div>
</div>
</body>
<script language="javascript" type="text/javascript" src="js/jquery.js"></script>
<script language="javascript" type="text/javascript" charset="utf-8">
    $(document).ready(function () {
        loadConsigne();
    });
    
    $("#client").change(function () {
        var client = $("#client").val();

        $("#upload_zone").slideDown(300);
             loadConsigne();
    });

    function deleteConsigne(id)
    {
        alert(id);
        $.ajax({
            type: "GET",
            url: "php/link.php?action=delConsigneDet&id=" + id,
            success: function (msg) {
                //if (msg
                alert(msg);
                loadConsigne();
            }
        });
    }

    function loadConsigne()
    {
        var client = $('#client').val();
        if(client==undefined)
            client='';
        $.ajax({
            type: "GET",
            url: "php/link.php?action=loadConsignesDet&client=" + client,
            success: function (msg) {
                var id = $('#droitUser').val();
//                    if (id == 1)
//                        window.open(msg);
//                    else
                $('#lst_consigne').html(msg);
            }
        });
    }

    var holder = document.getElementById('holder'),
            tests = {
                filereader: typeof FileReader != 'undefined',
                dnd: 'draggable' in document.createElement('span'),
                formdata: !!window.FormData,
                progress: "upload" in new XMLHttpRequest
            },
            support = {
                filereader: document.getElementById('filereader'),
                formdata: document.getElementById('formdata'),
                progress: document.getElementById('progress')
            },
            acceptedTypes = {
                'image/png': true,
                'image/jpeg': true,
                'image/gif': true
            },
            progress = document.getElementById('uploadprogress'),
            fileupload = document.getElementById('upload');

    "filereader formdata progress".split(' ').forEach(function (api) {
        if (tests[api] === false) {
            support[api].className = 'fail';
        } else {
            // FFS. I could have done el.hidden = true, but IE doesn't support
            // hidden, so I tried to create a polyfill that would extend the
            // Element.prototype, but then IE10 doesn't even give me access
            // to the Element object. Brilliant.
            support[api].className = 'hidden';
        }
    });

    function previewfile(file) {
        if (tests.filereader === true && acceptedTypes[file.type] === true) {
            var reader = new FileReader();
            reader.onload = function (event) {
                var image = new Image();
                image.src = event.target.result;
                image.width = 250; // a fake resize
                holder.appendChild(image);
            };

            reader.readAsDataURL(file);
        } else {
            holder.innerHTML += '<p>' + file.name + ' --- ' + (file.size ? (file.size / 1024 | 0) + 'K' : '');
            console.log(file);
        }
    }

    function readfiles(files) {
        //debugger;
        $('#p_bar').slideDown(100);
        var client = $("#client").val();
        progress.value = progress.innerHTML = 0;
        var formData = tests.formdata ? new FormData() : null;
        for (var i = 0; i < files.length; i++) {
            if (tests.formdata)
                formData.append('file', files[i]);

            previewfile(files[i]);
        }

        // now post a new XHR request
        if (tests.formdata) {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', "./uploadifyDetourage.php?folder=/consignes&dossier=39&client=" + client);
            xhr.onload = function (msg) {
                progress.value = progress.innerHTML = 100;

            };

            if (tests.progress) {
                xhr.upload.onprogress = function (event) {

                    if (event.lengthComputable) {

                        var complete = (event.loaded / event.total * 100 | 0);
                        progress.value = progress.innerHTML = complete;
                        //alert(JSON.stringify(event));

                    }

                }
            }
            xhr.send(formData);


            xhr.addEventListener('readystatechange', function (e) {
                if (this.readyState === 4) {
                    // the transfer has completed and the server closed the connection.
                    loadConsigne();
                    $('#p_bar').slideUp(100);
                }
            });
        }
    }

    if (tests.dnd) {
        holder.ondragover = function () {
            this.className = 'hover';
            return false;
        };
        holder.ondragend = function () {
            this.className = '';
            return false;
        };
        holder.ondrop = function (e) {
            this.className = '';
            e.preventDefault();
            readfiles(e.dataTransfer.files);
        }
    } else {
        fileupload.className = 'hidden';
        fileupload.querySelector('input').onchange = function () {
            readfiles(this.files);
        };
    }
</script>
</html>

