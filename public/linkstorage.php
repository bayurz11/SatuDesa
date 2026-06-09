<?php

$target = __DIR__ . '/../storage/app/public';
$link = __DIR__ . '/storage';

if (symlink($target, $link)) {
    echo 'Storage linked successfully';
} else {
    echo 'Failed to create link';
}
