<?php

require_once('init.php');

print(include_template('layouts\main-layout.php', [
    'page_content' => include_template('guest.php'),
    'page_header' => include_template('layouts\header.php'),
    'css_file' => 'css\guest_page-style.css',
    'title' => 'Task Manager - Guest page'
]));