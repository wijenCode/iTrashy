@extends('layouts.app')

@section('page-title', 'Setor Sampah')

@section('content')
<div class="flex-1 overflow-y-auto relative bg-[#f5f6fb]">

    <div class=" pt-0">
        <div class="flex flex-col lg:flex-row gap-4 lg:gap-6">

            <!-- Daftar Jenis Sampah -->
            <div class="w-full lg:w-3/4">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-3 md:gap-4">
                    @foreach ($jenis_sampah as $index => $sampah)
                    <div class="flex items-center bg-white rounded-lg shadow-md p-3 gap-3">
                        <img src="{{ asset('storage/' . $sampah->gambar) }}" alt="{{ $sampah->nama_sampah }}" class="h-16 w-16 md:h-20 md:w-20 object-cover rounded-lg">
                        <div class="flex flex-col flex-1">
                            <h4 class="font-semibold md:text-base">{{ $sampah->nama_sampah }}</h4>
                            <p class="text-xs md:text-sm text-gray-500 mt-1">{{ $sampah->poin_per_kg }} poin/Kg</p>
                            <button onclick="addToOrderList({{ $index }}, '{{ $sampah->nama_sampah }}', {{ $sampah->poin_per_kg }}, {{ $sampah->id }}, this)" id="btn-{{ $index }}" class="bg-[#40916c] px-4 md:px-6 py-1.5 rounded-full mt-2 text-white text-xs md:text-sm hover:bg-[#2d724f] transition-colors">Pilih</button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Keranjang (Order List) -->
            <div id="cartOverlay" class="fixed lg:relative top-0 right-0 h-full w-full max-w-md bg-white shadow-xl transform translate-x-full lg:translate-x-0 transition-transform duration-300 rounded-lg z-50 lg:z-0 lg:block">
                <div class="h-full flex flex-col">
                    <!-- Mobile Header Order List -->
                    <div class="p-4 border-b flex justify-between items-center lg:hidden">
                        <h3 class="font-semibold text-lg">Order List</h3>
                        <button id="closeCart" class="text-gray-500 hover:text-gray-700">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>

                    <form action="{{ route('setor.sampah.store') }}" method="POST" class="h-full flex flex-col">
                        @csrf
                        <div class="flex-1 overflow-y-auto p-4">
                            <!-- List Sampah -->
                            <div class="bg-gray-100 rounded-lg p-4 mb-4">
                                <h3 class="font-semibold text-lg mb-5">List Sampah</h3>
                                <div id="orderListItems" class="space-y-3"></div>
                                <div id="emptyOrderMessage" class="text-sm text-gray-600 mb-4">Belum ada jenis sampah yang kamu masukin nih</div>
                                <div class="border-t border-gray-300 mt-4 pt-4 space-y-2">
                                    <div class="flex justify-between text-sm font-semibold">
                                        <span>Total Poin</span>
                                        <span id="totalPoin">0 poin</span>
                                        <input type="hidden" name="total_poin" id="totalPoinInput" value="0">
                                    </div>
                                </div>
                            </div>

                            <!-- Pilih Alamat -->
                            <div class="mb-4">
                                <label class="block font-semibold mb-2">Alamat Penjemputan</label>
                                <select name="alamat" id="addressSelect" class="py-3 w-full border border-gray-300 rounded-lg p-2 text-sm text-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                    <option value="" disabled selected>Pilih alamat</option>
                                    <option value="{{ auth()->user()->alamat }}">{{ auth()->user()->alamat }}, {{ auth()->user()->kecamatan }}, {{ auth()->user()->kota }}</option>
                                </select>
                            </div>

                            <!-- Tanggal & Waktu Penjemputan -->
                            <div>
                                <label class="block font-semibold mb-2">Tanggal Penjemputan</label>
                                <input type="date" id="pickup_date" name="tanggal_setor" class="w-full border mb-5 border-gray-300 rounded-lg p-3 text-sm text-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500" required/>

                                <label class="block font-semibold mb-2">Waktu Penjemputan</label>
                                <select id="pickup_time" name="waktu_setor" class="w-full border border-gray-300 rounded-lg p-3 text-sm text-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                    <option value="" disabled selected>Pilih waktu</option>
                                    <option value="08:00">08:00-10:00</option>
                                    <option value="10:00">10:00-12:00</option>
                                    <option value="12:00">12:00-14:00</option>
                                    <option value="14:00">14:00-16:00</option>
                                    <option value="16:00">16:00-18:00</option>
                                    <option value="18:00">18:00-20:00</option>
                                </select>
                            </div>
                        </div>

                        <!-- Hidden inputs for sampah data -->
                        <div id="hiddenInputs"></div>

                        <!-- Tombol Submit -->
                        <div class="p-4">
                            <button type="submit" id="saveOrderButton" class="w-full bg-blue-500 text-white py-2.5 rounded-full hover:bg-blue-600 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500">
                                Setor Sampah
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- End Cart Overlay -->
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Global variables to store order data
let orderItems = [];
let totalPoints = 0;
const FEE_PERCENTAGE = 0.20; // 20% fee

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Set minimum date to today for the date picker
    const today = new Date();
    const formattedDate = today.toISOString().split('T')[0];
    document.getElementById('pickup_date').min = formattedDate;
    
    // Setup event listeners
    setupDateTimeValidation();
    setupMobileCartButtons();
    
    // Validate initial date/time selections
    validateDateTime();
});

