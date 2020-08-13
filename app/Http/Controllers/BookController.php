<?php

namespace App\Http\Controllers;

use App\Book;
use App\User;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.book.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::pluck('name', 'id')->sort()->toArray();
        $model = new Book();

        return view('pages.book.form', [
            'users' => $users,
            'model' => $model
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title'         => 'required|string|max:225',
            'cover'         => 'file|image',
        ]);

        $cover = null;

        if($request->hasFile('cover')) {
            $cover = $request->file('cover')->store('assets/covers');
        }

        $model = Book::create([
                    'title' => $request->title,
                    'user_id' => $request->user_id,
                    'cover' => $cover,
                ]);

        return $model;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        $model = Book::findOrFail($book->id);
        return view('pages.book.show', compact('model'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function edit(Book $book)
    {
        $model = Book::with('user')->findOrFail($book->id);
        $users = User::pluck('name', 'id')->sort()->toArray();

        return view('pages.book.form', [
            'model' => $model,
            'users' => $users
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book)
    {
        // dd($request);
        $this->validate($request, [
            'title'  => 'required|string|max:225',
            'cover'  => 'file|image',
        ]);

        $cover = $book->cover;

        if($request->hasFile('cover')){
            Storage::delete($book->cover);
            $cover = $request->file('cover')->store('assets/covers');
        }

        $model = $book->update([
            'title' => $request->title,
            'user_id' => $request->user_id,
            'cover' => $cover,
        ]);

        return;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        // $book->delete();
        // Storage::delete($book->cover);

        $model = Book::findOrFail($book->id);
        Storage::delete($book->cover);
        $model->delete();
    }

    public function dataTable()
    {
        $book   = Book::with('user');
        $model  = Book::query();

        return DataTables::of($book)
            ->addColumn('action', function($model){
                return view('layouts._action', [
                    'model' => $model,
                    'url_show' => route('book.show', $model->id),
                    'url_edit' => route('book.edit', $model->id),
                    'url_destroy' => route('book.destroy', $model->id)
                ]);
            })
            ->addColumn('user', function($model) {
                return $model->user->name;
            })
            ->editColumn('cover', function($model){
                return '<img src="' . $model->getCover() . '" height="150px">';
            })
            ->addIndexColumn()
            ->rawColumns(['cover', 'action'])
            ->make(true);
    }
}
