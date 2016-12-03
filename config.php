<?php

// Program Mode (0 = production, 1 = debug)
$mode = 1;

//Database Configuration
$cleardb_info = parse_url(getenv("CLEARDB_DATABASE_URL"));
$db_server = $cleardb_info["host"];
$db_user = $cleardb_info["user"];
$db_pass = $cleardb_info["pass"];
$db_db = substr($cleardb_info["path"], 1);


// Chances (in percentage up to 2 decimal places)
$chance_user_phrase = 40;
$chance_phrase = 10;
$chance_user = 2;
$chance_random = 0.5;
