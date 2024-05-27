<?php

namespace App\Http\Controllers\Landlord;

use App\Area;
use App\House;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AreaController extends Controller
{
 
    public function index()
    {
        $areas = Area::latest()->paginate(8);
        $areacount = Area::all()->count();
        return view('landlord.area.index', compact('areas', 'areacount'));
    }

    public function create()
    {
        return view('landlord.area.create');
    }


    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|unique:areas'
        ]);
    
        $area = new Area();
        $area->name = $request->name;
        $area->user_id = Auth::id();
        $area->save();
        return redirect(route('landlord.area.index'))->with('success', 'Area Added successfully');
    }

    public function show($id)
    {
        //
    }

  
    public function edit(Area $area)
    {
        return view('landlord.area.edit')->with('area', $area);
    }

 
    public function update(Request $request, Area $area)
    {
        $this->validate($request,[
            'name' => 'required|unique:areas,name,'. $area->id ,
        ]);
    
        $area->name = $request->name;
        $area->save();

        return redirect(route('landlord.area.index'))->with('success', 'Area Updated Successfully');
    }


    public function destroy(Area $area)
    {
        if(House::where('area_id', $area->id)->count() > 0){
            session()->flash('danger', 'You do not delete this area because it have some houses imformation');
            return redirect()->back();
        }
        $area->delete();
        return redirect(route('landlord.area.index'))->with('success', 'Area Removved Successfully');
    }
}
