<?php

namespace App\Http\Controllers\Admin;

use Throwable;
use App\Models\Order;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class NotifyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notifications = Auth::guard('admin')->user()->notifications()->paginate();

        foreach ($notifications as $notify) {
            $notify->order = Order::find($notify->data['order']['id']);
        }

        return view('admin.notifications.index', compact('notifications'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $notify = Auth::guard('admin')->user()
            ->notifications()->orderBy('read_at', 'desc')->where('id', $id)->first();
            if ($notify->read_at) {
                $notify->read_at = null;
                $notify->save();
            } else {
                $notify->markAsRead();
            }

            return redirect()->back()->with('message', trans('notification.update_noti_success'));
        } catch (Throwable $th) {
            dd($th);
            return redirect()->back()->with('error-message', trans('notification.update_noti_fail'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
