<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\VacanteService;



class notificacion_vacantes_revisadas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notificacion_vacantes_revisadas';

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
        VacanteService::NotificacionEstatusVacantesDesactualizado();

    }
}
