<?php

fwrite(STDOUT, "Divalia development server started on http://localhost:8000\n");

$cmd = "php -S localhost:8000 -t public";

$output = shell_exec($cmd);
