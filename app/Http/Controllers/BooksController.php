<?php

namespace App\Http\Controllers;

use App\Book;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\BookResource;
use App\Http\Requests\PostBookRequest;

class BooksController extends Controller
{
    public function __construct()
    {
        $this->middleware(["auth", "auth.admin"])->only("store");
    }

    public function index(Request $request)
    {
        $books = Book::query()
            ->with(["authors", "reviews"])
            ->when($request->title, function ($query) use ($request) {
                $query->where('title', 'like', "%$request->title%");
            })
            ->when(isset($request->authors), function ($query) use ($request) {
                $query->whereHas('authors', function ($query) use ($request) {
                    $query->whereIn('id', explode(',', $request->authors));
                });
            });

        if ($request->sortColumn) {
            $sortDirection = $request->sortDirection ?? 'ASC';

            if ($request->sortColumn === "avg_review") {
                $books->withCount(['reviews as avg_review' => function ($query) {
                    $query->select(DB::raw('coalesce(avg(review),0)'));
                }])->orderBy('avg_review', $sortDirection);
            } else {
                $books->orderBy($request->sortColumn, $sortDirection);
            }
        }

        // Query the data from Book Eloquent model and respond with the BookResource collection.
        // Implement pagination feature (from Eloquent).
        return BookResource::collection($books->paginate());
    }

    public function store(PostBookRequest $request)
    {
        // @TODO implement
        $validatedData = $request->validated();

        // Book Keys Data
        $bookKeys = [
            "isbn",
            "title",
            "description",
            "published_year",
        ];

        // Get only the book data from the validated request
        $bookData = Arr::only($validatedData, $bookKeys);

        // Save the book to the database.
        $book = Book::create($bookData);
        $book->authors()->sync($validatedData['authors']);

        return new BookResource($book);
    }
}
