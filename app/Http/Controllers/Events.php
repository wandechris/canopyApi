<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use Storage;
use App\Category;
use App\Photos;
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
            $event = $this->getEventWithPhoto($event);
            return $event; 
        }
        if ($id == null) {
            $event = Event::orderBy('id', 'asc')->get();
            $event = $this->getEventWithPhoto($event);
            return $event;
        } else {
            return $this->show($id);
        }
    }

    public function getEventWithPhoto($events)
    {
        foreach($events as $event) 
        {
            $photos = Photos::where('eventId', $event->id)->get();
            foreach($photos as $photo) {
                $contents = Storage::disk('s3')->get($event->id.$photo->name.'.png');
                $photo->value =$contents;
            }
            $event->photos = $photos;
        }
        return $events;
    }
    public function createCategorys(Request $request)
    {
        $response = new Response();
        $category = new Category;

        if($request->has('name'))
        {
            $category->name = $request->input('name');
            $category->description = $request->input('description');
            $category->save();
            return $response->setStatusCode(201)->setContent($category);
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
        if ($category != null)
        {
            return $category->name;
        }
            return "";
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
        $photoMdl = new Photos;

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
            $photos = $request->input('photos');
            $event->save();
            foreach($photos as $photo) {
                $data = $photo['value'];
                $data = base64_decode($data);
                Storage::disk('s3')->put($event->id.$photo['name'].".png",$data);
                $photoMdl->name = $photo['name'];
                $photoMdl->eventId = $event->id;
                $photoMdl->save();

                $event->photos = $photos;
            }
            return $response->setStatusCode(201)->setContent($event);
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
            $photos = Photos::where('eventId', $id)->get();
            foreach($photos as $photo) {
                $contents = Storage::url('s3')->url($id.$photo->name.'.png');
                $photo->value =$contents;
            }
            $event->photos = $photos;
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
            $response = new Response();
            $photoMdl = new Photos;
            $event->name = is_null($request->input('name')) ? $event->name : $request->input('name');
            if(!is_null($request->input('categoryId')))
            {
                $category = $this->getCategory($request->input('categoryId'));
                $event->category = $category ;
            }
            $event->categoryId = is_null($request->input('categoryId')) ? $event->categoryId : $request->categoryId('name');
            $event->description = is_null($request->input('description')) ? $event->name : $request->input('description');
            $event->duration = is_null($request->input('duration')) ? $event->name : $request->input('duration');
            $event->startDate = is_null($request->input('startDate')) ? $event->name : $request->input('startDate');
            $event->time = is_null($request->input('time')) ? $event->time : $request->input('time');
            $event->city = is_null($request->input('city')) ? $event->city : $request->input('location')['city'];
            $event->country = is_null($request->input('country')) ? $event->country : $request->input('location')['country'];
            $event->address = is_null($request->input('address')) ? $event->address : $request->input('location')['address'];
            $photos = is_null($request->input('photos')) ? $event->photos : $request->input('photos');
            $event->save();
            foreach($photos as $photo) {
                $data = $photo['value'];
                $data = base64_decode($data);
                Storage::disk('s3')->put($event->id.$photo['name'].".png",$data);
                $photoMdl->name = $photo['name'];
                $photoMdl->eventId = $event->id;
                $photoMdl->save();
                $event->photos = $photos;
            }
            return $response->setStatusCode(200)->setContent($event);
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