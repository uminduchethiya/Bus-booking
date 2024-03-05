<html lang="en">


<head>
    <meta charset="UTF-8">
    <title>Your Page Title</title>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Include your styles from Vite -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')

    <!-- Include Alpine.js from CDN -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2"></script>

    <!-- Other head elements -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAz-IbTNgHhfweThsHnp9Tt452ymYd8e18"></script>
</head>


<body class="bg-white">
    @include('components.nav-bar')

    <div class=" md:relative">
        <img src="{{ asset('img/fqa1.jpg') }}" class="w-screen h-[50%] darkened-image" />
        <div
            class="absolute z-20 transform -translate-x-1/2 -translate-y-1/2 lg:block md:top-3/4 left-1/3 md:w-7/12 top-2/4">
            <h1 class="text-5xl font-semibold text-blue-500 md:top-3/4 top-2/4"> Seats Select</h1>
        </div>
    </div>
    <div class="flex mx-12 my-20">
        <div class="w-1/4 ml-4 border">
            <form id="seat-selection-form" action="{{ route('select-seat') }}" method="post">
                <form id="seat-selection-form" action="#" method="post">
                    @csrf

                    {{-- <input type="hidden" name="selected_seats" id="selected-seats"> --}}
                    <div class="grid grid-cols-4 gap-4 mx-5 mt-5 mb-2">
                        @for ($i = 1; $i <= 52; $i++) <!-- Checkbox {{$i}} -->
                            @if ($i % 4 == 2)
                            <div class="flex flex-col items-center mr-5">
                                @elseif ($i % 4 == 3)
                                <div class="flex flex-col items-center ml-5">
                                    @else
                                    <div class="flex flex-col items-center">
                                        @endif
                                        @php
                                        $isBooked = in_array($i, $bookedSeats);
                                        @endphp
                                        <div class="flex flex-col items-center">
                                            <input id="checkbox{{$i}}" type="checkbox" value="{{$i}}" name="checkbox"
                                                {{$isBooked ? 'disabled' : '' }}
                                                class="w-6 h-6 text-red-600 bg-gray-100 border-gray-300 seat-checkbox focus:ring-red-500 dark:focus:ring-red-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                            <label for="checkbox{{$i}}"
                                                class="text-sm font-medium text-gray-900 dark:text-gray-300">{{$i}}</label>
                                        </div>
                                    </div>
                                    @endfor
                                </div>
                                {{-- <button type="submit">Submit</button> --}}
                </form>

                <script>
                    let selectedSeats = []; // Initialize as an empty array

                    document.querySelectorAll('.seat-checkbox').forEach(function (checkbox) {
                        checkbox.addEventListener('change', function () {
                            const seatNumber = parseInt(this.value);
                            if (this.checked) {
                                selectedSeats.push(seatNumber);
                            } else {
                                selectedSeats = selectedSeats.filter(seat => seat !== seatNumber);
                            }
                            updateSelectedSeatsInput(); // Update hidden input field
                            updateTotalPrice(); // Update total price and pay-button value
                        });
                    });

                    function updateSelectedSeatsInput() {
                        document.getElementById('selected-seats').value = selectedSeats;
                    }

                    function updateTotalPrice() {
                        const totalPrice = selectedSeats.length * {{$bus->price}};
                        const payButton = document.getElementById('pay-button');
                        payButton.textContent = 'Pay $' + totalPrice.toFixed(2);
                        payButton.value = totalPrice; // Set the value attribute of the pay-button
                    }

                    // Call updateTotalPrice once when the page loads
                    window.addEventListener('load', updateTotalPrice);
                </script>





        </div>
        <div class="grid w-4/5 grid-cols-3">
            <div class="flex col-span-2 ml-16">
                <img src="{{ asset('assets/images/' . $bus->image) }}" alt="" class="object-cover w-full h-96" />
            </div>
            <div class="flex w-1/5 ml-5 h-96">
                <table class="border-collapse">
                    <tr class="border-b">
                        <td class="pb-2 pr-4">Date</td>
                        <td class="pb-2">{{$date}}</td>
                    </tr>
                    <tr class="border-b">
                        <td class="pb-2 pr-4">Bus Number</td>
                        <td class="pb-2">{{$bus->bus_number}}</td>
                    </tr>
                    <tr class="border-b">
                        <td class="pb-2 pr-4">Root Number</td>
                        <td class="pb-2">{{$bus->root_number}}</td>
                    </tr>
                    <tr class="border-b">
                        <td class="pb-2 pr-4">Type</td>
                        <td class="pb-2">{{$bus->type}}</td>
                    </tr>
                    <tr class="border-b">
                        <td class="pb-2 pr-4">Price (1 seat)</td>
                        <td class="pb-2">{{$bus->price}}</td>
                    </tr>
                    <tr class="border-b">
                        <td class="pb-2 pr-4">Start</td>
                        <td class="pb-2">{{$bus->start}}</td>
                    </tr>
                    <tr class="border-b">
                        <td class="pb-2 pr-4">Start Time</td>
                        <td class="pb-2">{{$bus->starttime}}</td>
                    </tr>
                    <tr class="border-b">
                        <td class="pb-2 pr-4">End</td>
                        <td class="pb-2">{{$bus->end}}</td>
                    </tr>
                    <tr class="border-b">
                        <td class="pb-2 pr-4">End Time</td>
                        <td class="pb-2">{{$bus->endtime}}</td>
                    </tr>
                    <tr class="border-b">
                        <td class="pb-2 pr-4">Description</td>
                        <td class="pb-2">{{$bus->description}}</td>
                    </tr>
                </table>
            </div>
            <div class="col-span-3 ml-16 border">
                <div class="w-3/4 mx-auto mt-10">
                    <form action="{{ route('select-seat') }}" method="post">
                        @csrf
                        <!-- Card Number -->
                        <div class="px-2 mb-5">
                            <label for="type1" class="flex items-center cursor-pointer">
                                <input type="radio" class="w-5 h-5 text-indigo-500 form-radio" name="type" id="type1"
                                    checked>
                                <img src="https://leadershipmemphis.org/wp-content/uploads/2020/08/780370.png"
                                    class="h-8 ml-3">
                            </label>
                        </div>
                        <div>


                            <input type="hidden" name="selectedSeats[]" id="selected-seats">
                            <input type="hidden" name="bus_id" id="bus_id" value="{{ $busId }}">
                            <input type="hidden" name="date" id="date" value="{{ $date }}">
                            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                        </div>
                        <div>
                            <label class="block mb-1 text-sm font-medium" for="card-nr">Card Number <span
                                    class="text-red-500">*</span></label>
                            <input id="card-nr" oninput="validateCreditCard()"
                                class="w-full px-3 py-2 text-sm leading-5 text-gray-800 placeholder-gray-400 bg-white border border-gray-200 rounded shadow-sm hover:border-gray-300 focus:border-indigo-300 focus:ring-0"
                                type="text" placeholder="1234 1234 1234 1234" required />
                            <div id="card-error" class="mt-1 text-red-500"></div>
                        </div>

                        <script>
                            function validateCreditCard() {
                                const cardNumberInput = document.getElementById('card-nr');
                                const cardErrorDiv = document.getElementById('card-error');

                                // Remove non-digit characters
                                const cardNumber = cardNumberInput.value.replace(/\D/g, '');

                                // Check if the card number is numeric and has a valid length
                                if (!/^\d{12,19}$/.test(cardNumber)) {
                                    cardErrorDiv.textContent = 'Invalid card number';
                                } else {
                                    cardErrorDiv.textContent = '';
                                }
                            }
                        </script>
                        <!-- Expiry and CVC -->
                        <div class="flex space-x-4">
                            <div class="flex-1">
                                <label class="block mb-1 text-sm font-medium" for="card-expiry">Expiry Date <span
                                        class="text-red-500">*</span></label>
                                <input id="card-expiry" oninput="validateExpiryDate()"
                                    class="w-full px-3 py-2 text-sm leading-5 text-gray-800 placeholder-gray-400 bg-white border border-gray-200 rounded shadow-sm hover:border-gray-300 focus:border-indigo-300 focus:ring-0"
                                    type="text" placeholder="MM/YY" required />
                                <div id="expiry-error" class="mt-1 text-red-500"></div>
                            </div>
                            <script>
                                function validateExpiryDate() {
                                    const expiryInput = document.getElementById('card-expiry');
                                    const expiryErrorDiv = document.getElementById('expiry-error');

                                    const expiryDate = expiryInput.value;

                                    // Check if the expiry date matches MM/YY format
                                    if (!/^(0[1-9]|1[0-2])\/\d{2}$/.test(expiryDate)) {
                                        expiryErrorDiv.textContent = 'Invalid expiry date (MM/YY)';
                                    } else {
                                        expiryErrorDiv.textContent = '';
                                    }
                                }
                            </script>
                            <div class="flex-1">
                                <label class="block mb-1 text-sm font-medium" for="card-cvc">CVC <span
                                        class="text-red-500">*</span></label>
                                <input id="card-cvc" oninput="validateCVC()"
                                    class="w-full px-3 py-2 text-sm leading-5 text-gray-800 placeholder-gray-400 bg-white border border-gray-200 rounded shadow-sm hover:border-gray-300 focus:border-indigo-300 focus:ring-0"
                                    type="text" placeholder="CVC" required />
                                <div id="cvc-error" class="mt-1 text-red-500"></div>
                            </div>
                            <script>
                                function validateCVC() {
                                    const cvcInput = document.getElementById('card-cvc');
                                    const cvcErrorDiv = document.getElementById('cvc-error');

                                    const cvc = cvcInput.value;

                                    // Check if the CVC is a three or four-digit number
                                    if (!/^\d{3,4}$/.test(cvc)) {
                                        cvcErrorDiv.textContent = 'Invalid CVC (should be 3 or 4 digits)';
                                    } else {
                                        cvcErrorDiv.textContent = '';
                                    }
                                }
                            </script>
                        </div>
                        <!-- Name on Card -->
                        <div>
                            <label class="block mb-1 text-sm font-medium" for="card-name">Name on Card <span
                                    class="text-red-500">*</span></label>
                            <input id="card-name" name="card-name"
                                class="w-full px-3 py-2 text-sm leading-5 text-gray-800 placeholder-gray-400 bg-white border border-gray-200 rounded shadow-sm hover:border-gray-300 focus:border-indigo-300 focus:ring-0"
                                type="text" placeholder="John Doe" required />
                        </div>
                        <!-- Email -->
                        <div>
                            <label class="block mb-1 text-sm font-medium" for="card-email">Email <span
                                    class="text-red-500">*</span></label>
                            <input id="card-email"
                                class="w-full px-3 py-2 text-sm leading-5 text-gray-800 placeholder-gray-400 bg-white border border-gray-200 rounded shadow-sm hover:border-gray-300 focus:border-indigo-300 focus:ring-0"
                                type="email" placeholder="john@company.com" required />
                        </div>
{{-- <input type="text" hidden> --}}
                        <!-- Form footer -->
                        <div class="mt-6">
                            <div class="mb-4">
                                <button id="pay-button" type="submit" name="price"
                                    class="inline-flex items-center justify-center w-full px-3 py-2 text-sm font-medium leading-5 text-white transition duration-150 ease-in-out bg-indigo-500 border border-transparent rounded shadow-sm hover:bg-indigo-600 focus:outline-none focus-visible:ring-2">Pay
                                    $0.00</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @if ($status == 'send')
    <div id="map" class="w-full h-96"></div>
