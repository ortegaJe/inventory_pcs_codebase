<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>InventorioPC | Reporte generado</title>
</head>

<body>
  <table style="border-collapse: collapse; width: 100%;">
    <tbody>
      <tr>
        <td style="width: 100%; border-style: hidden;">
          <table style="height: 273px; width: 100%; border-collapse: collapse;" border="1">
            <tbody>
              <tr style="height: 10px;">
                <td style="width: 21.0318%; height: 20px;" rowspan="2" align="middle" valign="top">
                  <p style="text-align: center;"><img style="display: block; margin: auto;"
                      src="https://viva1a.com.co/wp-content/uploads/2023/01/cropped-LogoViva1A-IPS-VARIACION-min.png"
                      alt="" width="150" height="50" hspace="2" vspace="13" /></p>
                </td>
                <td style="width: 57.0634%; height: 10px;">
                  <p style="text-align: center;"><strong>Centro Tecnolog&iacute;a Inteligencia
                    </strong></p>
                  <p style="text-align: center;"><strong>Innovaci&oacute;n (CETII)</strong></p>
                </td>
                <td style="width: 13.7412%; height: 10px; text-align: center;"><strong>Proceso:
                    <br /></strong>Tecnolog&iacute;a</td>
              </tr>
              <tr style="height: 10px;">
                <td style="width: 57.0634%; height: 10px; text-align: center;"><strong>Actas De Entrega
                    De Entrega
                    Equipos
                    TI<br />
                </td>
                <td></td>
                {{-- </strong>VERSION ENT 001-1
                <td style="width: 13.7412%; height: 10px; text-align: center;"><strong>Fecha:
                    25-01-2018</strong></td> --}}
              </tr>
              @foreach($reportDelivery as $repo)
              <tr>
                <td style="width: 91.8364%;" colspan="3">
                  <p style="text-align: center;"><strong>Acta de Entrega de Equipos
                      Computacionales</strong></p>
                  <p style="text-align: justify; font-size: 14px">Hoy {{ $repo->Dia }}
                    del mes de
                    <?php $dt = \Carbon\Carbon::parse($repo->Mes); setlocale(LC_TIME, 'Spanish');
                    echo $dt->localeMonth;?>
                    de {{ $repo->Anio }}, mediante el presente documento se
                    realiza la entrega formal de los equipos computacionales que se indican el punto
                    2.-&nbsp;
                    EQUIPOS COMPUTACIONALES ASIGNADOS para el cumplimiento de las actividades
                    laborales del
                    FUNCIONARIO RESPONSABLE, qui&eacute;n declara recepci&oacute;n de los mismos en
                    buen estado y se
                    compromete a cuidar de los recursos y hacer uso de ellos para los fines
                    establecidos.
                  </p>
                  <table
                    style="height: 37px; width: 98.175%; border-collapse: collapse; margin-left: auto; margin-right: auto; font-size: 14px"
                    border="1">
                    <caption>
                      <p style="text-align: left; font-size: 14px"><strong>1.- FUNCIONARIO
                          RESPONSABLE</strong></p>
                    </caption>
                    <tbody>
                      <tr style="height: 19px;">
                        <td style="width: 50.5989%; height: 19px; text-align: left;">Nombres,
                          Apellidos</td>
                        <td style="width: 67.2216%; height: 19px;">
                          {{ $repo->NombreCustodio }}
                        </td>
                      </tr>
                      <tr style="height: 18px;">
                        <td style="width: 50.5989%; height: 18px;">Cargo</td>
                        <td style="width: 67.2216%; height: 18px;">
                          {{ $repo->CargoCustodio }}
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  <br />
                  <table
                    style="width: 98.175%; border-collapse: collapse; margin-left: auto; margin-right: auto; font-size: 14px"
                    border="1">
                    <caption>
                      <p style="text-align: left; font-size: 14px"><strong>2.- EQUIPOS
                          COMPUTACIONALES
                          ASIGNADOS</strong></p>
                    </caption>
                    <tbody>
                      <tr>
                        <td style="width: 50%;">MODELO DEL EQUIPO</td>
                        <td style="width: 47.9791%;">{{ $repo->DescripcionEquipo }}</td>
                      </tr>
                      <tr>
                        <td style="width: 50%;">SEDE DEL EQUIPO</td>
                        <td style="width: 47.9791%;">{{ $repo->SedeEquipo }}</td>
                      </tr>
                      <tr>
                        <td style="width: 50%;">NÚMERO DE SERIE</td>
                        <td style="width: 47.9791%;">{{ $repo->NumeroSerial }}</td>
                      </tr>
                      <tr>
                        <td style="width: 50%;">NÚMERO DE INVENTARIO</td>
                        <td style="width: 47.9791%;">{{ $repo->ActivoFijo }}</td>
                      </tr>
                    </tbody>
                  </table>
                  <p>&nbsp;</p>
                  <table
                    style="height: 270px; width: 98.175%; border-collapse: collapse; margin-left: auto; margin-right: auto; font-size: 14px"
                    border="1">
                    <tbody>
                      <tr style="height: 18px;">
                        <td style="width: 16.2227%; height: 18px; text-align: center;">
                          <strong>Descripci&oacute;n</strong>
                        </td>
                        <td style="width: 17.8131%; height: 18px; text-align: center;">
                          <strong>Marca</strong>
                        </td>
                        <td style="width: 21.479%; height: 18px; text-align: center;">
                          <strong>Referencia</strong>
                        </td>
                        <td style="width: 21.479%;; height: 18px; text-align: center;">
                          <strong>Caracteristicas</strong>
                        </td>
                        <td style="width: 23.0815%; height: 18px; text-align: center;">
                          <strong>Serial</strong>
                        </td>
                      </tr>
                      <tr style="height: 18px;">
                        <td style="width: 16.2227%; height: 18px;">Procesador</td>
                        <td style="width: 17.8131%; height: 18px;">
                          {{ $repo->ProcesadorMarca }}
                        </td>
                        <td style="width: 23.479%; height: 18px; font-size: 10px">
                          {{ $repo->ProcesadorGeneracion }} {{ $repo->ProcesadorVelocidad }}
                        </td>
                        <td style="width: 19.4037%; height: 18px;">
                        </td>
                        <td style="width: 23.0815%; height: 18px;">&nbsp;</td>
                      </tr>
                      <tr style="height: 18px;">
                        <td style="width: 16.2227%; height: 18px;">Disco Duro</td>
                        <td style="width: 17.8131%; height: 18px;">&nbsp;</td>
                        <td style="width: 23.479%; height: 18px;">
                        </td>
                        <td style="width: 19.4037%; height: 18px; font-size: 10px">
                          Disco Duro #1:{{ $repo->PrimerUnidadAlmacenamiento }}
                          <br />
                          Disco Duro #2:
                          {{ $repo->SegundaUnidadAlmacenamiento }}
                        </td>
                        <td style="width: 23.0815%; height: 18px;">&nbsp;</td>
                      </tr>
                      <tr style="height: 18px;">
                        <td style="width: 16.2227%; height: 18px;">Memoria RAM</td>
                        <td style="width: 17.8131%; height: 18px;">&nbsp;</td>
                        <td style="width: 23.479%; height: 18px; font-size: 12px">
                        </td>
                        <td style="width: 19.4037%; height: 18px;font-size: 10px">
                          RAM #1: {{ $repo->RanuraRamUno }}
                          <br />
                          RAM #2: {{ $repo->RanuraRamDos }}
                        </td>
                        <td style="width: 23.0815%; height: 18px;">&nbsp;</td>
                      </tr>
                      <tr style="height: 18px;">
                        <td style="width: 16.2227%; height: 18px;">Teclado</td>
                        <td style="width: 17.8131%; height: 18px;">&nbsp;</td>
                        <td style="width: 23.479%; height: 18px;">&nbsp;</td>
                        <td style="width: 19.4037%; height: 18px;">
                        </td>
                        <td style="width: 23.0815%; height: 18px;">
                          {{ $repo->SerialTeclado }}
                        </td>
                      </tr>
                      <tr style="height: 18px;">
                        <td style="width: 16.2227%; height: 18px;">Monitor</td>
                        <td style="width: 17.8131%; height: 18px;">&nbsp;</td>
                        <td style="width: 23.479%; height: 18px;">&nbsp;</td>
                        <td style="width: 19.4037%; height: 18px;">&nbsp;</td>
                        <td style="width: 23.0815%; height: 18px;">
                          {{ $repo->MonitorNumeroSerial }}
                        </td>
                      </tr>
                      <tr style="height: 18px;">
                        <td style="width: 16.2227%; height: 18px;">SO</td>
                        <td style="width: 17.8131%; height: 18px;">&nbsp;</td>
                        <td style="width: 23.479%; height: 18px;">&nbsp;</td>
                        <td style="width: 19.4037%; height: 18px; font-size: 11px">
                          {{ $repo->Os }}
                        </td>
                        <td style="width: 23.0815%; height: 18px;">&nbsp;</td>
                      </tr>
                      <tr style="height: 18px;">
                        <td style="width: 16.2227%; height: 18px;">Mouse</td>
                        <td style="width: 17.8131%; height: 18px;">&nbsp;</td>
                        <td style="width: 23.479%; height: 18px;">&nbsp;</td>
                        <td style="width: 19.4037%; height: 18px;">
                        </td>
                        <td style="width: 23.0815%; height: 18px;">
                          {{ $repo->SerialMouse }}
                        </td>
                      </tr>
                      <tr style="height: 18px;">
                        <td style="width: 16.2227%; height: 18px;">Adaptador</td>
                        <td style="width: 17.8131%; height: 18px;">&nbsp;</td>
                        <td style="width: 23.479%; height: 18px;">&nbsp;</td>
                        <td style="width: 19.4037%; height: 18px;">
                        </td>
                        <td style="width: 23.0815%; height: 18px;">
                          {{ $repo->SerialAdaptadorCorriente }}
                        </td>
                      </tr>
                      <tr style="height: 18px;">
                        <td colspan="5"
                          style="width: 16.2227%; height: 18px; text-align:center; font-size:16px; font-style:bold">
                          Accesorios
                        </td>
                      </tr>
                      <tr style="height: 18px;">
                        <td colspan="3" style="width: 16.2227%; height: 18px;">Funda</td>
                        <td colspan="2" style="width: 19.4037%; height: 18px; text-align:center;">
                          {{ $repo->TieneFunda }}
                        </td>
                      </tr>
                      <tr style="height: 18px;">
                        <td colspan="3" style="width: 16.2227%; height: 18px;">Malet&iacute;n</td>
                        <td colspan="2" style="width: 19.4037%; height: 18px; text-align:center;">
                          {{ $repo->TieneMaletin }}
                        </td>
                      </tr>
                      <tr style="height: 18px;">
                        <td colspan="3" style="width: 16.2227%; height: 18px;">Candado</td>
                        <td colspan="2" style="width: 19.4037%; height: 18px;text-align:center;">
                          {{ $repo->TieneCandado }}
                        </td>
                      </tr>
                      {{-- <tr style="height: 18px;">
                        <td colspan="3" style="width: 16.2227%; height: 18px;">WIFI</td>
                        <td colspan="2" style="width: 19.4037%; height: 18px;text-align:center;">
                          {{ $repo->TieneWifi }}
                        </td>
                      </tr> --}}
                      <tr style="height: 18px;">
                        <td colspan="3" style="width: 16.2227%; height: 18px;">Web Cam</td>
                        <td colspan="2" style="width: 19.4037%; height: 18px;text-align:center;">
                          {{ $repo->TieneWebCam }}
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  <table style="width: 98.175%; border-collapse: collapse; margin-left: auto; margin-right: auto;">
                    <tbody style="font-size: 12px;">
                      <tr>
                        <td style="width: 63.5915%;">
                          <img src="{{ public_path('storage/'.$repo->FirmaTecnico) }}" alt="" width="150" height="50">
                        </td>
                      </tr>
                      <tr>
                        <td style="width: 63.5915%;">
                          <strong>{{ $repo->NombreTecnico }}</strong>
                        </td>
                        <td style="width: 36.4085%; text-align: right;">
                          <strong>{{ $repo->NombreCustodio }}</strong>
                        </td>
                      </tr>
                      <tr>
                        <td style="width: 63.5915%;">
                          <strong>{{ $repo->CargoTecnico }}</strong>
                        </td>
                        <td style="width: 36.4085%; text-align: right;">
                          <strong>{{ $repo->CargoCustodio }}</strong>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </td>
      </tr>
    </tbody>
  </table>
</body>

</html>