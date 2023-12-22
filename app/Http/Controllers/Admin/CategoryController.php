<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Intervention\Image\Facades\Image;

// DI CODE - Start
use Illuminate\Support\Facades\DB;
// DI CODE - End

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $titles = ['title' => 'Manage Category', 'subTitle' => 'Add Category', 'listTitle' => 'Category List'];
        $deleteRouteName = "category.destroy";

        $categories = Category::with('parent')->get();
        $parentCategories = Category::where('category_id', 0)->get();
        $noImage = asset(Config::get('constants.NO_IMG_ADMIN'));

        return view('admin.category.create', compact('titles', 'categories', 'parentCategories', 'noImage', 'deleteRouteName'));
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
            'name_en' => 'required',
            'name_ar' => 'required',
             // DI CODE - Start 
            'image' => 'image:png,jpg,jpeg',
            'banner_image' => 'image:png,jpg,jpeg',
            'slide_image' => 'image:png,jpg,jpeg',
			// DI CODE - End
        ]);

        $data = array();

        $categoryImage = $request->file('image');
        $bannerImage = $request->file('banner_image');
		// DI CODE - Start
        $sliderImage = $request->file('slide_image');
		// DI CODE - End

        if ($categoryImage != NULL) {
            $newFileName = time() . $categoryImage->getClientOriginalName();
            $originalPath = Category::$imagePath;
            
			// DI CODE - Start
			/*// Image Upload Process
            $thumbnailImage = Image::make($categoryImage);
            $thumbnailImage->save($originalPath . $newFileName);*/
			
			$mediumPath = Category::$imageMediumPath;
			$thumbPath = Category::$imageThumbPath;

			// Image Upload Process
			$processImage = Image::make($categoryImage);
			$processImage->save($originalPath . $newFileName);

			// resize the image to a width of 500 and constrain aspect ratio (auto height)
			$processImage->resize(420, null, function ($constraint) {
				$constraint->aspectRatio();
			});
			$processImage->save($mediumPath . $newFileName);

			// resize the image to a width of 250 and constrain aspect ratio (auto height)
			$processImage->resize(250, null, function ($constraint) {
				$constraint->aspectRatio();
			});
			$processImage->save($thumbPath . $newFileName);
			// DI CODE - End

            $data['image'] = $newFileName;
        }

        if ($bannerImage != NULL) {
            $newFileName = time() . $bannerImage->getClientOriginalName();
            $originalPath = Category::$imagePath;
			
			// DI CODE - Start
            /*// Image Upload Process
            $thumbnailImage = Image::make($bannerImage);
            $thumbnailImage->save($originalPath . $newFileName);*/
			
			$mediumPath = Category::$imageMediumPath;
			$thumbPath = Category::$imageThumbPath;

			// Image Upload Process
			$processImage = Image::make($bannerImage);
			$processImage->save($originalPath . $newFileName);

			// resize the image to a width of 500 and constrain aspect ratio (auto height)
			$processImage->resize(420, null, function ($constraint) {
				$constraint->aspectRatio();
			});
			$processImage->save($mediumPath . $newFileName);

			// resize the image to a width of 250 and constrain aspect ratio (auto height)
			$processImage->resize(250, null, function ($constraint) {
				$constraint->aspectRatio();
			});
			$processImage->save($thumbPath . $newFileName);
			// DI CODE - End

            $data['banner_image'] = $newFileName;
        }
		// DI CODE - Start
		if ($sliderImage != NULL) {
            $newFileName = time() . $sliderImage->getClientOriginalName();
            $originalPath = Category::$imagePath;
			
			$mediumPath = Category::$imageMediumPath;
			$thumbPath = Category::$imageThumbPath;

			// Image Upload Process
			$processImage = Image::make($sliderImage);
			$processImage->save($originalPath . $newFileName);

			// resize the image to a width of 500 and constrain aspect ratio (auto height)
			$processImage->resize(420, null, function ($constraint) {
				$constraint->aspectRatio();
			});
			$processImage->save($mediumPath . $newFileName);

			// resize the image to a width of 250 and constrain aspect ratio (auto height)
			$processImage->resize(250, null, function ($constraint) {
				$constraint->aspectRatio();
			});
			$processImage->save($thumbPath . $newFileName);

            $data['slide_image'] = $newFileName;
        }
		// DI CODE - End

        $data['name_en'] = $request->name_en;
		// DI CODE - Start
		$data['slug']	 = unique_slug($request->name_en, 'Category');
		// DI CODE - End
        $data['name_ar'] = $request->name_ar;
        $data['category_id'] = $request->category_id;

        Category::create($data);
        return redirect()->route('category.index')->with('success', 'Created Successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $titles = ['title' => 'Manage Category', 'subTitle' => 'Add Category', 'listTitle' => 'Category List'];
        $editCategory = Category::find($id);

        $parentCategories = Category::where('category_id', 0)->get();

        return view('admin.category.edit', compact('titles', 'parentCategories', 'editCategory'));
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
            'name_en' => 'required',
            'name_ar' => 'required',
            'image' => 'image:png,jpg,jpeg',
            'banner_image' => 'image:png,jpg,jpeg',
            'slide_image' => 'image:png,jpg,jpeg',
        ]);

        $data = array();

        $category = Category::find($id);

        $categoryImage = $request->file('image');
        $bannerImage = $request->file('banner_image');
		// DI CODE - Start
        $sliderImage = $request->file('slide_image');
		// DI CODE - End

        if ($categoryImage != NULL) {

            // Delete the previous image
            $this->deleteImageBuddy(Category::$imagePath, $category->image);

            $newFileName = time() . $categoryImage->getClientOriginalName();
            $originalPath = Category::$imagePath;

            // DI CODE - Start
			/*// Image Upload Process
            $thumbnailImage = Image::make($categoryImage);
            $thumbnailImage->save($originalPath . $newFileName);*/
			
			$mediumPath = Category::$imageMediumPath;
			$thumbPath = Category::$imageThumbPath;

			// Image Upload Process
			$processImage = Image::make($categoryImage);
			$processImage->save($originalPath . $newFileName);

			// resize the image to a width of 500 and constrain aspect ratio (auto height)
			$processImage->resize(420, null, function ($constraint) {
				$constraint->aspectRatio();
			});
			$processImage->save($mediumPath . $newFileName);

			// resize the image to a width of 250 and constrain aspect ratio (auto height)
			$processImage->resize(250, null, function ($constraint) {
				$constraint->aspectRatio();
			});
			$processImage->save($thumbPath . $newFileName);
			// DI CODE - End

            $category->image = $newFileName;
        }

        if ($bannerImage != NULL) {

            // Delete the previous image
            $this->deleteImageBuddy(Category::$imagePath, $category->banner_image);

            $newFileName = time() . $bannerImage->getClientOriginalName();
            $originalPath = Category::$imagePath;

            // DI CODE - Start
			/*// Image Upload Process
            $thumbnailImage = Image::make($bannerImage);
            $thumbnailImage->save($originalPath . $newFileName);*/
			
			$mediumPath = Category::$imageMediumPath;
			$thumbPath = Category::$imageThumbPath;

			// Image Upload Process
			$processImage = Image::make($bannerImage);
			$processImage->save($originalPath . $newFileName);

			// resize the image to a width of 500 and constrain aspect ratio (auto height)
			$processImage->resize(420, null, function ($constraint) {
				$constraint->aspectRatio();
			});
			$processImage->save($mediumPath . $newFileName);

			// resize the image to a width of 250 and constrain aspect ratio (auto height)
			$processImage->resize(250, null, function ($constraint) {
				$constraint->aspectRatio();
			});
			$processImage->save($thumbPath . $newFileName);
			// DI CODE - End

            $category->banner_image = $newFileName;
        }
		// DI CODE - Start
		if ($sliderImage != NULL) {
			// Delete the previous image
            $this->deleteImageBuddy(Category::$imagePath, $category->slide_image);
			
            $newFileName = time() . $sliderImage->getClientOriginalName();
            $originalPath = Category::$imagePath;
			
			$mediumPath = Category::$imageMediumPath;
			$thumbPath = Category::$imageThumbPath;

			// Image Upload Process
			$processImage = Image::make($sliderImage);
			$processImage->save($originalPath . $newFileName);

			// resize the image to a width of 500 and constrain aspect ratio (auto height)
			$processImage->resize(420, null, function ($constraint) {
				$constraint->aspectRatio();
			});
			$processImage->save($mediumPath . $newFileName);

			// resize the image to a width of 250 and constrain aspect ratio (auto height)
			$processImage->resize(250, null, function ($constraint) {
				$constraint->aspectRatio();
			});
			$processImage->save($thumbPath . $newFileName);

            $category->slide_image = $newFileName;
        }
		// DI CODE - End

        $category->name_en = $request->name_en;		
		// DI CODE - Start
		$category->slug	 = unique_slug($request->name_en, 'Category');
		// DI CODE - End
        $category->name_ar = $request->name_ar;
        $category->category_id = $request->category_id;

        $category->save();

        return redirect()->route('category.index')->with('success', 'Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        $title = 'Delete';

        $deleteId = $request->delete_id;
        $category = Category::find($deleteId);
		
        if ($deleteId) {
            // $category = Category::with('ads')->findOrFail($deleteId);

            // Delete the previous image
            $this->deleteImageBuddy(Category::$imagePath, $category->image);
            $this->deleteImageBuddy(Category::$imagePath, $category->banner_image);
            $category->delete();

            return redirect()->route('category.index')->with('success', 'Deleted Successfully');

        }
    }
	
	// DI CODE - Start
	public function getBrand(Request $request)
	{		
		$cat_id = $_REQUEST['cat_id'];
		
		//$brand = DB::table('brands')->where('category_id', $cat_id)->value('name_en');
		$brand = DB::table('brands')->where('category_id', $cat_id)->get();
		
		if(count($brand)>0){			
			$brand_val = array();
			foreach($brand as $brandval)
			{
				//$brand_val[]  = '<option value="'.$brandval->id.'">'.$brandval->name_en.'</option>';
				$brand_val[$brandval->id]  = $brandval->name_en;
			}			
			echo json_encode($brand_val);
		}
		else{return false;}
	}	
	
	public function deleteCatSlide($deleteId)
    {
        if ($deleteId) {
			$catimage = Category::find($deleteId);
            if ($catimage) {
                $imageName = $catimage->slide_image;
                $this->deleteImageBuddy(Category::$imagePath, $imageName);
                $this->deleteImageBuddy(Category::$imageMediumPath, $imageName);
                $this->deleteImageBuddy(Category::$imageThumbPath, $imageName);
                
				Category::where('id', $catimage->id)->update(['slide_image' => null]);
            }
            return json_encode(['status' => 1]);
        }
    }
	// DI CODE - End
}