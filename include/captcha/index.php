<?php

header("HTTP/1.0 404 Not Found");
echo "<h1>404 Not Found</h1>";
echo "<p>The requested address <strong>{$_SERVER['REQUEST_URI']}</strong> was not found.</p>";
exit();