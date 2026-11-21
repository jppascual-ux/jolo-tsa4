<?php
/*
 * This file should never run. The root .htaccess sends every visitor into
 * public/. If you can see this page, the .htaccess file in the main folder
 * did not upload or is empty.
 */
http_response_code(500);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Setup not finished</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif; max-width: 640px; margin: 3rem auto; padding: 0 1.25rem; line-height: 1.6; color: #1d1d1f; }
        h1 { font-size: 1.6rem; }
        code { background: #f5f5f7; padding: .1em .35em; border-radius: 4px; }
        li { margin-bottom: .5rem; }
    </style>
</head>
<body>
    <h1>Almost there: the <code>.htaccess</code> file is missing</h1>
    <p>The app is uploaded, but the file that routes visitors into the <code>public</code> folder is not working yet.</p>
    <ol>
        <li>In FileZilla, click <strong>Server &gt; Force showing hidden files</strong>.</li>
        <li>Check that <code>.htaccess</code> is in this main folder (next to <code>app</code> and <code>public</code>) and is not 0 bytes.</li>
        <li>Check that <code>public</code> also contains its own <code>.htaccess</code>.</li>
        <li>If either is missing, upload it again from FileZilla's left panel.</li>
    </ol>
</body>
</html>
