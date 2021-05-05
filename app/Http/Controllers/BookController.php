<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class BookController extends Controller
{
    public function all() {
        $booksArr = Book::all();
        return $booksArr;
    }

    public function add(Request $request) {
        $book = new Book;
        $book->title = $request->title;
        $book->author = $request->author;
        $book->availability = 1;
        $book->save();

        return "ok";
    }

    public function changeAvailabilty($id) {
        $book = Book::find($id);
        if ($book->availability) {
            $book->availability = 0;
        } else {
            $book->availability = 1;
        }
        $book->save();
        return "ok";
    }

    public function delete($id) {
        Book::destroy($id);
        return "ok";
    }

}
