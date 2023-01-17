<?php
require(__DIR__."/../database/MySqlConnection.php");
require(__DIR__."/../config/constants.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}