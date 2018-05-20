<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no'>
    <title>English</title>
</head>
<body>
<video width="343" controls>
    <source src="./resources/1.mp4" type="video/mp4">
    <track kind="subtitles" src="resources/1_eng.vtt" srclang="en" label="English">
    <track kind="subtitles" src="resources/1_chn.vtt" srclang="中文" label="简体中文">
    <p>Fall back code if video isn't support</p>
</video>
</body>
</html>
