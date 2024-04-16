<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('units')->insert([
            ['nombre'=>'VENTANILLA UNICA','abreviatura'=>'VU','color'=>'#1F7087'],
            ['nombre'=>'VEHICULOS','abreviatura'=>'VE','color'=>'#952175'],
            ['nombre'=>'INMUEBLES','abreviatura'=>'IN','color'=>'#1F7087'],
            ['nombre'=>'INDUSTRIA COMERCIO','abreviatura'=>'IC','color'=>'#952175'],
            ['nombre'=>'ESPEC. PUBLICOS','abreviatura'=>'EP','color'=>'#1F7087'],
            ['nombre'=>'MERCADOS','abreviatura'=>'ME','color'=>'#952175'],
            ['nombre'=>'VALORES','abreviatura'=>'VA','color'=>'#1F7087'],
            ['nombre'=>'BANCO','abreviatura'=>'BA','color'=>'#952175']
        ]);
    }
}
