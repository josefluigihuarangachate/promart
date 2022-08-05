<?php

namespace App\Http\Controllers;

use App\Models\Clientes;
use Illuminate\Http\Request;
// Agregar 
use Laravel\Passport\HasApiTokens;
use Auth;
use Exception;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use \Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View; // Nuevo
use Illuminate\Support\Facades\File; // Nuevo
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use Illuminate\Support\Facades\Input;

include 'tools/string.php'; // Si funciona
include 'tools/function.php'; // Si funciona
include 'tools/json.php'; // Si funciona
// Fin Agregar

class ClientesController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listclientes() {
        $cliente = DB::table('clientes')
                ->select(
                        'id as Codigo_Cliente',
                        'nombre as Nombre_Cliente',
                        'apellido as Apellido_Cliente',
                        'edad as Edad_Cliente',
                        'fechanacimiento as FecNacimiento_Cliente',
                )
                ->get();
        $data = objectToArray($cliente);
        if ($data) {

            // PROBABILIDAD DE MUERTE
            for ($i = 0; $i < count($data); $i++) {
                $data[$i]['AnioProbabilidadMuerte'] = probabilidaddemuerteanio($data[$i]['FecNacimiento_Cliente']);
                $data[$i]['EdadProbabilidadMuerte'] = probabilidaddemuerteedad($data[$i]['Edad_Cliente']);
            }

            $json = json('ok', strings('success_read'), $data);
        } else {
            $json = json('error', strings('error_read'), '');
        }
        return jsonPrint($json);
    }

    public function kpideclientes() {
        $cliente = DB::table('clientes')
                ->select(
                        'id as Codigo_Cliente',
                        'nombre as Nombre_Cliente',
                        'apellido as Apellido_Cliente',
                        'edad as Edad_Cliente',
                        'fechanacimiento as FecNacimiento_Cliente',
                )
                ->get();
        $data = objectToArray($cliente);
        if ($data) {

            // PROBABILIDAD DE MUERTE
            $desviacionestandaredad = [];
            for ($i = 0; $i < count($data); $i++) {
                $desviacionestandaredad[] = $data[$i]['Edad_Cliente'];
            }

            $json = json('ok', strings('success_read'), $data);
            $json['PromediodeEdad'] = array_sum($desviacionestandaredad) / count($desviacionestandaredad);
            $json['DesviacionEstandar'] = Stand_Deviation($desviacionestandaredad);
        } else {
            $json = json('error', strings('error_read'), '');
        }
        return jsonPrint($json);
    }

    public function creacliente(Request $request) {
        $nombre = inputs($request->input('nombre'));
        $apellido = inputs($request->input('apellido'));
        $edad = inputs($request->input('edad'));
        $fecnacimiento = inputs($request->input('fecnacimiento'));

        if (
                !empty($nombre) &&
                !empty($apellido) &&
                !empty($edad) &&
                !empty($fecnacimiento)
        ) {
            try {
                $id = DB::table('clientes')->insertGetId(
                        [
                            'nombre' => $nombre,
                            'apellido' => $apellido,
                            'edad' => $edad,
                            'fechanacimiento' => $fecnacimiento
                        ],
                );
                if ($id) {
                    $json = json('ok', strings('success_create'), '');
                } else {
                    $json = json('error', strings('error_create'), '');
                }
            } catch (ArithmeticError | Exception $e) {
                if (intval($e->getCode()) == 23000) {
                    $json = json('error', strings('error_duplicate'), '');
                } else {
                    $json = json('error', strings('error_create'), '');
                }
            }
        } else {
            $json = json('error', strings('error_empty'), '');
        }
        return jsonPrint($json);
    }

    public function index() {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Clientes  $clientes
     * @return \Illuminate\Http\Response
     */
    public function show(Clientes $clientes) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Clientes  $clientes
     * @return \Illuminate\Http\Response
     */
    public function edit(Clientes $clientes) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Clientes  $clientes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Clientes $clientes) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Clientes  $clientes
     * @return \Illuminate\Http\Response
     */
    public function destroy(Clientes $clientes) {
        //
    }

}
