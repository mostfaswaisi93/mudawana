<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Post;
use Illuminate\Http\Request;
use Validator;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $comments = Comment::with('post')->get();

        if (request()->ajax()) {
            return datatables()->of($comments)
                ->addColumn('post', function ($data) {
                    return $data->post->title;
                })
                ->addColumn('action', function ($data) {
                    $button = '<button type="button" name="edit" id="' . $data->id . '" class="edit btn btn-primary btn-sm"><i class="fa fa-edit"></i></button>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<button type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.comments.comments')
        ->with('posts', Post::get(['id', 'title']));
    }

    public function store(Request $request)
    {
        $rules = array(
            'content' => 'required',
            'post_id' => 'required'
        );

        $error = Validator::make($request->all(), $rules);

        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        Comment::create($request->all());
        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function edit($id)
    {
        if (request()->ajax()) {
            $data = Comment::findOrFail($id);
            return response()->json(['data' => $data]);
        }
    }

    public function update(Request $request)
    {
        $rules = array(
            'content' => 'required',
            'post_id' => 'required'
        );

        $error = Validator::make($request->all(), $rules);

        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $comment = Comment::findOrFail($request->hidden_id);
        $comment->update($request->all());
        return response()->json(['success' => 'Data is successfully updated']);
    }

    public function destroy($id)
    {
        $data = Comment::findOrFail($id);
        $data->delete();
    }
}
