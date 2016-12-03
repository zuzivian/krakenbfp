<?php

// Program Mode (0 = production, 1 = debug)
$mode = 1;

//Database Configuration
$cleardb_info = parse_url(getenv("CLEARDB_DATABASE_URL"));
$db_server = $url["host"];
$db_user = $url["user"];
$db_pass = $url["pass"];
$db_db = substr($url["path"], 1);


// Chances (in percentage up to 2 decimal places)
$chance_user_phrase = 40;
$chance_phrase = 10;
$chance_user = 2;
$chance_random = 0.5;
