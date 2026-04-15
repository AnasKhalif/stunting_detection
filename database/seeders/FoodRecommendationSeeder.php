<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FoodRecommendation;

/**
 * Data rekomendasi makanan bersumber dari:
 * Buku Bagan SDIDTK (Stimulasi, Deteksi, dan Intervensi Dini Tumbuh Kembang Anak)
 * Kemenkes RI, Revisi 2022 — Lampiran halaman 131–148
 *
 * Kategori:
 *   umum     = baik untuk semua anak (normal & stunting)
 *   stunting  = diprioritaskan untuk anak dengan status pendek/sangat pendek
 *   tinggi    = mendukung pertumbuhan tinggi badan optimal
 */
class FoodRecommendationSeeder extends Seeder
{
    public function run(): void
    {
        FoodRecommendation::truncate();

        $foods = [
            // ===================================================
            // KATEGORI: UMUM (baik untuk semua anak)
            // Sumber: Tabel Protein Hewani SDIDTK hal. 136–137
            //         Tabel Protein Nabati hal. 138
            //         Tabel Sayuran hal. 139
            //         Tabel Buah-buahan hal. 147–148
            // ===================================================
            [
                'name'             => 'Telur Ayam',
                'category'         => 'umum',
                'nutritional_info' => 'Mengandung 7 gram protein, 2 gram lemak per 55 gram (1 butir). Protein lengkap yang mudah dicerna anak.',
                'recipe'           => "Cara penyajian:\n• Usia 6–8 bulan: Ceplok lunak atau dadar tipis, haluskan sebelum disajikan.\n• Usia 9–11 bulan: Dadar tipis cincang halus.\n• Usia ≥12 bulan: Semur telur, telur dadar, telur rebus.\n\nFrekuensi: Bisa diberikan setiap hari.",
                'image'            => null,
            ],
            [
                'name'             => 'Daging Ayam',
                'category'         => 'umum',
                'nutritional_info' => 'Mengandung 7 gram protein, 2 gram lemak per 40 gram (1 potong sedang). Protein hewani mudah dicerna.',
                'recipe'           => "Cara penyajian:\n• Usia 6–8 bulan: Tim ayam halus (10 g), haluskan dengan blender.\n• Usia 9–11 bulan: Ayam cincang halus (25 g) dicampur nasi tim.\n• Usia ≥12 bulan: Semur ayam, ayam rebus, sup ayam (40 g).\n\nMenu dari SDIDTK: Sup ayam tahu labu kuning (untuk usia 6–23 bulan).",
                'image'            => null,
            ],
            [
                'name'             => 'Ikan Kembung',
                'category'         => 'umum',
                'nutritional_info' => 'Sumber protein hewani dan asam lemak omega-3. 1/3 ekor sedang (30 g) mengandung ±7 gram protein.',
                'recipe'           => "Cara penyajian:\n• Usia 6–8 bulan: Ikan kembung kukus, haluskan, saring tulang.\n• Usia 9–11 bulan: Ikan kembung bumbu kuning cincang halus.\n• Usia ≥12 bulan: Ikan kembung bumbu kuning (30–35 g).\n\nMenu dari SDIDTK: Ikan kembung bumbu kuning (menu MP-ASI standar).",
                'image'            => null,
            ],
            [
                'name'             => 'Tempe',
                'category'         => 'umum',
                'nutritional_info' => 'Mengandung 6 gram protein, 3 gram lemak, 8 gram karbohidrat per 25 gram (½ potong). Protein nabati terjangkau dan bergizi.',
                'recipe'           => "Cara penyajian:\n• Usia 6–8 bulan: Tempe tim/kukus haluskan (10 g).\n• Usia 9–11 bulan: Tempe goreng cincang (25 g) atau sayur kare wortel tempe.\n• Usia ≥12 bulan: Tempe goreng, tempe bacem, sayur tempe (25–50 g).\n\nMenu dari SDIDTK: Sayur kare wortel tempe (menu MP-ASI standar).",
                'image'            => null,
            ],
            [
                'name'             => 'Tahu',
                'category'         => 'umum',
                'nutritional_info' => 'Mengandung 6 gram protein dan kalsium per 50 gram (1 buah sedang). Protein nabati mudah dicerna.',
                'recipe'           => "Cara penyajian:\n• Usia 6–8 bulan: Tahu kukus halus (20 g).\n• Usia 9–11 bulan: Tahu kukus/goreng cincang (25–50 g).\n• Usia ≥12 bulan: Sup tahu, tahu goreng, tahu bacem (50–100 g).\n\nMenu dari SDIDTK: Sup ayam tahu labu kuning.",
                'image'            => null,
            ],
            [
                'name'             => 'Bayam',
                'category'         => 'umum',
                'nutritional_info' => 'Sayuran golongan B. Per 100 gram mengandung 25 kalori, 5 gram karbohidrat, 1 gram protein. Kaya zat besi dan folat.',
                'recipe'           => "Cara penyajian:\n• Usia 6–8 bulan: Bayam rebus haluskan (15 g), saring serat kasar.\n• Usia 9–11 bulan: Bening bayam, bayam kukus cincang.\n• Usia ≥12 bulan: Bening/bobor bayam (20 g).\n\nMenu dari SDIDTK: Bening/bobor bayam (menu MP-ASI standar).",
                'image'            => null,
            ],
            [
                'name'             => 'Wortel',
                'category'         => 'umum',
                'nutritional_info' => 'Sayuran golongan B. Sumber beta-karoten (provitamin A), serat, dan mineral. Per 15 g (2 sdm) menghasilkan ±14 g matang.',
                'recipe'           => "Cara penyajian:\n• Usia 6–8 bulan: Puree wortel kukus.\n• Usia 9–11 bulan: Wortel rebus cincang halus, atau sayur kare wortel tempe.\n• Usia ≥12 bulan: Sup wortel, tumis wortel, sayur bening.",
                'image'            => null,
            ],
            [
                'name'             => 'Buncis',
                'category'         => 'umum',
                'nutritional_info' => 'Sayuran golongan B. Sumber serat, vitamin C, dan zat besi. Per 15 g menghasilkan ±17 g matang rebus.',
                'recipe'           => "Cara penyajian:\n• Usia 6–8 bulan: Buncis kukus haluskan.\n• Usia 9–11 bulan: Tumis buncis cincang halus.\n• Usia ≥12 bulan: Tumis buncis (10–20 g).\n\nMenu dari SDIDTK: Tumis buncis (menu MP-ASI standar).",
                'image'            => null,
            ],
            [
                'name'             => 'Pisang Ambon',
                'category'         => 'umum',
                'nutritional_info' => 'Per 1 buah sedang (50 g): 50 kalori, 10 gram karbohidrat. Sumber kalium, vitamin B6, dan serat.',
                'recipe'           => "Cara penyajian:\n• Usia 6–8 bulan: Haluskan sebagai puree.\n• Usia ≥9 bulan: Potong-potong kecil, bisa dipegang anak.\n• Usia ≥12 bulan: Langsung makan.\n\nBerikan 1 buah sedang per hari.",
                'image'            => null,
            ],
            [
                'name'             => 'Pepaya',
                'category'         => 'umum',
                'nutritional_info' => 'Per 1 potong besar (100–190 g): 50 kalori. Kaya vitamin C, beta-karoten, dan enzim papain yang membantu pencernaan.',
                'recipe'           => "Cara penyajian:\n• Usia 6–8 bulan: Haluskan sebagai puree.\n• Usia ≥9 bulan: Potong dadu kecil.\n• Usia ≥12 bulan: Langsung makan 1 potong besar/hari.",
                'image'            => null,
            ],
            [
                'name'             => 'Nasi / Bubur Beras',
                'category'         => 'umum',
                'nutritional_info' => 'Per ¾ gelas nasi (100 g): 175 kalori, 40 gram karbohidrat, 4 gram protein. Sumber energi utama anak.',
                'recipe'           => "Tekstur dan porsi sesuai usia:\n• 6–8 bulan: Bubur beras (50 g dari 10 g beras), mulai 2–3 sdm bertahap hingga ½ mangkok.\n• 9–11 bulan: Nasi tim (35–50 g dari 15 g beras), ½–¾ mangkok.\n• 12–23 bulan: Nasi biasa (55 g), ¾–1 mangkok.\n• ≥24 bulan: Nasi ¾ gelas (100 g).",
                'image'            => null,
            ],
            [
                'name'             => 'Kacang Hijau',
                'category'         => 'umum',
                'nutritional_info' => 'Per 2½ sdm (25 g): 80 kalori, 6 gram protein, 8 gram karbohidrat. Sumber protein nabati, zat besi, dan serat.',
                'recipe'           => "Cara penyajian:\n• Bubur kacang hijau: Rebus 25 g kacang hijau hingga lunak, haluskan atau sajikan dengan kuah.\n• Usia 6–23 bulan: Bubur sumsum kacang hijau (75 g) — menu selingan resmi dari SDIDTK.\n\nBerikan sebagai snack/selingan 1–2x/hari.",
                'image'            => null,
            ],
            [
                'name'             => 'Jeruk Manis',
                'category'         => 'umum',
                'nutritional_info' => 'Per 2 buah sedang (100 g): 50 kalori, 10 gram karbohidrat. Tinggi vitamin C yang membantu penyerapan zat besi.',
                'recipe'           => "Cara penyajian:\n• Usia 6–8 bulan: Peras, berikan sarinya.\n• Usia ≥9 bulan: Belah, peras, berikan.\n• Usia ≥12 bulan: Langsung makan atau dibuat jus tanpa gula.\n\nBerikan 1–2 buah per hari.",
                'image'            => null,
            ],

            // ===================================================
            // KATEGORI: STUNTING (prioritas untuk anak pendek/sangat pendek)
            // Sumber: SDIDTK hal. 96–97 (Asuhan Nutrisi Pediatrik)
            //         Tabel Protein Hewani hal. 136–137
            //         Menu Selingan hal. 134
            // ===================================================
            [
                'name'             => 'Hati Ayam',
                'category'         => 'stunting',
                'nutritional_info' => 'Per 1 buah (30 g): protein tinggi, zat besi heme, vitamin A, vitamin B12. Sangat dianjurkan dalam asuhan nutrisi pediatrik untuk anak stunting.',
                'recipe'           => "Cara penyajian:\n• Usia 6–8 bulan: Hati ayam kukus (25 g), haluskan dengan blender.\n• Usia 9–11 bulan: Semur hati ayam cincang halus (25 g).\n• Usia ≥12 bulan: Semur hati ayam (40 g).\n\nMenu dari SDIDTK: Semur hati ayam (menu MP-ASI standar untuk 6–23 bulan).\nFrekuensi yang dianjurkan: 2–3 kali per minggu.",
                'image'            => null,
            ],
            [
                'name'             => 'Hati Sapi',
                'category'         => 'stunting',
                'nutritional_info' => 'Per 1 potong sedang (50 g): protein tinggi, zat besi heme sangat tinggi (±6 mg/100g), vitamin A, B12, folat. Sangat dianjurkan untuk anak dengan anemia dan stunting.',
                'recipe'           => "Cara penyajian:\n• Usia 9–11 bulan: Hati sapi rebus haluskan (10–25 g).\n• Usia ≥12 bulan: Hati goreng, hati rebus, semur hati (25–50 g).\n\nFrekuensi: 2–3 kali per minggu.\nCatatan: Pilih hati segar, masak hingga matang sempurna.",
                'image'            => null,
            ],
            [
                'name'             => 'Udang Segar',
                'category'         => 'stunting',
                'nutritional_info' => 'Per 5 ekor sedang (35 g): 7 gram protein, 2 gram lemak. Sumber zinc dan mineral penting untuk pertumbuhan dan perkembangan sistem imun.',
                'recipe'           => "Cara penyajian:\n• Usia 9–11 bulan: Udang kukus/tim haluskan (15–25 g).\n• Usia ≥12 bulan: Udang rebus, tumis udang, sup udang (35 g).\n\nFrekuensi: 2–3 kali per minggu.",
                'image'            => null,
            ],
            [
                'name'             => 'Kerang',
                'category'         => 'stunting',
                'nutritional_info' => 'Per ½ gelas (90 g): protein tinggi, zinc sangat tinggi (±14 mg/100g). Zinc penting untuk sintesis protein, pertumbuhan sel, dan sistem imun anak.',
                'recipe'           => "Cara penyajian:\n• Usia ≥12 bulan: Tumis kerang, sup kerang.\n• Masak hingga matang sempurna sebelum disajikan.\n\nFrekuensi: 1–2 kali per minggu.",
                'image'            => null,
            ],
            [
                'name'             => 'Ikan Teri Kering',
                'category'         => 'stunting',
                'nutritional_info' => 'Per 1 sdm (20 g): protein tinggi, kalsium sangat tinggi (±1200 mg/100g). Sumber kalsium terbaik selain susu, sangat penting untuk pertumbuhan tulang.',
                'recipe'           => "Cara penyajian:\n• Teri goreng renyah: Goreng kering, tabur di atas nasi atau sayur.\n• Teri tumis: Tumis dengan bawang putih dan sedikit minyak.\n• Teri kacang: Tumis teri dengan kacang tanah — kaya protein dan kalsium.\n\nFrekuensi: Bisa diberikan setiap hari (1–2 sdm).",
                'image'            => null,
            ],
            [
                'name'             => 'Bubur Sumsum Kacang Hijau',
                'category'         => 'stunting',
                'nutritional_info' => 'Menu selingan resmi dari Buku Bagan SDIDTK Kemenkes 2022 (hal. 134). Per 75 g: karbohidrat, protein nabati, dan zat besi.',
                'recipe'           => "Resep Bubur Sumsum Kacang Hijau (untuk 1 porsi 75 g):\n• 25 g tepung beras\n• 25 g kacang hijau\n• 200 ml santan encer\n• Sejumput garam\n• Gula merah secukupnya\n\nCara membuat:\n1. Rebus kacang hijau hingga lunak.\n2. Larutkan tepung beras dengan santan, aduk rata.\n3. Masak sambil terus diaduk hingga mengental.\n4. Tambahkan kacang hijau rebus.\n5. Sajikan dengan sirup gula merah.\n\nFrekuensi: 1–2x/hari sebagai makanan selingan.",
                'image'            => null,
            ],
            [
                'name'             => 'Nugget Ikan',
                'category'         => 'stunting',
                'nutritional_info' => 'Menu selingan resmi dari Buku Bagan SDIDTK Kemenkes 2022 (hal. 134). Per 35 g: protein ikan tinggi, omega-3. Mudah diterima anak.',
                'recipe'           => "Resep Nugget Ikan Homemade:\n• 200 g daging ikan tenggiri/tuna (fillet, tanpa tulang)\n• 1 butir telur\n• 2 sdm tepung terigu\n• 2 siung bawang putih, haluskan\n• Sedikit garam\n• Tepung panir untuk salut\n\nCara membuat:\n1. Haluskan ikan dengan blender atau ulekan.\n2. Campur dengan telur, tepung, bawang putih, dan garam.\n3. Bentuk sesuai selera, gulingkan di tepung panir.\n4. Kukus 15 menit, lalu goreng sebentar hingga kekuningan.\n5. Sajikan hangat.\n\nFrekuensi: 1–2x/hari sebagai makanan selingan.",
                'image'            => null,
            ],
            [
                'name'             => 'Perkedel Kentang Isi Daging',
                'category'         => 'stunting',
                'nutritional_info' => 'Menu selingan resmi dari Buku Bagan SDIDTK Kemenkes 2022 (hal. 134). Per 30 g: karbohidrat dari kentang dan protein dari daging.',
                'recipe'           => "Resep Perkedel Kentang Isi Daging:\n• 200 g kentang, kukus, haluskan\n• 50 g daging sapi cincang\n• 1 butir telur\n• Bawang putih, garam secukupnya\n• Sedikit minyak goreng\n\nCara membuat:\n1. Tumis daging cincang dengan bawang putih hingga matang.\n2. Campur kentang halus dengan telur, garam, dan daging.\n3. Bentuk bulat pipih.\n4. Goreng dengan sedikit minyak hingga kecokelatan.\n\nFrekuensi: 1–2x/hari sebagai makanan selingan.",
                'image'            => null,
            ],
            [
                'name'             => 'Susu Sapi / Susu Formula',
                'category'         => 'stunting',
                'nutritional_info' => 'Per 1 gelas (250 ml): 150–160 kalori, 8 gram protein, kalsium tinggi (±300 mg). Penting untuk pertumbuhan tulang dan tinggi badan.',
                'recipe'           => "Anjuran pemberian:\n• Usia < 6 bulan: ASI eksklusif, susu formula hanya jika ASI tidak tersedia.\n• Usia 6–23 bulan: Prioritaskan ASI. Jika tidak mendapat ASI, tambahkan 1–2 gelas susu (250 ml) per hari.\n• Usia ≥ 2 tahun: 1–2 gelas susu sapi/formula per hari sebagai pelengkap.\n\nCatatan: Konsultasikan jenis dan jumlah susu dengan tenaga kesehatan.",
                'image'            => null,
            ],
            [
                'name'             => 'Ikan Lele',
                'category'         => 'stunting',
                'nutritional_info' => 'Per 1/3 ekor sedang (40 g): protein tinggi, lemak baik. Mudah didapat, harga terjangkau, dan disukai anak.',
                'recipe'           => "Cara penyajian:\n• Lele goreng: Bersihkan, bumbu bawang putih dan garam, goreng.\n• Pepes lele: Bungkus dengan daun pisang, kukus 20 menit.\n• Lele bakar: Bakar dengan bumbu kecap, lebih rendah lemak.\n\nFrekuensi: 3–4 kali per minggu.",
                'image'            => null,
            ],

            // ===================================================
            // KATEGORI: TINGGI (mendukung pertumbuhan tinggi badan)
            // Sumber: Prinsip gizi seimbang SDIDTK untuk pertumbuhan linear
            //         Menu MP-ASI standar hal. 133, Menu Selingan hal. 134
            // ===================================================
            [
                'name'             => 'Daging Sapi',
                'category'         => 'tinggi',
                'nutritional_info' => 'Per 1 potong sedang (35 g): 7 gram protein, 5 gram lemak. Protein hewani berkualitas tinggi dengan zat besi heme untuk pertumbuhan tulang dan otot.',
                'recipe'           => "Cara penyajian:\n• Usia ≥12 bulan: Semur daging, sup daging, daging rebus.\n• Usia ≥2 tahun: Steak tipis, rendang, semur daging.\n\nFrekuensi: 3–4 kali per minggu (35–50 g per porsi).",
                'image'            => null,
            ],
            [
                'name'             => 'Kacang Kedelai / Sari Kedelai',
                'category'         => 'tinggi',
                'nutritional_info' => 'Per 2½ sdm (25 g kering): 6 gram protein, kalsium, dan isoflavon. Sari kedelai 2½ gelas (185 ml) setara 1 porsi protein nabati.',
                'recipe'           => "Cara penyajian:\n• Sari kedelai: Blender kedelai rebus, saring, tambahkan sedikit gula. Berikan 1–2 gelas/hari.\n• Edamame rebus: Kedelai muda direbus, camilan bergizi.\n• Tambahkan ke sup atau bubur.\n\nFrekuensi: 1–2 porsi per hari.",
                'image'            => null,
            ],
            [
                'name'             => 'Brokoli',
                'category'         => 'tinggi',
                'nutritional_info' => 'Sayuran golongan B. Per 100 g: 25 kalori, 5 g karbohidrat, 1 g protein. Kaya vitamin C (mendukung sintesis kolagen untuk tulang) dan kalsium.',
                'recipe'           => "Cara penyajian:\n• Usia 9–11 bulan: Brokoli kukus haluskan.\n• Usia ≥12 bulan: Tumis brokoli bawang putih, sup brokoli, brokoli kukus.\n• Pastikan dimasak tidak terlalu lama agar vitamin C tidak hilang.\n\nFrekuensi: 3–4 kali per minggu.",
                'image'            => null,
            ],
            [
                'name'             => 'Ubi Jalar Kuning',
                'category'         => 'tinggi',
                'nutritional_info' => 'Per 1 buah sedang (135 g): 175 kalori, karbohidrat + beta-karoten sangat tinggi. Beta-karoten diubah tubuh menjadi vitamin A yang penting untuk pertumbuhan.',
                'recipe'           => "Cara penyajian:\n• Usia 6–8 bulan: Puree ubi jalar kukus — rasa manis alami disukai bayi.\n• Usia ≥9 bulan: Ubi jalar rebus potong dadu.\n• Usia ≥12 bulan: Ubi jalar kukus/rebus, bisa sebagai pengganti nasi 2–3x/minggu.",
                'image'            => null,
            ],
            [
                'name'             => 'Mangga',
                'category'         => 'tinggi',
                'nutritional_info' => 'Per ¾ buah besar (90 g): 50 kalori, 10 g karbohidrat. Kaya vitamin C (membantu penyerapan zat besi), vitamin A, dan serat.',
                'recipe'           => "Cara penyajian:\n• Usia 6–8 bulan: Puree mangga matang.\n• Usia ≥9 bulan: Potong dadu kecil.\n• Usia ≥12 bulan: Jus mangga tanpa gula, potongan mangga segar.\n\nFrekuensi: 1 porsi per hari (¾ buah besar).",
                'image'            => null,
            ],
            [
                'name'             => 'Makaroni Daging Kukus',
                'category'         => 'tinggi',
                'nutritional_info' => 'Menu MP-ASI standar dari Buku Bagan SDIDTK Kemenkes 2022 (hal. 133). Per porsi 70–125 g: karbohidrat dari makaroni dan protein dari daging.',
                'recipe'           => "Resep Makaroni Daging Kukus (untuk 1 porsi):\n• 50 g makaroni kering (masak hingga lembut)\n• 30 g daging sapi cincang halus\n• Kaldu ayam/sapi secukupnya\n• Sedikit bawang putih, garam\n• Sedikit margarin\n\nCara membuat:\n1. Rebus makaroni hingga sangat lunak, tiriskan.\n2. Tumis bawang putih, masukkan daging cincang, masak matang.\n3. Campurkan makaroni dan daging, tambahkan kaldu.\n4. Kukus 10 menit, sajikan hangat.\n\nUkuran per usia:\n• 6–8 bulan: 70 g\n• 9–11 bulan: 90 g\n• 12–23 bulan: 125 g",
                'image'            => null,
            ],
            [
                'name'             => 'Puding Mangga',
                'category'         => 'tinggi',
                'nutritional_info' => 'Menu selingan resmi dari Buku Bagan SDIDTK Kemenkes 2022 (hal. 134). Per 50 g: vitamin C dari mangga, kalsium dari susu/agar.',
                'recipe'           => "Resep Puding Mangga (untuk anak):\n• 1 bungkus agar-agar plain\n• 200 ml susu cair\n• 100 ml jus mangga segar\n• 2 sdm gula pasir\n\nCara membuat:\n1. Campur agar-agar, susu, jus mangga, dan gula dalam panci.\n2. Masak sambil diaduk hingga mendidih.\n3. Tuang ke cetakan, dinginkan hingga beku.\n4. Sajikan dingin atau suhu ruang.\n\nFrekuensi: 1–2x/hari sebagai makanan selingan (50 g per porsi).",
                'image'            => null,
            ],
            [
                'name'             => 'Talam Ambon',
                'category'         => 'tinggi',
                'nutritional_info' => 'Menu selingan resmi dari Buku Bagan SDIDTK Kemenkes 2022 (hal. 134). Per 50 g: karbohidrat dari tepung beras dan santan.',
                'recipe'           => "Resep Talam Ambon:\n• 100 g tepung beras\n• 200 ml santan kental\n• 50 ml air\n• 2 sdm gula pasir\n• Sejumput garam\n• Pewarna alami (pandan/kunyit) secukupnya\n\nCara membuat:\n1. Campur semua bahan, aduk rata hingga tidak bergerindil.\n2. Tuang ke cetakan kecil.\n3. Kukus 15–20 menit.\n4. Dinginkan sebelum disajikan.\n\nFrekuensi: Sebagai snack 1–2x/hari (50 g per porsi).",
                'image'            => null,
            ],
        ];

        foreach ($foods as $food) {
            FoodRecommendation::create($food);
        }
    }
}
