<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Models\Book;
use Illuminate\Http\JsonResponse;

class BooksController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $books = request()->user()->books()
            ->with('authors', 'user')->get();
        return response()->json($books);
    }

    /**
     * @param BookRequest $request
     * @return JsonResponse
     */
    public function store(BookRequest $request): JsonResponse
    {
        $book = Book::create([
            'name' => $request->name,
            'user_id' => $request->user()->id,
        ]);
        $validated = $request->validated();
        $book->book_authors()
            ->createMany($validated['authors']);
        return response()->json($book->with('authors', 'user'));
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $book = \request()->user()->books()
            ->findOrFail($id)
            ->with('authors', 'user');
        return response()->json($book);
    }

    /**
     * @param BookRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(BookRequest $request, int $id): JsonResponse
    {
        $book = \request()->user()->books()
            ->findOrFail($id);
        $book->update(['name' => $request->name]);

        $authors = collect($request->authors);

        $book->book_authors()
            ->whereNotIn('author_id', $authors->pluck('author_id'))
            ->delete();

        $book->book_authors()
            ->upsert(
                [$request->authors],
                ['book_id', 'author_id'],
            );
        return response()->json($book->with('authors', 'user'));
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        return response()->json(['deleted' => request()->user()->books()->delete($id)]);
    }
}
