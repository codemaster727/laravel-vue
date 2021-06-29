<?php

return [
    // システム
    'system' => [
        'name' => 'ぬりえもん',
    ],
    // 運営事務局
    'owner' => [
        'name'  => 'ぬりえもん運営事務局',
        'email' => 'info@nuriemon.jp',
        'url'   => 'https://www.google.co.jp/',
    ],
    // ユーザー
    'user' => [
        // ステータス
        'status' => [
            'active'  => 0, // 稼働
            'halting' => 1, // 一時停止中
        ],
    ],
    // 職人
    'worker' => [
        // 職人ステータス
        'status' =>  [
            'active'  => 0,   // 通常
            'halting' => 1   // 停止
        ]
    ],
    // 管理者
    'manager' => [
        // 権限の有無
        'authority' =>  [
            'owner'  => 0,  // 管理者
            'agency' => 1   // 代理店
        ]
    ],
    // その他銀行
    'other_bank' => [
        'type' => [
            'normal'  => 0, // 普通
            'current' => 1, // 当座
        ]
    ],
    // 広告
    'advertisings' => [
        'status' => [
            'active'  => 0, // 出稿中
            'halting' => 1, // 停止中
            'deleted' => 2 // 削除済み
        ],
    ],
    // 金額
    'price' => [
        '1'  => 5000,
        '2'  => 10000,
        '3'  => 15000,
        '4'  => 20000,
        '5'  => 25000,
        '6'  => 30000,
        '7'  => 35000,
        '8'  => 40000,
        '9'  => 45000,
        '10' => 50000,
    ],
    // 現場
    'work' => [
        // ステータス
        'status' => [
            'unavailable' => 0, //　未確定
            'in_progress' => 1, //　進行中
            'completed' => 2, //　完了済み
        ],
        // 作業報告書
        'report' => [
            // 作業報告書画像
            'photo' => [
                'upload_folder' => 'uploads/photos',
                'file_types' => 'jpeg,png,jpg,gif,svg',
                'max_size' => '2048', // in kilobytes
            ]
        ],
        // 現場ステータス
        'status' => [
            'unsettled' => 0, // 未確定
            'confirmed' => 1, // 確定済み
            'completed' => 2, // 完了済み
        ],
    ],
    // 銀行
    'bank' => [
        'type' => [
            'japan' => 0,
            'other' => 1,
        ]
    ]

];
