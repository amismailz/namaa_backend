<?php

namespace Database\Seeders;

use App\Models\HostingPlans;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Str;

class HostingPlansSeeder extends Seeder
{
    public function run(): void
    {
        $plans = [
            [
                'name' => [
                    'ar' => 'خطة الاستضافة 1',
                    'en' => 'Hosting Plan 1',
                ],
                'slug' => 'hosting-plan-1',
                'price' => 10000,
                'currency' => 'ج.م',
                'terms_conditions' => [
                    'ar' => 'سنوياً *الشروط و الأحكام ...',
                    'en' => 'Annually *Terms & Conditions ...',
                ],
                'free_domain' => true,
                'is_most_popular' => false,
                'billing_cycle' => 'سنوياً',
            ],
            [
                'name' => [
                    'ar' => 'خطة الاستضافة 2',
                    'en' => 'Hosting Plan 2',
                ],
                'slug' => 'hosting-plan-2',
                'price' => 15000,
                'currency' => 'ج.م',
                'terms_conditions' => [
                    'ar' => 'یحتاج مزود الخدمة الى ما لا یقل عن ١٠ أیام ...',
                    'en' => 'The provider needs at least 10 days ...',
                ],
                'free_domain' => true,
                'is_most_popular' => true,
                'billing_cycle' => 'سنوياً',
            ],
            [
                'name' => [
                    'ar' => 'خطة الاستضافة 3',
                    'en' => 'Hosting Plan 3',
                ],
                'slug' => 'hosting-plan-3',
                'price' => 20000,
                'currency' => 'ج.م',
                'terms_conditions' => [
                    'ar' => 'یقوم مزود الخدمة بتقدیم الخطة الموسمیة ...',
                    'en' => 'The provider offers the seasonal plan ...',
                ],
                'free_domain' => true,
                'is_most_popular' => false,
                'billing_cycle' => 'سنوياً',
            ],
            [
                'name' => [
                    'ar' => 'تصميم وبرمجة المواقع',
                    'en' => 'Website design and programming',
                ],
                'slug' => 'web-design-development',
                'price' => 40000,
                'currency' => 'ج.م',
                'terms_conditions' => [
                    'ar' => 'باقة تصميم وبرمجة المواقع ...',
                    'en' => 'Website design and development package ...',
                ],
                'free_domain' => false,
                'is_most_popular' => false,
                'billing_cycle' => 'سنوياً',
            ],
            [
                'name' => [
                    'ar' => 'باقة إدارة الحملات الإعلانية',
                    'en' => 'Campaign management package',
                ],
                'slug' => 'ads-management',
                'price' => 40000,
                'currency' => 'ج.م',
                'terms_conditions' => [
                    'ar' => 'شهرياً *الشروط و الأحكام ...',
                    'en' => 'Monthly *Terms & Conditions ...',
                ],
                'free_domain' => false,
                'is_most_popular' => false,
                'billing_cycle' => 'شهرياً',
            ],
        ];

        foreach ($plans as $plan) {
            HostingPlans::updateOrCreate(['slug' => $plan['slug']], $plan);
        }
    }
}
