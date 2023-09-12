<?php

namespace App\Helper;

class Status
{
    public static function print($statusId): string
    {
        $status = '';
        switch ($statusId) {
            case 0:
                $status = __('In Progress');
                break;

            case 1:
                $status = __('Accepted');
                break;

            case 2:
                $status = __('Rejected');
                break;

            default:
                //
                break;
        }

        return $status;
    }
}
