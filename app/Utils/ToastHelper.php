<?php

namespace App\Utils;

class ToastHelper
{
  public static function dispatch($type = 'success', $message, )
  {
    return [
      'message' => __($message),
      'type' => $type,
    ];
  }
}
