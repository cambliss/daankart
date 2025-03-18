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
        $data['withdrawVerify'] = [
            'path' => 'assets/images/verify/withdraw'
        ];
        $data['depositVerify'] = [
            'path'      => 'assets/images/verify/deposit'
        ];
        $data['verify'] = [
            'path'      => 'assets/verify'
        ];
        $data['default'] = [
            'path'      => 'assets/images/default.png',
        ];
        $data['withdrawMethod'] = [
            'path'      => 'assets/images/withdraw/method',
            'size'      => '800x800',
        ];
        $data['ticket'] = [
            'path'      => 'assets/support',
        ];
        $data['logo_icon'] = [
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
            'size'      => '350x300',
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
            'path'      => 'assets/images/category',
            'size'      => '375x250',
        ];
        $data['success'] = [
            'path'      => 'assets/images/success',
            'size'      => '800x665',
        ];
        $data['success_seo'] = [
            'path'      => 'assets/images/success/seo',
            'size'      => '800x665',
        ];
        $data['campaign'] = [
            'path'      => 'assets/images/campaign',
            'size'      => '795x580',
        ];
        $data['proof'] = [
            'path'      => 'assets/images/campaign/proof',
            'size'      => '400x300',
        ];
        $data['volunteer'] = [
            'path'      => 'assets/images/volunteer',
            'size'      => '255x215',
        ];

        $data['userCover'] = [
            'path'      => 'assets/images/user/cover',
            'size'      => '1220x400',
        ];
        $data['userProfile'] = [
            'path'      => 'assets/images/user/profile',
            'size'      => '350x300',
        ];
        $data['orgCover'] = [
            'path'      => 'assets/images/organization/cover',
            'size'      => '1220x400',
        ];
        $data['orgProfile'] = [
            'path'      => 'assets/images/organization/profile',
            'size'      => '350x300',
        ];
        $data['orgAward'] = [
            'path'      => 'assets/images/award',
            'size'      => '370x250',
        ];
        $data['orgDonor'] = [
            'path'      => 'assets/images/donor',
            'size'      => '375x250',
        ];
        $data['pushConfig'] = [
            'path'      => 'assets/admin',
        ];
        return $data;
    }
}
