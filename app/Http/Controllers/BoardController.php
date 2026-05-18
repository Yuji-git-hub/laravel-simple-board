<?php

namespace App\Http\Controllers;

use App\Http\Requests\BoardRequest;
use App\Models\Board;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class BoardController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = Board::with('user');

        if($request->filled('keyword') || $request->filled('body')) {
            $query->where(function ($q) use ($request) {
                if($request->filled('keyword')) {
                    $q->where('title', 'like', '%' . $request->keyword . '%');
                }

                if($request->filled('body')) {
                    $q->orWhere('body', 'like', '%' . $request->body . '%');
                }
            });
        }

        if($request->filled('name')) {
                $query->whereHas('user', function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->name . '%');
            });
        }

        $boards = $query->simplePaginate(10)->withQueryString();

        return view('boards.index', ['boards' => $boards]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('boards.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BoardRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $data['user_id'] = Auth::id();

        Board::create($data);

        return redirect()->route('boards.index')
                         ->with('success', '投稿作成できました。');
    }

    /**
     * Display the specified resource.
     */
    public function show(Board $board): View
    {
        return view('boards.show', ['board' => $board]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Board $board): View
    {
        $this->authorize('update', $board);

        return view('boards.edit', ['board' => $board]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BoardRequest $request, Board $board): RedirectResponse
    {
        $this->authorize('update', $board);

        $board->update($request->validated());

        return redirect()->route('boards.index')
                         ->with('success', '更新が完了しました。');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Board $board): RedirectResponse
    {
        $this->authorize('delete', $board);

        $board->delete();

        return redirect()->route('boards.index')
                         ->with('success', '削除しました。');
    }
}
