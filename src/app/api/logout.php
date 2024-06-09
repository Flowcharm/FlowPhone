<?php
session_start();
session_destroy();

header('Location: /src/app/login.php');