/**
 * Add a waste item to the order list
 * @param {number} index - Index of the waste item
 * @param {string} name - Name of the waste item
 * @param {number} pointsPerKg - Points per kg for the waste item
 * @param {number} id - Database ID of the waste item
 * @param {HTMLElement} button - The button element that was clicked
 */
function addToOrderList(index, name, pointsPerKg, id, button) {
    // Check if item already exists in the order
    const existingItemIndex = orderItems.findIndex(item => item.id === id);
    
    if (existingItemIndex === -1) {
        // Add new item
        const newItem = {
            index: index,
            name: name,
            pointsPerKg: pointsPerKg,
            id: id,
            weight: 0.25, // Default weight
            totalPoints: pointsPerKg * 0.25
        };
        
        orderItems.push(newItem);
        
        // Update button state
        button.textContent = 'Dipilih';
        button.classList.remove('bg-[#40916c]', 'hover:bg-[#2d724f]');
        button.classList.add('bg-gray-400', 'hover:bg-gray-500');
        
        // Render order list
        renderOrderList();
    }
}

/**
 * Remove an item from the order list
 * @param {number} id - ID of the waste item to remove
 */
function removeFromOrderList(id) {
    // Find the item index
    const itemIndex = orderItems.findIndex(item => item.id === id);
    
    if (itemIndex !== -1) {
        // Reset the button state
        const button = document.getElementById(`btn-${orderItems[itemIndex].index}`);
        if (button) {
            button.textContent = 'Pilih';
            button.classList.remove('bg-gray-400', 'hover:bg-gray-500');
            button.classList.add('bg-[#40916c]', 'hover:bg-[#2d724f]');
        }
        
        // Remove the item
        orderItems.splice(itemIndex, 1);
        
        // Render the updated order list
        renderOrderList();
    }
}

/**
 * Change the weight of an item in the order list
 * @param {number} id - ID of the waste item
 * @param {number} change - Amount to change the weight by
 */
function changeWeight(id, change) {
    // Find the item
    const item = orderItems.find(item => item.id === id);
    
    if (item) {
        // Calculate new weight (minimum 0.25kg)
        const newWeight = Math.max(0.25, item.weight + change);
        
        // Update weight and points
        item.weight = newWeight;
        item.totalPoints = Math.round(item.pointsPerKg * newWeight);
        
        // Render the updated order list
        renderOrderList();
    }
}

/**
 * Render the entire order list
 */
function renderOrderList() {
    const orderListContainer = document.getElementById('orderListItems');
    const emptyMessage = document.getElementById('emptyOrderMessage');
    const hiddenInputsContainer = document.getElementById('hiddenInputs');
    
    // Clear containers
    orderListContainer.innerHTML = '';
    hiddenInputsContainer.innerHTML = '';
    
    // Reset total points
    totalPoints = 0;
    
    // Show/hide empty message
    if (orderItems.length === 0) {
        emptyMessage.style.display = 'block';
    } else {
        emptyMessage.style.display = 'none';
        
        // Generate order items HTML
        orderItems.forEach((item, index) => {
            // Create order item element
            const itemElement = document.createElement('div');
            itemElement.className = 'flex items-center justify-between bg-white p-3 rounded-lg';
            
            // Calculate total points for this item
            const itemPoints = item.totalPoints;
            totalPoints += itemPoints;
            
            // Create HTML structure
            itemElement.innerHTML = `
                <div class="flex-1">
                    <h5 class="font-medium">${item.name}</h5>
                    <div class="text-xs text-gray-500">${item.pointsPerKg} poin/Kg</div>
                </div>
                <div class="flex items-center gap-2">
                    <button type="button" onclick="changeWeight(${item.id}, -0.25)" class="w-7 h-7 flex items-center justify-center bg-gray-200 rounded-full hover:bg-gray-300">-</button>
                    <div class="text-sm font-medium w-12 text-center">${item.weight.toFixed(2)}</div>
                    <button type="button" onclick="changeWeight(${item.id}, 0.25)" class="w-7 h-7 flex items-center justify-center bg-gray-200 rounded-full hover:bg-gray-300">+</button>
                </div>
                <button type="button" onclick="removeFromOrderList(${item.id})" class="ml-2 text-red-500 hover:text-red-700">
                    <i class="fas fa-times"></i>
                </button>
            `;
            
            // Add to container
            orderListContainer.appendChild(itemElement);
            
            // Create hidden inputs for form submission
            const hiddenInputs = document.createElement('div');
            hiddenInputs.innerHTML = `
                <input type="hidden" name="sampah_id[]" value="${item.id}">
                <input type="hidden" name="sampah_berat[]" value="${item.weight.toFixed(2)}">
                <input type="hidden" name="sampah_poin[]" value="${itemPoints}">
            `;
            
            hiddenInputsContainer.appendChild(hiddenInputs);
        });
    }
    
    // Calculate fee and points after fee
    const fee = Math.round(totalPoints * FEE_PERCENTAGE);
    const pointsAfterFee = totalPoints - fee;
    
    // Update total points display with fee information
    document.getElementById('totalPoin').innerHTML = `
        <div class="space-y-1">
            <div class="flex justify-between">
                <span>Subtotal</span>
                <span>${totalPoints} poin</span>
            </div>
            <div class="flex justify-between text-red-500">
                <span>Fee (20%)</span>
                <span>-${fee} poin</span>
            </div>
            <div class="flex justify-between font-bold text-green-600">
                <span>Total</span>
                <span>${pointsAfterFee} poin</span>
            </div>
        </div>
    `;
    
    // Update hidden input with points after fee
    document.getElementById('totalPoinInput').value = pointsAfterFee;
    
    // Enable/disable submit button based on if there are items
    const submitButton = document.getElementById('saveOrderButton');
    if (orderItems.length === 0) {
        submitButton.disabled = true;
        submitButton.classList.add('opacity-50', 'cursor-not-allowed');
    } else {
        submitButton.disabled = false;
        submitButton.classList.remove('opacity-50', 'cursor-not-allowed');
    }
}

