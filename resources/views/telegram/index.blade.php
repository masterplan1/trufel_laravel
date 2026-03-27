🛒 <b>Нове замовлення #{{ $order->id }}</b>

👤 <b>{{ $order->orderDetail->customer_name }}</b>
📞 {{ $order->orderDetail->customer_phone }}
📅 Дата отримання: <b>{{ \Carbon\Carbon::parse($order->orderDetail->order_date)->format('d.m.Y') }}</b>
@if($order->orderDetail->comment)
💬 Коментар: {{ $order->orderDetail->comment }}
@endif

━━━━━━━━━━━━━━━━
📦 <b>Склад замовлення:</b>
@foreach ($order->orderItems as $item)
@php
    $filling = $item->filling;
    $type = $filling->category->type ?? null;
    $isWeight = $type && $type->weight_quantity === 'weight';
    $amount = $isWeight
        ? number_format($item->unit_price * $item->weight, 0, '.', ' ')
        : number_format($item->unit_price * $item->quantity, 0, '.', ' ');
@endphp
▪ {{ $filling->title }}
  {{ $isWeight ? ($item->weight . ' кг × ' . $item->unit_price . ' грн/кг') : ($item->quantity . ' шт × ' . $item->unit_price . ' грн') }} = <b>{{ $amount }} грн</b>
@endforeach
━━━━━━━━━━━━━━━━
💰 <b>Разом: {{ number_format($order->total_price, 0, '.', ' ') }} грн</b>
