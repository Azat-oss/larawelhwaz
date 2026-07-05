<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

#[Signature('app:parse-command')]
#[Description('Command description')]
class ParseCommand extends Command
{
    public function handle()
    {
        $products = Product::query()->get()->map(function (Product $product) {
            $product->discount = $product->price / 100 * 10;
            $product->image =  rand(1, 2) . '.jpg';
            $product->save();
        });

        $this->info('Команда успешно отработала.' . ' ' . $products->count() . ' записей обновлено!');
    }
}
