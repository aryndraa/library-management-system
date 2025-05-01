<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Borrowing Receipt</title>
    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "Times New Roman", Times, serif;
            line-height: 1.5;
        }

        .section {
            margin: 0 10%;
            position: relative;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            font-weight: 800;
            margin: 20px 0;
        }

        .header h2 {
            font-size: 1.2rem;
            font-weight: 600;
            padding: 14px 0px;
            border-top: dashed 2px;
            border-bottom: dashed 2px;
        }

        .details {
            display: flex;
            flex-direction: column;
            padding-bottom: 20px;
            margin-bottom: 20px;
            border-bottom: dashed 2px;
            gap: 8px;
        }

        .details .detail-item {
            align-items: center;
            padding: 8px 0;
            font-size: 1.1rem;
            font-weight: 500;
            gap: 8px;
        }

        .details .detail-item strong {
            font-weight: 400;
        }

        .details .detail-item span {
            position: absolute;
            right: 0;
        }
    </style>
</head>
<body>
<div class="section">
    <div class="header">
        <h1>Perpusku.</h1>
        <h2>Receipt Code : DSQGFG</h2>
    </div>

    <div class="details">
        <div class="detail-item">
            <strong>Member :</strong>
            <span>Hendro Jawir</span>
        </div>

        <div class="detail-item">
            <strong>Library :</strong>
            <span>Denpasar Utara</span>
        </div>

        <div class="detail-item">
            <strong>Book :</strong>
            <span>Homesweet Alabama</span>
        </div>
        <div class="detail-item">
            <strong>ISBN :</strong>
            <span>Homesweet Alabama</span>
        </div>
    </div>

    <div class="details">
        <div class="detail-item">
            <strong>Borrowing Date :</strong>
            <span>20 Apr 2025</span>
        </div>
        <div class="detail-item">
            <strong>Borrowing Due :</strong>
            <span>25 Apr 2025</span>
        </div>
    </div>
</div>
</body>
</html>
