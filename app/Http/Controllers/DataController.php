<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Contract\Database;
use Illuminate\Support\Facades\Storage;
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

    private function findLatestId($kategoriCode, $divisiCode)
    {
        // Reference to the location in your Realtime Database where data is stored
        // Replace 'Data' with the actual path to your data
        $dataRef = $this->database->getReference('Data');

        // Query to find the latest ID based on 'kategori' and 'divisi'
        $latestId = 0; // Initialize with 0

        // Retrieve the data from the Realtime Database
        $data = $dataRef->getSnapshot();

        foreach ($data as $key => $entry) {
            // Check if the entry matches the selected 'kategori' and 'divisi'
            if (
                isset($entry['kategori']) && isset($entry['divisi']) &&
                $entry['kategori'] == $kategoriCode && $entry['divisi'] == $divisiCode
            ) {
                // Extract and compare the numeric part of the ID from the key
                $idParts = explode('-', $key);
                $id = end($idParts); // Get the last part of the key (the ID)

                // Convert to integer and check if it's greater than the current latest ID
                $id = (int) $id;
                if ($id > $latestId) {
                    $latestId = $id;
                }
            }
        }

        // Increment the latest ID by 1 to get the next ID
        $nextId = $latestId + 1;

        return $nextId;
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

        $kategori = $request->kategori;
        $divisi = $request->divisi;

        // Determine a code for "Kategori" and "Divisi" (e.g., BOX for Box, PDG for Perdagangan)
        $kategoriCode = strtoupper(substr($kategori, 0, 3)); // Take the first 3 letters of "Kategori"
        $divisiCode = strtoupper(substr($divisi, 0, 3)); // Take the first 3 letters of "Divisi"

        // Find the latest ID for the selected "Kategori" and "Divisi" combination
        $latestId = $this->findLatestId($kategoriCode, $divisiCode);

        // Increment the latest ID by 1
        $nextId = $latestId + 1;

        // Format the new ID as KategoriCode-DivisiCode-Number
        $formattedId = $kategoriCode . '-' . $divisiCode . '-' . $nextId;

        $postData = [
            'id' => $formattedId,
            'nama' => $request->nama,
            'nomorSurat' => $request->nomorSurat,
            'keterangan' => $request->keterangan,
            'kategori' => $request->kategori,
            'divisi' => $request->divisi
        ];

        // Reference to the location in your Realtime Database where data is stored
        // Replace 'Data' with the actual path to your data
        $dataRef = $this->database->getReference('Data');

        $postRef = $dataRef->push($postData);

        if ($postRef->getKey()) {
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

        $editdata = $this->database->getReference($this->tablename)->getChild($id)->getValue();

        $data = $this->database->getReference($tablename . '/' . $itemKey . '/' . $columnToRetrieve)->getValue();

        $code = QrCode::format('svg')->size(290)->errorCorrection('H')->generate($data);
        return view('data.show', ['pageTitle' => $pageTitle, 'code' => $code, 'key' => $id, 'editdata' => $editdata]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $kategori = $this->database->getReference('Kategori')->getValue();
        $divisi = $this->database->getReference('Divisi')->getValue();

        $pageTitle = 'edit';
        $key = $id;
        $editdata = $this->database->getReference($this->tablename)->getChild($key)->getValue();
        if ($editdata) {
            return view('data.edit', ['pageTitle' => $pageTitle, 'editdata' => $editdata, 'key' => $key, 'divisi' => $divisi, 'kategori' => $kategori]);
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