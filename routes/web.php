<?php

use App\Livewire\Administracion\Rol;
use App\Livewire\Administracion\Usuario;
use App\Livewire\Configuracion\Departamento;
use App\Livewire\Configuracion\Servicio;
use App\Livewire\Inicio;
use App\Livewire\Perfil;
use App\Livewire\Permiso\FormSolicitud;
use App\Livewire\Permiso\MisPermisos;
use App\Livewire\Permiso\Solicitud;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
/* Route::get('excel', function(){
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="myfile.xlsx"');
    header('Cache-Control: max-age=0');

    $spreadsheet = new Spreadsheet();
    $activeWorksheet = $spreadsheet->getActiveSheet();
    $activeWorksheet->setCellValue('A1', 'Hello World !');

    $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
    $writer->save('php://output');
}); */

Route::get('permiso/solicita', FormSolicitud::class)->name('permiso.solicita');

Route::group(['middleware'=> 'auth'],function() {
    Route::get('perfil', Perfil::class)->name('perfil');

    Route::get('inicio', Inicio::class)->name('inicio');
    
    Route::prefix('rol')->group(function () {
        Route::get('general', App\Livewire\Rol\General::class)->name('rol.general');
        Route::get('administracion', App\Livewire\Rol\Administracion::class)->name('rol.administracion');

        Route::get('pdf/{idRol}', [App\Http\Controllers\RolController::class, 'pdf'])->name('rol.pdf');
        Route::get('general-xlsx/', [App\Http\Controllers\RolController::class, 'generalXls'])->name('rol.general-xlsx');
    });
    Route::prefix('configuracion')->group(function () {
        Route::get('departamento', Departamento::class)->name('configuracion.departamento');
        Route::get('servicio', Servicio::class)->name('configuracion.servicio');
    });

    Route::prefix('administracion')->group(function () {
        Route::get('usuario', Usuario::class)->name('administracion.usuario');
        Route::get('rol', Rol::class)->name('administracion.rol');
    });

    Route::prefix('permiso')->group(function () {
        Route::get('solicitud', Solicitud::class)->name('permiso.solicitud');
        Route::get('mis-permisos', MisPermisos::class)->name('permiso.mis-permisos');
    });

    Route::prefix('asistencia')->group(function () {
        Route::get('mis-marcaciones', App\Livewire\Asistencia\MisMarcaciones::class)->name('asistencia.mis-marcaciones');
        Route::get('registros', App\Livewire\Asistencia\Registros::class)->name('asistencia.registros');
    });
});