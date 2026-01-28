<?php
/**
 * Operon Cortex - Logout
 */

session_start();
session_destroy();

header("Location: index.php");
exit;
