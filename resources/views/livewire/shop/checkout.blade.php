<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Checkout</div>

                <div class="card-body">
                    @if ($checkoutForm)
                        <form wire:submit.prevent="checkout">
                            <div class="form-group">
                                <div class="form-row mb-2">
                                    <div class="col">
                                        <input wire:model="firstName" type="text"
                                            class="form-control @error('firstName') is-invalid @enderror"
                                            placeholder="First Name">
                                        @error('firstName')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="col">
                                        <input wire:model="lastName" type="text"
                                            class="form-control @error('lastName') is-invalid @enderror"
                                            placeholder="Last Name">
                                        @error('lastName')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-row mb-2">
                                    <div class="col">
                                        <input wire:model="email" type="email"
                                            class="form-control @error('email') is-invalid @enderror"
                                            placeholder="Email">
                                        @error('email')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="col">
                                        <input wire:model="phone" type="text"
                                            class="form-control @error('phone') is-invalid @enderror"
                                            placeholder="Phone">
                                        @error('phone')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-row mb-2">
                                    <div class="col">
                                        <label for="">Address</label>
                                        <textarea wire:model="address" id="" cols="30" rows="5"
                                            class="form-control @error('address') is-invalid @enderror"></textarea>
                                        @error('address')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-row mb-2">
                                    <div class="col">
                                        <input wire:model="city" type="text"
                                            class="form-control @error('city') is-invalid @enderror" placeholder="City">
                                        @error('city')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="col">
                                        <input wire:model="postalCode" type="text"
                                            class="form-control @error('postalCode') is-invalid @enderror"
                                            placeholder="Postal Code">
                                        @error('postalCode')
                                            <span class="invalid-feedback">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <button wire:click="$emit('payment', '{{ $snapToken }}')" type="submit"
                                    class="btn btn-sm btn-primary">Submit</button>
                        </form>
                    @else
                        <button wire:click="$emit('payment', '{{ $snapToken }}')"
                            class="btn btn-primary">Payment</button>
                        <script>
                            window.livewire.on('payment', function(snapToken) {
                                snap.pay(snapToken, {
                                    // Optional
                                    onSuccess: function(result) {
                                        window.livewire.emit('emptyCart');
                                        window.location.href = "/shop";
                                    },
                                    // Optional
                                    onPending: function(result) {
                                        location.reload();
                                    },
                                    // Optional
                                    onError: function(result) {
                                        location.reload();
                                    }
                                });
                            });
                        </script>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
