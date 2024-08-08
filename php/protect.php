<?php
include_once ("./php/session.php");

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
}
?>