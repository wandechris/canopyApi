<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use App\Category;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use App\Exceptions\CanopyException;
use Illuminate\Support\Facades\Input;

class Events extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id = null)
    {
        $category = Input::get('category');
        if($category != null)
        {
            $event = Event::where('categoryId', $category)->get();
            return $event; 
        }
        if ($id == null) {
            return Event::orderBy('id', 'asc')->get();
        } else {
            return $this->show($id);
        }
    }

    // public function getCategorys($id)
    // {
    //     return Category::orderBy('id', 'asc')->get();
    //     // return EventCategory::where('categoryId', $id)->get();
    // }

    public function createCategorys(Request $request)
    {
        $response = new Response();
        $category = new Category;

        if($request->has('name'))
        {
            $category->name = $request->input('name');
            $category->description = $request->input('description');
            $category->save();
            return $response->setStatusCode(201);
        }else
        {
            return $response->setStatusCode(400);
        }
    }

    public function getCategorys()
    {
        return Category::orderBy('id', 'asc')->get();
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

    public function getCategory($categoryId)
    {
        $category = Category::find($categoryId);
        return $category->name;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $response = new Response();
        $event = new Event;

        if($request->has('name'))
        {
            $event->name = $request->input('name');
            $category = $this->getCategory($request->input('categoryId'));
            $event->category = $category ;
            $event->categoryId = $request->input('categoryId');
            $event->description = $request->input('description');
            $event->duration = $request->input('duration');
            $event->startDate = $request->input('startDate');
            $event->time = $request->input('time');
            $event->city = $request->input('location')['city'];
            $event->country = $request->input('location')['country'];
            $event->address = $request->input('location')['address'];
            $event->save();
            return $response->setStatusCode(201);
        }else
        {
            return $response->setStatusCode(400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
         $response = new Response();

        $event = Event::find($id);
        if ($event != null)
        {
            return $event;
        }
        else
        {
            return $response->setStatusCode(404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $response = new Response();

        $event = Event::find($id);
        if ($event != null)
        {
            $event->title = $request->input('title');
            $event->description = $request->input('description');
            $event->city = $request->input('city');
            $event->state = $request->input('state');
            $event->country = $request->input('country');
            $event->organiser = $request->input('organiser');
            $event->url = $request->input('url');
            $event->save();
            return $response->setStatusCode(204);
        }
        return $response->setStatusCode(404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $response = new Response();

        $event = Event::find($id);
        if ($event != null)
        {
            $event->delete();
            return $response->setStatusCode(204);
        }
        else
        {
             CanopyException::error(['error' => 'Event does not exist.'], 404);
        }
    }
}