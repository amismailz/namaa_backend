<?php

namespace App\Enums;

enum JobTitleEnum: string
{
    case WebDeveloper = 'Web Developer';
    case WebDesigner = 'Web Designer';
    case GraphicDesigner = 'Graphic Designer';
    case CallCenter = 'Call Center';



    public function label(): string
    {

        return match ($this) {
            self::WebDeveloper => __('Web Developer'),
            self::WebDesigner => __('Web Designer'),
            self::GraphicDesigner => __('Graphic Designer'),
            self::CallCenter => __('Call Center'),
        };
    }
}
