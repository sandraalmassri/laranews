<?php

namespace App\Http\Controllers;

use App\Models\category;
use Illuminate\Http\Request;
use App\Http\Controllers\categoryResource;
use App\Mail\UserWelcomeEmail;
use App\Models\Admin;
use App\Models\writer;
use App\Notifications\NewUserNotification;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Permission;
use Symfony\Component\HttpFoundation\Response;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $categories = category::all();
        // return response()->view('backend.categories.category',['categories'=>$categories]);
        $categories = category::all();
        return response()->view('cms.categories.index', ['categories' => $categories]);

    //     {
    //     if ($request->expectsJson()) {


    //         return categoryResource::collection($categories);

    //     } else {
    //         return response()->view('backend.categories$categories.index', ['categories$categories' => $categories]);
    //     }
    // }
}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
     {return response()->view('cms.categories.edit');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        //dd($request->all());
        $request->validate([
            'name' => 'required|string|min:3',
            'status' => 'nullable|string|in:on',

        ], [
            'name.required' => 'Enter the category name',

        ]);

       $category = new category();

        $category->name = $request->input('name');
        $category->status = $request->has('status');
        $isSaved = $category->save();

        if ($isSaved) {
            session()->flash('message', 'category created successfully');
            return redirect()->back();

        }

             //error- هنا ما بيحفظ

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(category $category)
    {
        //
        return response()->view('cms.categories.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, category $category)
    {
        $request->validate([
            'name' => 'required|string|min:3|max:50',
            'status' => 'nullable|string|in:on'
        ]);

        $category->name = $request->input('name');
        $category->status = $request->has('status');
        $isSaved = $category->save();

        if ($isSaved) {
            return redirect()->route('categories.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(category $category)
    {
        $isDeleted = $category->delete();
        return redirect()->back();
    }
}
