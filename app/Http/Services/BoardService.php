<?php

namespace App\Http\Services;

use App\Models\Board;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BoardService
{

    public function getBoards(Request $request)
    {
        $user = $request->user();
        $sharedBoards = $user->boards()->with('users')->get();
        $myBoards = $user->board;
        return [
            "shared" => $sharedBoards,
            "myBoards" => $myBoards,
        ];
    }

    public function createBoard($validated, $user)
    {
        $users = $validated["user_ids"];
        $board = new Board([
            "name" => $validated["name"],
            "description" => $validated["description"],
            "user_id" => $user->getKey(),
        ]);
        $board->save();

        $board->users()->sync($users);

        return $board;
    }
}
