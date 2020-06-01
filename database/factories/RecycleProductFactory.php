<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Models\RecycleProduct;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

$factory->define(RecycleProduct::class, function (Faker $faker) {
    $status = $faker->numberBetween(0, 5);
    $carrying_from_datetime = $faker->dateTimeBetween('now', '+3 month');

    return [
        'name' => mb_substr($faker->realText(10), 0, $faker->numberBetween(4, 10)),
        'product_status' => $faker->numberBetween(1, 6),
        'detail' => $faker->realText($faker->numberBetween(60, 200)),
        'status' => $status,
        'carrying_from_datetime' => $status >= 3 ? $carrying_from_datetime->format('Y-m-d') : null,
        'carrying_to_datetime' => $status >= 4 ? $faker->dateTimeBetween($carrying_from_datetime, strtotime($carrying_from_datetime->format('Y-m-d').' +'.$faker->randomDigitNotNull.' month'))->format('Y-m-d') : null,
    ];
});

$factory->afterCreating(RecycleProduct::class, function ($recycleProduct, $faker) {
    $recycleProduct->image1 = $faker->boolean ? str_replace('lorempixel.com', 'picsum.photos', $faker->imageUrl($faker->numberBetween(400, 640), $faker->numberBetween(400, 640))) : '';
    $recycleProduct->image2 = $faker->boolean ? str_replace('lorempixel.com', 'picsum.photos', $faker->imageUrl($faker->numberBetween(400, 640), $faker->numberBetween(400, 640))) : '';
    $recycleProduct->image3 = $faker->boolean ? str_replace('lorempixel.com', 'picsum.photos', $faker->imageUrl($faker->numberBetween(400, 640), $faker->numberBetween(400, 640))) : '';
    $recycleProduct->image4 = $faker->boolean ? str_replace('lorempixel.com', 'picsum.photos', $faker->imageUrl($faker->numberBetween(400, 640), $faker->numberBetween(400, 640))) : '';
    $recycleProduct->image5 = $faker->boolean ? str_replace('lorempixel.com', 'picsum.photos', $faker->imageUrl($faker->numberBetween(400, 640), $faker->numberBetween(400, 640))) : '';

    foreach ($recycleProduct->image_array as $imageKey => $url) {
        if ($url) {
            $image = file_get_contents($url);
            $fileName = Str::random(40).'.jpg';
            $path = Storage::disk('public')->put("uploads/{$recycleProduct->getTable()}/{$recycleProduct->id}/images/{$fileName}", $image);
            $recycleProduct->$imageKey = $fileName;
        }
    }
    $recycleProduct->save();
});
