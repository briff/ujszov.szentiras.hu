<?php

return [
    'connections' => [
        'mysql' => [
            'database'    => 'ujszov_staging',
            'username' => getenv("MYSQL_SZENTIRAS_USER"),
            'password' => getenv("MYSQL_SZENTIRAS_PASSWORD"),

        ],
    ],

];