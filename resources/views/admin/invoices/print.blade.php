<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <title>Document</title>
    <style>
        .foot {
            position: relative;
        }

        .sign {
            position: absolute;
            bottom: 0;
            left: 20px;
        }
    </style>
</head>
<body>
    <div class="d-flex justify-content-start mb-3" style="margin-bottom: 90px;">
        <img class="w-75" src="{{asset('assets/img/invoice.jpeg')}}" alt="">
    </div>
    <br>
    <div class="d-flex justify-content-between">
        <span>&nbsp;</span>
        <h2 class="ms-5 text-success">INVOICE</h2>
        <div class="d-flex gap-3">
            <h5>Job Card</h5>
            <h5>: {{$invoice->invoice_no}}</h5>
        </div>
    </div>
    <br>
    <div class="row px-2">
        <div class="col-8 pe-1 mb-1">
            <input type="text" class="form-control" value="Name   -   {{$invoice->customer->customer_name}}">
        </div>
        <div class="col-4 ps-0 mb-1">
            <input type="text" class="form-control" value="Date  -  {{$invoice->date}}">
        </div>
        <div class="col-8 pe-1">
            <input type="text" class="form-control" value="Name   -   {{$invoice->customer->address}}">
        </div>
        <div class="col-4 ps-0">
            <input type="text" class="form-control" value="Date  -  {{$invoice->voucher_no}}">
        </div>
        <div class="px-2 mt-5">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Particulars</th>
                        <th>Qty</th>
                        <th>Rate</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($invoice->particulars as $p)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$p->particular_name}}</td>
                            <td>{{$p->qty}}</td>
                            <td>{{$p->rate}}</td>
                            <td class="text-end">{{$p->amount}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="foot mt-3">
            <div class="sign d-flex flex-column align-items-center">
                <span>_____________________</span>
                <h5>Mathi</h5>
                <h6>(Receiver)</h6>
            </div>
            <div class="row mb-1">
                <div class="col-2 offset-7 pt-1">Total</div>
                <div class="col-3"><input type="text" name="total" class="form-control w-100 total" value="{{$invoice->total}}"></div>
            </div>
            <div class="row mb-1">
                <div class="col-2 offset-7 pt-1">Advance</div>
                <div class="col-3"><input type="number" name="advance" class="form-control w-100 advance" value="{{$invoice->advance}}"></div>
            </div>
            <div class="row mb-1">
                <div class="col-2 offset-7 pt-1">Balance</div>
                <div class="col-3"><input type="text" name="balance" class="form-control w-100 balance" value="{{$invoice->balance}}"></div>
            </div>
        </div>
    </div>
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-qFOQ9YFAeGj1gDOuUD61g3D+tLDv3u1ECYWqT82WQoaWrOhAY+5mRMTTVsQdWutbA5FORCnkEPEgU0OF8IzGvA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Add page numbers when printing


        (function() {
            window.print();

        })();
    })


</script>
</html>
