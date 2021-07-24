<h2>Hi {{ $admin->fullname }}</h2>
<h3><a href="{{ route('admin.orders.index') }}">{{ $message_to_admin }}</a></h3>
<table class="table" style="border: 1px solid black;">
    <thead>
        <tr>
            <th scope="col" style="border: 1px solid black; padding: 5px;">Total order today</th>
            <th scope="col" style="border: 1px solid black; padding: 5px;">Total order pending today</th>
            <th scope="col" style="border: 1px solid black; padding: 5px;">Total order done today</th>
            <th scope="col" style="border: 1px solid black; padding: 5px;">Total order cancel today</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="border: 1px solid black; padding: 5px;">{{ $total_order_today }}</td>
            <td style="border: 1px solid black; padding: 5px;">{{ $total_order_pending_today }}</td>
            <td style="border: 1px solid black; padding: 5px;">{{ $total_order_done_today }}</td>
            <td style="border: 1px solid black; padding: 5px;">{{ $total_order_cancel_today }}</td>
        </tr>
    </tbody>
</table>
