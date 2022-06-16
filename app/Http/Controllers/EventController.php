<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Event;
use Illuminate\Support\Carbon;
use Datatables;


class EventController extends Controller
{
    public function index()
    {

        return view('eventList');
    }

    public function eventsAjax(Request $request)
    {
        $events = Event::where('slug', '!=', '')->orderBy('id', 'desc')->get();
        if ($request->ajax()) {
            return datatables()->of($events)
                ->addIndexColumn()
                ->editColumn('EventTime', function ($row) {

                    return $row->startAt . ' to  ' . $row->endAt;
                })
                ->editColumn('updated_at', function ($row) {

                    return Carbon::create($row->updated_at)->diffForHumans();
                })

                ->addColumn('action', function ($row) {
                    $btn = '<a href="' . route('showEvent', ['id' => $row->id]) . '" class="btn btn-success btn-sm">View</a> &nbsp;';

                    $btn .= '<a href="' . route('e-edit', ['id' => $row->id]) . '" class="btn btn-primary btn-sm">Update</a> &nbsp;';
                    $btn .= '<a href="' . route('e-delete', ['id' => $row->id]) . '" class="btn btn-danger btn-sm">Delete</a>';

                    return $btn;
                })
                ->make(true);
        }
    }

    public function show($id)
    {
        $event = Event::find($id);
        return view('eventView', compact('event'));
    }


    public function create()
    {
        return view('eventCreate');
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'startAt' => 'required|date',
            'endAt' => 'required|date',

        ]);
        $slug = Str::of($request->name)->slug('-');
        $is_exist = Event::where('slug', '=', $slug)->count();
        if ($is_exist > 0) {
            return response()->json(['error' => 'event already exist']);
        }
        $event = Event::create(array(
            'name' => $request->name,
            'slug' => $slug,
            'startAt' => $request->startAt,
            'endAt' => $request->endAt,

        ));
        if ($event) {
            return ['success' => 1, 'msg' => 'Event has been created successfully.'];
        } else {
            return ['success' => 0, 'msg' => 'please try again'];
        }
    }


    public function edit($id)
    {
        $event = Event::findOrFail($id);
        return view('eventEdit', compact('event'));
    }

    public function update(Request $request, $id)
    {

        $validated = $request->validate([
            'name' => 'required',
            'startAt' => 'required|date',
            'endAt' => 'required|date',

        ]);
        $event = Event::findOrFail($id);
        $slug = Str::of($request->name)->slug('-');
        $is_exist = Event::where('slug', '=', $slug)->count();
        if ($is_exist > 0) {
            return response()->json(['error' => 'event slug already exist']);
        }
        $event->update(array(
            'name' => $request->name,
            'slug' => $slug,
            'startAt' => $request->startAt,
            'endAt' => $request->endAt,

        ));
        if ($event) {
            return ['success' => 1, 'msg' => 'Event has been updated successfully.'];
        } else {
            return ['success' => 0, 'msg' => 'please try again'];
        }
    }
    public function destroy(Request $request, $id)
    {
        $event = Event::findOrFail($id)->delete();
        if ($event) {
            return redirect()->back()->with('message', 'Event Deleted successfully');
        } else {
            return redirect()->back()->with('error', 'Event Deleted successfully');
        }
    }
}
