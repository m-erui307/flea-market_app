<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersAndProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $usersData = [
            [
                'user_name' => 'user1',
                'email' => 'user1@example.com',
                'password' => Hash::make('password'),
            ],
            [
                'user_name' => 'user2',
                'email' => 'user2@example.com',
                'password' => Hash::make('password'),
            ],
            [
                'user_name' => 'user3',
                'email' => 'user3@example.com',
                'password' => Hash::make('password'),
            ],
        ];

        $users = [];
        foreach ($usersData as $data) {
            $users[] = User::create($data);
        }

        $products = [
            // ユーザー1用
            [
                'product_name' => '腕時計',
                'price' => 15000,
                'brand' => 'Rolex',
                'explanation' => 'スタイリッシュなデザインのメンズ腕時計',
                'product_image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Armani+Mens+Clock.jpg',
                'condition' => '1',
            ],
            [
                'product_name' => 'HDD',
                'price' => 5000,
                'brand' => '西芝',
                'explanation' => '高速で信頼性の高いハードディスク',
                'product_image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/HDD+Hard+Disk.jpg',
                'condition' => '2',
            ],
            [
                'product_name' => '玉ねぎ3束',
                'price' => 300,
                'brand' => 'なし',
                'explanation' => '新鮮な玉ねぎ3束のセット',
                'product_image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/iLoveIMG+d.jpg',
                'condition' => '3',
            ],
            [
                'product_name' => '革靴',
                'price' => 4000,
                'explanation' => 'クラシックなデザインの革靴',
                'product_image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Leather+Shoes+Product+Photo.jpg',
                'condition' => '4',
            ],
            [
                'product_name' => 'ノートPC',
                'price' => 45000,
                'explanation' => '高性能なノートパソコン',
                'product_image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Living+Room+Laptop.jpg',
                'condition' => '1',
            ],
            // ユーザー2用
            [
                'product_name' => 'マイク',
                'price' => 8000,
                'brand' => 'なし',
                'explanation' => '高音質のレコーディング用マイク',
                'product_image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Music+Mic+4632231.jpg',
                'condition' => '2',
            ],
            [
                'product_name' => 'ショルダーバッグ',
                'price' => 3500,
                'explanation' => 'おしゃれなショルダーバッグ',
                'product_image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Purse+fashion+pocket.jpg',
                'condition' => '3',
            ],
            [
                'product_name' => 'タンブラー',
                'price' => 500,
                'brand' => 'なし',
                'explanation' => '使いやすいタンブラー',
                'product_image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Tumbler+souvenir.jpg',
                'condition' => '4',
            ],
            [
                'product_name' => 'コーヒーミル',
                'price' => 4000,
                'brand' => 'Starbacks',
                'explanation' => '手動のコーヒーミル',
                'product_image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Waitress+with+Coffee+Grinder.jpg',
                'condition' => '1',
            ],
            [
                'product_name' => 'メイクセット',
                'price' => 2500,
                'explanation' => '便利なメイクアップセット',
                'product_image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/%E5%A4%96%E5%87%BA%E3%83%A1%E3%82%A4%E3%82%AF%E3%82%A2%E3%83%83%E3%83%95%E3%82%9A%E3%82%BB%E3%83%83%E3%83%88.jpg',
                'condition' => '2',
            ],
        ];

        foreach (array_slice($products, 0, 5) as $product) {
            DB::table('products')->insert(array_merge($product, ['user_id' => $users[0]->id]));
        }

        foreach (array_slice($products, 5, 5) as $product) {
            DB::table('products')->insert(array_merge($product, ['user_id' => $users[1]->id]));
        }

        $this->command->info("ユーザー3は商品なしで作成完了");
    }
}
