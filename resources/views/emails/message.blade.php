<!-- resources/views/emails/contact.blade.php -->
<h2>Pesan Baru dari {{ $contactData['name'] }}</h2>
<p><strong>Email:</strong> {{ $contactData['email'] }}</p>
<p><strong>No Telepon:</strong> {{ $contactData['phone'] }}</p>
<p><strong>Subject:</strong> {{ $contactData['subject'] }}</p>
<p><strong>Pesan:</strong> {{ $contactData['message'] }}</p>
