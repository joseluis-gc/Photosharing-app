<?php

namespace App\Http\Controllers;

use App\Models\Album;
#use Dotenv\Util\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AlbumController extends Controller
{
    //

    public function Index()
    {
        # code...
        return view('album.index');
    }

    public function getAlbums()
    {
        # code...
        $albums = Album::with('Category')->where('user_id', auth()->user()->id)->get();
        return $albums;
    }

    public function Create()
    {
        # code...
        return view('album.create');
    }

    public function Store(Request $request)
    {
        # code...
        $this->validate($request,[
            'name'=>'required|min:3|max:100',
            'description'=>'required|max:140',
            'category'=>'required',
            'image'=>'required|mimes:jpg,jpeg,png,gif'
        ]);

        $image_name = $request->image->hashName();
        $request->image->move(public_path('album'), $image_name);
        $album = Album::create([
            'name'=>$request->name,
            'description'=>$request->description,
            'category_id'=>$request->category,
            'slug'=>Str::slug($request->name),
            'user_id'=>auth()->user()->id,
            'image'=>$image_name

        ]);

        $id = $album->id;
        return response()->json(['id'=>$id]);
    }

    public function getOneAlbum($id)
    {
        # code...
        return Album::with('category')->find($id);
    }

    public function Update($id, Request $request)
    {
        # code...
        $find_album = Album::find($id);
        $photo = $find_album->image;

        if($request->hasFile('image'))
        {
            $file = $request->file('image');
            $photo = $file->hashName();
            $file->move('./album/', $photo);
        }

        $album = Album::find($id);
        $album->name = $request->name;
        $album->description = $request->description;
        $album->category_id = $request->category;
        $album->image = $photo;
        $success = $album->save();

        if($success)
        {
            return response()->json($this->getAlbums());
        }

    }



    public function destroy($id)
    {
        # code...
        $album = Album::find($id)->delete();
        if($album)
        {
            return response()->json($this->getAlbums());
        }
    }
}
