<?php

namespace App\Http\Controllers;

use App\Book;
use App\BookReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\BookReviewResource;
use App\Http\Requests\PostBookReviewRequest;

class BooksReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware(["auth", "auth.admin"]);
    }

    public function store(int $bookId, PostBookReviewRequest $request)
    {
        // @TODO implement
        $validatedReviewData = $request->validated();
        // find the book by id to be associated with book review and if its doesn't exist throw status code 404.
        $book = Book::findOrFail($bookId);

        // Create a new book review and associate it with the book and the user.
        $bookReview = new BookReview();
        $bookReview->book()->associate($book);
        $bookReview->user()->associate(Auth::user());
        $bookReview->fill($validatedReviewData);
        $bookReview->save();

        // Return a new BookReviewResource object representing the book review.
        return new BookReviewResource($bookReview);
    }

    public function destroy(int $bookId, int $reviewId, Request $request)
    {
        // @TODO implement
        $book = Book::with("reviews")->findOrFail($bookId);
        $book->reviews()->findOrFail($reviewId)->delete();
        return response()->json([], 204);
    }
}