@endif

    <script>
        function initMap() {
            // Define the center of the map
            var center = { lat: 40.7128, lng: -74.0060 }; // Example: New York City coordinates

            // Create a new map instance
            var map = new google.maps.Map(document.getElementById('map'), {
                center: center,
                zoom: 12 // Adjust the zoom level as needed
            });

            // Add a marker to the map
            var marker = new google.maps.Marker({
                position: center,
                map: map,
                title: 'Your location'
            });
        }

        // Initialize the map when the page loads
        google.maps.event.addDomListener(window, 'load', initMap);
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAz-IbTNgHhfweThsHnp9Tt452ymYd8e18"></script>
    <div id="map" class="w-full h-auto mb-10"></div>
    <script>
        function initMap() {
        var center = { lat: {{ $latitude }}, lng: {{ $longitude }} }; // Use the compacted values
        var map = new google.maps.Map(document.getElementById('map'), {
            center: center,
            zoom: 12
        });
        var marker = new google.maps.Marker({
            position: center,
            map: map,
            title: 'Your location'
        });
    }
    google.maps.event.addDomListener(window, 'load', initMap);
    </script>
    @include('components.footer')
    <style>
        .darkened-image {
            filter: brightness(30%);
            /* Adjust the brightness percentage as needed (e.g., 50% for a darker effect) */
        }
    </style>


</body>

</html>
