<x-app-layout title="Checkout — Boltify" description="Review your Boltify hardware order and continue securely to payment." :noindex="true">
    <header class="border-b border-zinc-300/80 pb-8">
        <p class="font-mono text-[10px] font-semibold uppercase tracking-[0.2em] text-orange-600">Checkout / secure payment</p>
        <h1 class="mt-3 text-4xl font-extrabold tracking-[-0.06em] sm:text-5xl">Review, then pay.</h1>
        <p class="mt-4 max-w-xl text-sm leading-7 text-zinc-600">Confirm the order below. Payment and final shipping details continue securely through Stripe.</p>
    </header>

    <div class="grid gap-12 py-10 lg:grid-cols-[1fr_380px] lg:gap-16">
        <section class="border-t border-zinc-950 pt-5">
            <div class="flex items-baseline justify-between gap-4">
                <h2 class="text-lg font-extrabold tracking-[-0.035em]">Order items</h2>
                <span class="font-mono text-[9px] font-semibold uppercase tracking-[0.16em] text-zinc-500">Before payment</span>
            </div>
            <div class="mt-6 divide-y divide-zinc-300/80 border-y border-zinc-300/80">
                @foreach($summary as $item)
                    <div class="flex justify-between gap-5 py-5">
                        <div>
                            <p class="font-bold tracking-[-0.02em]">{{ $item['name'] }}</p>
                            <p class="mt-1 font-mono text-[9px] uppercase tracking-[0.12em] text-zinc-500">{{ $item['category'] }} / {{ $item['quantity'] }} × ₱{{ number_format($item['price'],2) }}</p>
                        </div>
                        <strong class="shrink-0">₱{{ number_format($item['totalPrice'],2) }}</strong>
                    </div>
                @endforeach
            </div>
        </section>

        <aside class="h-fit border-t border-zinc-950 pt-5 lg:sticky lg:top-28">
            <h2 class="text-lg font-extrabold tracking-[-0.035em]">Payment</h2>
            <form action="{{ route('checkout.store') }}" method="post" class="mt-6">
                @csrf
                <label class="flex cursor-pointer items-center gap-3 border-y border-zinc-300/80 py-4">
                    <input type="radio" name="payment_method" value="card" checked required class="border-zinc-400 text-orange-600 focus:ring-orange-500">
                    <i data-feather="credit-card" class="h-5 w-5"></i>
                    <div>
                        <span class="block text-sm font-bold">Credit / debit card</span>
                        <span class="mt-0.5 block text-[11px] text-zinc-500">Processed securely by Stripe</span>
                    </div>
                </label>

                <dl class="mt-7 space-y-3 text-sm">
                    <div class="flex justify-between gap-4"><dt class="text-zinc-500">Subtotal</dt><dd>₱{{ number_format($subTotal,2) }}</dd></div>
                    <div class="flex justify-between gap-4"><dt class="text-zinc-500">Shipping</dt><dd>₱58.00</dd></div>
                    <div class="mt-5 flex items-end justify-between gap-4 border-t border-zinc-300/80 pt-5">
                        <dt class="font-mono text-[9px] font-semibold uppercase tracking-[0.16em] text-zinc-500">Total</dt>
                        <dd class="text-3xl font-extrabold tracking-[-0.05em]">₱{{ number_format($subTotal+58,2) }}</dd>
                    </div>
                </dl>

                <button class="mt-7 flex w-full items-center justify-between bg-zinc-950 px-5 py-4 text-sm font-extrabold text-white hover:bg-orange-500 hover:text-zinc-950">
                    <span>Continue to Stripe</span><span aria-hidden="true">→</span>
                </button>
                <p class="mt-3 text-[10px] leading-5 text-zinc-500">Your card details are entered on Stripe's secure checkout. Boltify does not store your card number.</p>
            </form>
        </aside>
    </div>
</x-app-layout>
