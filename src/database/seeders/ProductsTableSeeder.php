<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = [
            [
            'product_name' => '腕時計',
            'price' => 15000,
            'brand' => 'Rolex',
            'explanation' => 'スタイリッシュなデザインのメンズ腕時計',
            'product_image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Armani+Mens+Clock.jpg',
            'condition' => '良好'
            ],
            [
            'product_name' => 'HDD',
            'price' => 5000,
            'brand' => '西芝',
            'explanation' => '高速で信頼性の高いハードディスク',
            'product_image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/HDD+Hard+Disk.jpg',
            'condition' => '目立った傷や汚れなし'
            ],
            [
            'product_name' => '玉ねぎ3束',
            'price' => 300,
            'brand' => 'なし',
            'explanation' => '新鮮な玉ねぎ3束のセット',
            'product_image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/iLoveIMG+d.jpg',
            'condition' => 'やや傷や汚れあり'
            ],
            [
            'product_name' => '革靴',
            'price' => 4000,
            'explanation' => 'クラシックなデザインの革靴',
            'product_image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Leather+Shoes+Product+Photo.jpg',
            'condition' => '状態が悪い'
            ],
            [
            'product_name' => 'ノートPC',
            'price' => 45000,
            'explanation' => '高性能なノートパソコン',
            'product_image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Living+Room+Laptop.jpg',
            'condition' => '良好'
            ],
            [
            'product_name' => 'マイク',
            'price' => 8000,
            'brand' => 'なし',
            'explanation' => '高音質のレコーディング用マイク',
            'product_image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Music+Mic+4632231.jpg',
            'condition' => '目立った傷や汚れなし'
            ],
            [
            'product_name' => 'ショルダーバッグ',
            'price' => 3500,
            'explanation' => 'おしゃれなショルダーバッグ',
            'product_image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Purse+fashion+pocket.jpg',
            'condition' => 'やや傷や汚れあり'
            ],
            [
            'product_name' => 'タンブラー',
            'price' => 500,
            'brand' => 'なし',
            'explanation' => '使いやすいタンブラー',
            'product_image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Tumbler+souvenir.jpg',
            'condition' => '状態が悪い'
            ],
            [
            'product_name' => 'コーヒーミル',
            'price' => 4000,
            'brand' => 'Starbacks',
            'explanation' => '手動のコーヒーミル',
            'product_image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Waitress+with+Coffee+Grinder.jpg',
            'condition' => '良好'
            ],
            [
            'product_name' => 'メイクセット',
            'price' => 2500,
            'explanation' => '便利なメイクアップセット',
            'product_image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/%E5%A4%96%E5%87%BA%E3%83%A1%E3%82%A4%E3%82%AF%E3%82%A2%E3%83%83%E3%83%95%E3%82%9A%E3%82%BB%E3%83%83%E3%83%88.jpg',
            'condition' => '目立った傷や汚れなし'
            ],
        ];

        $users = User::all();

        foreach ($users as $index => $user) {
        if (!isset($products[$index])) {
            break;
        }

        $product = $products[$index];

        DB::table('products')->insert([
            'product_name' => $product['product_name'],
            'price' => $product['price'],
            'brand' => $product['brand'] ?? null,
            'explanation' => $product['explanation'],
            'product_image' => $product['product_image'],
            'condition' => $product['condition'],
            'user_id' => $user->id,
        ]);
        }
    }
}