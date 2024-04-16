<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('users')->insert([
            ["cuenta"=>"ADM","caja"=>"","name"=>"Administrador","email"=>"admin@gamo.com",'password'=>Hash::make('admin123Admin'),"unit_id"=>1],
            ["cuenta"=>"VU","caja"=>"CAJA1","name"=>"Ventanilla Unica","email"=>"vu@gamo.com",'password'=>Hash::make('VU'),"unit_id"=>1],
            ["cuenta"=>"VE","caja"=>"CAJA2","name"=>"Vehiculos","email"=>"ve@gamo.com",'password'=>Hash::make('VE'),"unit_id"=>2],
            ["cuenta"=>"IN","caja"=>"CAJA3","name"=>"Inmuebles","email"=>"ie@gamo.com",'password'=>Hash::make('IN'),"unit_id"=>3],
            ["cuenta"=>"IC","caja"=>"CAJA4","name"=>"Industria Comercio","email"=>"ic@gamo.com",'password'=>Hash::make('IC'),"unit_id"=>4],
            ["cuenta"=>"EP","caja"=>"CAJA5","name"=>"Espectaculos Publicos","email"=>"ep@gamo.com",'password'=>Hash::make('EP'),"unit_id"=>5],
            ["cuenta"=>"ME","caja"=>"CAJA6","name"=>"Mercados","email"=>"me@gamo.com",'password'=>Hash::make('ME'),"unit_id"=>6],
            ["cuenta"=>"VA","caja"=>"CAJA7","name"=>"Valores","email"=>"va@gamo.com",'password'=>Hash::make('VA'),"unit_id"=>7],
            ["cuenta"=>"BA","caja"=>"CAJA8","name"=>"Cajas","email"=>"ca@gamo.com",'password'=>Hash::make('BA'),"unit_id"=>8],
        ]);
    }
}
