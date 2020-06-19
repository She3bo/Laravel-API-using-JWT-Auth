<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Book;
use Validator;
class BookController extends BaseController
{
    public function index()
    {
        $books = Book::all();
        return $this->sendResponse($books->toArray(),'Books read Successfully');
    }
    public function show($id)
    {
        $book = Book::find($id);
        if(is_null($book)){
            return $this->sendError("error","book not found");
        }
        return $this->sendResponse($book->toArray(),'Book read Successfully');
    }
    public function store(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'name'    => 'required|string',
            'details' => 'required|string',
        ]);
        if($validate->fails()){
            return $this->sendError("validate error",$validate->errors());
        }
        $book = Book::create([
            'name'      => $request->name,
            'details'   => $request->details,
        ]);
        return $this->sendResponse($book->toArray(),'Books created Successfully');
    }
    public function update(Request $request, $id)
    {
        $validate = Validator::make($request->all(),[
            'name'    => 'string',
            'details' => 'string',
        ]);
        if($validate->fails()){
            return $this->sendError("validate error",$validate->errors());
        }
        $book = Book::find($id);
        if(is_null($book)){
            return $this->sendError("error","book not found");
        }
        if(!empty($request->name)){
            $book->name = $request->name;
        }
        if(!empty($request->details)){
            $book->details = $request->details;
        }
        $book->update();
        return $this->sendResponse($book->toArray(),'Books updated Successfully');
    }
    public function destroy($id)
    { 
        $book = Book::find($id);
        if(is_null($book)){
            return $this->sendError("error","book not found");
        }
        $book->delete();

        return $this->sendResponse($book->toArray(),'Books deleted Successfully');
    }


       
}
