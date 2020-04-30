<?php

namespace App\Http\Controllers;

use App\Models\NewModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $new = NewModel::all();

        return $new->toJson();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $name = time() . uniqid();
        $filename = str_shuffle($name) . '.jpg';
        $file = $request->image->storeAs('public/news', $filename);


        $new = NewModel::create([
            "title" => $data["title"],
            "text" => $data["text"],
            "image" => $filename,
        ]);

        return $new->toJson();
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $new = NewModel::find($id);

        if (!isset($new)) {
            return response(json_encode(["error" => 'New not found']), 404);
        }

        return $new->toJson();
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
        $data = $request->all();

        $new = NewModel::find($id);

        if (!isset($new)) {
            return response(json_encode(["error" => 'New not found']), 404);
        }

        $newData = [
            "title" => $data["title"],
            "text" => $data["text"]
        ];

        if ($request->hasFile('image')) {
            $name = time() . uniqid();
            $filename = str_shuffle($name) . '.jpg';
            $file = $request->image->storeAs('public/news', $filename);

            Storage::delete("images/" . $new->image);

            $newData["image"] = $filename;
        }

        $new->update($newData);

        return $new->toJson();
    }

    public function active(Request $request, $id)
    {
        $status = $request->status;

        $new = NewModel::find($id);

        if (!isset($new)) {
            return response(json_encode(["error" => 'New not found']), 404);
        }

        $new->update(["active" => $status]);

        return response(null, 202);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $new = NewModel::find($id);

        if (!isset($new)) {
            return response(json_encode(["error" => 'New not found']), 404);
        }

        Storage::delete("images/" . $new->image);

        $new->delete();

        return response(null, 202);
    }
}
