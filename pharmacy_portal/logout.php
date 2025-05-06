<?php
session_start();
session_destroy();
header("Location: PharmacyServer.php?action=login");
exit;
