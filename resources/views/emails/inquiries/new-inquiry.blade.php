<x-mail::message>
# New Client Inquiry Received

A visitor has submitted a new inquiry via the public contact desk:

* **Name**: {{ $contactMessage->firstname }} {{ $contactMessage->lastname }}
* **Email**: [{{ $contactMessage->email }}](mailto:{{ $contactMessage->email }})
* **Telephone**: {{ $contactMessage->phone ?? 'Not provided' }}

<x-mail::panel>
{{ $contactMessage->message }}
</x-mail::panel>

<x-mail::button :url="route('admin.messages.index')">
Manage Inquiries in Admin Console
</x-mail::button>

Received at {{ $contactMessage->created_at ? $contactMessage->created_at->format('M d, Y H:i') : now()->format('M d, Y H:i') }}
</x-mail::message>
