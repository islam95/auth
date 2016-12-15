<?php include_once 'resource/session.php';
include_once 'resource/functions.php';
session_destroy();
redirect("index");
