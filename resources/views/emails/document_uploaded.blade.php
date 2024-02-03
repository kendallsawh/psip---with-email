<!-- resources/views/emails/document_uploaded.blade.php -->

<h1>New Document Uploaded</h1>

<p>You are receiving this email because a new document has been uploaded that falls under your group's responsibility.</p>

<p>
    <strong>Document Details:</strong><br>
    Name: {{ $documentName }}<br>
    Type: Test<br>
    Uploaded By: Test<br>
    Description: Test
</p>

<p>To view this document, <a href="{{ url('/path/to/document') }}">click here</a>.</p>

<p>If you have any questions, please <a href="mailto:support@example.com">contact support</a>.</p>

<p>Best regards,<br>Your Company</p>
