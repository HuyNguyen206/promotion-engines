<?php

namespace App\DataFixtures;

use App\Entity\ProductPromotion;
use App\Factory\ProductFactory;
use App\Factory\ProductPromotionFactory;
use App\Factory\PromotionFactory;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        UserFactory::createOne([
            'email' => 'nguyenlehuyuit@gmail.com',
            'name' => 'huy'
        ]);
        UserFactory::createMany(5);
        PromotionFactory::createOne([
            'name' => 'Black friday',
            'type' => 'date_range_multiplier',
            'adjustment' => 0.5,
            'criteria' => '{"to": "2022-11-28", "from": "2022-11-25"}',
        ]);

        PromotionFactory::createOne([
            'name' => 'Voucher',
            'type' => 'fixed_price_voucher',
            'adjustment' => 100,
            'criteria' => '{"code": "OUB12"}',
        ]);

        ProductFactory::createMany(5);

        foreach (range(1, 10) as $i) {
            ProductPromotionFactory::createOne([
                'product' => ProductFactory::random(),
                'promotion' => PromotionFactory::random(),
            ]);
        }
    }
}
