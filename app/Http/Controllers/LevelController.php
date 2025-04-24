<?php

namespace App\Http\Controllers;

use App\Models\LevelModel;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class LevelController extends Controller
{
    public function index()
    {
        return view('level.index', [
            'breadcrumb' => (object) [
            'title' => 'List of User Levels',
            'list' => ['Home', 'Level']
            ],
            'level' => LevelModel::all(),
            'page' => (object) [
            'title' => 'List of user levels registered in the system'
            ],
            'activeMenu' => 'level'
        ]);
    }

    public function list(Request $req)
    {
        $level = LevelModel::select('level_id', 'level_kode', 'level_nama');

        if ($req->level_id) {
            $level->where('level_id', $req->level_id);
        }

        return DataTables::of($level)
            ->addIndexColumn()
            ->addColumn('aksi', function ($level) {
                $btn = '<button onclick="modalAction(\''.url('/level/' . $level->level_id . '/show_ajax ').'\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\''.url('/level/' . $level->level_id . '/edit_ajax').'\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\''.url('/level/' . $level->level_id . '/delete_ajax').'\')" class="btn btn-danger btn-sm">Delete</button> ';
    
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function show($id)
    {
        $breadcrumb = (object) [
            'title' => 'Detail Level',
            'list' => ['Home', 'Level', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail Level'
        ];

        $level = LevelModel::find($id);

        if (!$level) {
            return redirect('/level')->with('error', 'Level data not found!');
        }

        $activeMenu = 'level';

        return view('level.show', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'level' => $level,
            'activeMenu' => $activeMenu
        ]);
    }

    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Add Level',
            'list' => ['Home', 'Level', 'Add']
        ];
        $page = (object) [
            'title' => 'Add New Level'
        ];
        $level = LevelModel::all();
        $activeMenu = 'level';
        return view('level.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level, 'activeMenu' => $activeMenu]);
    }

    public function edit(string $id)
    {
        $level = LevelModel::find($id);
        $breadcrumb = (object) [
            'title' => 'Edit Level',
            'list' => ['Home', 'Level', 'Edit']
        ];
        $page = (object) [
            'title' => 'Edit level'
        ];
        $activeMenu = 'level';
        return view('level.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level, 'activeMenu' => $activeMenu]);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'level_kode' => 'required|string|min:3|unique:m_level,level_kode,' . $id . ',level_id',
            'level_nama' => 'required|string|max:100',
        ]);

        LevelModel::find($id)->update([
            'level_kode' => $request->level_kode,
            'level_nama' => $request->level_nama
        ]);
        return redirect('/level')->with('success', 'The level data was changed successfully!');
    }

    public function destroy(string $id)
    {
        $check = LevelModel::find($id);
        if (!$check) {
            return redirect('/level')->with('error', 'Level data not found!');
        }
        try {
            LevelModel::destroy($id);
            return redirect('/level')->with('success', 'The level data was deleted successfully!');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/level')->with('error', 'The level data failed to be deleted because there are still other tables related to this data.');
        }
    }

    public function store(Request $req)
    {
        $req->validate([
            'level_kode' => "required|string|min:3|unique:m_level,level_kode",
            'level_nama' => 'required|string|max:100|unique:m_level,level_nama'
        ]);

        LevelModel::create([
            'level_kode' => $req->level_kode,
            'level_nama' => $req->level_nama
        ]);

        return redirect('/level')
            ->with('success', 'Level data saved successfully!');
    }

    // ajax
    public function show_ajax(string $id)
    {
        $level = LevelModel::find($id);
        return view('level.show_ajax', ['level' => $level]);
    }

    public function create_ajax()
    {
        return view('level.create_ajax');
    }

    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'level_kode' => 'required|string|min:3|unique:m_level,level_kode',
                'level_nama' => 'required|string|max: 100'
            ];
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation Failed!',
                    'msgField' => $validator->errors()
                ]);
            }

            LevelModel::create($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Level data saved successfully!'
            ]);
        }
        redirect('/');
    }

    public function edit_ajax(string $id)
    {
        $level = LevelModel::find($id);
        return view('level.edit_ajax', ['level' => $level]);
    }

    public function update_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'level_kode' => 'required|string|min:3|unique:m_level,level_kode,' . $id . ',level_id',
                'level_nama' => 'required|string|max:100'
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status'   => false, 
                    'message'  => 'Validation Failed!',
                    'msgField' => $validator->errors()
                ]);
            }
            $check = LevelModel::find($id);
            if ($check) {
                if (!$request->filled('password')) {
                    $request->request->remove('password');
                }
                $check->update($request->all());
                return response()->json([
                    'status'  => true,
                    'message' => ''
                ]);
            } else {
                return response()->json([
                    'status'  => false,
                    'message' => 'Level data not found!'
                ]);
            }
        }
        redirect('/');
    }

    public function confirm_ajax(string $id)
    {
        $level = LevelModel::find($id);
        return view('level.confirm_ajax', ['level' => $level]);
    }

    public function delete_ajax(Request $request, $id)
    {
        if($request->ajax() || $request->wantsJson()){
            $level = LevelModel::find($id);
            if($level){
                try {
                    LevelModel::destroy($id);
                    return response()->json([
                        'status'  => true,
                        'message' => 'Data deleted successfully!'
                    ]);
                } catch (\Illuminate\Database\QueryException $e) {
                    return response()->json([
                        'status'  => false,
                        'message' => 'The level data failed to be deleted because there are still other tables related to this data.'
                    ]);
                }
            }else{
                return response()->json([
                    'status'  => false,
                    'message' => 'Level data not found!'
                ]);
            }
    }
        redirect('/');
    }
}