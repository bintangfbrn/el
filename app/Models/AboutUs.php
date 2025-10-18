<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutUs extends Model
{
    use HasFactory;

    protected $table = 'about_us';

    protected $fillable = [
        'company_name',
        'tagline',
        'description',
        'founded_year',
        'address',
        'phone',
        'email',
        'website',
        'image',
        'image_2',
        'status',
    ];

    public function visionMission()
    {
        return $this->hasOne(VisionMission::class, 'about_id');
    }

    public function clients()
    {
        return $this->hasMany(Client::class, 'about_id');
    }

    public function faqs()
    {
        return $this->hasMany(AboutFaq::class, 'about_id');
    }

    public function howWeWork()
    {
        return $this->hasMany(HowWeWork::class, 'about_id');
    }

    public function team()
    {
        return $this->hasMany(Team::class, 'about_id');
    }

    public function testimonials()
    {
        return $this->hasMany(Testimonial::class, 'about_id');
    }

    public function bestSelling()
    {
        return $this->hasMany(Selling::class, 'about_id');
    }

    public function pages()
    {
        return $this->hasMany(AboutPage::class, 'about_id');
    }
}
