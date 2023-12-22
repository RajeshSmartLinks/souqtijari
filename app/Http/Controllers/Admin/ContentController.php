<?php
// DI CODE - Start
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class ContentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $titles = ['title' => 'Manage Content', 'subTitle' => 'Content List'];
        $deleteRouteName = "content.destroy";

        $posts = Post::whereType('page')->get();

        return view('admin.content.list', compact('titles', 'deleteRouteName', 'posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $titles = ['title' => 'Manage Content', 'subTitle' => 'Add Content'];

        return view('admin.content.create', compact('titles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title_en' => 'required',
            'title_ar' => 'required',
            'description_en' => 'required',
            'description_ar' => 'required',
        ]);

        $data = array();

        $brandImage = $request->file('image');

        if ($brandImage != NULL) {
            $newFileName = time() . $brandImage->getClientOriginalName();
            $originalPath = Post::$imagePath;
            $mediumPath = Post::$imageMediumPath;
            $thumbPath = Post::$imageThumbPath;

            // Image Upload Process
            $processImage = Image::make($brandImage);
            $processImage->save($originalPath . $newFileName);

            // resize the image to a width of 500 and constrain aspect ratio (auto height)
            $processImage->resize(375, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $processImage->save($mediumPath . $newFileName);

            // resize the image to a width of 250 and constrain aspect ratio (auto height)
            $processImage->resize(100, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $processImage->save($thumbPath . $newFileName);

            $data['image_name'] = $newFileName;
        }

        $data['slug'] = unique_slug($request->title_en, 'Post');
        $data['title_en'] = $request->title_en;
        $data['title_ar'] = $request->title_ar;
        $data['description_en'] = $request->description_en;
        $data['description_ar'] = $request->description_ar;
        $data['meta_keyword'] = $request->meta_keyword;
        $data['meta_description'] = $request->meta_description;
        $data['post_date'] = Carbon::now()->toDateTimeString();
        $data['type'] = 'page';
        $data['user_id'] = auth()->user()->id;

        Post::create($data);

        return redirect(route('content.index'))->with('success', 'Created Successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $titles = ['title' => 'Manage Content', 'subTitle' => 'Content Edit'];
        $deleteRouteName = "content.destroy";

        $editPost = Post::find($id);

        return view('admin.content.edit', compact('titles', 'editPost'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title_en' => 'required',
            'title_ar' => 'required',
            'description_en' => 'required',
            'description_ar' => 'required',
        ]);

        $data = array();
        $post = Post::find($id);

        $brandImage = $request->file('image');

        if ($brandImage != NULL) {

            // Delete the previous image
            $this->deleteImageBuddy(Post::$imagePath, $post->image_name);
            $this->deleteImageBuddy(Post::$imageMediumPath, $post->image_name);
            $this->deleteImageBuddy(Post::$imageThumbPath, $post->image_name);

            $newFileName = time() . $brandImage->getClientOriginalName();
            $originalPath = Post::$imagePath;
            $mediumPath = Post::$imageMediumPath;
            $thumbPath = Post::$imageThumbPath;

            // Image Upload Process
            $processImage = Image::make($brandImage);
            $processImage->save($originalPath . $newFileName);

            // resize the image to a width of 500 and constrain aspect ratio (auto height)
            $processImage->resize(375, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $processImage->save($mediumPath . $newFileName);

            // resize the image to a width of 250 and constrain aspect ratio (auto height)
            $processImage->resize(100, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $processImage->save($thumbPath . $newFileName);

            $post->image_name = $newFileName;
        }

        $post->title_en = $request->title_en;
        $post->title_ar = $request->title_ar;
        $post->description_en = $request->description_en;
        $post->description_ar = $request->description_ar;
        $post->meta_keyword = $request->meta_keyword;
        $post->meta_description = $request->meta_description;

        $post->save();

        return redirect(route('content.index'))->with('success', 'Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        $deleteId = $request->delete_id;
        $detail = Post::find($deleteId);

        if ($deleteId) {
            // Delete the previous image
            $this->deleteImageBuddy(Post::$imagePath, $detail->image_name);
            $this->deleteImageBuddy(Post::$imageMediumPath, $detail->image_name);
            $this->deleteImageBuddy(Post::$imageThumbPath, $detail->image_name);
            $detail->delete();

            return redirect()->route('content.index')->with('success', 'Deleted Successfully');

        }
    }
}
// DI CODE - End