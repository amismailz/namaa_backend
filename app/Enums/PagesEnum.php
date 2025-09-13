<?php

namespace App\Enums;

enum PagesEnum: string
{
    case Home = 'home';
    case Blogs = 'blogs';
    case Jobs = 'jobs';
    case HostingPlans = 'hosting_plans';
    case Portfolio = 'portfolio';
    case AboutUs = 'about_us';



    public function label(): string
    {

        return match ($this) {
            self::Home => __('Home'),
            self::Blogs => __('Blogs'),
            self::Jobs => __('Jobs'),
            self::HostingPlans => __('Hosting Plans'),
            self::Portfolio => __('Portfolio'),
            self::AboutUs => __('About Us'),
        };
    }
}
