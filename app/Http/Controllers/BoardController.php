<?php

namespace App\Http\Controllers;

use App\Http\Requests\BoardRequest;
use App\Http\Services\BoardService;
use Illuminate\Http\Request;

class BoardController extends Controller
{
    public function __construct(private BoardService $boardService)
    {
    }

    public function index(Request $request)
    {
        $boards = $this->boardService->getBoards($request);
        return response()->json([
            'data' => $boards,
        ]);
    }

    public function store(BoardRequest $request)
    {
        $validated = $request->validated();
        $board = $this->boardService->createBoard($validated, $request->user());

        return response()->json([
            'data' => $board,
        ]);
    }
}
