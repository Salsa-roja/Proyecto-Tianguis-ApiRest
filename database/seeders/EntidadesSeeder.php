<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class EntidadesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $entidades=[
                [
                    "id"=>"01",
                    "nombre_entidad"=>"AGUASCALIENTES"],
                [
                    "id"=>"02",
                    "nombre_entidad"=>"BAJA CALIFORNIA"],
                [
                    "id"=>"03",
                    "nombre_entidad"=>"BAJA CALIFORNIA SUR"],
                [
                    "id"=>"04",
                    "nombre_entidad"=>"CAMPECHE"],
                [
                    "id"=>"05",
                    "nombre_entidad"=>"COAHUILA DE ZARAGOZA"],
                [
                    "id"=>"06",
                    "nombre_entidad"=>"COLIMA"],
                [
                    "id"=>"07",
                    "nombre_entidad"=>"CHIAPAS"],
                [
                    "id"=>"08",
                    "nombre_entidad"=>"CHIHUAHUA"],
                [
                    "id"=>"09",
                    "nombre_entidad"=>"CIUDAD DE MÉXICO"],
                [
                    "id"=>"10",
                    "nombre_entidad"=>"DURANGO"],
                [
                    "id"=>"11",
                    "nombre_entidad"=>"GUANAJUATO"],
                [
                    "id"=>"12",
                    "nombre_entidad"=>"GUERRERO"],
                [
                    "id"=>"13",
                    "nombre_entidad"=>"HidALGO"],
                [
                    "id"=>"14",
                    "nombre_entidad"=>"JALISCO"],
                [
                    "id"=>"15",
                    "nombre_entidad"=>"MÉXICO"],
                [
                    "id"=>"16",
                    "nombre_entidad"=>"MICHOACÁN DE OCAMPO"],
                [
                    "id"=>"17",
                    "nombre_entidad"=>"MORELOS"],
                [
                    "id"=>"18",
                    "nombre_entidad"=>"NAYARIT"],
                [
                    "id"=>"19",
                    "nombre_entidad"=>"NUEVO LEÓN"],
                [
                    "id"=>"20",
                    "nombre_entidad"=>"OAXACA"],
                [
                    "id"=>"21",
                    "nombre_entidad"=>"PUEBLA"],
                [
                    "id"=>"22",
                    "nombre_entidad"=>"QUERÉTARO"],
                [
                    "id"=>"23",
                    "nombre_entidad"=>"QUINTANA ROO"],
                [
                    "id"=>"24",
                    "nombre_entidad"=>"SAN LUIS POTOSÍ"],
                [
                    "id"=>"25",
                    "nombre_entidad"=>"SINALOA"],
                [
                    "id"=>"26",
                    "nombre_entidad"=>"SONORA"],
                [
                    "id"=>"27",
                    "nombre_entidad"=>"TABASCO"],
                [
                    "id"=>"28",
                    "nombre_entidad"=>"TAMAULIPAS"],
                [
                    "id"=>"29",
                    "nombre_entidad"=>"TLAXCALA"],
                [
                    "id"=>"30",
                    "nombre_entidad"=>"VERACRUZ DE IGNACIO DE LA LLAVE"],
                [
                    "id"=>"31",
                    "nombre_entidad"=>"YUCATÁN"],
                [
                    "id"=>"32",
                    "nombre_entidad"=>"ZACATECAS"]
        ];
        foreach ($entidades as $key => $obj) {
            DB::table('cat_entidades')->insert($obj);
        }
    }
}
