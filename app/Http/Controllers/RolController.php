<?php

namespace App\Http\Controllers;

use App\Models\DepartamentoHospital;
use App\Models\Parametros;
use App\Models\Rol;
use CustomPdf;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class RolController extends Controller
{
    function pdf($idRol) : void {
        $rol = Rol::with('empleados.detalles.rTurno')->find($idRol);
        $diasMes = getDiasMes($rol->anio, $rol->mes);
        $titulo = $rol->departamento->descripcion.' - '.$rol->servicio->descripcion.' ('.$rol->mes().' '.$rol->anio.')';

        $w = 195/(count($diasMes)+1);

        $parametros = Parametros::all()->toArray();
        $size1 = 16;
        $size2 = 9;
        $size3 = 7;
        /*277*/
        $h = 4;
        $h2 = 8;
        $h3 = 12;

        $pdf = new CustomPdf('L', 'mm', 'A4');
        $pdf->AddPage();
        $pdf->AliasNbPages();
        $pdf->SetTitle(encoding($titulo));
        $pdf->SetFillColor(247,201,91);
        $pdf->setFont('Helvetica');
        $pdf->setFontSize($size1);
        $pdf->Cell(0, $h, $parametros[0]['valor'], 0, 1, 'C');
        /* $pdf->Cell(0, $h, $parametros[1]['valor'], 1, 1, 'C'); */
        //$pdf->Image(public_path('images/logo alto inclan_h.png'), 235, 4, 50, 0, 'PNG');
        $pdf->Ln(); 

        $pdf->setFontSize($size2);
        $pdf->setBold(true);
        $pdf->Cell(15, $h, 'Area:');
        $pdf->setBold(false);
        $pdf->Cell(127, $h, encoding($rol->departamento->descripcion. ' - ' .$rol->servicio->descripcion));
        $pdf->setBold(true);
        $pdf->Cell(20, $h, encoding('Período:'));
        $pdf->setBold(false);
        $pdf->Cell(115, $h, $rol->mes(). ' - ' .$rol->anio.' ('.$rol->estado->descripcion.')',0,1);

        $pdf->setFontSize($size2);
        $pdf->setBold(true);
        $pdf->Cell(15, $h, 'Registra:');
        $pdf->setBold(false);
        $pdf->Cell(127, $h, encoding($rol->registra->nombreCompleto(). ' (' .$rol->fechaCreacion().')'));
        $pdf->setBold(true);
        $pdf->Cell(20, $h, encoding('Valida:'));
        $pdf->setBold(false);
        $pdf->Cell(115, $h, encoding($rol->revisa->nombreCompleto(). ' (' .$rol->fechaRevision().')'),0,1);

        $pdf->setFontSize($size2);
        $pdf->setBold(true);
        $pdf->Cell(27, $h, 'Observaciones:');
        $pdf->setBold(false);
        $pdf->MultiCell(250, $h, encoding($rol->observaciones));

        $pdf->Ln(2);
        $pdf->Line($pdf->getX(), $pdf->getY(), $pdf->getX()+277, $pdf->getY());
        $pdf->Ln();

        $pdf->setBold(true);
        $pdf->setFontSize($size2);
        $pdf->Cell(7, $h3, encoding('N°'),1,0,'C',1);
        $pdf->Cell(75, $h3, 'Nombres',1,0,'C',1);

        $x = $pdf->GetX();

        foreach ($diasMes as $i => $dia) {
            $pdf->Cell($w, $h3/2, $i,1,0,'C',1);
        }
        $pdf->Cell($w, $h3, '',1,0,'C',1);
        $pdf->RotatedText($pdf->getX()-1.5,$pdf->getY()+$h3-1,'Horas',90);

        $y = $pdf->getY();
        $pdf->Ln();
        //$pdf->setX($x+100);
        $pdf->SetLeftMargin(92);
        $pdf->setY($y+$h3/2);
        foreach ($diasMes as $i => $dia) {
            $pdf->Cell($w, $h3/2, $dia['inicial'],1,0,'C',1);
        }
        $pdf->SetLeftMargin(10);
        $pdf->setFont('Courier','', $size3);
        $pdf->Ln();

        foreach ($rol->empleados as $i => $empleado){
            $pdf->Cell(7, $h2, ($i+1),1,0,'C');

            $x = $pdf->getX();
            $y = $pdf->getY();
            $pdf->Cell(75, $h2/2, mayusculas($empleado->empleado->nombreCompleto()),0,1);

            $pdf->SetX($x);
            $pdf->Cell(75, $h2/2, mayusculas($empleado->empleado->cargo?->descripcion),'B');
            $pdf->SetXY($x+75, $y);
            $totalHoras = 0;
            foreach ($diasMes as $i => $dia) {
                $turno = "";
                foreach ($empleado->detalles as $detalle) {

                    if($detalle->dia == $i) {
                        $turno = $detalle->turno;
                        $totalHoras += $detalle->rTurno->horas;
                    }
                }
                $pdf->Cell($w, $h2, $turno,1,0,'C');
            }
            $pdf->Cell($w, $h2, $totalHoras,1,0,'C');

            $pdf->Ln();
        }


        $pdf->Output('I', encoding($titulo).'.pdf');
        exit();
    }

    function resumenRol(Request $request) : void {

        $anio = $request->get('anio');
        $mes = $request->get('mes');
        $meses = getMeses();

        /* $roles = Rol::with('empleados.detalles.rTurno')->where(['anio' => $anio, 'mes' => $mes, 'estadoId' => 2])->get()->toArray(); */
        $roles = Rol::with(['empleados.empleado.cargo', 'empleados.detalles.rTurno'])
                    ->where(['anio' => $anio, 'mes' => $mes, 'estadoId' => 2])
                    ->get();
        $empleadosCollection = $roles->flatMap(function ($rol) {
            return $rol->empleados->map(function ($empleado) {
                return $empleado; // Devuelve el empleado directamente
            });
        });
        $empleadosCollection = $empleadosCollection->sortBy(function ($empleado) {
            return $empleado->empleado->cargo?->ordenRolConsolidado;
        });

        $diasMes = getDiasMes($anio, $mes);
        $titulo = 'Resumen rol ('.$meses[$mes].' '.$anio.')';

        $w = 195/(count($diasMes));

        $parametros = Parametros::all()->toArray();
        $size1 = 12;
        $size2 = 9;
        $size3 = 7;
        /*277*/
        $h = 4;
        $h2 = 8;
        $h3 = 12;

        $pdf = new CustomPdf('L', 'mm', 'A4');
        $pdf->AddPage();
        $pdf->AliasNbPages();
        $pdf->SetTitle(encoding($titulo));
        $pdf->SetFillColor(247,201,91);
        $pdf->setFont('Courier');
        $pdf->setFontSize($size1);
        $pdf->setBold(true);
        $pdf->Cell(0, $h, 'PROGRAMACION DE ASISTENCIA DE PERSONAL', 0, 1, 'C');
        $pdf->Cell(0, $h, $parametros[0]['valor'].' '.$meses[$mes].' '.$anio, 0, 1, 'C');

        $pdf->Ln(2);

        
        $pdf->setFontSize($size2);
        $pdf->Cell(7, $h3, encoding('N°'),1,0,'C',1);
        $pdf->Cell(75, $h3, 'Nombres',1,0,'C',1);

        $x = $pdf->GetX();

        foreach ($diasMes as $i => $dia) {
            $pdf->Cell($w, $h3/2, $i,1,0,'C',1);
        }

        $y = $pdf->getY();
        $pdf->Ln();
        
        $pdf->SetLeftMargin(92);
        $pdf->setY($y+$h3/2);
        foreach ($diasMes as $i => $dia) {
            $pdf->Cell($w, $h3/2, $dia['inicial'],1,0,'C',1);
        }
        $pdf->SetLeftMargin(10);
        $pdf->setFont('Courier','', $size3);
        $pdf->Ln();

        /* foreach ($empleadosCollection as $i => $empleado){
            $pdf->Cell(7, $h2, ($i+1),1,0,'C');

            $x = $pdf->getX();
            $y = $pdf->getY();
            $pdf->Cell(75, $h2/2, mayusculas($empleado->empleado->nombreCompleto()),0,1);

            $pdf->SetX($x);
            $pdf->Cell(75, $h2/2, mayusculas($empleado->empleado->cargo?->descripcion),'B');
            $pdf->SetXY($x+75, $y);
            $totalHoras = 0;
            foreach ($diasMes as $i => $dia) {
                $turno = "";
                foreach ($empleado->detalles as $detalle) {
                    if($detalle->dia == $i) {
                        $turno = $detalle->turno;
                        $totalHoras += $detalle->rTurno->horas;
                    }
                }
                $pdf->Cell($w, $h2, $turno,1,0,'C');
            }
            $pdf->Cell($w, $h2, $totalHoras,1,0,'C');

            $pdf->Ln();
        } */
        $cargo = "";
        foreach ($empleadosCollection as $i => $empleado){
            if($cargo != $empleado->empleado->cargo?->id){
                $cargo = $empleado->empleado->cargo?->id;
                $pdf->setBold(true);
                $pdf->Cell(7, $h, '','BLR',0,'C');
                $pdf->Cell(195+75, $h, mayusculas($empleado->empleado->cargo?->descripcion),'BLR',1);
                $pdf->setBold(false);
            }
            $pdf->Cell(7, $h, ($i+1),'BLR',0,'C');
            $x = $pdf->getX();
            $y = $pdf->getY();
            $pdf->Cell(75, $h, mayusculas($empleado->empleado->nombreCompleto()),'BR',0);
            $totalHoras = 0;
            foreach ($diasMes as $i => $dia) {
                $turno = "";
                foreach ($empleado->detalles as $detalle) {
                    if($detalle->dia == $i) {
                        $turno = $detalle->turno;
                        $totalHoras += $detalle->rTurno->horas;
                    }
                }
                $pdf->Cell($w, $h, $turno,'BR',0,'C');
            }
            /* $pdf->Cell($w, $h, $totalHoras,'BR',0,'C'); */

            $pdf->Ln();
        }

        $pdf->Output('I', encoding($titulo).'.pdf');
        exit();
    }

    function generalPdf(Request $request) {
        $anio = $request->get('anio');
        $mes = $request->get('mes');
        $idDepartamento = $request->get('departamento');
        $search = $request->get('search');

        $meses = getMeses();

        $departamentosRol = DepartamentoHospital::
                        whereHas('servicios.roles', function($q) use ($anio, $mes, $idDepartamento, $search) {
                            $q->where('estadoId', 2)
                                ->where('anio', $anio)
                                ->where('mes', $mes)
                                ->when(!empty($idDepartamento), function($qq) use ($idDepartamento){
                                    $qq->where('departamentoId', $idDepartamento);
                                })
                                ->when(!empty($search), function($qq) use ($search) {
                                    $qq->wherehas('empleados.empleado', function($qqq) use ($search){
                                        $qqq->search($search);
                                    });
                                });
                        })
                        ->with(['servicios.roles' => function($q) use ($anio, $mes, $idDepartamento, $search){
                                $q->with('empleados.detalles.rTurno')
                                    ->where('estadoId', 2)
                                    ->where('anio', $anio)
                                    ->where('mes', $mes)
                                    ->when(!empty($idDepartamento), function($qq) use ($idDepartamento){
                                        $qq->where('departamentoId', $idDepartamento);
                                    })
                                    ->when(!empty($search), function($qq) use ($search){
                                        $qq->with('empleados.empleado', function($qqq) use ($search){
                                            $qqq->search($search);
                                        });
                                    });
                            }
                        ])
                        ->orderBy('descripcion')
                        ->get();


        $departamentosRol->each(function ($departamento) {
            $departamento->setRelation('servicios', $departamento->servicios->filter(function ($servicio) {
                // Filtrar roles que no tienen empleados con empleado
                $servicio->setRelation('roles', $servicio->roles->filter(function ($rol) {
                    $rol->setRelation('empleados', $rol->empleados->filter(function ($empleado) {
                        return $empleado->empleado !== null;
                    }));
                    return $rol->empleados->isNotEmpty();
                }));
                return $servicio->roles->isNotEmpty();
            }));
        });

        // Eliminar los departamentos que no tienen servicios después del filtrado
        $departamentosRol = $departamentosRol->filter(function ($departamento) {
            return $departamento->servicios->isNotEmpty();
        });



        $diasMes = getDiasMes($anio, $mes);
        $titulo = 'Rol General ('.$meses[$mes].' '.$anio.')';

        $w = 195/(count($diasMes));

        $parametros = Parametros::all()->toArray();
        $size1 = 12;
        $size2 = 9;
        $size3 = 7;
        /*277*/
        $h = 4;
        $h2 = 8;
        $h3 = 12;

        $pdf = new CustomPdf('L', 'mm', 'A4');
        $pdf->AddPage();
        $pdf->AliasNbPages();
        $pdf->SetTitle(encoding($titulo));

        $pdf->SetFillColor(247,201,91);

        $pdf->setFont('Courier');
        $this->cabeceraGeneralPdf($pdf, $h, $h3, $size1, $size2, $w, $diasMes, $meses, $mes, $anio, $parametros);

        foreach ($departamentosRol as $dep) {
            $pdf->setBold(true);
            $pdf->setFontSize($size2);
            $pdf->setTextColorType("danger");
            $pdf->Cell(0, $h2, encoding($dep->descripcion),1,1,'C');
            $pdf->setBold(false);
            foreach ($dep->servicios as $serv) {
                $pdf->setBold(true);
                $pdf->setTextColorType("primary");
                $pdf->setFontSize($size2);
                $pdf->Cell(0, $h, encoding($serv->descripcion),1,1);
                $pdf->setBold(false);

                $pdf->setTextColorType();
                $pdf->setFontSize($size3);
                
                foreach ($serv->roles[0]->empleados as $i => $empleado){
                    
                    if(round($pdf->GetPageHeight(),2)-round($pdf->GetY(),2) <= 31){
                        $pdf->AddPage();
                        $this->cabeceraGeneralPdf($pdf, $h, $h3, $size1, $size2, $w, $diasMes, $meses, $mes, $anio, $parametros);
                    }
                    $pdf->Cell(7, $h2, ($i+1),1,0,'C');
        
                    $x = $pdf->getX();
                    $y = $pdf->getY();
                    $pdf->Cell(75, $h2/2, mayusculas($empleado->empleado->nombreCompleto()),0,1);
        
                    $pdf->SetX($x);
                    $pdf->Cell(75, $h2/2, mayusculas($empleado->empleado->cargo?->descripcion),'B');
                    $pdf->SetXY($x+75, $y);
                    $totalHoras = 0;
                    foreach ($diasMes as $i => $dia) {
                        $turno = "";
                        foreach ($empleado->detalles as $detalle) {
                            if($detalle->dia == $i) {
                                $turno = $detalle->turno;
                                $totalHoras += $detalle->rTurno->horas;
                            }
                        }
                        $pdf->Cell($w, $h2, $turno,1,0,'C');
                    }
        
                    $pdf->Ln();
                }
            }
        }

        $pdf->Output('I', encoding($titulo).'.pdf');
        exit();

    }
    
    function cabeceraGeneralPdf($pdf, $h, $h3, $size1, $size2, $w, $diasMes, $meses, $mes, $anio, $parametros) : void {
        
        $pdf->setFontSize($size1);
        $pdf->setBold(true);
        $pdf->Cell(0, $h, 'PROGRAMACION DE PERSONAL', 0, 1, 'C');
        $pdf->Cell(0, $h, $parametros[0]['valor'].' '.$meses[$mes].' '.$anio, 0, 1, 'C');

        $pdf->Ln(2);

        
        $pdf->setFontSize($size2);
        $pdf->Cell(7, $h3, encoding('N°'),1,0,'C',1);
        $pdf->Cell(75, $h3, 'Nombres',1,0,'C',1);

        $x = $pdf->GetX();

        foreach ($diasMes as $i => $dia) {
            $pdf->Cell($w, $h3/2, $i,1,0,'C',1);
        }

        $y = $pdf->getY();
        $pdf->Ln();
        
        $pdf->SetLeftMargin(92);
        $pdf->setY($y+$h3/2);
        foreach ($diasMes as $i => $dia) {
            $pdf->Cell($w, $h3/2, $dia['inicial'],1,0,'C',1);
        }
        $pdf->SetLeftMargin(10);
        $pdf->setFont('Courier','', $size2);
        $pdf->Ln();
    }

    function generalXls(Request $request){
        $anio = $request->get('anio');
        $mes = $request->get('mes');
        $idDepartamento = $request->get('departamento');

        $diasMes = getDiasMes($anio, $mes);

        $departamentosRol = DepartamentoHospital::with([
                                    'servicios.roles' => function($q) use ($anio, $mes, $idDepartamento){
                                        $q->with('empleados.detalles.rTurno')
                                            ->where('estadoId', 2)
                                            ->where('anio', $anio)
                                            ->where('mes', $mes)
                                            ->when(!empty($idDepartamento), function($qq) use ($idDepartamento){
                                                $qq->where('departamentoId', $idDepartamento);
                                            });
                                    }
                                ])
                                ->whereHas('servicios.roles', function($q) use ($anio, $mes, $idDepartamento){
                                    $q->where('estadoId', 2)
                                        ->where('anio', $anio)
                                        ->where('mes', $mes)
                                        ->when(!empty($idDepartamento), function($qq) use ($idDepartamento){
                                            $qq->where('departamentoId', $idDepartamento);
                                        });
                                })
                                ->get();

        $titulo = "Role de personal";

        $bodyStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_HAIR, // Establecer el estilo del borde
                    'color' => ['rgb' => '000000'], // Establecer el color del borde (en este caso, negro)
                ],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
        ];
        $headerStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_HAIR, // Establecer el estilo del borde
                    'color' => ['rgb' => '000000'], // Establecer el color del borde (en este caso, negro)
                ],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Centrar texto
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, // Tipo de relleno sólido
                'startColor' => ['argb' => 'D8E4BC'], // Color de fondo (en este caso, verde claro)
            ],
        ];

        $departamentoStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, // Establecer el estilo del borde
                    'color' => ['rgb' => '000000'], // Establecer el color del borde (en este caso, negro)
                ],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, // Tipo de relleno sólido
                'startColor' => ['argb' => 'FCD5B4'], // Color de fondo (en este caso, amarillo)
            ],
            'font' => [
                'bold' => true,
                'size' => 16
            ]
        ];
        $servicioStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, // Establecer el estilo del borde
                    'color' => ['rgb' => '000000'], // Establecer el color del borde (en este caso, negro)
                ],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, // Tipo de relleno sólido
                'startColor' => ['argb' => 'DCE6F1'], // Color de fondo (en este caso, amarillo)
            ],
            'font' => [
                'bold' => true,
                'size' => 12
            ]
        ];

        $ini = 1;

        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setTitle('Rol');
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(30);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(10);
        for ($i = 5; $i <= 45 ; $i++) {
            $sheet->getColumnDimension(numeroLetra($i))->setWidth(5);
        }
        $sheet->getStyle('A'.$ini.':'.numeroLetra(count($diasMes)+5).($ini+1))->applyFromArray($headerStyle);
        

        

        /* $sheet->setCellValue('A'.$ini, 'N°')
                ->setCellValue('B'.$ini, 'APELLIDOS Y NOMBRES')
                ->setCellValue('C'.$ini, 'CARGO')
                ->setCellValue('D'.$ini, 'CONTRATO'); */

        $sheet->mergeCells('A'.$ini.':A'.$ini+1)->setCellValue('A'.$ini,'N°');
        $sheet->mergeCells('B'.$ini.':B'.$ini+1)->setCellValue('B'.$ini,'APELLIDO Y NOMBRES');
        $sheet->mergeCells('C'.$ini.':C'.$ini+1)->setCellValue('C'.$ini,'CARGO');
        $sheet->mergeCells('D'.$ini.':D'.$ini+1)->setCellValue('D'.$ini,'CONTRATO');
        
        $iniTurnos = 4;

        foreach ($diasMes as $i => $dia) {
            $letra = numeroLetra($iniTurnos + $i);
            $sheet->setCellValue($letra.$ini, $i)
                    ->setCellValue($letra.$ini+1, $dia['inicial']);
        }

        $sheet->mergeCells(numeroLetra($iniTurnos + count($diasMes) + 1).$ini.':'.numeroLetra($iniTurnos + count($diasMes) + 1).$ini+1)
                ->setCellValue(numeroLetra($iniTurnos + count($diasMes) + 1).$ini,'TOTAL');         

        $ini += 2;

        foreach ($departamentosRol as $departamento) {
            $sheet->mergeCells('A'.$ini.':'.numeroLetra(count($diasMes)+5).$ini)
                    ->setCellValue('A'.$ini, $departamento->descripcion)
                    ->getStyle('A'.$ini.':'.numeroLetra(count($diasMes)+5).$ini)->applyFromArray($departamentoStyle);
            $ini++;
            foreach ($departamento->servicios as $servicio) {
                if($servicio->roles->count() > 0){
                    $sheet->mergeCells('A'.$ini.':'.numeroLetra(count($diasMes)+5).$ini)
                            ->setCellValue('A'.$ini, $servicio->descripcion)
                            ->getStyle('A'.$ini.':'.numeroLetra(count($diasMes)+5).$ini)->applyFromArray($servicioStyle);
                    $ini++;
                    foreach ($servicio->roles[0]->empleados as $i => $empleado) {
                        $emp = $empleado->empleado;
                        $sheet->setCellValue('A'.$ini, $i+1)
                                ->setCellValue('B'.$ini, $emp->nombreCompleto())
                                ->setCellValue('C'.$ini, $emp->cargo?->descripcion)
                                ->setCellValue('D'.$ini, $emp->contrato?->descripcion);
                            
                        foreach ($diasMes as $i => $dia) {
                            $turno = $empleado->detalles->where('dia', $i)->first();
                            if(!is_null($turno)){
                                $letra = numeroLetra($i + 4);
                                $sheet->setCellValue($letra.$ini, $turno->turno);
                            }
                        }
                        $ini++;
                    }
                }
            }
            
        }



        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$titulo.'.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
    }
}
