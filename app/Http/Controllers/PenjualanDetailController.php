<?php

namespace App\Http\Controllers;

use App\Models\PenjualanDetailModel;
use App\Models\PenjualanModel;
use App\Models\BarangModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class PenjualanDetailController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Detail Penjualan',
            'list' => ['Home', 'Detail Penjualan']
        ];

        $page = (object) [
            'title' => 'Daftar detail penjualan yang terdaftar dalam sistem'
        ];

        $activeMenu = 'detail_penjualan';

        $detail_penjualan = PenjualanDetailModel::all();
        $penjualan = PenjualanModel::all();
        $barang = BarangModel::all();
        return view('detail_penjualan.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu, 'penjualan' => $penjualan, 'detail_penjualan' => $detail_penjualan, 'barang' => $barang]);
    }

    public function list(Request $request)
    {
        // $detail = PenjualanDetailModel::with(['penjualan', 'barang']);
        $detail = PenjualanDetailModel::with(['penjualan', 'barang'])->select('detail_id', 'penjualan_id', 'barang_id', 'harga', 'jumlah');

        if ($request->penjualan_id) {
            $detail->where('penjualan_id', $request->penjualan_id);
        }

        if ($request->barang_id) {
            $detail->where('barang_id', $request->barang_id);
        }

        return DataTables::of($detail)
            ->addIndexColumn()
            // ->addColumn('barang_id', function ($row) {
            //     return $row->barang ? $row->barang->nama_barang : '-';
            // })
            ->addColumn('barang_nama', function ($barang) {
                return $barang->barang->nama_barang ?? '-';
            })
            // ->addColumn('penjualan_id', function ($detail_penjualan) {
            //     return $detail_penjualan->penjualan_id ? $detail_penjualan->penjualan->penjualan_kode : '-';
            // })
            // ->addColumn('barang_id', function ($detail_penjualan) {
            //     return $detail_penjualan->barang_id ? $detail_penjualan->barang->barang_nama : 'NO RELATION';
            // })
            ->addColumn('subtotal', fn($detail_penjualan) => $detail_penjualan->jumlah * $detail_penjualan->harga)
            ->addColumn('aksi', function ($detail_penjualan) {
                $btn  = '<button onclick="modalAction(\'' . url('/detail_penjualan/' . $detail_penjualan->penjualan_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/detail_penjualan/' . $detail_penjualan->penjualan_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/detail_penjualan/' . $detail_penjualan->penjualan_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Detail Penjualan',
            'list' => ['Home', 'Detail Penjualan', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah data detail penjualan baru'
        ];

        $penjualan = PenjualanModel::all();
        $barang = BarangModel::all();
        $activeMenu = 'detail_penjualan';

        return view('detail_penjualan.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'penjualan' => $penjualan, 'barang' => $barang, 'activeMenu' => $activeMenu]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'penjualan_id' => 'required|integer',
            'barang_id' => 'required|integer',
            'harga' => 'required|int',
            'jumlah' => 'required|int'
        ]);

        PenjualanModel::create($request->all());

        return redirect('/detail_penjualan')->with('success', 'Data detail penjualan berhasil disimpan');
    }

    public function show(string $id)
    {
        $detail_penjualan = PenjualanDetailModel::with(['penjualan', 'barang'])->find($id);

        $breadcrumb = (object) [
            'title' => 'Data Petail Penjualan',
            'list' => ['Home', 'Detail Penjualan', 'Detail']
        ];

        $page = (object) [
            'title' => 'Data detail penjualan'
        ];

        $activeMenu = 'detail_penjualan';

        return view('detail_penjualan.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'detail_penjualan' => $detail_penjualan, 'activeMenu' => $activeMenu]);
    }

    public function edit(String $id)
    {
        $detail_penjualan = PenjualanDetailModel::find($id);
        $penjualan = PenjualanModel::all();
        $barang = BarangModel::all();

        $breadcrumb = (object) [
            'title' => 'Edit Detail Penjualan',
            'list' => ['Home', 'Detail Penjualan', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit detail penjualan',
        ];

        $activeMenu = 'detail_penjualan';

        return view('penjualan.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'detail_penjualan' => $detail_penjualan, 'penjualan' => $penjualan, 'barang' => $barang, 'activeMenu' => $activeMenu]);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'penjualan_id' => 'required|integer',
            'barang_id' => 'required|integer',
            'harga' => 'required|int',
            'jumlah' => 'required|int'
        ]);

        PenjualanDetailModel::find($id)->update([
            'penjualan_id' => $request->penjualan_id,
            'barang_id' => $request->barang_id,
            'harga' => $request->harga,
            'jumlah' => $request->jumlah,
        ]);

        return redirect('/detail_penjualan')->with('success', 'Data detail penjualan berhasil diubah');
    }

    public function destroy(String $id)
    {
        $check = PenjualanDetailModel::find($id);
        if (!$check) {
            return redirect('/detail_penjualan')->with('error', 'Data detail penjualan tidak ditemukan');
        }

        try {
            PenjualanDetailModel::destroy($id);
            return redirect('/detail_penjualan')->with('success', 'Data detail penjualan berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/detail_penjualan')->with('error', 'Data detail penjualan gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }

    public function create_ajax()
    {
        $penjualan = PenjualanModel::all();
        $barang = BarangModel::all();
        return view('detail_penjualan.create_ajax', ['penjualan' => $penjualan, 'barang' => $barang]);
    }

    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'penjualan_id' => 'required|integer',
                'barang_id' => 'required|integer',
                'harga' => 'required|int',
                'jumlah' => 'required|int'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal',
                    'msgField' => $validator->errors()
                ]);
            }

            PenjualanDetailModel::create($request->all());

            return response()->json([
                'status' => true,
                'message' => 'Data detail penjualan berhasil disimpan'
            ]);
        }
        return redirect('/');
    }

    public function show_ajax(string $id)
    {
        $detail_penjualan = PenjualanDetailModel::with(['penjualan', 'barang'])->find($id);
        return view('detail_penjualan.show_ajax', compact('detail_penjualan'));
    }

    public function edit_ajax(string $id)
    {
        $detail_penjualan = PenjualanDetailModel::find($id);
        $penjualan = PenjualanModel::all();
        $barang = BarangModel::all();

        return view('detail_penjualan.edit_ajax', ['penjualanDetail' => $detail_penjualan, 'penjualan' => $penjualan, 'barang' => $barang]);
    }

    public function update_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'penjualan_id' => 'required|integer',
                'barang_id' => 'required|integer',
                'harga' => 'required|int',
                'jumlah' => 'required|int'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors()
                ]);
            }

            $detail_penjualan = PenjualanDetailModel::find($id);
            if ($detail_penjualan) {
                $detail_penjualan->update($request->all());
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diupdate'
                ]);
            }

            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ]);
        }
        return redirect('/');
    }

    public function confirm_ajax(string $id)
    {
        $detail_penjualan = PenjualanDetailModel::find($id);
        return view('detail_penjualan.confirm_ajax', ['detail_penjualan' => $detail_penjualan]);
    }

    public function delete_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $detail_penjualan = PenjualanDetailModel::find($id);
            if ($detail_penjualan) {
                try {
                    PenjualanDetailModel::destroy($id);
                    return response()->json([
                        'status' => true,
                        'message' => 'Data berhasil dihapus'
                    ]);
                } catch (\Illuminate\Database\QueryException $e) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Data penjualan gagal dihapus karena masih terkait dengan data lain'
                    ]);
                }
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('/');
    }
}