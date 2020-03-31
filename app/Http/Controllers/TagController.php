<?php

namespace App\Http\Controllers;

use App\Tag;
use Illuminate\Http\Request;
use Validator;

class TagController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (request()->ajax()) {
            return datatables()->of(Tag::get())
                ->addColumn('action', function ($data) {
                    $button = '<button type="button" name="edit" id="' . $data->id . '" class="edit btn btn-primary btn-sm"><i class="fa fa-edit"></i></button>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<button type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.tags.tags');
    }

    public function store(Request $request)
    {
        $rules = array(
            'name' => 'required'
        );

        $error = Validator::make($request->all(), $rules);

        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        Tag::create($request->all());
        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function edit($id)
    {
        if (request()->ajax()) {
            $data = Tag::findOrFail($id);
            return response()->json(['data' => $data]);
        }
    }

    public function update(Request $request)
    {
        $rules = array(
            'name' => 'required'
        );

        $error = Validator::make($request->all(), $rules);

        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $tag = Tag::findOrFail($request->hidden_id);
        $tag->update($request->all());
        return response()->json(['success' => 'Data is successfully updated']);
    }

    public function destroy($id)
    {
        $data = Tag::findOrFail($id);
        $data->delete();
    }
}
