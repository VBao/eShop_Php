<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LaptopSpecs extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cpus = ["Intel Pentium, N6000, 1.10 GHz",
            "Intel Core i3, 10110U",
            "Intel Core i3, Ice Lake, 1005G1, 1.20 GHz",
            "Intel Core i3, Coffee Lake, 8145U, 2.10 GHz",
            "Intel Core i3, Tiger Lake, 1115G4, 3.00 GHz",
            "Intel Core i5, Tiger Lake, 1135G7, 2.40 GHz",
            "Intel Core i5, Ice Lake, 1035G1, 1.00 GHz",
            "Intel Core i5, Ice Lake, 1035G4, 1.10 GHz",
            "Intel Core i5, 7200U,  ( 2.5 GHz - 3.1 GHz / 3MB / 2 nhân, 4 luồng )",
            "Intel Core i5, 8250U,  ( 1.6 GHz - 3.4 GHz / 6MB / 4 nhân, 8 luồng )",
            "Intel Core i5, Coffee Lake, 8265U, 1.60 GHz",
            "Intel Core i5, Coffee Lake, 9300H, 2.40 GHz",
            "Intel Core i5, Comet Lake, 10300H, 2.50 GHz",
            "Intel Core i5, 10200H",
            "Intel Core i5, Comet Lake, 10210U, 1.60 GHz",
            "Intel Core i7, 1065G7",
            "Intel Core i7, 10750H",
            "Intel Core i7, 10875H",
            "Intel Core i7, 10510U",
            "Intel Core i7, Comet Lake, 10710U, 1.10 GHz",
            "Intel Core i7, Coffee Lake, 8565U, 1.80 GHz",
            "Intel Core i7, Comet Lake, 10870H, 2.20 GHz",
            "Intel Core i7, Comet Lake, 10750H, 2.60 GHz",
            "Intel Core i7, Tiger Lake, 1165G7, 2.80 GHz",
            "Intel Celeron, N4020, 1.10 GHz",
            "AMD Ryzen 5, 5500U, 2.10 GHz",
            "AMD Ryzen 3, 3250U, 2.60 GHz",
            "AMD Ryzen 5, 4600H, 3.00 GHz"];

        $gpus = [
            "Card đồ họa tích hợp, Intel UHD Graphics",
            "Card đồ họa rời, NVIDIA GeForce GTX1650 4GB",
            "Card đồ họa rời, NVIDIA GeForce MX250 2GB",
            "Card đồ họa rời, NVIDIA GeForce RTX2060",
            "Card đồ họa tích hợp, Intel Iris Xe Graphics",
            "Card đồ họa tích hợp, Intel HD Graphics 620",
            "Card đồ họa tích hợp, Intel Iris Plus Graphics",
            "Card đồ họa rời, NVIDIA GeForce GTX 1650Ti 4GB",
            "Card đồ họa tích hợp, Intel UHD Graphics 600",
            "Card đồ họa tích hợp, AMD Radeon Graphics",
            "Card đồ họa rời, NVIDIA GeForce GTX 1660Ti Max-Q, 6GB",
            "NVIDIA GeForce GTX 1650 4GB GDDR6 / Intel UHD Graphics",
            "NVIDIA GeForce RTX 2060 6GB GDDR6 / Intel UHD Graphics",
            "NVIDIA GeForce RTX 2070 Super 8GB GDDR6 / Intel UHD Graphics"
        ];
        $rams = [
            "2 GB, DDR3L, 1600 MHz",
            "4 GB, DDR3L, 1600 MHz",
            "8 GB, DDR3L, 1600 MHz",
            "4 GB, DDR4, 2133 MHz",
            "4 GB, DDR4, 2400 MHz",
            "4 GB, DDR4, 2666 MHz",
            "4 GB, DDR4, 2933 MHz",
            "4 GB, DDR4, 3200 MHz",
            "4 GB, DDR4, 4266 MHz",
            "8 GB, DDR4, 2133 MHz",
            "8 GB, DDR4, 2400 MHz",
            "8 GB, DDR4, 2666 MHz",
            "8 GB, DDR4, 2933 MHz",
            "8 GB, DDR4, 3200 MHz",
            "16 GB, DDR4, 2400 MHz",
            "16 GB, DDR4, 3200 MHz",
            "16 GB, DDR4, 3600 MHz",
            "32 GB, DDR4, 2666 MHz",
            "4 GB, LPDDR4X, 4266 MHz",
            "8 GB, LPDDR4X, 3200 MHz",
            "8 GB, LPDDR4X, 4266 MHz",
            "8 GB, LPDDR4X, 4267 MHz",
            "16 GB, LPDDR4X, 4266 MHz",
            "16 GB, LPDDR4X, 4267 MHz"
        ];
        $roms = [
            "SSD 1TB M.2 PCIe",
            "SSD 512GB M.2 NVMe",
            "SSD 512GB M.2 SATA",
            "HDD 500GB SATA3, Hỗ trợ khe cắm SSD M.2 PCIe",
            "SSD 256GB NVMe PCIe",
            "SSD 256GB M.2 NVMe",
            "SSD 256GB M.2 SATA",
            "SSD 512GB NVMe PCIe",
            "SSD 256GB NVMe PCIe, Hỗ trợ khe cắm SSD M.2 PCIe",
            "SSD 256GB NVMe PCIe, Hỗ trợ khe cắm HDD SATA",
            "SSD 512GB NVMe PCIe, Hỗ trợ khe cắm HDD SATA",
            "SSD 512GB NVMe PCIe, Hỗ trợ khe cắm SSD M.2 PCIe",
            "SSD 512 GB M.2 PCIe",
            "SSD 512 GB M.2 PCIe, Hỗ trợ khe cắm SSD M.2 PCIe",
            "SSD 512GB NVMe PCIe, Không hỗ trợ khe cắm HDD",
            "SSD 512GB NVMe PCI, Hỗ trợ thêm 2 khe cắm SSD M.2 PCIe"
        ];

        $screens = [
            "13 inch, WQHD (2160 x 1350)",
            "13.3 inch, Full HD (1920 x 1080)",
            "13.3 inch, IPS ( 1920 x 1080 ) , không cảm ứng",
            "13.3 inch, QHD (2560x1600)",
            "13.4 inch, Full HD+ (1920 x 1200)",
            "13.4 inch, 4K/UHD (3840 x 2400)",
            "14 inch, HD 720 (1280 x 720)",
            "14 inch, HD (1366 x 768)",
            "14 inch, IPS (1920 x 1080)",
            "14 inch, Full HD (1920 x 1080)",
            "15.6 inch, Full HD (1920 x 1080)",
            "15.6 inch, HD (1366 x 768)",
            "15.6 inch, Full HD (1920 x 1080), 144Hz",
            "15 inch, IPS (1920 x 1080)",
            "15.6 inch, IPS (1920 x 1080), 144Hz",
            "15.6 inch, IPS (1920 x 1080), 240Hz ",
            "15.6 inch, IPS ( 1920 x 1080 ) , không cảm ứng",
            "17 inch, WQXGA (2560 x 1600)",
            "17 inch, IPS (2560 x 1600)"
        ];
        $ports = [
            "Thunderbolt 3, 2 x USB 3.1, HDMI",
            "Thunderbolt 3, 3 x USB 3.1, HDMI",
            "Thunderbolt 3, USB 3.1, HDMI, USB 2.0",
            "Thunderbolt 3, 1 x USB 3.2, 2 x USB 2.0, HDMI, LAN (RJ45), Mini DisplayPort",
            "Thunderbolt 4 USB-C, 2 x USB 3.1",
            "Thunderbolt 4 USB-C, 2x SuperSpeed USB A",
            "1 x USB 3.2, 2 x Thunderbolt4 USB-C, HDMI",
            "1 x USB 3.2, 2 x USB 2.0, HDMI, USB Type-C",
            "1 x USB 3.2, Thunderbolt4 USB-C, 2 x USB 2.0, HDMI",
            "2 x Thunderbolt 4 USB-C",
            "2 x Thunderbolt 4 USB-C, USB Type-C",
            "2 x Thunderbolt4 USB-C, 1 x USB 3.2, HDMI",
            "2 x SuperSpeed USB A, 2 x Thunderbolt 3 (USB-C)",
            "2 x USB Type-C (Power Delivery and DisplayPort), USB Type-C",
            "2 x USB 2.0, USB 3.1, HDMI, LAN (RJ45)",
            "2 x USB 3.0, HDMI, USB 2.0",
            "2 x USB 3.0, HDMI, USB 2.0, USB Type-C",
            "2 x USB 3.0, HDMI, LAN (RJ45), USB Type-C",
            "2 x USB 3.1, USB Type-C",
            "2 x USB 3.1, HDMI, USB Type-C",
            "2 x USB 3.1, HDMI, LAN (RJ45), USB 2.0",
            "2 x USB 3.1, HDMI, LAN (RJ45), USB 2.0, USB Type-C",
            "2 x USB 3.1, HDMI, 2 x Thunderbolt 3 (USB-C)",
            "2 x USB 3.2, HDMI, USB Type-C",
            "2 x USB 3.2, HDMI, LAN (RJ45), USB 2.0",
            "2 x USB 3.2, HDMI, LAN (RJ45), USB 2.0, USB Type-C",
            "2 x USB 3.2, Thunderbolt4 USB-C, HDMI, LAN (RJ45), USB Type-C",
            "2 x USB 3.2, USB Type-C (Power Delivery and DisplayPort), HDMI",
            "3 x USB 3.1, HDMI, LAN (RJ45), USB Type-C",
            "3 x USB 3.2, HDMI, LAN (RJ45), USB Type-C",
            "3 x USB 3.2, Thunderbolt4 USB-C, HDMI 2.0, LAN (RJ45)",
            "USB Type-C (Power Delivery and DisplayPort), 3x SuperSpeed USB A, HDMI, LAN (RJ45)"
        ];

        $weights = [
            "0.966 kg",
            "1 kg",
            "1.1 kg",
            "1.17 kg",
            "1.19kg",
            "1.2 kg",
            "1.236 kg",
            "1.3 kg",
            "1.38 kg",
            "1.4 kg",
            "1.45 kg",
            "1.46 kg",
            "1.5 kg",
            "1.55 kg",
            "1.592 kg",
            "1.66 kg",
            "1.7 kg",
            "1.79kg",
            "1.96 kg",
            "1.8 kg",
            "1.9 kg",
            "2.1 kg",
            "2.14 kg",
            "2.172 kg",
            "2.3 kg",
            "2.4 kg",
            "2.65 kg"
        ];
        $sizes = [
            "Dài 321.7 mm - Rộng 211.8 mm - Dày 17.9 mm",
            "Dài 323 mm - Rộng 218 mm - Dày 17.9 mm",
            "Dài 328.8 mm - Rộng 236 mm - Dày 17.95 mm",
            "Dài 363.96 mm - Rộng 249 mm - Dày 19.9 mm",
            "Dài 363.4 mm - Rộng 254.5 mm - Dày 22.9 mm",
            "Dài 360.2 mm - Rộng 234.0 mm - Dày 17.9 mm",
            "Dài 380 mm - Rộng 258 mm - Dày 19.8 mm",
            "Dài 370 mm - Rộng 262.5 mm - Dày 23.5 mm",
            "Dài 319.5 mm - Rộng 217 mm - Dày 15.95 mm",
            "Dài 307 mm - Rộng 211.5 mm - Dày 14.7 mm"
        ];

        $os = [
            "Windows 10 Home SL",
            "Windows 10 Home SL + Office Home&Student 2019 vĩnh viễn",
            "Windows 10 Home 64-bit",
            "Ubuntu 20.10",
            "Free DOS",
            "MacOS"
        ];

        $batteries = [
            "125Wh",
            "42Wh",
            "65Wh"
        ];

        foreach ($cpus as $value) DB::table('laptop_cpus')->insert(['value' => $value]);
        foreach ($gpus as $value) DB::table('laptop_gpus')->insert(['value' => $value]);
        foreach ($rams as $value) DB::table('laptop_rams')->insert(['value' => $value]);
        foreach ($roms as $value) DB::table('laptop_roms')->insert(['value' => $value]);
        foreach ($screens as $value) DB::table('laptop_screens')->insert(['value' => $value]);
        foreach ($ports as $value) DB::table('laptop_ports')->insert(['value' => $value]);
        foreach ($weights as $value) DB::table('laptop_weights')->insert(['value' => $value]);
        foreach ($sizes as $value) DB::table('laptop_sizes')->insert(['value' => $value]);
        foreach ($os as $value) DB::table('laptop_os')->insert(['value' => $value]);
        foreach ($batteries as $value) DB::table('laptop_batteries')->insert(['value' => $value]);
    }
}