/**
 * Setup date and time validation
 */
function setupDateTimeValidation() {
    const dateInput = document.getElementById('pickup_date');
    const timeInput = document.getElementById('pickup_time');
    
    // Add event listeners
    dateInput.addEventListener('change', validateDateTime);
    timeInput.addEventListener('change', validateDateTime);
}

/**
 * Validate date and time selections
 */
function validateDateTime() {
    const dateInput = document.getElementById('pickup_date');
    const timeInput = document.getElementById('pickup_time');
    const saveButton = document.getElementById('saveOrderButton');
    
    const selectedDate = new Date(dateInput.value);
    const now = new Date();
    
    // Reset time options
    resetTimeOptions();
    
    // If selected date is today, disable past time slots
    if (selectedDate.toDateString() === now.toDateString()) {
        const currentHour = now.getHours();
        
        // Get all time options
        const timeOptions = timeInput.querySelectorAll('option:not([disabled])');
        
        // Disable past time slots
        timeOptions.forEach(option => {
            if (option.value === '') return; // Skip placeholder
            
            const optionHour = parseInt(option.value.split(':')[0]);
            if (optionHour <= currentHour) {
                option.disabled = true;
            }
        });
        
        // If the currently selected time is now disabled, reset selection
        if (timeInput.selectedIndex > 0 && timeInput.options[timeInput.selectedIndex].disabled) {
            timeInput.selectedIndex = 0;
        }
    }
    
    // Check if both date and time are selected for form validation
    const isDateSelected = dateInput.value !== '';
    const isTimeSelected = timeInput.value !== '';
    const hasItems = orderItems.length > 0;
    
    saveButton.disabled = !(isDateSelected && isTimeSelected && hasItems);
    
    if (saveButton.disabled) {
        saveButton.classList.add('opacity-50', 'cursor-not-allowed');
    } else {
        saveButton.classList.remove('opacity-50', 'cursor-not-allowed');
    }
}

/**
 * Reset time options (remove disabled attribute)
 */
function resetTimeOptions() {
    const timeInput = document.getElementById('pickup_time');
    const timeOptions = timeInput.querySelectorAll('option');
    
    timeOptions.forEach(option => {
        if (option.value !== '') { // Skip placeholder
            option.disabled = false;
        }
    });
}

/**
 * Setup mobile cart buttons
 */
function setupMobileCartButtons() {
    // Mobile cart button (show cart)
    const showCartButton = document.createElement('button');
    showCartButton.id = 'showCart';
    showCartButton.className = 'fixed bottom-4 right-4 lg:hidden bg-blue-500 text-white p-4 rounded-full shadow-lg z-40';
    showCartButton.innerHTML = '<i class="fas fa-shopping-cart"></i>';
    document.body.appendChild(showCartButton);
    
    // Show cart event
    showCartButton.addEventListener('click', function() {
        const cartOverlay = document.getElementById('cartOverlay');
        cartOverlay.classList.remove('translate-x-full');
    });
    
    // Close cart event
    document.getElementById('closeCart').addEventListener('click', function() {
        const cartOverlay = document.getElementById('cartOverlay');
        cartOverlay.classList.add('translate-x-full');
    });
}
</script>
@endpush