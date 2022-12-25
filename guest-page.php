<?php

require_once('init.php');

print(includeTemplate('layouts\main-layout.php', [
    'page_content' => includeTemplate('guest.php'),
    'page_header' => includeTemplate('layouts\header.php'),
    'css_file' => 'css\guest_page-style.css',
    'title' => 'Task Manager - Guest page'
]));