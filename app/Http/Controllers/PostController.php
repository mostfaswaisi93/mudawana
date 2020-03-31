<?php

namespace App\Http\Controllers;

use App\Post;
use App\Tag;
use Illuminate\Http\Request;
use Validator;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $posts = Post::with('tags')->get();

        if (request()->ajax()) {
            return datatables()->of($posts)
                ->addColumn('tags', function ($data) {
                    return $data->tags;
                })
                ->addColumn('action', function ($data) {
                    $button = '<button type="button" name="edit" id="' . $data->id . '" class="edit btn btn-primary btn-sm"><i class="fa fa-edit"></i></button>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<button type="button" name="show" id="' . $data->id . '" class="showBtn btn btn-info btn-sm"><i class="fa fa-eye"></i></button>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<button type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.posts.posts')
            ->with('tags', Tag::get(['id', 'name']));
    }

    public function store(Request $request)
    {
        $rules = array(
            'title'     => 'required',
            'author'    => 'required',
            'body'      => 'required'
        );

        $error = Validator::make($request->all(), $rules);

        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'title'                 =>  $request->title,
            'author'                =>  $request->author,
            'body'                  =>  $request->body
        );

        Post::create($form_data)->tags()->attach($request->tag_id);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function show($id)
    {
        if (request()->ajax()) {
            $data = Post::with('tags')->findOrFail($id);
            return response()->json(['data' => $data]);
        }
    }

    public function edit($id)
    {
        if (request()->ajax()) {
            $data = Post::with(['tags'])->findOrFail($id);
            return response()->json(['data' => $data]);
        }
    }

    public function update(Request $request)
    {
        $rules = array(
            'title'     => 'required',
            'author'    => 'required',
            'body'      => 'required'
        );

        $error = Validator::make($request->all(), $rules);

        if ($error->fails()) {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'title'                 =>  $request->title,
            'author'                =>  $request->author,
            'body'                  =>  $request->body
        );


        $post = Post::findOrFail($request->hidden_id);
        $post->update($form_data);
        $post->tags()->sync($request->tag_id);

        return response()->json(['success' => 'Data is successfully updated']);
    }

    public function destroy($id)
    {
        $data = Post::findOrFail($id);
        $data->delete();
        $data->tags()->detach();
    }

    public function updatePublished(Request $request, $id)
    {
        $post               = Post::find($id);
        $published          = $request->get('published');
        $post->published    = $published;
        $post               = $post->save();

        if ($post) {
            return response(['success' => TRUE, "message" => 'Done']);
        }
    }
}
