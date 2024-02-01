<?php
// DI CODE - Start
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/* Newly Added */
use App\Models\Ad;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Area;
use App\Models\User;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;


class AdController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $titles = ['title' => 'Add Ad'];

        $categories = Category::with('parent')->get();	
		$areas = Area::with('parent')->get();
		
		return view('admin.ad.create', compact('titles', 'categories', 'areas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'ad_category_id' => 'required',
            'ad_title' => 'required',
            'ad_description' => 'required',
            'ad_location_area' => 'required',
            'ad_condition' => 'required',
            'ad_price' => 'required',
            'ad_seller_name' => 'required',
            'ad_seller_email' => 'required|email',
            'ad_seller_phone' => 'required',
			'ad_image[]' => 'image|mimes:jpeg,jpg,png,gif',
        ]);
		
        $data = array();
		
		$parentCategoryId			= Category::where('id', $request->ad_category_id)->get();		
		$data['ad_category_id']		= $parentCategoryId[0]->category_id;		
		$data['ad_sub_category_id']	= $request->ad_category_id;		
		$data['ad_brand_id']		= $request->ad_brand_id;
        $data['ad_title']			= $request->ad_title;
		$data['slug']				= unique_slug($request->ad_title, 'Ad');
        $data['ad_description']		= $request->ad_description;
        $data['ad_location_area']	= $request->ad_location_area;				
		$ad_location_area_cat = Area::where('id',$request->ad_location_area)->first();		
        $data['ad_location_area_cat']= $ad_location_area_cat->area_id;
        $data['ad_condition']		= $request->ad_condition;
        $data['ad_price']			= $request->ad_price;
		if($request->ad_is_negotiable){
			$data['ad_is_negotiable']	= $request->ad_is_negotiable;
		}        
        $data['ad_seller_name']		= $request->ad_seller_name;
        $data['ad_seller_email']	= $request->ad_seller_email;
        $data['ad_seller_phone']	= $request->ad_seller_phone;
        $data['ad_seller_address']	= $request->ad_seller_address;
		
		$user = auth()->user();
		$data['ad_user_id']	= $user->id;
		
        $create_Ad = Ad::create($data);
		
		//Add Images
        $images = $request->file('ad_image');
        if ($images) {
            for ($i = 0; $i < count($images); $i++) {
                $image = $images[$i];
                if ($image != NULL) {
                    $newFileName = sha1(date('YmdHis')) . '-' . $image->getClientOriginalName();
                    $originalPath = Ad::$imagePath;
                    $mediumPath = Ad::$imageMediumPath;
                    $thumbPath = Ad::$imageThumbPath;

                    // Image Upload Process
                    $processImage = Image::make($image);
                    $processImage->save($originalPath . $newFileName);

                    // resize the image to a width of 500 and constrain aspect ratio (auto height)
                    $processImage->resize(500, null, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                    $processImage->save($mediumPath . $newFileName);

                    // resize the image to a width of 250 and constrain aspect ratio (auto height)
                    $processImage->resize(250, null, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                    $processImage->save($thumbPath . $newFileName);

                    /*$mediaData = new Media;
                    $mediaData->media_for = "product";
                    $mediaData->session_id = Session::getId();
                    $mediaData->storage_type = "public";
                    $mediaData->user_id = $agent;
                    $mediaData->ad_id = $sls_product_data->id;
                    $mediaData->image_name = $newFileName;

                    $mediaData->save();*/
					
					DB::insert('INSERT INTO '.DB::getTablePrefix().'ads_images (`ads_ad_id`, `ads_user_id`, `ads_image`, `created_at`, `updated_at`) VALUES (?,?,?,?,?)', [$create_Ad->id, $user->id, $newFileName, now(), now()]);
                }
            }
        }
        return redirect()->route('ad.index')->with('success', 'Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {		
		$titles = ['title' => 'Edit Ad'];
		
		$editAd = Ad::find($id);
        $categories = Category::with('parent')->get();	
		$areas = Area::with('parent')->get();
		//$brands = Brand::get();
				
		$brands = DB::table('brands')
            ->select('*')
			->where('category_id', '=', $editAd->ad_sub_category_id)
            ->get();
		
		//$editAd = Ad::with('ads_images')->find($id);
		$adsimages = DB::table('ads_images')
            ->select('*')
			->where('ads_ad_id', '=', $editAd->id)
            ->get();
	
		return view('admin.ad.edit', compact('titles', 'categories', 'areas', 'editAd', 'brands', 'adsimages'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'ad_category_id' => 'required',
            'ad_title' => 'required',
            'ad_description' => 'required',
            'ad_location_area' => 'required',
            'ad_condition' => 'required',
            'ad_price' => 'required',
            'ad_seller_name' => 'required',
            'ad_seller_email' => 'required|email',
            'ad_seller_phone' => 'required',
			'ad_image[]' => 'image|mimes:jpeg,jpg,png,gif',
        ]);

        $data = array();

        $ad = Ad::find($id);
		
		$parentCategoryId 		= Category::where('id', $request->ad_category_id)->get();		
		$ad->ad_category_id		= $parentCategoryId[0]->category_id;		
		$ad->ad_sub_category_id	= $request->ad_category_id;
        $ad->ad_brand_id		= $request->ad_brand_id;
        $ad->ad_title			= $request->ad_title;
		//$ad->slug				= unique_slug($request->ad_title, 'Ad');
        $ad->ad_description		= $request->ad_description;
        $ad->ad_location_area	= $request->ad_location_area;	
		$ad_location_area_cat = Area::where('id',$request->ad_location_area)->first();		
        $ad->ad_location_area_cat = $ad_location_area_cat->area_id;
		$ad->ad_condition		= $request->ad_condition;
        $ad->ad_price			= $request->ad_price;
		if($request->ad_is_negotiable){
			 $ad->ad_is_negotiable	= $request->ad_is_negotiable;
		} 
        $ad->ad_seller_name		= $request->ad_seller_name;
		$ad->ad_seller_email	= $request->ad_seller_email;
        $ad->ad_seller_phone	= $request->ad_seller_phone;
        $ad->ad_seller_address	= $request->ad_seller_address;
		
		$user = auth()->user();
		/*$ad->ad_user_id	= $user->id;*/
		
        $ad->save();
		
		//Add Images
        $images = $request->file('ad_image');
        if ($images) {
            for ($i = 0; $i < count($images); $i++) {
                $image = $images[$i];
                if ($image != NULL) {
                    $newFileName = sha1(date('YmdHis')) . '-' . $image->getClientOriginalName();
                    $originalPath = Ad::$imagePath;
                    $mediumPath = Ad::$imageMediumPath;
                    $thumbPath = Ad::$imageThumbPath;

                    // Image Upload Process
                    $processImage = Image::make($image);
                    $processImage->save($originalPath . $newFileName);

                    // resize the image to a width of 500 and constrain aspect ratio (auto height)
                    $processImage->resize(500, null, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                    $processImage->save($mediumPath . $newFileName);

                    // resize the image to a width of 250 and constrain aspect ratio (auto height)
                    $processImage->resize(250, null, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                    $processImage->save($thumbPath . $newFileName);

                    /*$mediaData = new Media;
                    $mediaData->media_for = "product";
                    $mediaData->session_id = Session::getId();
                    $mediaData->storage_type = "public";
                    $mediaData->user_id = $agent;
                    $mediaData->ad_id = $sls_product_data->id;
                    $mediaData->image_name = $newFileName;

                    $mediaData->save();*/
					
					DB::insert('INSERT INTO '.DB::getTablePrefix().'ads_images (`ads_ad_id`, `ads_user_id`, `ads_image`, `created_at`, `updated_at`) VALUES (?,?,?,?,?)', [$ad->id, $user->id, $newFileName, now(), now()]);
                }
            }
        }

        return redirect()->route('adlist')->with('success', 'Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        $title = 'Delete';

        $deleteId = $request->delete_id;
        $ad = Ad::find($deleteId);
		
        if ($deleteId) {
            // Delete the ads image
			/*$adimages = DB::table('ads_images')->find($ad->id);
			
			if ($adimages) {
				$imageName = $adimages->ads_image;
				$this->deleteImageBuddy(Ad::$imagePath, $imageName);
				$this->deleteImageBuddy(Ad::$imageMediumPath, $imageName);
				$this->deleteImageBuddy(Ad::$imageThumbPath, $imageName);
				DB::table('ads_images')->where('ads_ad_id', $adimages->id)->delete();
			}*/			
            $ad->delete();
            return redirect()->route('adlist')->with('success', 'Deleted Successfully');
        }
    }
	
	public function adlist()
	{
		$titles = ['title' => 'Ads List'];
        $deleteRouteName = "ad.destroy";
		
        //$ads = Ad::get();		
		/*$ads = DB::table('ads')
            ->join('categories', 'ads.ad_category_id', '=', 'categories.id')
            ->select('ads.*', 'categories.name_en as category_name')
			->whereNull('ads.deleted_at')
            ->get();*/
		

			$ads = Ad::select('ads.*', 'cat.name_en as category_name', 'sub_cat.name_en as sub_category_name',DB::raw(' (select GROUP_CONCAT(ads_image) from sls_ads_images WHERE ads_ad_id = sls_ads.id and `status` =1 ) as ad_images'))->leftJoin('categories as cat', 'ads.ad_category_id', '=', 'cat.id')
			->leftJoin('categories as sub_cat', 'ads.ad_sub_category_id', '=', 'sub_cat.id')
			->whereNull('ads.deleted_at')
			->orderByDesc('ads.id')
            ->get();

		//print_r($ads);
		
		$noImage = asset(Config::get('constants.NO_IMG_ADMIN'));
		
		return view('admin.ad.list', compact('titles', 'ads', 'noImage', 'deleteRouteName'));
	}
	
	public function adblock(Request $request)
	{
		$ad_id = $request->ad_id;
        $ad = Ad::find($ad_id);
		
		if($ad->status==1)
		{
			$ad->status	= '0';
			$returnValue = ' Blocked';
		}
		else if($ad->status==0)
		{
			$ad->status	= '1';
			$returnValue = ' Not Blocked';
		}
		
        if($ad->save())
		{
			return $returnValue;
		}
	}
	
	
	public function adblocklist()
	{
		$titles = ['title' => 'Ads - Blocked List'];
        $deleteRouteName = "ad.destroy";
		
		$ads = Ad::join('categories as cat', 'ads.ad_category_id', '=', 'cat.id')
			->join('categories as sub_cat', 'ads.ad_sub_category_id', '=', 'sub_cat.id')
            ->select('ads.*', 'cat.name_en as category_name', 'sub_cat.name_en as sub_category_name' )
			->whereNull('ads.deleted_at')
			->orderByDesc('ads.id')
			->where('ads.status','0')
            ->get();
		
		$noImage = asset(Config::get('constants.NO_IMG_ADMIN'));		
		return view('admin.ad.blocklist', compact('titles', 'ads', 'noImage', 'deleteRouteName'));
	}
	
	public function adfeatured(Request $request)
	{
		$ad_id = $request->ad_id;
        $ad = Ad::find($ad_id);
		
		if($ad->ad_is_featured==1)
		{
			$ad->ad_is_featured	= '0';
			$returnValue = ' Not Featured';
		}
		else if($ad->ad_is_featured==0)
		{
			$ad->ad_is_featured	= '1';
			$returnValue = ' Featured';
		}
		
        if($ad->save())
		{
			return $returnValue;
		}
	}
	
	public function adpriority(Request $request)
	{
		$ad_id = $request->ad_id;
        $ad = Ad::find($ad_id);
		
		if($ad->ad_priority==1)
		{
			$ad->ad_priority	= '0';
			$returnValue = ' Not Priority';
		}
		else if($ad->ad_priority==0)
		{
			$ad->ad_priority	= '1';
			$returnValue = ' Priority';
		}
		
        if($ad->save())
		{
			return $returnValue;
		}
	}
	
	public function deleteMedia($deleteId)
    {
        if ($deleteId) {
            //$media = Media::find($deleteId);
			$adimages = DB::table('ads_images')->find($deleteId);
            if ($adimages) {
                $imageName = $adimages->ads_image;
                $this->deleteImageBuddy(Ad::$imagePath, $imageName);
                $this->deleteImageBuddy(Ad::$imageMediumPath, $imageName);
                $this->deleteImageBuddy(Ad::$imageThumbPath, $imageName);
                //$media->delete();
				DB::table('ads_images')->where('id', $adimages->id)->delete();
            }
            return json_encode(['status' => 1]);
        }
    }
	
	// Ads imported via CSV file
	public function adimport(Request $request)
	{
		$fileName = $request->import_file;
		
		if ($_FILES["import_file"]["size"] > 0)
		{        
			$file = fopen($fileName, "r");

			$row = 0;
			$headers = [];
			while (($column = fgetcsv($file, 10000, ",")) !== FALSE) 
			{
				if (++$row == 1) 
				{
					$headers = array_flip($column); // Get the column names from the header.
					//$headers = ($column); // Get the column names from the header.
					continue;
				}
				else
				{
	//				$col1 = $column[$headers['Col1Name']]; // Read row by the column name.
	//				$col2 = $column[$headers['Col2Name']];

					/*$parentCategoryId			= Category::where('name_en', $column[$headers['parent_cat_en']])->first();				
					$subCategoryId				= Category::where('name_en', $column[$headers['sub_cat_en']])->first();		
					$data['ad_category_id']		= $parentCategoryId->category_id;		
					$data['ad_sub_category_id']	= $subCategoryId->category_id;
					$data['id_old_ads']			= $column[$headers['id']];
					$data['ad_title']			= $column[$headers['title']];
					$data['slug']				= $column[$headers['slug']];
					$data['ad_description']		= $column[$headers['description']];
					$ad_location_area_cat 		= Area::where('name_en',$column[$headers['states.state_name']])->first();		
					$ad_location_area 			= Area::where('name_en',$column[$headers['cities.city_name']])->first();		
					$data['ad_location_area_cat']= $ad_location_area_cat->id;
					$data['ad_location_area']	= $ad_location_area->id;
					$data['ad_condition']		= $column[$headers['ad_condition']];
					$data['ad_price']			= $column[$headers['price']];
					$data['ad_is_negotiable']	= $column[$headers['is_negotiable']];
					$data['ad_seller_name']		= $column[$headers['seller_name']];
					$data['ad_seller_email']	= $column[$headers['seller_email']];
					$data['ad_seller_phone']	= $column[$headers['seller_phone']];
					$data['ad_seller_address']	= $column[$headers['address']];
					$data['ad_views']			= $column[$headers['view']];
					$data['created_at']			= $column[$headers['created_at']];
					$data['updated_at']			= $column[$headers['updated_at']];

					$userId						= User::where('email', $column[$headers['users.email']])->first();
					$data['ad_user_id']			= $userId->id;*/


					$parentCategoryId			= Category::where('name_en', $column[4])->first();
					$subCategoryId				= Category::where('name_en', $column[8])->first();
					$userId						= User::where('email', $column[26])->first();

					if(!empty($userId))
					{
						if(!empty($parentCategoryId) && !empty($subCategoryId))
						{
							$data['ad_category_id']		= $parentCategoryId->id;		
							$data['ad_sub_category_id']	= $subCategoryId->id;
							$data['id_old_ads']			= $column[0];
							$data['ad_title']			= $column[1];
							$data['slug']				= $column[2];
							$data['ad_description']		= $column[3];
							$ad_location_area_cat 		= Area::where('name_en',$column[28])->first();		
							$ad_location_area 			= Area::where('name_en',$column[30])->first();		
							$data['ad_location_area_cat']= $ad_location_area_cat->id;
							$data['ad_location_area']	= $ad_location_area->id;
							$data['ad_condition']		= $column[12];
							$data['ad_price']			= $column[13];
							$data['ad_is_negotiable']	= $column[14];
							$data['ad_seller_name']		= $column[15];
							$data['ad_seller_email']	= strtolower($column[16]);
							$data['ad_seller_phone']	= $column[17];
							$data['ad_seller_address']	= $column[18];
							$data['ad_views']			= $column[19];
//							$data['created_at']			= date('Y-m-d H:i:s',strtotime($column[21]));
//							$data['updated_at']			= date('Y-m-d H:i:s',strtotime($column[22]));
//							$data['created_at']			= date('Y-d-m H:i:s',strtotime($column[21]));
//							$data['updated_at']			= date('Y-d-m H:i:s',strtotime($column[22]));
							$data['created_at']			= $column[21];
							$data['updated_at']			= $column[22];
							$data['ad_user_id']			= $userId->id;
						}
						else 
						{		
							$data['ad_category_id']		= '161'; // Others Parent Category	
							$data['ad_sub_category_id']	= '163'; // Others Sub Category
							$data['id_old_ads']			= $column[0];
							$data['ad_title']			= $column[1];
							$data['slug']				= $column[2];
							$data['ad_description']		= $column[3];
							$ad_location_area_cat 		= Area::where('name_en',$column[28])->first();		
							$ad_location_area 			= Area::where('name_en',$column[30])->first();		
							$data['ad_location_area_cat']= $ad_location_area_cat->id;
							$data['ad_location_area']	= $ad_location_area->id;
							$data['ad_condition']		= $column[12];
							$data['ad_price']			= $column[13];
							$data['ad_is_negotiable']	= $column[14];
							$data['ad_seller_name']		= $column[15];
							$data['ad_seller_email']	= strtolower($column[16]);
							$data['ad_seller_phone']	= $column[17];
							$data['ad_seller_address']	= $column[18];
							$data['ad_views']			= $column[19];
//							$data['created_at']			= date('Y-m-d H:i:s',strtotime($column[21]));
//							$data['updated_at']			= date('Y-m-d H:i:s',strtotime($column[22]));
//							$data['created_at']			= date('Y-d-m H:i:s',strtotime($column[21]));
//							$data['updated_at']			= date('Y-d-m H:i:s',strtotime($column[22]));
							$data['created_at']			= $column[21];
							$data['updated_at']			= $column[22];
							$data['ad_user_id']			= $userId->id;
						}
						$create_Ad = Ad::create($data);
					}
				}

				if (! empty($create_Ad)) {
					$type = "success";
					$message = "CSV Data Imported into the Database";
				} else {
					$type = "error";
					$message = "Problem in Importing CSV Data";
				}
			}
    	}		
		return redirect()->route('adlist')->with($type, $message);
	}
	
	// Ads Images imported via CSV file
	public function adimagesimport(Request $request)
	{
		$fileName = $request->import_file_image;
		
		if ($_FILES["import_file_image"]["size"] > 0)
		{        
			$file = fopen($fileName, "r");

			$row = 0;
			$headers = [];
			while (($column = fgetcsv($file, 10000, ",")) !== FALSE) 
			{
				if (++$row == 1) 
				{
					//$headers = array_flip($column); // Get the column names from the header.
					continue;
				}
				else
				{
					$Ad			= Ad::where('id_old_ads', $column[2])->first();
					if(!empty($Ad))
					{
						$data['ads_ad_id']			= $Ad->id;
						$data['ads_user_id']		= $Ad->ad_user_id;
						$data['ads_image']			= $column[3];
						$data['is_feature']			= $column[4];
						//$data['created_at']	= date('Y-m-d H:i:s',strtotime($column[5]));
						//$data['updated_at']	= date('Y-m-d H:i:s',strtotime($column[6]));
//						$data['created_at']	= date('Y-d-m H:i:s',strtotime($column[5]));
//						$data['updated_at']	= date('Y-d-m H:i:s',strtotime($column[6]));
						$data['created_at']	= $column[5];
						$data['updated_at']	= $column[6];
						
						$create_Ad_Image = DB::insert('INSERT INTO '.DB::getTablePrefix().'ads_images (`ads_ad_id`, `ads_user_id`, `ads_image`, `is_feature`, `created_at`, `updated_at`) VALUES (?,?,?,?,?,?)', [$data['ads_ad_id'], $data['ads_user_id'], $data['ads_image'], $data['is_feature'], $data['created_at'], $data['updated_at']]);
					}
				}

				if (! empty($create_Ad_Image)) {
					$type = "success";
					$message = "CSV Data Imported into the Database";
				} else {
					$type = "error";
					$message = "Problem in Importing CSV Data";
				}
			}
    	}		
		return redirect()->route('adlist')->with($type, $message);
	}
	
	public function createadimagesthumb(Request $request)
	{
		if($request->has('submit_thumb'))
		{
			$pathToImages = Ad::$imagePath;
			$pathToThumbs = Ad::$imageThumbPath;
			$thumbWidth = '250';
			// open the directory
			  $dir = opendir( $pathToImages );

			  // loop through it, looking for any/all JPG files:
			  while (false !== ($fname = readdir( $dir ))) {
				// parse path for the extension
				$info = pathinfo($pathToImages . $fname);				
				  
				/*  // continue only if this is a JPEG image
				if ( strtolower($info['extension']) == 'jpg' ) 
				{
				  echo "Creating thumbnail for {$fname} <br />";

				  // load image and get image size
				  $img = imagecreatefromjpeg( "{$pathToImages}{$fname}" );
				  $width = imagesx( $img );
				  $height = imagesy( $img );

				  // calculate thumbnail size
				  $new_width = $thumbWidth;
				  $new_height = floor( $height * ( $thumbWidth / $width ) );

				  // create a new temporary image
				  $tmp_img = imagecreatetruecolor( $new_width, $new_height );

				  // copy and resize old image into new image 
				  imagecopyresized( $tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height );

				  // save thumbnail into a file
				  imagejpeg( $tmp_img, "{$pathToThumbs}{$fname}" );
				}*/
				  
				  if ( isset($info['extension']) AND (strtolower($info['extension']) == 'jpg' || strtolower($info['extension']) == 'jpeg' || strtolower($info['extension']) == 'png' || strtolower($info['extension']) == 'gif' ) )
				  {
					  $processImage = Image::make($pathToImages . $fname)->resize(250, null, function ($constraint) {
						  $constraint->aspectRatio();
					  });
					  $processImage->save(Ad::$imageThumbPath . $fname);
				  }
			  }
			// close the directory
			closedir( $dir );
			
			if (! empty($processImage))
			{
				$type = "success";
				$message = "Thumbimage created for the Ads Images";
			}
			return redirect()->route('adlist')->with($type, $message);
		}
	}
}
// DI CODE - End