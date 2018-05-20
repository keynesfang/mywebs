<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
    <link rel='stylesheet' type='text/css' href='../../lib/bootstrap-3.3.7/css/bootstrap.min.css'>
    <link rel='stylesheet' type='text/css' href='../../lib/font-awesome-4.7.0/css/font-awesome.min.css'>
    <link rel='stylesheet' type='text/css' href='../../css/common.css'>
    <link rel='stylesheet' type='text/css' href='./css/family.css'>
    <link href="../../lib/bootstrap-wysiwyg/prettify.css" rel="stylesheet"/>
    <link href="../../lib/bootstrap-wysiwyg/style.css" rel="stylesheet"/>
    <script src='../../lib/jquery-3.2.1.min.js'></script>
    <script src='../../lib/popper.min.js'></script>
    <script src='../../lib/bootstrap-3.3.7/js/bootstrap.min.js'></script>
    <script src='../../lib/jquery.cookie.js'></script>
    <script src='../../lib/common.js'></script>
    <script src="../../lib/form_operator.js"></script>
    <script src="../../lib/bootstrap-wysiwyg/jquery.hotkeys.js"></script>
    <script src="../../lib/bootstrap-wysiwyg/prettify.js"></script>
    <script src="../../lib/bootstrap-wysiwyg/bootstrap-wysiwyg.js"></script>
    <script>
        $(function () {
            $("#person_name").text($.cookie("person_name"));
            $('#editor').wysiwyg();
        });
        
        function add_event() {
            var data_arr = {};
            data_arr["family_id"] = $.cookie("family_id");
            data_arr["person_id"] = $.cookie("person_id");
            data_arr["happen_date"] = $.trim($("#happen_date").val());
            data_arr["event_title"] = $.trim($("#event_title").val());
            data_arr["event_content"] = ($("#editor").html());
            insertDataToDB("family_event", data_arr, add_event_callback);
        }
        
        function add_event_callback() {
            clear_person_info();
        }
        
        function giveup() {
            clear_person_info();
        }

        function clear_person_info() {
            $.cookie("person_id", "");
            $.cookie("person_name", "");
            parent.$("#sub_frame").attr("src", "./family_browse.php");
        }
    </script>
    <title>族谱网</title>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <div style="margin: 30px 0 30px 0" class="user_flag">
                匆匆那年！<span id="person_name" style="color: red;"></span>
            </div>
            <div>
                <div class="form-group">
                    <label for="happen_date">发生日期</label>
                    <input type="date" class="form-control" id="happen_date">
                </div>
                <div class="form-group">
                    <label for="event_title">事件标题</label>
                    <input type="text" class="form-control" id="event_title" placeholder="建议10字以内概括事件">
                </div>
                <label for="happen_date">发生经过</label>
                <div class="btn-toolbar event_btn_toolbar" data-role="editor-toolbar" data-target="#editor">
                    <div class="btn-group">
                        <a class="btn btn-default dropdown-toggle" data-toggle="dropdown" title="Font Size"><i
                                class="fa fa-text-height"></i>&nbsp;<b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a data-edit="fontSize 5" class="fs-Five">Huge</a></li>
                            <li><a data-edit="fontSize 3" class="fs-Three">Normal</a></li>
                            <li><a data-edit="fontSize 1" class="fs-One">Small</a></li>
                        </ul>
                    </div>
                    <div class="btn-group">
                        <a class="btn btn-default dropdown-toggle" data-toggle="dropdown"
                           title="Text Highlight Color"><i class="fa fa-paint-brush"></i>&nbsp;<b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <p>&nbsp;&nbsp;&nbsp;Text Highlight Color:</p>
                            <li><a data-edit="backColor #00FFFF">Blue</a></li>
                            <li><a data-edit="backColor #00FF00">Green</a></li>
                            <li><a data-edit="backColor #FF7F00">Orange</a></li>
                            <li><a data-edit="backColor #FF0000">Red</a></li>
                            <li><a data-edit="backColor #FFFF00">Yellow</a></li>
                        </ul>
                    </div>
                    <div class="btn-group">
                        <a class="btn btn-default dropdown-toggle" data-toggle="dropdown" title="Font Color"><i
                                class="fa fa-font"></i>&nbsp;<b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <p>&nbsp;&nbsp;&nbsp;Font Color:</p>
                            <li><a data-edit="foreColor #000000">Black</a></li>
                            <li><a data-edit="foreColor #0000FF">Blue</a></li>
                            <li><a data-edit="foreColor #30AD23">Green</a></li>
                            <li><a data-edit="foreColor #FF7F00">Orange</a></li>
                            <li><a data-edit="foreColor #FF0000">Red</a></li>
                            <li><a data-edit="foreColor #FFFF00">Yellow</a></li>
                        </ul>
                    </div>
                    <div class="btn-group">
                        <a class="btn btn-default" data-edit="bold" title="Bold (Ctrl/Cmd+B)"><i class="fa fa-bold"></i></a>
                        <a class="btn btn-default" data-edit="italic" title="Italic (Ctrl/Cmd+I)"><i
                                class="fa fa-italic"></i></a>
                        <a class="btn btn-default" data-edit="strikethrough" title="Strikethrough"><i
                                class="fa fa-strikethrough"></i></a>
                        <a class="btn btn-default" data-edit="underline" title="Underline (Ctrl/Cmd+U)"><i
                                class="fa fa-underline"></i></a>
                    </div>
                    <div class="btn-group">
                        <a class="btn btn-default" data-edit="insertunorderedlist" title="Bullet list"><i
                                class="fa fa-list-ul"></i></a>
                        <a class="btn btn-default" data-edit="insertorderedlist" title="Number list"><i
                                class="fa fa-list-ol"></i></a>
                        <a class="btn btn-default" data-edit="outdent" title="Reduce indent (Shift+Tab)"><i
                                class="fa fa-outdent"></i></a>
                        <a class="btn btn-default" data-edit="indent" title="Indent (Tab)"><i class="fa fa-indent"></i></a>
                    </div>
                    <div class="btn-group">
                        <a class="btn btn-default" data-edit="justifyleft" title="Align Left (Ctrl/Cmd+L)"><i
                                class="fa fa-align-left"></i></a>
                        <a class="btn btn-default" data-edit="justifycenter" title="Center (Ctrl/Cmd+E)"><i
                                class="fa fa-align-center"></i></a>
                        <a class="btn btn-default" data-edit="justifyright" title="Align Right (Ctrl/Cmd+R)"><i
                                class="fa fa-align-right"></i></a>
                        <a class="btn btn-default" data-edit="justifyfull" title="Justify (Ctrl/Cmd+J)"><i
                                class="fa fa-align-justify"></i></a>
                    </div>
                    <div class="btn-group">
                        <a class="btn btn-default dropdown-toggle" data-toggle="dropdown" title="Hyperlink"><i
                                class="fa fa-link"></i></a>
                        <div class="dropdown-menu input-append">
                            <input placeholder="URL" type="text" data-edit="createLink">
                            <button class="btn" type="button">Add</button>
                        </div>
                        <a class="btn btn-default" data-edit="unlink" title="Remove Hyperlink"><i
                                class="fa fa-unlink"></i></a>
                    </div>
                    <div class="btn-group">
                    <span id="pictureBtn" class="btn btn-default" title="插入图片 (支持拖拽)"> <i class="fa fa-picture-o"></i>
                        <input class="imgUpload" style="top:0; left:0;" type="file" data-role="magic-overlay"
                               data-target="#pictureBtn" data-edit="insertImage">
                    </span>
                    </div>
                    <div class="btn-group">
                        <a class="btn btn-default" data-edit="undo" title="Undo (Ctrl/Cmd+Z)"><i class="fa fa-undo"></i></a>
                        <a class="btn btn-default" data-edit="redo" title="Redo (Ctrl/Cmd+Y)"><i
                                class="fa fa-repeat"></i></a>
                    </div>
                </div>
                <div id="editor" class="lead" style="overflow:scroll; min-height: 250px;" contenteditable="true"></div>
                <button class="btn btn-primary" style="float: right; margin-bottom: 20px;" onclick="add_event();">提交</button>
                <button class="btn btn-default" style="float: right; margin-right: 20px; margin-bottom: 20px;" onclick="giveup();">放弃</button>
            </div>
        </div>
    </div>
</div>
</body>
</html>
