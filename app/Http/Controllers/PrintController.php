<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Kreait\Firebase\Contract\Database;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PrintController extends Controller
{
    //
    public function __construct(Database $database)
    {
        $this->database = $database;
        $this->tablename = 'Data';
    }
    public function printOut($id)
    {
        $pageTitle = 'download';

        $tablename = $this->tablename;
        $itemKey = $id;
        $columnToRetrieve = 'id';


        $data = $this->database->getReference($tablename . '/' . $itemKey . '/' . $columnToRetrieve)->getValue();

        $code = QrCode::format('svg')->size(200)->errorCorrection('H')->generate($data);

        $pdf = PDF::loadview('layouts.print', ['code' => $code, 'key' => $id, 'pageTitle' => $pageTitle]);

        return $pdf->stream();
    }
}