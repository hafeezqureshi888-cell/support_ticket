@extends('layouts.app')

@section('title', 'Submit Support Ticket')

@section('content')
<div class="w-full md:max-w-xl md:mx-auto">
    <div id="card" class="bg-white rounded-lg shadow-md p-4 md:p-8 transition-all">

      <h1 class="mb-6 md:mb-8 text-lg md:text-xl font-semibold text-gray-800">Submit a Support Ticket</h1>

      <!-- Success message (hidden by default) -->
      <div id="successMsg" class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg flex items-start gap-3 hidden">
        <svg class="w-5 h-5 text-green-600 flex-shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M12 9v4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
          <path d="M12 17h.01" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
          <path d="M21 12c0 4.97-4.03 9-9 9s-9-4.03-9-9 4.03-9 9-9 9 4.03 9 9z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        <div>
          <p id="successText" class="text-green-800">Your support ticket has been submitted successfully! We'll get back to you soon.</p>
        </div>
      </div>

      <form id="ticketForm" class="space-y-5" novalidate>
        @csrf

        <!-- Ticket Type -->
        <div>
          <label for="ticketType" class="block mb-2 text-sm text-gray-700">
            Ticket Type <span class="text-red-500">*</span>
          </label>
          <select id="ticketType" name="ticketType" data-field class="w-full px-3 py-3 md:px-4 md:py-2.5 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors">
            <option value="">Select a ticket type</option>
            <option>Technical Issues</option>
            <option>Account & Billing</option>
            <option>Product & Service</option>
            <option>General Inquiry</option>
            <option>Feedback & Suggestions</option>
          </select>
          <p data-error-for="ticketType" class="mt-1.5 text-red-500 text-sm flex items-center gap-1 hidden">
             <span class="error-text"></span>
          </p>
        </div>

        <!-- Full Name -->
        <div>
          <label for="fullName" class="block mb-2 text-sm text-gray-700">
            Full Name <span class="text-red-500">*</span>
          </label>
          <input id="fullName" name="fullName" data-field type="text" placeholder="Enter your full name"
            class="w-full px-3 py-3 md:px-4 md:py-2.5 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors"/>
          <p data-error-for="fullName" class="mt-1.5 text-red-500 text-sm flex items-center gap-1 hidden">
             <span class="error-text"></span>
          </p>
        </div>

        <!-- Email -->
        <div>
          <label for="email" class="block mb-2 text-sm text-gray-700">
            Email Address <span class="text-red-500">*</span>
          </label>
          <input id="email" name="email" data-field type="email" placeholder="Enter your email address"
            class="w-full px-3 py-3 md:px-4 md:py-2.5 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors"/>
          <p data-error-for="email" class="mt-1.5 text-red-500 text-sm flex items-center gap-1 hidden">
             <span class="error-text"></span>
          </p>
        </div>

        <!-- Phone -->
        <div>
          <label for="phoneNumber" class="block mb-2 text-sm text-gray-700">
            Phone Number <span class="text-gray-500 text-sm">(Optional)</span>
          </label>
          <input id="phoneNumber" name="phoneNumber" data-field type="tel" placeholder="Enter your phone number"
            class="w-full px-3 py-3 md:px-4 md:py-2.5 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors" />
        </div>

        <!-- Subject -->
        <div>
          <label for="subject" class="block mb-2 text-sm text-gray-700">
            Subject <span class="text-red-500">*</span>
          </label>
          <input id="subject" name="subject" data-field type="text" placeholder="Short summary of the issue"
            class="w-full px-3 py-3 md:px-4 md:py-2.5 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors"/>
          <p data-error-for="subject" class="mt-1.5 text-red-500 text-sm flex items-center gap-1 hidden">
             <span class="error-text"></span>
          </p>
        </div>

        <!-- Description -->
        <div>
          <label for="description" class="block mb-2 text-sm text-gray-700">
            Description <span class="text-red-500">*</span>
          </label>
          <textarea id="description" name="description" data-field rows="5" placeholder="Describe your issue in detail…"
            class="w-full px-3 py-3 md:px-4 md:py-2.5 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 resize-y transition-colors"></textarea>
          <p data-error-for="description" class="mt-1.5 text-red-500 text-sm flex items-center gap-1 hidden">
             <span class="error-text"></span>
          </p>
        </div>

        <!-- Submit -->
        <button id="submitBtn" type="submit"
          class="w-full bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white py-3 rounded-lg shadow-lg hover:shadow-xl transition-all mt-6 text-sm font-semibold inline-flex items-center justify-center disabled:opacity-75 disabled:cursor-not-allowed">
          <svg id="btnSpinner" aria-hidden="true" role="status" class="hidden w-4 h-4 me-2 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/>
            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/>
          </svg>
          <span id="btnText">Submit Ticket</span>
        </button>

      </form>
    </div>
</div>

<script>
  const form = document.getElementById('ticketForm');
  const submitBtn = document.getElementById('submitBtn');
  const btnSpinner = document.getElementById('btnSpinner');
  const btnText = document.getElementById('btnText');
  const successMsg = document.getElementById('successMsg');
  const csrfToken = document.querySelector('input[name="_token"]').value;

  form.addEventListener('submit', async function(e) {
    e.preventDefault();
    
    // Simple validation (can be enhanced)
    const formData = new FormData(form);
    const data = Object.fromEntries(formData.entries());
    
    // Clear errors
    document.querySelectorAll('[data-error-for]').forEach(el => el.classList.add('hidden'));

    // Set loading state
    submitBtn.disabled = true;
    btnSpinner.classList.remove('hidden');
    btnText.textContent = 'Submitting...';

    try {
        const response = await fetch('/submit-ticket', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify(data)
        });

        const result = await response.json();

        if (response.ok) {
            const ticketRef = result.ticket_ref;
            document.getElementById('successText').innerHTML = 
                `Your support ticket has been submitted successfully!<br>
                <strong>Ticket Reference: ${ticketRef}</strong><br>
                <a href="/check-status" class="underline text-green-700 hover:text-green-900">Check your ticket status</a>`;
            successMsg.classList.remove('hidden');
            form.reset();
            setTimeout(() => successMsg.classList.add('hidden'), 10000);
        } else {
            if (result.errors) {
                // Show errors
                for (const [key, msgs] of Object.entries(result.errors)) {
                    const errEl = document.querySelector(`[data-error-for="${key}"]`);
                    if (errEl) {
                        errEl.querySelector('.error-text').textContent = msgs[0];
                        errEl.classList.remove('hidden');
                    }
                }
            } else {
                alert('Error: ' + (result.message || 'Something went wrong'));
            }
        }
    } catch (error) {
        console.error('Error:', error);
        alert('An error occurred. Please try again.');
    } finally {
        // Reset loading state
        submitBtn.disabled = false;
        btnSpinner.classList.add('hidden');
        btnText.textContent = 'Submit Ticket';
    }
  });
</script>
@endsection
