<?php
require_once __DIR__ . '/../includes/helpers.php';
startSession();
session_destroy();
jsonOut(['ok' => true]);
