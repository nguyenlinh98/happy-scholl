<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Message\CreateMessageRequest;
use App\Http\Requests\Message\UpdateMessageRequest;
use App\Models\Message;
use Illuminate\Support\Facades\Storage;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $messages = Message::where('status', Message::STATUS_NOT_YET)->get();

        return view('admin.message.index', ['messages' => $messages]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $message = new Message();
        $message->prepare();

        return view('admin.message.create', ['message' => $message, 'title' => 'お知らせ']);
    }

    /**
     * Show the form confirmation.
     */
    public function confirm(CreateMessageRequest $request, Message $message = null)
    {
        if (is_null($message)) {
            $message = new Message();
        }
        $message->confirm();

        return view('admin.message.confirm', ['message' => $message]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CreateMessageRequest $request)
    {
       if($request-> filled('reject_x')) {
            // only on confirm
            // if user want to edit, redirect back to create page
            return redirect()->route('admin.message.create')->withInput();
        }
        $message = new Message();
        $message->createFromRequest($request);
        session()->flash('action', 'created');

        return redirect()->route('admin.message.index');
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Message $message)
    {
        return view('admin.message.show', ['message' => $message]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Message $message)
    {
        $message->prepareForEdit();

        return view('admin.message.edit', ['message' => $message]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMessageRequest $request, Message $message)
    {
       if($request-> filled('reject_x')) {
            // only on confirm
            // if user want to edit, redirect back to create page
            return redirect()->route('admin.message.edit', $message)->withInput();
        }
        $message->createFromRequest($request);

        session()->flash('action', 'updated');

        return redirect()->route('admin.message.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Message $message)
    {
        $message->delete();

        session()->flash('action', 'deleted');

        return redirect()->route('admin.message.index');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * show list message sent
     */
    public function sentList(){
        $messages = Message::where('status', Message::STATUS_IN_PROGRESS)->get();

        return view('admin.message.sent_list', ['messages' => $messages]);
    }
}
