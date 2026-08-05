<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Guitar;
use App\Models\GuitarItem;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'demo@example.com'],
            [
                'name' => '弾き語りデモユーザー',
                'password' => 'password',
            ]
        );

        $articles = [
            [
                'title' => '弾き語り初心者が最初に知るべき5つのこと',
                'slug' => 'beginner-first-steps',
                'category' => 'beginner',
                'excerpt' => 'ギター選びから練習のコツまで、スタート前に押さえておきたい基礎をまとめました。',
                'body' => "弾き語りを始めるとき、最初に大切なのは「続けられる環境」を作ることです。\n\n1. まずは無理のない予算でアコギを選ぶ\n2. 毎日15分でも触る習慣をつける\n3. コードは3つから覚える\n4. メトロノームでリズムを意識する\n5. 好きな曲でモチベーションを保つ",
                'thumbnail_url' => 'https://images.unsplash.com/photo-1510915361894-db8b60106cb1?w=800',
                'is_featured' => true,
                'published_at' => now()->subDays(1),
            ],
            [
                'title' => '初心者におすすめのアコースティックギター',
                'slug' => 'recommended-acoustic-guitars',
                'category' => 'guitar',
                'excerpt' => '弾き語り向けに、扱いやすさと音のバランスで選んだおすすめモデルを紹介。',
                'body' => "初心者には、ネックが細めで弦高が低めのモデルがおすすめです。ヤマハ・エピフォン・コルグ周辺のエントリー機種から始めると失敗しにくいです。",
                'thumbnail_url' => 'https://images.unsplash.com/photo-1564186763535-ebb21ef5277f?w=800',
                'is_featured' => true,
                'published_at' => now()->subDays(2),
            ],
            [
                'title' => 'おすすめのミニギターで気軽に練習',
                'slug' => 'recommended-mini-guitars',
                'category' => 'guitar',
                'excerpt' => '部屋が狭くても安心。持ち運びやすいミニギターの選び方。',
                'body' => "ミニギターは弦長が短く、指が小さな人や子どもにも扱いやすいのが魅力です。弾き語りの入門機としても優秀です。",
                'thumbnail_url' => 'https://images.unsplash.com/photo-1556449895-a33c9dba33dd?w=800',
                'is_featured' => true,
                'published_at' => now()->subDays(3),
            ],
            [
                'title' => 'おすすめのピックで弾き語りの音が変わる',
                'slug' => 'recommended-picks',
                'category' => 'gear',
                'excerpt' => '厚み・素材・形状で音色が変わります。初心者向けの選び方を解説。',
                'body' => "弾き語りなら 0.6〜0.8mm のミディアムが扱いやすいです。ナイロン系は柔らかい音、セルロイド系はアタックがはっきりします。",
                'thumbnail_url' => 'https://images.unsplash.com/photo-1516924962500-2b4b3b99ea02?w=800',
                'is_featured' => true,
                'published_at' => now()->subDays(4),
            ],
            [
                'title' => 'おすすめのカポタストとチューナー',
                'slug' => 'recommended-capo-tuner',
                'category' => 'gear',
                'excerpt' => 'キー変更とチューニングをスムーズにする定番アイテム。',
                'body' => "カポはワンタッチ式が便利。チューナーはクリップ式をギターヘッドに付けておけば、練習前の準備が短くなります。",
                'thumbnail_url' => 'https://images.unsplash.com/photo-1471478331149-c72f17e33c73?w=800',
                'is_featured' => true,
                'published_at' => now()->subDays(5),
            ],
            [
                'title' => 'ギターコード表：まずはC・G・Am・Fから',
                'slug' => 'basic-chord-chart',
                'category' => 'beginner',
                'excerpt' => '弾き語り定番コードを覚える順番と練習メニュー。',
                'body' => "多くの曲は基本コードの組み合わせで弾けます。C→G→Am→F の循環をゆっくりつなげる練習から始めましょう。",
                'thumbnail_url' => 'https://images.unsplash.com/photo-1493225457124-a3eb161ffa5f?w=800',
                'is_featured' => false,
                'published_at' => now()->subDays(6),
            ],
            [
                'title' => '新着：アコギ初心者講座の進め方',
                'slug' => 'acoustic-beginner-course',
                'category' => 'news',
                'excerpt' => '姿勢・チューニング・ストロークを段階的に学ぶロードマップ。',
                'body' => "毎週1テーマずつ進めると無理なく定着します。最初の2週間はフォームとチューニングに集中するのがおすすめです。",
                'thumbnail_url' => 'https://images.unsplash.com/photo-1525201548942-d8732f6617a0?w=800',
                'is_featured' => false,
                'published_at' => now()->subHours(8),
            ],
        ];

        foreach ($articles as $article) {
            Article::query()->updateOrCreate(['slug' => $article['slug']], $article);
        }

        $guitars = [
            [
                'name' => 'FS820',
                'brand' => 'YAMAHA',
                'price' => 38500,
                'body_type' => 'concert',
                'level' => 'beginner',
                'description' => 'コンパクトで抱えやすく、弾き語り入門に最適なコンサートボディ。',
                'image_url' => 'https://images.unsplash.com/photo-1510915361894-db8b60106cb1?w=800',
                'is_recommended' => true,
            ],
            [
                'name' => 'FG830',
                'brand' => 'YAMAHA',
                'price' => 41800,
                'body_type' => 'dreadnought',
                'level' => 'beginner',
                'description' => '低音が豊かなドレッドノート。ストローク中心の弾き語りに向く。',
                'image_url' => 'https://images.unsplash.com/photo-1564186763535-ebb21ef5277f?w=800',
                'is_recommended' => true,
            ],
            [
                'name' => 'DR-100',
                'brand' => 'Epiphone',
                'price' => 27500,
                'body_type' => 'dreadnought',
                'level' => 'beginner',
                'description' => 'コスパ重視の定番モデル。初めての一本におすすめ。',
                'image_url' => 'https://images.unsplash.com/photo-1556449895-a33c9dba33dd?w=800',
                'is_recommended' => true,
            ],
            [
                'name' => 'Little Martin LX1',
                'brand' => 'Martin',
                'price' => 52800,
                'body_type' => 'mini',
                'level' => 'beginner',
                'description' => '持ち運びやすいミニアコギ。ソファ練習や旅行にも便利。',
                'image_url' => 'https://images.unsplash.com/photo-1516924962500-2b4b3b99ea02?w=800',
                'is_recommended' => false,
            ],
            [
                'name' => 'CD-60S',
                'brand' => 'Fender',
                'price' => 33000,
                'body_type' => 'dreadnought',
                'level' => 'beginner',
                'description' => 'バランスの良いサウンド。初心者セットで見つけやすいモデル。',
                'image_url' => 'https://images.unsplash.com/photo-1471478331149-c72f17e33c73?w=800',
                'is_recommended' => false,
            ],
        ];

        foreach ($guitars as $guitar) {
            Guitar::query()->updateOrCreate(
                ['name' => $guitar['name'], 'brand' => $guitar['brand']],
                $guitar
            );
        }

        $items = [
            [
                'name' => 'Tortex Standard 0.73mm',
                'brand' => 'Dunlop',
                'category' => 'pick',
                'price' => 120,
                'specs' => '0.73mm / Tortex',
                'description' => '弾き語りで使いやすいミディアム厚。滑りにくく耐久性も高い。',
                'image_url' => 'https://images.unsplash.com/photo-1511379938547-c1f69419868d?w=800',
                'is_recommended' => true,
            ],
            [
                'name' => 'Nylon Standard 0.60mm',
                'brand' => 'Jim Dunlop',
                'category' => 'pick',
                'price' => 100,
                'specs' => '0.60mm / Nylon',
                'description' => '柔らかい音色が欲しいときにおすすめの薄めピック。',
                'image_url' => 'https://images.unsplash.com/photo-1493225457124-a3eb161ffa5f?w=800',
                'is_recommended' => true,
            ],
            [
                'name' => 'Quick-Change Capo',
                'brand' => 'Kyser',
                'category' => 'capo',
                'price' => 2800,
                'specs' => 'ワンタッチ式',
                'description' => 'キー変更が素早くできる定番カポ。ライブでも安心。',
                'image_url' => 'https://images.unsplash.com/photo-1525201548942-d8732f6617a0?w=800',
                'is_recommended' => true,
            ],
            [
                'name' => 'Clip-on Tuner SNARK SN-5X',
                'brand' => 'SNARK',
                'category' => 'tuner',
                'price' => 1980,
                'specs' => 'クリップ式',
                'description' => '暗い会場でも見やすいディスプレイ。練習前の必須アイテム。',
                'image_url' => 'https://images.unsplash.com/photo-1510915361894-db8b60106cb1?w=800',
                'is_recommended' => true,
            ],
            [
                'name' => 'Phosphor Bronze Light',
                'brand' => 'Elixir',
                'category' => 'string',
                'price' => 2200,
                'specs' => '012-053',
                'description' => 'コーティング弦で長持ち。交換頻度を減らしたい人に。',
                'image_url' => 'https://images.unsplash.com/photo-1564186763535-ebb21ef5277f?w=800',
                'is_recommended' => false,
            ],
            [
                'name' => 'Comfort Strap',
                'brand' => 'Levy\'s',
                'category' => 'strap',
                'price' => 3500,
                'specs' => '幅5cm / パッド付き',
                'description' => '長時間の練習でも肩が痛くなりにくいストラップ。',
                'image_url' => 'https://images.unsplash.com/photo-1556449895-a33c9dba33dd?w=800',
                'is_recommended' => false,
            ],
        ];

        foreach ($items as $item) {
            GuitarItem::query()->updateOrCreate(
                ['name' => $item['name'], 'brand' => $item['brand']],
                $item
            );
        }
    }
}
