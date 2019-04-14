<?php

namespace App\Http\Controllers;

use App\Employee;
use Illuminate\Http\Request;

class EmployeesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('/');
        }

        $buscar = $request->buscar;

        $criterio = $request->criterio;

        if ($buscar == "") {
            $empleados = Employee::orderBy('id', 'desc')->paginate(7);
        } else {
            $empleados = Employee::where($criterio, 'like', '%' . $buscar . '%')->orderBy('id', 'desc')->paginate(7);
        }

        return [
            'pagination' => [
                'total'        => $empleados->total(),
                'current_page' => $empleados->currentPage(),
                'per_page'     => $empleados->perPage(),
                'last_page'    => $empleados->lastPage(),
                'from'         => $empleados->firstItem(),
                'to'           => $empleados->lastItem(),
            ],
            'empleados'  => $empleados,
        ];

    }

    /**
     * Show the form for creating a new resource.


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('/');
        }

        $empleado                 = new Employee();
        $empleado->tipo_documento = $request->tipo_documento;
        $empleado->documento      = $request->documento;
        $empleado->nombre         = $request->nombre;
        $empleado->apellido       = $request->apellido;
        $empleado->direccion      = $request->direccion;
        $empleado->telefono       = $request->telefono;
        $empleado->email          = $request->email;
        $empleado->estado         = $request->estado;

        $empleado->save();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if (!$request->ajax()) {
            return redirect('/');
        }

        $empleado                 = Employee::findOrFail($request->id);
        $empleado->tipo_documento = $request->tipo_documento;
        $empleado->documento      = $request->documento;
        $empleado->nombre         = $request->nombre;
        $empleado->apellido       = $request->apellido;
        $empleado->direccion      = $request->direccion;
        $empleado->telefono       = $request->telefono;
        $empleado->email          = $request->email;
        $empleado->estado         = $request->estado;
        $empleado->update();
    }

    public function delete($id)
    {
        $empleado = Employee::findOrFail($id);
        $empleado->delete();
    }

}
