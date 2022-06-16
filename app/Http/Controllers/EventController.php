<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use Datatables;


class EventController extends Controller
{
    public function index(){
        
        return view('eventList');
    }

    public function eventsAjax(Request $request){
        $events=Event::where('slug','!=', '')->orderBy('id','desc')->get();
        if ($request->ajax()) {
            return datatables()->of($events)
            ->addIndexColumn()
            ->editColumn('EventTime', function($row){
                    
                return $row->startAt.'-'.$row->endAt;
            })
            ->addColumn('action', function($row){
                $btn = '<a href="'.route('e-edit', ['id' => $row->id]).'" class="btn btn-primary btn-sm">Edit</a>';
                $btn .= '<a href="'.route('e-delete', ['id' => $row->id]).'" class="btn btn-danger btn-sm">Edit</a>';

                return $btn;
            })
            ->make(true);
        }
    }
}
