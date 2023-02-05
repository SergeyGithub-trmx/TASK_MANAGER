<?php

function debug(array $array): void
{
    print('<pre>');
    print_r($array);
    print('</pre>');
    exit;
}
