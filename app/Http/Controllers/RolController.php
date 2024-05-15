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
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, // Tipo de relleno sólido
                'startColor' => ['argb' => 'D8E4BC'], // Color de fondo (en este caso, amarillo)
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
        $sheet->getColumnDimension('B')->setWidth(25);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(15);
        for ($i = 3; $i <= 45 ; $i++) {
            $sheet->getColumnDimension(numeroLetra($i))->setWidth(5);
        }
        $sheet->getStyle('A'.$ini.':'.numeroLetra(count($diasMes)+5).($ini+1))->applyFromArray($headerStyle);
        $sheet->freezePane('A3');

        

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
