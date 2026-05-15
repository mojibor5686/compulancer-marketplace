<?php

namespace App\Constants;

class FileInfo
{

    /*
    |--------------------------------------------------------------------------
    | File Information
    |--------------------------------------------------------------------------
    |
    | This class basically contain the path of files and size of images.
    | All information are stored as an array. Developer will be able to access
    | this info as method and property using FileManager class.
    |
    */

    public function fileInfo()
    {
        $data['verify'] = [
            'path'      => 'assets/verify'
        ];
        $data['default'] = [
            'path'      => 'assets/images/default.png',
        ];

        $data['ticket'] = [
            'path'      => 'assets/support',
        ];
        $data['logoIcon'] = [
            'path'      => 'assets/images/logo_icon',
        ];
        $data['favicon'] = [
            'size'      => '128x128',
        ];
        $data['extensions'] = [
            'path'      => 'assets/images/extensions',
            'size'      => '36x36',
        ];
        $data['seo'] = [
            'path'      => 'assets/images/seo',
            'size'      => '1180x600',
        ];
        $data['userProfile'] = [
            'path'      => 'assets/images/user/profile',
            'size'      => '100x100',
        ];
        $data['adminProfile'] = [
            'path'      => 'assets/admin/images/profile',
            'size'      => '400x400',
        ];
        $data['push'] = [
            'path'      => 'assets/images/push_notification',
        ];

        $data['maintenance'] = [
            'path'      => 'assets/images/maintenance',
            'size'      => '660x325',
        ];
        $data['language'] = [
            'path' => 'assets/images/language',
            'size' => '50x50'
        ];
        $data['gateway'] = [
            'path' => 'assets/images/gateway',
            'size' => ''
        ];
        $data['withdrawMethod'] = [
            'path' => 'assets/images/withdraw_method',
            'size' => ''
        ];

        $data['category'] = [
            'path' => 'assets/images/category',
            'size' => '48x48',
        ];

        $data['subcategory'] = [
            'path' => 'assets/images/subcategory',
            'size' => '200x200',
        ];
        $data['service'] = [
            'path' => 'assets/images/service',
            'size' => '810x445',
        ];
        $data['software'] = [
            'path' => 'assets/images/software',
            'size' => '810x445',
        ];
        $data['extraImage'] = [
            'path' => 'assets/images/extraImage',
            'size' => '810x445',
        ];
        $data['documentFile'] = [
            'path' => 'assets/file/software/document',
        ];
        $data['softwareFile'] = [
            'path' => 'assets/file/software',
        ];
        $data['job'] = [
            'path' => 'assets/images/job',
            'size' => '810x445',
        ];
        $data['workFile'] = [
            'path' => 'assets/file/workFile',
        ];
        $data['chatFile'] = [
            'path' => 'assets/file/chatFile',
        ];
        $data['messageFile'] = [
            'path' => 'assets/file/messageFile',
        ];

        $data['advertisement'] = [
            'path' => 'assets/images/advertisement'
        ];

        $data['userBgImage'] = [
            'path' => 'assets/images/user/profile',
            'size' => '385x170',
        ];

        $data['pushConfig'] = [
            'path'      => 'assets/admin',
        ];


        return $data;
    }
}
