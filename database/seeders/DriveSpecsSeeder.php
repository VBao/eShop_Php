<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DriveSpecsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $type = ["HHD", "SSD", "Di động HHD", "Di động SSD"];
        $connection = ["USB Type C", "USB 3.0", "USB 3.1", "USB 3.2", "M.2 NVMe", "M.2 SATA", "SATA 3", "PCI e", "Ethernet"];
        $capacity = ["120GB", "128GB", "256GB", "500GB", "1TB", "2TB", "4TB", "6TB"];
        $dimension = ["2.5''", "3.5''", "M.2 2280", "M.2", "Card PCI"];
        $read = ["114 MB/s", "120 MB/s", "125 MB/ s", "540 MB/s", "545 MB/s", "500 MB/s", "1550MB/s", "2000MB/s", "2400MB/s"];
        $write = [
            "115 MB/s",
            "350MB/s",
            "550MB/s",
            "950MB/s",
            "1100MB/s",
            "1550MB/s"
        ];
        $rotation = ["None",
            "5400RPM",
            "5900RPM",
            "7200RPM"
        ];
        $cache = ["None","128MB", "256MB"];

        foreach ($dimension as $value) \DB::table('drive_dimensions')->insert(['value' => $value]);
        foreach ($capacity as $value) \DB::table('drive_capacities')->insert(['value' => $value]);
        foreach ($connection as $value) \DB::table('drive_connects')->insert(['value' => $value]);
        foreach ($type as $value) \DB::table('drive_types')->insert(['value' => $value]);
        foreach ($read as $value) \DB::table('drive_reads')->insert(['value' => $value]);
        foreach ($write as $value) \DB::table('drive_writes')->insert(['value' => $value]);
        foreach ($rotation as $value) \DB::table('drive_rotations')->insert(['value' => $value]);
        foreach ($cache as $value) \DB::table('drive_caches')->insert(['value' => $value]);
    }
}
