<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Admins table data
        DB::table('admins')->insert([
            [
                'id' => 1,
                'name' => 'test',
                'email' => 'test@gmail.com',
                'password' => '$2y$10$2VqtcAftQhcze32FuGt2e.cWulQa8q8yXanmqC/O/iCJivtcZ3bq',
                'created_at' => '2025-01-28 14:18:04',
                'updated_at' => '2025-01-28 14:18:04',
            ],
        ]);

        // Areas table data
        DB::table('areas')->insert([
            ['id' => 1, 'name' => '東京都', 'created_at' => '2025-01-28 23:38:48', 'updated_at' => '2025-01-28 23:38:48'],
            ['id' => 2, 'name' => '大阪府', 'created_at' => '2025-01-28 23:39:16', 'updated_at' => '2025-01-28 23:39:16'],
            ['id' => 3, 'name' => '福岡県', 'created_at' => '2025-01-28 23:39:50', 'updated_at' => '2025-01-28 23:39:50'],
        ]);

        // Users table data
        DB::table('users')->insert([
            [
                'id' => 1,
                'name' => '田家信貴',
                'email' => 'taie0424engineer@gmail.com',
                'password' => '$2y$10$VNNDbIgjLXDd6fmvMttdOeNRoRx6Oo0XWRV98oiPF8pf9nfNkDpR.',
                'created_at' => '2025-01-29 00:12:23',
                'updated_at' => '2025-01-29 00:12:23',
            ],
        ]);

        // Owners table data
        DB::table('owners')->insert([
            [
                'id' => 1,
                'name' => '山田太郎',
                'email' => 'yamada@gmail.com',
                'password' => '$2y$10$lqt2i/E/9hm71tGBVnpW1uOQZmIPYmyLuAtluoMg9CjQsVsrsWwPS',
                'created_at' => '2025-01-28 14:18:27',
                'updated_at' => '2025-01-28 14:18:27',
            ],
            [
                'id' => 2,
                'name' => '田中太郎',
                'email' => 'tanaka@gmail.com',
                'password' => '$2y$10$RZ0Ztih8xi.tu7Sn2DrSVebDATZwfaYLI/eB/FksTLw..DKcvCM6W',
                'created_at' => '2025-01-28 14:29:44',
                'updated_at' => '2025-01-28 14:29:44',
            ],
            [
                'id' => 4,
                'name' => '佐藤太郎',
                'email' => 'satou@gmail.con',
                'password' => '$2y$10$QBlnsO1oV.W2fYIkgf4fKuszxXjR.pG5ZsLeaEn7Hxryf.74v9J8y',
                'created_at' => '2025-02-06 04:00:54',
                'updated_at' => '2025-02-06 04:00:54',
            ],
        ]);

        // Reservations table data
        DB::table('reservations')->insert([
            [
                'id' => 1,
                'user_id' => 1,
                'shop_id' => 1,
                'num_of_users' => 2,
                'start_at' => '2025-01-06 10:00:00',
                'rating' => null,
                'comment' => null,
                'created_at' => '2025-01-04 00:13:35',
                'updated_at' => '2025-01-04 00:50:54',
            ],
            [
                'id' => 5,
                'user_id' => 1,
                'shop_id' => 3,
                'num_of_users' => 4,
                'start_at' => '2025-02-06 10:00:00',
                'rating' => null,
                'comment' => null,
                'created_at' => '2025-01-29 03:11:56',
                'updated_at' => '2025-01-29 03:11:56',
            ],
            [
                'id' => 6,
                'user_id' => 1,
                'shop_id' => 4,
                'num_of_users' => 3,
                'start_at' => '2025-02-06 10:00:00',
                'rating' => 5,
                'comment' => 'とても美味しかった。',
                'created_at' => '2025-01-29 03:33:07',
                'updated_at' => '2025-02-09 23:45:05',
            ],
            [
                'id' => 7,
                'user_id' => 1,
                'shop_id' => 2,
                'num_of_users' => 3,
                'start_at' => '2025-02-06 10:00:00',
                'rating' => null,
                'comment' => null,
                'created_at' => '2025-01-29 03:45:20',
                'updated_at' => '2025-01-29 03:45:20',
            ],
            [
                'id' => 8,
                'user_id' => 1,
                'shop_id' => 4,
                'num_of_users' => 3,
                'start_at' => '2025-02-06 10:00:00',
                'rating' => 5,
                'comment' => '親切な接客で、料理もとても美味しかったです。',
                'created_at' => '2025-01-29 04:25:34',
                'updated_at' => '2025-02-06 03:22:22',
            ],
            [
                'id' => 9,
                'user_id' => 1,
                'shop_id' => 2,
                'num_of_users' => 3,
                'start_at' => '2025-07-25 19:00:00',
                'rating' => null,
                'comment' => null,
                'created_at' => '2025-02-06 03:03:21',
                'updated_at' => '2025-02-06 03:23:36',
            ],
            [
                'id' => 10,
                'user_id' => 1,
                'shop_id' => 10,
                'num_of_users' => 7,
                'start_at' => '2025-05-28 09:00:00',
                'rating' => null,
                'comment' => null,
                'created_at' => '2025-02-16 23:37:30',
                'updated_at' => '2025-02-16 23:37:30',
            ],
        ]);

        // Areas table data
        DB::table('areas')->insert([
            ['id' => 1, 'name' => '東京都', 'created_at' => '2025-01-28 23:38:48', 'updated_at' => '2025-01-28 23:38:48'],
            ['id' => 2, 'name' => '大阪府', 'created_at' => '2025-01-28 23:39:16', 'updated_at' => '2025-01-28 23:39:16'],
            ['id' => 3, 'name' => '福岡県', 'created_at' => '2025-01-28 23:39:50', 'updated_at' => '2025-01-28 23:39:50'],
        ]);

        // Genres table data
        DB::table('genres')->insert([
            ['id' => 1, 'name' => '寿司', 'created_at' => '2025-01-28 23:38:48', 'updated_at' => '2025-01-28 23:38:48'],
            ['id' => 2, 'name' => '焼肉', 'created_at' => '2025-01-28 23:39:16', 'updated_at' => '2025-01-28 23:39:16'],
            ['id' => 3, 'name' => '居酒屋', 'created_at' => '2025-01-28 23:39:50', 'updated_at' => '2025-01-28 23:39:50'],
            ['id' => 4, 'name' => 'イタリアン', 'created_at' => '2025-01-28 23:40:16', 'updated_at' => '2025-01-28 23:40:16'],
            ['id' => 5, 'name' => 'ラーメン', 'created_at' => '2025-01-28 23:40:46', 'updated_at' => '2025-01-28 23:40:46'],
        ]);

        // Favorites table data
        DB::table('favorites')->insert([
            ['id' => 1, 'user_id' => 1, 'shop_id' => 1, 'created_at' => '2025-01-28 23:38:48', 'updated_at' => '2025-01-28 23:38:48'],
            ['id' => 2, 'user_id' => 1, 'shop_id' => 2, 'created_at' => '2025-01-28 23:39:16', 'updated_at' => '2025-01-28 23:39:16'],
            ['id' => 3, 'user_id' => 1, 'shop_id' => 3, 'created_at' => '2025-01-28 23:39:50', 'updated_at' => '2025-01-28 23:39:50'],
        ]);

        // Shops table data
        DB::table('shops')->insert([
            [
                'id' => 1,
                'name' => '仙人',
                'area_id' => 1,
                'genre_id' => 1,
                'owner_id' => 1,
                'description' => '料理長厳選の食材から作る寿司を用いたコースをぜひお楽しみください。',
                'image_url' => 'https://coachtech-matter.s3-ap-northeast-1.amazonaws.com/image/sushi.jpg',
                'created_at' => '2025-01-28 23:38:48',
                'updated_at' => '2025-01-29 00:10:08',
            ],
            [
                'id' => 2,
                'name' => '牛助',
                'area_id' => 2,
                'genre_id' => 2,
                'owner_id' => 1,
                'description' => '焼肉業界で20年間経験を積み、肉を熟知したマスターによる実力派焼肉店。',
                'image_url' => 'https://coachtech-matter.s3-ap-northeast-1.amazonaws.com/image/yakiniku.jpg',
                'created_at' => '2025-01-28 23:39:16',
                'updated_at' => '2025-01-29 00:10:25',
            ],
            [
                'id' => 3,
                'name' => '戦慄',
                'area_id' => 3,
                'genre_id' => 3,
                'owner_id' => 2,
                'description' => '気軽に立ち寄れる昔懐かしの大衆居酒屋です。',
                'image_url' => 'https://coachtech-matter.s3-ap-northeast-1.amazonaws.com/image/izakaya.jpg',
                'created_at' => '2025-01-28 23:39:50',
                'updated_at' => '2025-01-29 00:10:52',
            ],
            [
                'id' => 4,
                'name' => 'ルーク',
                'area_id' => 1,
                'genre_id' => 4,
                'owner_id' => 2,
                'description' => '都心にひっそりとたたずむ、古民家を改築した落ち着いた空間です。',
                'image_url' => 'https://coachtech-matter.s3-ap-northeast-1.amazonaws.com/image/italian.jpg',
                'created_at' => '2025-01-28 23:40:16',
                'updated_at' => '2025-01-29 00:11:26',
            ],
            [
                'id' => 5,
                'name' => '志摩屋',
                'area_id' => 3,
                'genre_id' => 5,
                'owner_id' => null,
                'description' => 'ラーメン屋とは思えない店内にはカウンター席はもちろん、個室も用意してあります。',
                'image_url' => 'https://coachtech-matter.s3-ap-northeast-1.amazonaws.com/image/ramen.jpg',
                'created_at' => '2025-01-28 23:40:46',
                'updated_at' => '2025-01-28 23:40:46',
            ],
            [
                'id' => 6,
                'name' => '香',
                'area_id' => 1,
                'genre_id' => 2,
                'owner_id' => null,
                'description' => '大小さまざまなお部屋をご用意してます。',
                'image_url' => 'https://coachtech-matter.s3-ap-northeast-1.amazonaws.com/image/yakiniku.jpg',
                'created_at' => '2025-01-28 23:41:12',
                'updated_at' => '2025-01-28 23:41:12',
            ],
            [
                'id' => 7,
                'name' => 'JJ',
                'area_id' => 2,
                'genre_id' => 4,
                'owner_id' => null,
                'description' => 'イタリア製ピザ窯芳ばしく焼き上げた極薄のミラノピッツァや厳選されたワインをお楽しみいただけます。',
                'image_url' => 'https://coachtech-matter.s3-ap-northeast-1.amazonaws.com/image/italian.jpg',
                'created_at' => '2025-01-28 23:41:54',
                'updated_at' => '2025-01-28 23:41:54',
            ],
            [
                'id' => 8,
                'name' => 'らーめん極み',
                'area_id' => 1,
                'genre_id' => 5,
                'owner_id' => null,
                'description' => '一杯、一杯心を込めて職人が作っております。',
                'image_url' => 'https://coachtech-matter.s3-ap-northeast-1.amazonaws.com/image/ramen.jpg',
                'created_at' => '2025-01-28 23:42:28',
                'updated_at' => '2025-01-28 23:42:28',
            ],
            [
                'id' => 9,
                'name' => '鳥雨',
                'area_id' => 2,
                'genre_id' => 3,
                'owner_id' => null,
                'description' => '素材の旨味を存分に引き出す為に、塩焼を中心としたお店です。',
                'image_url' => 'https://coachtech-matter.s3-ap-northeast-1.amazonaws.com/image/izakaya.jpg',
                'created_at' => '2025-01-28 23:43:01',
                'updated_at' => '2025-01-28 23:43:01',
            ],
            [
                'id' => 10,
                'name' => '築地色合',
                'area_id' => 1,
                'genre_id' => 1,
                'owner_id' => null,
                'description' => '鮨好きの方の為の鮨屋として、迫力ある大きさの握りを1貫ずつ提供致します。',
                'image_url' => 'https://coachtech-matter.s3-ap-northeast-1.amazonaws.com/image/sushi.jpg',
                'created_at' => '2025-01-28 23:43:34',
                'updated_at' => '2025-01-28 23:43:34',
            ],
            [
                'id' => 11,
                'name' => '晴海',
                'area_id' => 2,
                'genre_id' => 2,
                'owner_id' => null,
                'description' => '毎年チャンピオン牛を買い付け、仙台市長から表彰されるほどの上質な仕入れをする精肉店オーナーの本当に美味しい国産牛を食べてもらいたいという思いから誕生したお店です。',
                'image_url' => 'https://coachtech-matter.s3-ap-northeast-1.amazonaws.com/image/yakiniku.jpg',
                'created_at' => '2025-01-28 23:44:02',
                'updated_at' => '2025-01-28 23:44:02',
            ],
            [
                'id' => 12,
                'name' => '三子',
                'area_id' => 3,
                'genre_id' => 1,
                'owner_id' => null,
                'description' => '最高級の美味しいお肉で日々の疲れを軽減していただければと贅沢にサーロインを盛り込んだ御膳をご用意しております。',
                'image_url' => 'https://coachtech-matter.s3-ap-northeast-1.amazonaws.com/image/yakiniku.jpg',
                'created_at' => '2025-01-28 23:44:31',
                'updated_at' => '2025-01-28 23:44:31',
            ],
            [
                'id' => 13,
                'name' => '八戒',
                'area_id' => 1,
                'genre_id' => 3,
                'owner_id' => null,
                'description' => '当店自慢の鍋や焼き鳥などお好きなだけ堪能できる食べ放題プランをご用意しております。',
                'image_url' => 'https://coachtech-matter.s3-ap-northeast-1.amazonaws.com/image/izakaya.jpg',
                'created_at' => '2025-01-28 23:45:06',
                'updated_at' => '2025-01-28 23:45:06',
            ],
            [
                'id' => 14,
                'name' => '福助',
                'area_id' => 2,
                'genre_id' => 1,
                'owner_id' => null,
                'description' => 'ミシュラン掲載店で磨いた、寿司職人の旨さへのこだわりはもちろん、 食事をゆっくりと楽しんでいただける空間作りも意識し続けております。',
                'image_url' => 'https://coachtech-matter.s3-ap-northeast-1.amazonaws.com/image/sushi.jpg',
                'created_at' => '2025-01-28 23:45:35',
                'updated_at' => '2025-01-28 23:45:35',
            ],
            [
                'id' => 15,
                'name' => 'ラー北',
                'area_id' => 1,
                'genre_id' => 5,
                'owner_id' => null,
                'description' => 'お昼にはランチを求められるサラリーマン、夕方から夜にかけては、学生や会社帰りのサラリーマン、小上がり席もありファミリー層にも大人気です。',
                'image_url' => 'https://coachtech-matter.s3-ap-northeast-1.amazonaws.com/image/ramen.jpg',
                'created_at' => '2025-01-28 23:46:11',
                'updated_at' => '2025-01-28 23:46:11',
            ],
            [
                'id' => 16,
                'name' => '翔',
                'area_id' => 2,
                'genre_id' => 3,
                'owner_id' => null,
                'description' => '博多出身の店主自ら厳選した新鮮な旬の素材を使ったコース料理をご提供します。一人一人のお客様に目が届くようにしております。',
                'image_url' => 'https://coachtech-matter.s3-ap-northeast-1.amazonaws.com/image/izakaya.jpg',
                'created_at' => '2025-01-28 23:46:46',
                'updated_at' => '2025-01-28 23:46:46',
            ],
            [
                'id' => 17,
                'name' => '経緯',
                'area_id' => 1,
                'genre_id' => 1,
                'owner_id' => null,
                'description' => '職人が一つ一つ心を込めて丁寧に仕上げた、江戸前鮨ならではの味をお楽しみ頂けます。鮨に合った希少なお酒も数多くご用意しております。他にはない海鮮太巻き、当店自慢の蒸し鮑、是非ご賞味下さい。',
                'image_url' => 'https://coachtech-matter.s3-ap-northeast-1.amazonaws.com/image/sushi.jpg',
                'created_at' => '2025-01-28 23:47:17',
                'updated_at' => '2025-01-28 23:47:17',
            ],
            [
                'id' => 18,
                'name' => '漆',
                'area_id' => 1,
                'genre_id' => 2,
                'owner_id' => null,
                'description' => '店内に一歩足を踏み入れると、肉の焼ける音と芳香が猛烈に食欲を掻き立ててくる。そんな漆で味わえるのは至極の焼き肉です。',
                'image_url' => 'https://coachtech-matter.s3-ap-northeast-1.amazonaws.com/image/yakiniku.jpg',
                'created_at' => '2025-01-28 23:47:46',
                'updated_at' => '2025-01-28 23:47:46',
            ],
            [
                'id' => 19,
                'name' => 'THE TOOL',
                'area_id' => 3,
                'genre_id' => 4,
                'owner_id' => null,
                'description' => '非日常的な空間で日頃の疲れを癒し、ゆったりとした上質な時間を過ごせる大人の為のレストラン&バーです。',
                'image_url' => 'https://coachtech-matter.s3-ap-northeast-1.amazonaws.com/image/italian.jpg',
                'created_at' => '2025-01-28 23:48:17',
                'updated_at' => '2025-01-28 23:48:17',
            ],
            [
                'id' => 20,
                'name' => '木船',
                'area_id' => 2,
                'genre_id' => 1,
                'owner_id' => null,
                'description' => '毎日店主自ら市場等に出向き、厳選した魚介類が、お鮨をはじめとした繊細な料理に仕立てられます。また、選りすぐりの種類豊富なドリンクもご用意しております。',
                'image_url' => 'https://coachtech-matter.s3-ap-northeast-1.amazonaws.com/image/sushi.jpg',
                'created_at' => '2025-01-28 23:48:47',
                'updated_at' => '2025-01-28 23:48:47',
            ],
        ]);
    }
}