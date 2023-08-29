<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Contract\Database;
use Illuminate\Support\Facades\Validator;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class DataController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct(Database $database)
    {
        $this->database = $database;
        $this->tablename = 'Data';
    }

    public function index()
    {
        $fdata = $this->database->getReference($this->tablename)->getValue();
        $pageTitle = 'Data';
        return view('data.index', compact('pageTitle', 'fdata'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $kategori = $this->database->getReference('Kategori')->getValue();
        $divisi = $this->database->getReference('Divisi')->getValue();
        $pageTitle = 'Create';
        return view('data.create', ['pageTitle' => $pageTitle, 'divisi' => $divisi, 'kategori' => $kategori]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $messages = [
            'required' => ':Attribute harus diisi.',
        ];
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'nomorSurat' => 'required',
            'keterangan' => 'required',
            'divisi' => 'required',
            'kategori' => 'required',
        ], $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if ($request->kategori == 'box') {
            $temp = 'box';
        } else {
            $temp = 'esa';
        }
        $postData = [
            'id' => $temp . $request->id,
            'nama' => $request->nama,
            'nomorSurat' => $request->nomorSurat,
            'keterangan' => $request->keterangan,
            'kategori' => $request->kategori,
            'divisi' => $request->divisi
        ];
        $postRef = $this->database->getReference($this->tablename)->push($postData);
        if ($postRef) {
            return redirect('data')->with('status', 'Data Berhasil Ditambahkan');
        } else {
            return redirect('data.index')->with('status', 'Data Tidak Berhasil Ditambahkan');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pageTitle = 'detail';

        $tablename = $this->tablename;
        $itemKey = $id;
        $columnToRetrieve = 'id';


        $data = $this->database->getReference($tablename . '/' . $itemKey . '/' . $columnToRetrieve)->getValue();

        $code = QrCode::format('svg')->size(200)->errorCorrection('H')->generate($data);
        return view('data.show', ['pageTitle' => $pageTitle, 'code' => $code, 'key' => $id]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pageTitle = 'edit';
        $key = $id;
        $editdata = $this->database->getReference($this->tablename)->getChild($key)->getValue();
        if ($editdata) {
            return view('data.edit', ['pageTitle' => $pageTitle, 'editdata' => $editdata, 'key' => $key]);
        } else {
            return view('data');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $messages = [
            'required' => ':Attribute harus diisi.',
        ];
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'nomorSurat' => 'required',
            'keterangan' => 'required',
            'divisi' => 'required',
            'kategori' => 'required',
        ], $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $key = $id;
        $updateData = [
            'id' => $request->id,
            'nama' => $request->nama,
            'nomorSurat' => $request->nomorSurat,
            'keterangan' => $request->keterangan,
            'kategori' => $request->kategori,
            'divisi' => $request->divisi
        ];
        $res_updated = $this->database->getReference($this->tablename . '/' . $key)->update($updateData);
        if ($res_updated) {
            return redirect('data')->with('status', 'Data Berhasil Diperbarui');
        } else {
            return redirect('data')->with('status', 'Data Tidak Berhasil Diperbarui');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $key = $id;
        $deleted = $this->database->getReference($this->tablename . '/' . $key)->remove();
        if ($deleted) {
            return redirect('data');
        }
    }
}