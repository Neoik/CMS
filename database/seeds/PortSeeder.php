<?php

use Illuminate\Database\Seeder;

use App\Port;

class PortSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach(range('A','Z') as $v){
            //echo "$v \n";

            $port = new Port();
            $port->name = "Port $v";
            $port->location = "${v}_location";
            $port->save();
        }
    }
}
