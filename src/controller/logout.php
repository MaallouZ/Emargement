<?php
function logout() {
    session_start();
    session_reset();
    session_destroy();
    header("Location: index.php?action=login");
    exit;
}
