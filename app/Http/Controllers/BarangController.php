<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use App\Models\KategoriModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Symfony\Component\HttpFoundation\Response;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Barryvdh\DomPDF\Facade\Pdf;

class BarangController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Barang',
            'list' => ['Home', 'Barang']
        ];
        $page = (object) [
            'title' => 'Daftar barang yang terdaftar dalam sistem'
        ];
        $kategori = KategoriModel::all();
        $activeMenu = 'barang'; 
        return view('barang.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kategori' => $kategori, 'activeMenu' => $activeMenu]);
    }

        public function list(Request $req)
    {
        $barang = BarangModel::select('barang_id', 'kategori_id', 'barang_nama', 'barang_kode', 'harga_beli', 'harga_jual')->with('kategori');

        if ($req->kategori_id) {
                $barang->where('kategori_id', $req->kategori_id);
            }

        return DataTables::of($barang)
            ->addIndexColumn()
            ->addColumn('aksi', function ($barang) {
                $btn  = '<button onclick="modalAction(\'' . url('/barang/' . $barang->barang_id .'/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/barang/' . $barang->barang_id .'/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/barang/' . $barang->barang_id .'/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Barang',
            'list' => [
                'Home',
                'Barang',
                'Tambah'
            ]
        ];
        $page = (object) [
            'title' => 'Tambah barang baru'
        ];
        $kategori = KategoriModel::all();
        $activeMenu = 'barang';
        return view('barang.create', ['breadcrumb' => $breadcrumb, 'page' => $page,'kategori' => $kategori, 'activeMenu' => $activeMenu]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori_id' => 'required|integer',
            'barang_kode' => 'required|string|min:3|unique:m_barang,barang_kode',
            'barang_nama' => 'required|string|min:3|unique:m_barang,barang_nama',
            'harga_beli' => 'required|integer',
            'harga_jual' => 'required|integer'
        ]);
        BarangModel::create([
            'kategori_id' => $request->kategori_id,
            'barang_kode' => $request->barang_kode,
            'barang_nama' => $request->barang_nama,
            'harga_beli' => $request->harga_beli,
            'harga_jual' => $request->harga_jual
        ]);
        return redirect('/barang')->with('success', 'Data barang berhasil disimpan');
    }

    

    // ajax
    public function show_ajax(string $id)
    {
        $barang = BarangModel::with('kategori')->find($id); 
        return view('barang.show_ajax', ['barang' => $barang]);
    }
    
    public function create_ajax()
    {
        $kategori = KategoriModel::all();
        return view('barang.create_ajax', ['kategori' => $kategori]);
    }

    public function store_ajax(Request $request)
    {
        $request->validate([
            'kategori_id' => 'required|integer',
            'barang_kode' => 'required|string|min:3|unique:m_barang,barang_kode',
            'barang_nama' => 'required|string|min:3|unique:m_barang,barang_nama',
            'harga_beli' => 'required|integer',
            'harga_jual' => 'required|integer'
        ]);

        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'kategori_id' => 'required|integer',
                'barang_kode' => 'required|string|min:3|unique:m_barang,barang_kode',
                'barang_nama' => 'required|string|min:3|unique:m_barang,barang_nama',
                'harga_beli' => 'required|integer',
                'harga_jual' => 'required|integer'
            ];
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors()
                ]);
            }
            BarangModel::create([
                'kategori_id' => $request->kategori_id,
                'barang_kode' => $request->barang_kode,
                'barang_nama' => $request->barang_nama,
                'harga_beli' => $request->harga_beli,
                'harga_jual' => $request->harga_jual
            ]);
            return response()->json([
                'status' => true,
                'message' => 'Data barang berhasil disimpan'
            ]);
        }
        redirect('/');
    }

    public function edit_ajax(string $id)
    {
        $barang = BarangModel::find($id);
        $kategori = KategoriModel::select('kategori_id', 'kategori_nama')->get();
        return view('barang.edit_ajax', ['barang' => $barang, 'kategori' => $kategori]);
    }

    public function update_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'kategori_id' => 'required|integer',
                'barang_kode' => 'required|string|min:3|unique:m_barang,barang_kode,' . $id . ',barang_id',
                'barang_nama' => 'required|string|max:100',
                'harga_jual' => 'required|integer',
                'harga_beli' => 'required|integer'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status'   => false,
                    'message'  => 'Validasi gagal.',
                    'msgField' => $validator->errors() 
                ]);
            }
            $check = BarangModel::find($id);
            if ($check) {
                if (!$request->filled('password')) {
                    $request->request->remove('password');
                }
                $check->update($request->all());
                return response()->json([
                    'status'  => true,
                    'message' => 'Data berhasil diupdate'
                ]);
            } else {
                return response()->json([
                    'status'  => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        redirect('/');
    }

    public function confirm_ajax(string $id)
    {
        $barang = BarangModel::find($id);
        return view('barang.confirm_ajax', ['barang' => $barang]);
    }

    public function delete_ajax(Request $request, $id)
    {
        if($request->ajax() || $request->wantsJson()){
            $barang = BarangModel::find($id);
            if($barang){
                try {
                    BarangModel::destroy($id);
                    return response()->json([
                        'status'  => true,
                        'message' => 'Data berhasil dihapus'
                    ]);
                } catch (\Illuminate\Database\QueryException $e) {
                    return response()->json([
                        'status'  => false,
                        'message' => 'Data barang gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini'
                    ]);
                }
            }else{
                return response()->json([
                    'status'  => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
    }
        redirect('/');
    }

    public function showimport()
    {
        return view('barang.import');
    }

    public function import_ajax(Request $req)
    {
        if (!$req->ajax() && !$req->wantsJson()) {
            return redirect('/');
        }

        $rules = [
            'file_barang' => ['required', 'mimes:xlsx', 'max:1024']
        ];

        $validator = Validator::make($req->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal',
                'msgField' => $validator->errors()
            ], Response::HTTP_BAD_REQUEST);
        }

        $file = $req->file('file_barang');

        $reader = IOFactory::createReader('xlsx');
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load($file->getRealPath());
        $sheet = $spreadsheet->getActiveSheet();

        $data = $sheet->toArray(null, false, true, true);

        $insert = [];
        if (count($data) <= 1) {
            return response()->json([
                'status' => false,
                'message' => 'Tidak ada data yang diimport'
            ], Response::HTTP_BAD_REQUEST);
        }

        foreach ($data as $row => $val) {
            if ($row > 1) {
                $insert[] = [
                    'kategori_id' => $val['A'],
                    'barang_kode' => $val['B'],
                    'barang_nama' => $val['C'],
                    'supplier_id' => $val['D'],
                    'harga_beli' => $val['E'],
                    'harga_jual' => $val['F'],
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }
        }

        if (count($insert) > 0) {
            BarangModel::insertOrIgnore($insert);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil diimport'
        ], Response::HTTP_OK);
    }

    public function export_excel()
    {
        $barang = BarangModel::select('kategori_id', 'barang_kode', 'barang_nama', 'harga_beli', 'harga_jual')
            ->orderBy('kategori_id')
            ->with('kategori')
            ->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'No')
            ->setCellValue('B1', 'Kode Barang')
            ->setCellValue('C1', 'Nama Barang')
            ->setCellValue('D1', 'Harga Beli')
            ->setCellValue('E1', 'Harga Jual')
            ->setCellValue('F1', 'Kategori');
        
        $sheet->getStyle('A1:F1')->getFont()->setBold(true);

        $no = 1;
        $row = 2;

        foreach ($barang as $key => $value) {
            $sheet->setCellValue('A' . $row, $no++)
                ->setCellValue('B' . $row, $value->barang_kode)
                ->setCellValue('C' . $row, $value->barang_nama)
                ->setCellValue('D' . $row, $value->harga_beli)
                ->setCellValue('E' . $row, $value->harga_jual)
                ->setCellValue('F' . $row, $value->kategori->kategori_nama);
            $row++;
        }
        
        foreach (range('A', 'F') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $sheet->setTitle('Data Barang');
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data Barang ' . date('Y-m-d H-i-s') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');

        $writer->save('php://output');
        exit;
    }

    public function export_pdf()
    {
        $barang = BarangModel::select('kategori_id', 'barang_kode', 'barang_nama', 'harga_beli', 'harga_jual')
            ->orderBy('kategori_id')
            ->with('kategori')
            ->get();

        $pdf = Pdf::loadView('barang.export_pdf', [ 'barang' => $barang ])
                ->setPaper('A4', 'landscape')
                ->setOption('isRemoteEnabled', true)
                ->setOption('isHtml5ParserEnabled', true);
        
        $pdf->render();

        return $pdf->stream('Data Barang ' . date('Y-m-d H-i-s') . '.pdf');
    }
}