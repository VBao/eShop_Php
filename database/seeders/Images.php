<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class Images extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $img = [
            'https://cdn.tgdd.vn/Products/Images/44/235378/dell-inspiron-7501-i7-x3mry1-600x600.jpg',
            'https://cdn.tgdd.vn/Products/Images/44/235542/5-600x600.jpg',
            'https://cdn.tgdd.vn/Products/Images/44/232902/dell-g5-15-5500-i7-70225485-094921-024956-600x600.jpg',
            'https://cdn.tgdd.vn/Products/Images/44/238015/hp-340s-g7-i5-1035g1-8gb-512gb-win10-36a35pa-600x600.jpg',
            'https://cdn.tgdd.vn/Products/Images/44/218439/hp-348-g7-i5-9ph06pa-kg2-1-218439-600x600.jpg', 'https://cdn.tgdd.vn/Products/Images/44/232172/hp-envy-13-ba1028tu-i5-1135g7-8gb-512gb-office-h-s-600x600.jpg',
            'https://cdn.tgdd.vn/Products/Images/44/232172/hp-envy-13-ba1028tu-i5-1135g7-8gb-512gb-office-h-s-600x600.jpg',
            'https://cdn.tgdd.vn/Products/Images/44/216292/lenovo-ideapad-s145-81w8001xvn-a4-216292-600x600.jpg',
            'https://cdn.tgdd.vn/Products/Images/44/230161/lenovo-thinkbook-15iil-i3-20sm00d9vn-021320-101327-600x600.jpg',
            'https://cdn.tgdd.vn/Products/Images/44/222648/lenovo-ideapad-flex-5-14iil05-i3-81x1001tvn-152721-022757-600x600.jpg',
            'https://cdn.tgdd.vn/Products/Images/44/235405/acer-aspire-7-a715-42g-r4st-r5-nhqaysv004-16-600x600.jpg',
            'https://cdn.tgdd.vn/Products/Images/44/231082/acer-aspire-5-a514-54-33wy-i3-nxa23sv00j-021220-101200-600x600.jpg',
            'https://cdn.tgdd.vn/Products/Images/44/232715/thumb-600x600.jpg',
            'https://cdn.tgdd.vn/Products/Images/44/231342/acer-nitro-5-an515-55-5206-i5-nhq7nsv007-600x600.jpg',
            'https://cdn.tgdd.vn/Products/Images/44/238608/msi-gf63-10sc-i5-10300h-8gb-512gb-4gb-gtx1650-144h-600x600.jpg',
            'https://cdn.tgdd.vn/Products/Images/44/235499/msi-gl65-leopard-10scxk-i7-093vn-16-600x600.jpg',
            'https://cdn.tgdd.vn/Products/Images/44/238607/msi-gf65-thin-10ue-i5-10500h-16gb-512gb-6gb-rtx306-600x600.jpg',
            'https://cdn.tgdd.vn/Products/Images/44/231252/apple-macbook-air-2020-m1-mgne3saa-600x600.jpg',
            'https://cdn.tgdd.vn/Products/Images/44/231255/apple-macbook-pro-2020-z11c-3-600x600.jpg',
            'https://cdn.tgdd.vn/Products/Images/44/231251/apple-macbook-air-2020-m1-mgna3saa-1-600x600.jpg',
            'https://cdn.tgdd.vn/Products/Images/44/232444/asus-vivobook-x515ma-n5030-ej120t-301720-091748-600x600.jpg',
            'https://cdn.tgdd.vn/Products/Images/44/230351/asus-zenbook-ux425ea-i5-bm069t-grey-new-600x600.jpg',
            'https://cdn.tgdd.vn/Products/Images/44/234613/TUF2-600x400.jpg',
        ];
        $count = 1;
        $id = 36;
        for ($i = 1; $i < 189; $i++) {
            if ($count == 4) {
                $count = 1;
                $id++;
            }
            DB::table('images')->insert([
                'link_image' => $img[array_rand($img)],
                'info_id' => $id
            ]);
            $count++;
        }
    }
}
