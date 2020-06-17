<?php

namespace App\Http\Controllers\Admin;
use App\Photo;
use App\Category;
use App\Tag;
use App\PhotoDescription;
use App\Taggable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PhotosController extends Controller
{

    function create(){
        $categories= Category::all();
        $tags= Tag::all();
        return view("admin.photos.create",["categories" => $categories, "tags" => $tags]);
       
    }
    function index(){
        $photos= Photo::all();
        return view("admin.photos.index",["photos" => $photos]);
        // echo "<pre>" . json_encode($photos, JSON_PRETTY_PRINT). "</pre>";
    }

    public function store(Request $request){
        $request->validate([
            'title' => 'required|max:255',
            'image' => 'required',
            'category' => 'required',
            'tag' => 'required',
            'description' => 'required'
        ]);
        $image= $request->file("image")-> store("public");
        $title=$request->title;  
        $category_id=$request->category;
        $tag_id=$request->tag;
        $input['tag_id'] = implode(',', $tag_id);
       

        $photo= new Photo;
        $photo->title= $title;
        $photo->image= $image;
        $photo->category_id= $category_id;
        $photo->save();
        
        $description = new PhotoDescription;
        $description->photo_id = $photo->id;
        $description->content = $request->description;
        $description->save();

        for($i=0; $i<count($tag_id); $i++){
        $taggable = new Taggable;
        $taggable->photo_id= $photo->id;
        $taggable->tag_id=$tag_id[$i];
        $taggable->save();
        }
         return redirect("admin/photos");

    }

    public function edit($id)
    {
        $categories= Category::all();
        $tags= Tag::all();
        $photo= Photo::find($id);
    //    $photo = DB::table("photos")->where("id", $id)->find($id);
      return view("admin.photos.edit", ["photo"=> $photo,"categories" => $categories, "tags" => $tags]);
    }

   
    public function update(Request $request, $id)
    {
        $image= $request->file("image")-> store("public");
        $title=$request->title;  
        $category_id=$request->category;
        $tag_id=$request->tag;
        $input['tag_id'] = implode(',', $tag_id);

       $photo= new Photo;
        $photo_id = $photo->id;
  
        DB::table("photos")->where("id", $id)->update(
            ["title" =>  $title,  "image"=> $image, "category_id"=> $category_id]);
      
        
        DB::table("photo_descriptions")->where("photo_id", $id)->update(
            ["photo_id" => $id,  "content"=> $request->description]);

        for($i=0; $i<count($tag_id); $i++){
            DB::table("taggables")->where("photo_id", $id)->update(
                ["photo_id" => $id,  "tag_id"=> $tag_id[$i]]);
        }
         return redirect("admin/photos");
        
    }


    public function destroy($id)
    {
       
        DB::table("photo_descriptions")->where("photo_id" ,"=", $id)->delete();
        DB::table("taggables")->where("photo_id" ,"=", $id)->delete();
        DB::table("photos")->where("id" ,"=", $id)->delete();
         return redirect("admin/photos");
    }

}