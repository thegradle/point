<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Booking extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    public function review()
    {
        return $this->hasOne(Review::class);
    }

    public function getStatusText()
    {
        return match ($this->status) {
            0 => 'Очікує на схвалення',
            1 => 'Схвалено',
            2 => 'Відмовлено',
            3 => 'Виконано',
            4 => 'Скасовано',
            default => 'Немає даних',
        };
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function ($booking) {
            auth()->user()->notifications()->create([
                'title' => 'Запит #' . $booking->id . ' на бронювання подано',
                'text' => "Невдовзі власник <a href='/hotel/" . $booking->hotel->id . "'>" . $booking->room->hotel->name . "</a> розгляне Ваш запит, результат очікуйте в своєму профілі та в сповіщеннях",
            ]);

            $booking->room->hotel->user->notifications()->create([
                'title' => 'Новий запит #' . $booking->id . ' на бронювання ' . $booking->room->hotel->name . '!',
                'text' => "Користувач <a href='/profile/" . $booking->profile->id . "'>" . $booking->profile->name . "</a> подав запит на бронювання " . $booking->room->hotel->name . ", надайте відповідь у своєму профілі",
            ]);
        });
    }
}
