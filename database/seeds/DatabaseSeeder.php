<?php
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tires_prop_name')->insert([
            ['name' => 'Наименование','code'=>'name'],
            ['name' => 'Ширина','code' => 'width'],
            ['name' => 'Профиль','code' => 'profile'],
            ['name' => 'Диаметр','code' => 'diameter'],
            ['name' => 'Индекс нагрузки', 'code'=>'load_index'],
            ['name' => 'Индекс скорости', 'code' => 'speed_index'],
            ['name' => 'Производитель' ,'code' => 'vendor_id'],
            ['name' => 'Модель', 'code' => 'model_id'],
            ['name' => 'Количество', 'code'=> 'quantity'],
            ['name' => 'Цена','code' => 'price'],
            ['name' => 'Дата создания','code'=>'created_at'],
            ['name' => 'Дата изменения','code'=>'updated_at']
        ]);

        DB::table('vendor')->insert([
            ['id' => 1,'name' => 'НКШЗ'],
            ['id' => 2,'name' => 'HANKOOK'],
            ['id' => 3,'name' => 'NOKIAN']
        ]);

        DB::table('model')->insert([
            ['id' => 1, 'name' => 'Кама204'],
            ['id' => 2, 'name' => 'RA18 Vantra LT/C'],
            ['id' => 3, 'name' => 'Кама Euro 236'],
        ]);
    }
}
