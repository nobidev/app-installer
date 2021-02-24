<?php
/*
 * Copyright (c) 2021 NobiDev
 */

declare(strict_types=1);

use NobiDev\AppInstaller\Helpers\Helper;

/** @noinspection SpellCheckingInspection */
return [
    'name' => config('app.name'),
    'vendor' => 'NobiDev',
    'title' => Helper::withNamespace('common.title'),
    'favicon' => '/images/common/icon.svg',
    'icon' => '/images/common/icon.svg',
    'cover' => '/images/common/cover.png',
    'help_url' => 'https://help.nobidev.com',
    'purpose_en' => 'build high quality website to interact with customers',
    'purpose_vi' => 'xây dựng website chất lượng cao để tương tác với khách hàng',
    'policies' => [
        [
            'name_en' => 'End-User License Agreement (EULA)',
            'name_vi' => 'Thoả Thuận Cấp Phép Người Dùng Cuối',
            'url' => 'https://help.nobidev.com/End_User_License_Agreement',
        ], [
            'name_en' => 'Software Deployment Policy (SDP)',
            'name_vi' => 'Quy Định Triển Khai Phần Mềm',
            'url' => 'https://help.nobidev.com/Software_Deployment_Policy',
        ], [
            'name_en' => 'Information Use Policy (IUP)',
            'name_vi' => 'Quy Định Sử Dụng Thông Tin',
            'url' => 'https://help.nobidev.com/Information_Use_Policy',
        ], [
            'name_en' => 'Cloud Computing Platform Use Policy (CCPUP)',
            'name_vi' => 'Quy Định Sử Dụng Nền Tảng Điện Toán Đám Mây',
            'url' => 'https://help.nobidev.com/Cloud_Computing_Platform_Use_Policy',
        ]
    ],
    'server' => [
        'os' => 'Linux',
        'sapi' => 'fpm-fcgi',
        'php' => '7.4',
    ],
    'extensions' => [
        'json' => '7',
        'pdo' => '7',
        'openssl' => '7',
        'mbstring' => '7',
        'curl' => '7',
        'xdebug' => config('app.debug') ? '*' : 'false',
        'extension_not_exist' => 'false',
    ],
    'permissions' => [
        '/tmp' => '1777',
        '.env' => '0644',
        'storage/framework' => '0775',
        'storage/logs' => '0775',
        'bootstrap/cache' => '0775',
        'public/uploads' => '0775',
        '/file_not_exist' => 'false',
    ],
    'user' => [
        'model_type' => \App\User::class,
        'name' => 'Owner',
        'username' => 'owner',
        'password' => 'owner',
        'email' => 'owner@example.com',
    ],
    'finished_route' => 'home',
];
