<?php
// DI CODE - Start
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $titles = ['title' => 'Manage Faq', 'subTitle' => 'Add Faq', 'listTitle' => 'Faq List'];
        $deleteRouteName = "faq.destroy";

        $faqs = Faq::get();

		return view('admin.faq.create', compact('titles', 'faqs', 'deleteRouteName'));
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
            'faq_title_en'			=> 'required',
            'faq_title_ar'			=> 'required',
            'faq_description_en'	=> 'required',
            'faq_description_ar'	=> 'required',
        ]);
		
        $data = array();

        $data['faq_title_en']		= $request->faq_title_en;
        $data['faq_title_ar']		= $request->faq_title_ar;
		$data['slug']				= unique_slug($request->faq_title_en, 'Faq');
        $data['faq_description_en']	= $request->faq_description_en;
        $data['faq_description_ar']	= $request->faq_description_ar;
		
        Faq::create($data);
        return redirect()->route('faq.index')->with('success', 'Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $titles = ['title' => 'Edit Faq'];
        $editFaq = Faq::find($id);

		return view('admin.faq.edit', compact('titles', 'editFaq'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'faq_title_en'			=> 'required',
            'faq_title_ar'			=> 'required',
            'faq_description_en'	=> 'required',
            'faq_description_ar'	=> 'required',
        ]);

        $data = array();		
        $faq = Faq::find($id);

        $faq->faq_title_en			= $request->faq_title_en;
        $faq->faq_title_ar			= $request->faq_title_ar;
		$faq->slug					= unique_slug($request->faq_title_en, 'Faq');
        $faq->faq_description_en	= $request->faq_description_en;
        $faq->faq_description_ar	= $request->faq_description_ar;

        $faq->save();
        return redirect()->route('faq.index')->with('success', 'Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        $title = 'Delete';

        $deleteId = $request->delete_id;
        $faq = Faq::find($deleteId);
		
        if ($deleteId) {
            $faq->delete();
            return redirect()->route('faq.index')->with('success', 'Deleted Successfully');

        }
    }
}
// DI CODE - End