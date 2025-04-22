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
            gap: 2px;
        }

        .details .detail-item {
            align-items: center;
            padding: 8px 0;
            font-size: 1.1rem;
            font-weight: 500;
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
            <strong>Room :</strong>
            <span>Room 2</span>
        </div>
        <div class="detail-item">
            <strong>Price : </strong>
            <span>Rp. 80.000</span>
        </div>
    </div>

    <div class="details">
        <div class="detail-item">
            <strong>Booking Date :</strong>
            <span>20 Apr 2025</span>
        </div>
        <div class="detail-item">
            <strong>Started Time :</strong>
            <span>25 Apr 2025</span>
        </div>
        <div class="detail-item">
            <strong>Finished Time :</strong>
            <span>25 Apr 2025</span>
        </div>
    </div>

    <div class="details">
        <div class="detail-item">
            <strong>Total Price :</strong>
            <span>Rp. 160.000</span>
        </div>
        <div class="detail-item">
            <strong>Payment Method :</strong>
            <span>Gopay</span>
        </div>
    </div>
</div>
</body>
</html>
