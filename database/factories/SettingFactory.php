<?php

namespace Database\Factories;

use App\Models\Setting;
use Illuminate\Database\Eloquent\Factories\Factory;

class SettingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Setting::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'sitename_en' => "Souqtijari",
            'sitename_ar' => "Souqtijari",
            'web_logo' => $this->faker->imageUrl(250, 250),
            'web_fav' => $this->faker->imageUrl(60, 60),
            'web_status' => 1,
            'app_ios_url' => '',
            'app_android_url' => '',
            'host' => "mail.souqtijari.net",
            'port' => 4343,
            'email' => "info@souqtijari.net",
            'smtp_password' => '123456789',
            'from_name' => "Souqtijari",
            'smtp_encryption' => 'ssl',
        ];
    }
}
