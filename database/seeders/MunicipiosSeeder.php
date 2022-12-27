<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MunicipiosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $municipios=[
            ["id"=>"001", "nombre_municipio"=>"ACATIC", "entidad_id"=>"14"],
            ["id"=>"002", "nombre_municipio"=>"ACATLAN DE JUAREZ", "entidad_id"=>"14"],
            ["id"=>"003", "nombre_municipio"=>"AHUALULCO DE MERCADO", "entidad_id"=>"14"],
            ["id"=>"004", "nombre_municipio"=>"AMACUECA", "entidad_id"=>"14"],
            ["id"=>"005", "nombre_municipio"=>"AMATITAN", "entidad_id"=>"14"],
            ["id"=>"006", "nombre_municipio"=>"AMECA", "entidad_id"=>"14"],
            ["id"=>"007", "nombre_municipio"=>"SAN JUANITO DE ESCOBEDO", "entidad_id"=>"14"],
            ["id"=>"008", "nombre_municipio"=>"ARANDAS", "entidad_id"=>"14"],
            ["id"=>"009", "nombre_municipio"=>"EL ARENAL", "entidad_id"=>"14"],
            ["id"=>"010", "nombre_municipio"=>"ATEMAJAC DE BRIZUELA", "entidad_id"=>"14"],
            ["id"=>"011", "nombre_municipio"=>"ATENGO", "entidad_id"=>"14"],
            ["id"=>"012", "nombre_municipio"=>"ATENGUILLO", "entidad_id"=>"14"],
            ["id"=>"013", "nombre_municipio"=>"ATOTONILCO EL ALTO", "entidad_id"=>"14"],
            ["id"=>"014", "nombre_municipio"=>"ATOYAC", "entidad_id"=>"14"],
            ["id"=>"015", "nombre_municipio"=>"AUTLAN DE NAVARRO", "entidad_id"=>"14"],
            ["id"=>"016", "nombre_municipio"=>"AYOTLAN", "entidad_id"=>"14"],
            ["id"=>"017", "nombre_municipio"=>"AYUTLA", "entidad_id"=>"14"],
            ["id"=>"018", "nombre_municipio"=>"LA BARCA", "entidad_id"=>"14"],
            ["id"=>"019", "nombre_municipio"=>"BOLAÑOS", "entidad_id"=>"14"],
            ["id"=>"020", "nombre_municipio"=>"CABO CORRIENTES", "entidad_id"=>"14"],
            ["id"=>"021", "nombre_municipio"=>"CASIMIRO CASTILLO", "entidad_id"=>"14"],
            ["id"=>"022", "nombre_municipio"=>"CIHUATLAN", "entidad_id"=>"14"],
            ["id"=>"023", "nombre_municipio"=>"ZAPOTLAN EL GRANDE", "entidad_id"=>"14"],
            ["id"=>"024", "nombre_municipio"=>"COCULA", "entidad_id"=>"14"],
            ["id"=>"025", "nombre_municipio"=>"COLOTLAN", "entidad_id"=>"14"],
            ["id"=>"026", "nombre_municipio"=>"CONCEPCION DE BUENOS AIRES", "entidad_id"=>"14"],
            ["id"=>"027", "nombre_municipio"=>"CUAUTITLAN DE GARCIA BARRAGAN", "entidad_id"=>"14"],
            ["id"=>"028", "nombre_municipio"=>"CUAUTLA", "entidad_id"=>"14"],
            ["id"=>"029", "nombre_municipio"=>"CUQUIO", "entidad_id"=>"14"],
            ["id"=>"030", "nombre_municipio"=>"CHAPALA", "entidad_id"=>"14"],
            ["id"=>"031", "nombre_municipio"=>"CHIMALTITAN", "entidad_id"=>"14"],
            ["id"=>"032", "nombre_municipio"=>"CHIQUILISTLAN", "entidad_id"=>"14"],
            ["id"=>"033", "nombre_municipio"=>"DEGOLLADO", "entidad_id"=>"14"],
            ["id"=>"034", "nombre_municipio"=>"EJUTLA", "entidad_id"=>"14"],
            ["id"=>"035", "nombre_municipio"=>"ENCARNACION DE DIAZ", "entidad_id"=>"14"],
            ["id"=>"036", "nombre_municipio"=>"ETZATLAN", "entidad_id"=>"14"],
            ["id"=>"037", "nombre_municipio"=>"EL GRULLO", "entidad_id"=>"14"],
            ["id"=>"038", "nombre_municipio"=>"GUACHINANGO", "entidad_id"=>"14"],
            ["id"=>"039", "nombre_municipio"=>"GUADALAJARA", "entidad_id"=>"14"],
            ["id"=>"040", "nombre_municipio"=>"HOSTOTIPAQUILLO", "entidad_id"=>"14"],
            ["id"=>"041", "nombre_municipio"=>"HUEJUCAR", "entidad_id"=>"14"],
            ["id"=>"042", "nombre_municipio"=>"HUEJUQUILLA EL ALTO", "entidad_id"=>"14"],
            ["id"=>"043", "nombre_municipio"=>"LA HUERTA", "entidad_id"=>"14"],
            ["id"=>"044", "nombre_municipio"=>"IXTLAHUACAN DE LOS MEMBRILLOS", "entidad_id"=>"14"],
            ["id"=>"045", "nombre_municipio"=>"IXTLAHUACAN DEL RIO", "entidad_id"=>"14"],
            ["id"=>"046", "nombre_municipio"=>"JALOSTOTITLAN", "entidad_id"=>"14"],
            ["id"=>"047", "nombre_municipio"=>"JAMAY", "entidad_id"=>"14"],
            ["id"=>"048", "nombre_municipio"=>"JESUS MARIA", "entidad_id"=>"14"],
            ["id"=>"049", "nombre_municipio"=>"JILOTLAN DE LOS DOLORES", "entidad_id"=>"14"],
            ["id"=>"050", "nombre_municipio"=>"JOCOTEPEC", "entidad_id"=>"14"],
            ["id"=>"051", "nombre_municipio"=>"JUANACATLAN", "entidad_id"=>"14"],
            ["id"=>"052", "nombre_municipio"=>"JUCHITLAN", "entidad_id"=>"14"],
            ["id"=>"053", "nombre_municipio"=>"LAGOS DE MORENO", "entidad_id"=>"14"],
            ["id"=>"054", "nombre_municipio"=>"EL LIMON", "entidad_id"=>"14"],
            ["id"=>"055", "nombre_municipio"=>"MAGDALENA", "entidad_id"=>"14"],
            ["id"=>"056", "nombre_municipio"=>"SANTA MARIA DEL ORO", "entidad_id"=>"14"],
            ["id"=>"057", "nombre_municipio"=>"LA MANZANILLA DE LA PAZ", "entidad_id"=>"14"],
            ["id"=>"058", "nombre_municipio"=>"MASCOTA", "entidad_id"=>"14"],
            ["id"=>"059", "nombre_municipio"=>"MAZAMITLA", "entidad_id"=>"14"],
            ["id"=>"060", "nombre_municipio"=>"MEXTICACAN", "entidad_id"=>"14"],
            ["id"=>"061", "nombre_municipio"=>"MEZQUITIC", "entidad_id"=>"14"],
            ["id"=>"062", "nombre_municipio"=>"MIXTLAN", "entidad_id"=>"14"],
            ["id"=>"063", "nombre_municipio"=>"OCOTLAN", "entidad_id"=>"14"],
            ["id"=>"064", "nombre_municipio"=>"OJUELOS DE JALISCO", "entidad_id"=>"14"],
            ["id"=>"065", "nombre_municipio"=>"PIHUAMO", "entidad_id"=>"14"],
            ["id"=>"066", "nombre_municipio"=>"PONCITLAN", "entidad_id"=>"14"],
            ["id"=>"067", "nombre_municipio"=>"PUERTO VALLARTA", "entidad_id"=>"14"],
            ["id"=>"068", "nombre_municipio"=>"VILLA PURIFICACION", "entidad_id"=>"14"],
            ["id"=>"069", "nombre_municipio"=>"QUITUPAN", "entidad_id"=>"14"],
            ["id"=>"070", "nombre_municipio"=>"EL SALTO", "entidad_id"=>"14"],
            ["id"=>"071", "nombre_municipio"=>"SAN CRISTOBAL DE LA BARRANCA", "entidad_id"=>"14"],
            ["id"=>"072", "nombre_municipio"=>"SAN DIEGO DE ALEJANDRIA", "entidad_id"=>"14"],
            ["id"=>"073", "nombre_municipio"=>"SAN JUAN DE LOS LAGOS", "entidad_id"=>"14"],
            ["id"=>"074", "nombre_municipio"=>"SAN JULIAN", "entidad_id"=>"14"],
            ["id"=>"075", "nombre_municipio"=>"SAN MARCOS", "entidad_id"=>"14"],
            ["id"=>"076", "nombre_municipio"=>"SAN MARTIN DE BOLAÑOS", "entidad_id"=>"14"],
            ["id"=>"077", "nombre_municipio"=>"SAN MARTIN HidALGO", "entidad_id"=>"14"],
            ["id"=>"078", "nombre_municipio"=>"SAN MIGUEL EL ALTO", "entidad_id"=>"14"],
            ["id"=>"079", "nombre_municipio"=>"GOMEZ FARIAS", "entidad_id"=>"14"],
            ["id"=>"080", "nombre_municipio"=>"SAN SEBASTIAN DEL OESTE", "entidad_id"=>"14"],
            ["id"=>"081", "nombre_municipio"=>"SANTA MARIA DE LOS ANGELES", "entidad_id"=>"14"],
            ["id"=>"082", "nombre_municipio"=>"SAYULA", "entidad_id"=>"14"],
            ["id"=>"083", "nombre_municipio"=>"TALA", "entidad_id"=>"14"],
            ["id"=>"084", "nombre_municipio"=>"TALPA DE ALLENDE", "entidad_id"=>"14"],
            ["id"=>"085", "nombre_municipio"=>"TAMAZULA DE GORDIANO", "entidad_id"=>"14"],
            ["id"=>"086", "nombre_municipio"=>"TAPALPA", "entidad_id"=>"14"],
            ["id"=>"087", "nombre_municipio"=>"TECALITLAN", "entidad_id"=>"14"],
            ["id"=>"088", "nombre_municipio"=>"TECOLOTLAN", "entidad_id"=>"14"],
            ["id"=>"089", "nombre_municipio"=>"TECHALUTA DE MONTENEGRO", "entidad_id"=>"14"],
            ["id"=>"090", "nombre_municipio"=>"TENAMAXTLAN", "entidad_id"=>"14"],
            ["id"=>"091", "nombre_municipio"=>"TEOCALTICHE", "entidad_id"=>"14"],
            ["id"=>"092", "nombre_municipio"=>"TEOCUITATLAN DE CORONA", "entidad_id"=>"14"],
            ["id"=>"093", "nombre_municipio"=>"TEPATITLAN DE MORELOS", "entidad_id"=>"14"],
            ["id"=>"094", "nombre_municipio"=>"TEQUILA", "entidad_id"=>"14"],
            ["id"=>"095", "nombre_municipio"=>"TEUCHITLAN", "entidad_id"=>"14"],
            ["id"=>"096", "nombre_municipio"=>"TIZAPAN EL ALTO", "entidad_id"=>"14"],
            ["id"=>"097", "nombre_municipio"=>"TLAJOMULCO DE ZUÑIGA", "entidad_id"=>"14"],
            ["id"=>"098", "nombre_municipio"=>"SAN PEDRO TLAQUEPAQUE", "entidad_id"=>"14"],
            ["id"=>"099", "nombre_municipio"=>"TOLIMAN", "entidad_id"=>"14"],
            ["id"=>"100", "nombre_municipio"=>"TOMATLAN", "entidad_id"=>"14"],
            ["id"=>"101", "nombre_municipio"=>"TONALA", "entidad_id"=>"14"],
            ["id"=>"102", "nombre_municipio"=>"TONAYA", "entidad_id"=>"14"],
            ["id"=>"103", "nombre_municipio"=>"TONILA", "entidad_id"=>"14"],
            ["id"=>"104", "nombre_municipio"=>"TOTATICHE", "entidad_id"=>"14"],
            ["id"=>"105", "nombre_municipio"=>"TOTOTLAN", "entidad_id"=>"14"],
            ["id"=>"106", "nombre_municipio"=>"TUXCACUESCO", "entidad_id"=>"14"],
            ["id"=>"107", "nombre_municipio"=>"TUXCUECA", "entidad_id"=>"14"],
            ["id"=>"108", "nombre_municipio"=>"TUXPAN", "entidad_id"=>"14"],
            ["id"=>"109", "nombre_municipio"=>"UNION DE SAN ANTONIO", "entidad_id"=>"14"],
            ["id"=>"110", "nombre_municipio"=>"UNION DE TULA", "entidad_id"=>"14"],
            ["id"=>"111", "nombre_municipio"=>"VALLE DE GUADALUPE", "entidad_id"=>"14"],
            ["id"=>"112", "nombre_municipio"=>"VALLE DE JUAREZ", "entidad_id"=>"14"],
            ["id"=>"113", "nombre_municipio"=>"SAN GABRIEL", "entidad_id"=>"14"],
            ["id"=>"114", "nombre_municipio"=>"VILLA CORONA", "entidad_id"=>"14"],
            ["id"=>"115", "nombre_municipio"=>"VILLA GUERRERO", "entidad_id"=>"14"],
            ["id"=>"116", "nombre_municipio"=>"VILLA HidALGO", "entidad_id"=>"14"],
            ["id"=>"117", "nombre_municipio"=>"CAÑADAS DE OBREGON", "entidad_id"=>"14"],
            ["id"=>"118", "nombre_municipio"=>"YAHUALICA DE GONZALEZ GALLO", "entidad_id"=>"14"],
            ["id"=>"119", "nombre_municipio"=>"ZACOALCO DE TORRES", "entidad_id"=>"14"],
            ["id"=>"120", "nombre_municipio"=>"ZAPOPAN", "entidad_id"=>"14"],
            ["id"=>"121", "nombre_municipio"=>"ZAPOTILTIC", "entidad_id"=>"14"],
            ["id"=>"122", "nombre_municipio"=>"ZAPOTITLAN DE VADILLO", "entidad_id"=>"14"],
            ["id"=>"123", "nombre_municipio"=>"ZAPOTLAN DEL REY", "entidad_id"=>"14"],
            ["id"=>"124", "nombre_municipio"=>"ZAPOTLANEJO", "entidad_id"=>"14"],
            ["id"=>"125", "nombre_municipio"=>"SAN IGNACIO CERRO GORDO", "entidad_id"=>"14"],
        ];
        foreach ($municipios as $key => $obj) {
            DB::table('cat_municipios')->insert($obj);
        }
    }
}
