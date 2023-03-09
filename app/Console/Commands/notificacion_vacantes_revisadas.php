<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\controllers\VacanteController;
use App\Services\CorreosService;
use Illuminate\Support\Facades\Storage;
use App\Models\VacanteSolicitante;


class notificacion_vacantes_revisadas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notificacion:vacantes_revisadas';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Manda notificacion si la empresa llava mas de 3 dias con una postulacion en estatus Visto ';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $fecha_actual = strtotime(date("d-m-Y H:i:00", time()));
        $cosa = VacanteSolicitante::all();
        // $solicitudesDTO = ParseDTO::list($cosa, SolicitudDto::class);

        foreach ($cosa as $fecha) {

            if ($fecha['updated_at'] != null) {
                $hora = $fecha['updated_at']->format('Y/m/d H:i:00');
                if ($fecha_actual - $hora = 3) {
                    return "La fecha actual es mayor a la comparada";
                } else {
                    return "La fecha comparada es igual o menor";
                }
            } else {
                $hora = $fecha['created_at']->format('Y/m/d H:i:00');
                if ($fecha_actual - $hora = 3) {
                    return "La fecha actual es mayor a la comparada";
                } else {
                    return "La fecha comparada es igual o menor";
                }
            }
        }


        $data = array(
            'remitente' => null,
            'destinatario' => $cosa->id_solicitante,
            'asunto' => '¡Recibimos tu solicitud!',
            'cuerpo' => "Tu solicitud para la vacante " . $cosa->rel_vacantes[0]['vacante'] . " se ha procesado correctamente",
            'titulo' => ''
        );
        CorreosService::guardarYEnviar($data);
        // return 0;

    }
}
