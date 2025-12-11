<?php

namespace App\Helpers;

class AlertHelper
{
    public static function success($message)
    {
        session()->flash('success', $message);
    }

    public static function error($message)
    {
        session()->flash('error', $message);
    }

    public static function warning($message)
    {
        session()->flash('warning', $message);
    }

    public static function info($message)
    {
        session()->flash('info', $message);
    }

    public static function confirm($title, $text, $confirmButtonText = 'Sí, eliminar', $cancelButtonText = 'Cancelar')
    {
        session()->flash('confirm', [
            'title' => $title,
            'text' => $text,
            'confirmButtonText' => $confirmButtonText,
            'cancelButtonText' => $cancelButtonText,
        ]);
    }
}