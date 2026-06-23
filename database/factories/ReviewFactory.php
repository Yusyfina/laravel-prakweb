<?php
// CHALLENGE BAB 4 - Factory Review dengan distribusi rating realistis

namespace Database\Factories;

use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    protected $model = Review::class;

    // Komentar dikelompokkan sesuai kategori rating
    private array $positiveComments = [
        'Produknya bagus banget, sesuai ekspektasi!',
        'Kualitas mantap, pengiriman juga cepat.',
        'Recommended! Bakal beli lagi di sini.',
        'Sangat puas, kualitas premium dengan harga terjangkau.',
        'Pelayanan ramah, barang sampai dengan aman.',
    ];

    private array $goodComments = [
        'Produk cukup bagus, sesuai dengan deskripsi.',
        'Lumayan oke, cuma packing-nya agak kurang rapi.',
        'Worth it lah buat harga segini.',
        'Sesuai gambar, kualitas standar tapi memuaskan.',
        'Pengiriman agak lama tapi barangnya bagus.',
    ];

    private array $neutralComments = [
        'Produk standar, nggak ada yang istimewa.',
        'Biasa aja, sesuai harga.',
        'Cukup oke tapi ada beberapa kekurangan kecil.',
        'Kualitas sedang, mungkin bisa ditingkatkan lagi.',
        'Lumayan, tapi masih kalah sama kompetitor.',
    ];

    private array $negativeComments = [
        'Kualitas kurang sesuai ekspektasi, agak mengecewakan.',
        'Barang yang datang nggak sesuai foto.',
        'Pengiriman lama dan packing kurang rapi.',
        'Kurang puas, mungkin akan pertimbangkan brand lain.',
        'Sayang sekali, produk cepat rusak.',
    ];

    public function definition(): array
    {
        // Generate rating dengan distribusi: 40% (5), 30% (4), 20% (3), 10% (1-2)
        $rating = $this->generateWeightedRating();

        return [
            'user_id'    => User::inRandomOrder()->value('id'),
            'product_id' => Product::inRandomOrder()->value('id'),
            'rating'     => $rating,
            'comment'    => $this->generateComment($rating),
            // Sebar created_at dalam 1 tahun terakhir biar kelihatan natural/historis
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
    private function generateWeightedRating(): int
    {
        $roll = $this->faker->numberBetween(1, 100);

        return match (true) {
            $roll <= 40 => 5,                                   // 1-40   -> 40%
            $roll <= 70 => 4,                                   // 41-70  -> 30%
            $roll <= 90 => 3,                                   // 71-90  -> 20%
            default     => $this->faker->numberBetween(1, 2),   // 91-100 -> 10% (rating 1 atau 2)
        };
    }

    private function generateComment(int $rating): string
    {
        return match (true) {
            $rating === 5 => $this->faker->randomElement($this->positiveComments),
            $rating === 4 => $this->faker->randomElement($this->goodComments),
            $rating === 3 => $this->faker->randomElement($this->neutralComments),
            default       => $this->faker->randomElement($this->negativeComments), // rating 1-2
        };
    }
}
