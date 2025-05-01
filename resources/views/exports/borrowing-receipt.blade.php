<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Borrowing Receipt</title>
    <style>
        body { font-family: sans-serif; }
        .header { text-align: center; margin-bottom: 20px; }
        .details { margin-top: 10px; }
    </style>
</head>
<body>
<div class="header">
    <h2>Borrowing Receipt</h2>
</div>

<div class="details">
    <p><strong>Code:</strong> {{ $borrowedBook->code }}</p>
    <p><strong>Book Title:</strong> {{ $borrowedBook->book->title ?? 'N/A' }}</p>
    <p><strong>Borrowed At:</strong> {{ $borrowedBook->borrowed_at }}</p>
    <p><strong>Due Date:</strong> {{ $borrowedBook->due_date }}</p>
</div>
</body>
</html>
