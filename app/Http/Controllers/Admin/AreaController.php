<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Area;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Intervention\Image\Facades\Image;

class AreaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $titles = ['title' => 'Manage Area', 'subTitle' => 'Add Area', 'listTitle' => 'Area List'];
        $deleteRouteName = "area.destroy";

        $areas = Area::with('parent')->get();
        $states = Area::where('area_id', 0)->get();
        $noImage = asset(Config::get('constants.NO_IMG_ADMIN'));

        return view('admin.area.create', compact('titles', 'areas', 'states', 'noImage', 'deleteRouteName'));
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
        ]);

        $data = array();

        $areaImage = $request->file('image');

        if ($areaImage != NULL) {
            $newFileName = time() . $areaImage->getClientOriginalName();
            $originalPath = Area::$imagePath;

            // DI CODE - Start
			/*// Image Upload Process
            $thumbnailImage = Image::make($areaImage);
            $thumbnailImage->save($originalPath . $newFileName);*/
			
			$mediumPath = Area::$imageMediumPath;
			$thumbPath = Area::$imageThumbPath;

			// Image Upload Process
			$processImage = Image::make($areaImage);
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

        $data['name_en'] = $request->name_en;
        $data['name_ar'] = $request->name_ar;
        $data['area_id'] = $request->area_id;
        $data['slug'] = unique_slug($request->name_en, 'Area');

        Area::create($data);
        return redirect()->route('area.index')->with('success', 'Created Successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $titles = ['title' => 'Manage Area', 'subTitle' => 'Add Area', 'listTitle' => 'Area List'];
        $editArea = Area::find($id);

        $states = Area::where('area_id', 0)->get();

        return view('admin.area.edit', compact('titles', 'states', 'editArea'));
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
        ]);

        $data = array();

        $area = Area::find($id);

        $areaImage = $request->file('image');

        if ($areaImage != NULL) {

            // Delete the previous image
            $this->deleteImageBuddy(Area::$imagePath, $area->image);

            $newFileName = time() . $areaImage->getClientOriginalName();
            $originalPath = Area::$imagePath;

            // DI CODE - Start
			/*// Image Upload Process
            $thumbnailImage = Image::make($areaImage);
            $thumbnailImage->save($originalPath . $newFileName);*/
			
			$mediumPath = Area::$imageMediumPath;
			$thumbPath = Area::$imageThumbPath;

			// Image Upload Process
			$processImage = Image::make($areaImage);
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

            $area->image = $newFileName;
        }

        $area->name_en = $request->name_en;
        $area->name_ar = $request->name_ar;
        $area->area_id = $request->area_id;
        $data['slug'] = unique_slug($request->name_en, 'Area', $id);

        $area->save();

        return redirect()->route('area.index')->with('success', 'Updated Successfully');
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
        $area = Area::find($deleteId);

        if ($deleteId) {
            // $area = Area::with('ads')->findOrFail($deleteId);

            // Delete the previous image
            $this->deleteImageBuddy(Area::$imagePath, $area->image);
            $area->delete();

            return redirect()->route('area.index')->with('success', 'Deleted Successfully');

        }
    }
}
