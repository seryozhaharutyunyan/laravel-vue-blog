<?php

namespace App\Http\Controllers\Basic;

use App\Events\NewMessage;
use App\Http\Controllers\Controller;
use App\Http\Requests\Chat\StoreRequest;
use App\Models\Chat;
use Illuminate\Http\Request;

class ChatController extends Controller
{

    public function index()
    {
        $messages = Chat::orderBy('id', 'desc')->limit(10)->get();

        return response()->json($messages);
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        Chat::create($data);

        $messages = Chat::orderBy('id', 'desc')->limit(10)->get();

        \event(new NewMessage($messages));
        return \response()->json('ok',200);
    }
}
