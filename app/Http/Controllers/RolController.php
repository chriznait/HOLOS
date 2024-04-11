<?php

namespace App\Http\Controllers;

use App\Models\Parametros;
use App\Models\Rol;
use CustomPdf;

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
            $pdf->Cell(75, $h2/2, mayusculas($empleado->empleado->cargo->descripcion),'B');
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
}
