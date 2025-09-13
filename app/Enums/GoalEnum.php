<?php

namespace App\Enums;

enum GoalEnum: string
{
    case WebsiteDesign = 'Website Design';
    case GraphicDesign = 'Graphic Design';
    case LogoDesign = 'Logo Design';
    case EmailMarketing = 'Email Marketing';
    case ECommerce = 'E Commerce';
    case WebsiteDevelopment = 'Website Development';
    case SEO = 'SEO';
    case Video = 'Video';
    case FacebookMarketing = 'Facebook Marketing';
    case  WebMultimedia = 'Web Multimedia';
    case NetworkInfrastructure = 'Network Infrastructure';

    case Consultancy = 'Consultancy';
    case IPPBX = 'IPPBX';
    case Firewalls = 'Firewalls';


    public function label(): string
    {
        return match ($this) {
            self::WebsiteDesign => __('Website Design'),
            self::GraphicDesign => __('Graphic Design'),
            self::LogoDesign => __('Logo Design'),
            self::EmailMarketing => __('Email Marketing'),
            self::ECommerce => __('E-Commerce'),
            self::WebsiteDevelopment => __('Website Development'),
            self::SEO => __('SEO'),
            self::Video => __('Video'),
            self::FacebookMarketing => __('Facebook Marketing'),
            self::WebMultimedia => __('Web Multimedia'),
            self::NetworkInfrastructure => __('Network Infrastructure'),
            self::IPPBX => __('IPPBX'),
            self::Firewalls => __('Firewalls'),
            self::Consultancy => __('Consultancy'),
        };
    }

    /**
     * Get options as array [value => label] for Selects
     */
    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn($case) => [$case->value => $case->label()])
            ->toArray();
    }
}
