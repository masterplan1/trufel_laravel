Нове замовлення № {{ $order->id }}
на {{ $order->orderDetail->order_date }},
від {{ $order->orderDetail->customer_name }},
тел. {{ $order->orderDetail->customer_phone }},

@foreach ($order->orderItems as $item)
{{ $fillings[$item->filling_id]['title'] }} {{ $item->weight ?? $item->quantity }} @if ($item->weight) кг. @else шт.  @endif 
@endforeach

Ціна {{ $order->total_price }},

