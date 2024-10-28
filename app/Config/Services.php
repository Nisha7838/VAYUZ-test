<?php
namespace Config;

use CodeIgniter\Config\BaseService;
use CodeIgniter\Pager\Pager;

class Services extends BaseService
{
    public static function pager($getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('pager');
        }

        // Create a new Pager instance
        return new Pager(config('Pager'), service('renderer'));
    }
}
