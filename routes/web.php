<?php

use App\Livewire\Administracion\Rol;
use App\Livewire\Administracion\Usuario;
use App\Livewire\Configuracion\Cargo;
use App\Livewire\Configuracion\Departamento;
use App\Livewire\Configuracion\Profesion;
use App\Livewire\Configuracion\Servicio;
use App\Livewire\Inicio;
use App\Livewire\Perfil;
use App\Livewire\Permiso\FormSolicitud;
use App\Livewire\Permiso\MisPermisos;
use App\Livewire\Permiso\Solicitud;
use Illuminate\Support\Facades\Route;
use App\Livewire\Cie10\Cie10;
use App\Livewire\Configuracion\SubServicio;
use App\Livewire\AnexoTelefonico\Anexo;
/*------ticket---*/
use App\Livewire\Tickets\Ticket;
use App\Livewire\Tickets\Listar as TicketListar;

/*OTM */
use App\Livewire\Otm\MisOtm;
use App\Livewire\Otm\FormOtm;


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
Route::get('cie10', Cie10::class)->name('cie10');
Route::get('anexo', Anexo::class)->name('anexo');

Route::group(['middleware'=> 'auth'],function() {
    Route::get('perfil', Perfil::class)->name('perfil');

    Route::get('inicio', Inicio::class)->name('inicio');
    
    Route::prefix('rol')->group(function () {
        Route::get('general', App\Livewire\Rol\General::class)->name('rol.general');
        Route::get('administracion', App\Livewire\Rol\Administracion::class)->name('rol.administracion');

        Route::get('pdf/{idRol}', [App\Http\Controllers\RolController::class, 'pdf'])->name('rol.pdf');
        Route::get('general-xlsx/', [App\Http\Controllers\RolController::class, 'generalXls'])->name('rol.general-xlsx');
        Route::get('general-pdf/', [App\Http\Controllers\RolController::class, 'generalPdf'])->name('rol.general-pdf');
        Route::get('resumen/', [App\Http\Controllers\RolController::class, 'resumenRol'])->name('rol.resumen');
    });
    Route::prefix('configuracion')->group(function () {
        Route::get('departamento', Departamento::class)->name('configuracion.departamento');
        Route::get('servicio', Servicio::class)->name('configuracion.servicio');
        Route::get('profesion', Profesion::class)->name('configuracion.profesion');
        Route::get('cargo', Cargo::class)->name('configuracion.cargo');
        Route::get('subServicio', SubServicio::class)->name('configuracion.sub-servicio');
    });

    Route::prefix('administracion')->group(function () {
        Route::get('usuario', Usuario::class)->name('administracion.usuario');
        Route::get('rol', Rol::class)->name('administracion.rol');
    });

    Route::prefix('permiso')->group(function () {
        Route::get('solicitud', Solicitud::class)->name('permiso.solicitud');
        Route::get('mis-permisos', MisPermisos::class)->name('permiso.mis-permisos');
    });

    Route::prefix('ticket')->group(function () {
        Route::get('ticket', Ticket::class)->name('ticket.ticket');
        Route::get('listar', TicketListar::class)->name('ticket.listar');
    });

    Route::prefix('asistencia')->group(function () {
        Route::get('mis-marcaciones', App\Livewire\Asistencia\MisMarcaciones::class)->name('asistencia.mis-marcaciones');
        Route::get('registros', App\Livewire\Asistencia\Registros::class)->name('asistencia.registros');
        Route::get('buscar-marcaciones', App\Livewire\Asistencia\BuscarMarcaciones::class)->name('asistencia.buscar-marcaciones');
    });

    Route::prefix('empleado')->group(function () {
        Route::get('buscar', [App\Http\Controllers\EmpleadoController::class, 'buscarEmpleado'])->name('empleado.buscar');
    });

    Route::prefix('equipo')->group(function () {
        Route::get('buscar', [App\Http\Controllers\EquipoController::class, 'buscarEquipo'])->name('equipo.buscar');
    });

    Route::prefix('otm')->group(function () {
        Route::get('mis-otm', MisOtm::class)->name('otm.mis-otm');
        Route::get('form-otm/{id}', FormOtm::class)->name('otm.form-otm');
    });



    
});