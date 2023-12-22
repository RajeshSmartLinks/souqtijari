<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Intervention\Image\Facades\Image;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $titles = ['title' => 'Manage Brand', 'subTitle' => 'Add Brand', 'listTitle' => 'Brand List'];
        $deleteRouteName = "brand.destroy";

        $categories = Category::whereCategoryId(0)->get();
        $brands = Brand::get();
        $noImage = asset(Config::get('constants.NO_IMG_ADMIN'));

        return view('admin.brand.create', compact('titles', 'brands', 'deleteRouteName', 'noImage', 'categories'));
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
            'category_id' => 'required|integer',
            'name_en' => 'required',
            'name_ar' => 'required',
			// DI CODE - Start 
            'image' => 'image:png,jpg,jpeg',
			// DI CODE - End
        ]);

        $data = array();

        $brandImage = $request->file('image');

        if ($brandImage != NULL) {
            $newFileName = time() . $brandImage->getClientOriginalName();
            $originalPath = Brand::$imagePath;

            // Image Upload Process
            $thumbnailImage = Image::make($brandImage);
            $thumbnailImage->save($originalPath . $newFileName);

            $data['image'] = $newFileName;
        }

        $data['slug'] = unique_slug($request->name_en, 'Brand');
        $data['category_id'] = $request->category_id;
        $data['name_en'] = $request->name_en;
        $data['name_ar'] = $request->name_ar;

        Brand::create($data);
        return redirect()->route('brand.index')->with('success', 'Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $titles = ['title' => 'Manage Brand', 'subTitle' => 'Add Brand', 'listTitle' => 'Brand List'];
        $brand = Brand::find($id);
		// DI CODE - Start
		$categories = Category::whereCategoryId(0)->get();
		// DI CODE - End

        return view('admin.brand.edit', compact('titles', 'brand', 'categories'));
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
            'category_id' => 'required|integer',
            'name_en' => 'required',
            'name_ar' => 'required',
			// DI CODE - Start 
            'image' => 'image:png,jpg,jpeg',
			// DI CODE - End
        ]);

        $data = array();

        $brand = Brand::find($id);

        $brandImage = $request->file('image');

        if ($brandImage != NULL) {

            // Delete the previous image
            $this->deleteImageBuddy(Brand::$imagePath, $brand->image);

            $newFileName = time() . $brandImage->getClientOriginalName();
            $originalPath = Brand::$imagePath;

            // Image Upload Process
            $thumbnailImage = Image::make($brandImage);
            $thumbnailImage->save($originalPath . $newFileName);

            $brand->image = $newFileName;
        }

        $brand->category_id = $request->category_id;
        $brand->name_en = $request->name_en;
        $brand->name_ar = $request->name_ar;

        $brand->save();

        return redirect()->route('brand.index')->with('success', 'Updated Successfully');
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
        $brand = Brand::find($deleteId);

        if ($deleteId) {

            // Delete the previous image
            $this->deleteImageBuddy(Brand::$imagePath, $brand->image);
            $this->deleteImageBuddy(Brand::$imagePath, $brand->banner_image);
            $brand->delete();

            return redirect()->route('brand.index')->with('success', 'Deleted Successfully');

        }
    }
}
