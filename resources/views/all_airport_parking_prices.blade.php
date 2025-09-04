<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <form action="{{ route('all_airport_parking_prices.search_by_dates') }}" method="post">
        @csrf
        <input type="date" name="from_date" id="from_date"
            value="{{ old('from_date', request('from_date', date('Y-m-d'))) }}">
        <input type="date" name="to_date" id="to_date"
            value="{{ old('to_date', request('to_date', date('Y-m-d'))) }}">
        <select name="website_id" id="website_id">
            <option value="" >All Websites</option>
            @foreach($parkingWebsites as $website)
                <option value="{{ $website->id }}" {{ old('website_id') == $website->website_id ? 'selected' : '' }}>
                    {{ $website->name }}</option>
            @endforeach
        </select>
        <label for="gap_days">Gap of Days:</label>
        <select id="gap_days" name="gap_days" required>
            <option value="">Select gap</option>
            <option value="0">0</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7" selected>7</option>
            <option value="8">8</option>
            <option value="9">9</option>
            <option value="10">10</option>
            <option value="11">11</option>
            <option value="12">12</option>
            <option value="13">13</option>
            <option value="14">14</option>
            <option value="15">15</option>
            <option value="16">16</option>
            <option value="17">17</option>
            <option value="18">18</option>
            <option value="19">19</option>
            <option value="20">20</option>
            <option value="21">21</option>
            <option value="22">22</option>
            <option value="23">23</option>
            <option value="24">24</option>
            <option value="25">25</option>
            <option value="26">26</option>
            <option value="27">27</option>
            <option value="28">28</option>
            <option value="29">29</option>
            <option value="30">30</option>
        </select><br><br>
        <label>
        <button type="submit">Search</button>
        <button type="submit" formaction="{{ route('all_airport_parking_prices.download_excel') }}" formmethod="POST" style="margin-left:10px;">Download Excel</button>
    </form>

    @if(isset($parkingPrices) && count($parkingPrices) > 0)
        <table border="1" cellpadding="8" cellspacing="0" style="margin-top:20px; width:100%;">
            <caption style="caption-side: top; text-align: left; font-weight: bold; padding: 8px 0;">
                Showing {{ count($parkingPrices) }} result{{ count($parkingPrices) === 1 ? '' : 's' }}
            </caption>
            <thead>
                <tr>
                    <th>Website</th>
                    <th>Parking Company</th>
                    <th>Airport Code</th>
                    <th>Parking Type</th>
                    <th>Price</th>
                    <th>Discount</th>
                    <th>Transfer Time</th>
                    <th>From Date</th>
                    <th>To Date</th>
                    <th>Available</th>
                </tr>
            </thead>
            <tbody>
                @foreach($parkingPrices as $price)
                    <tr>
                        <td>{{ $price->website->name ?? '-' }}</td>
                        <td>{{ $price->parking_company_name ?? '-' }}</td>
                        <td>{{ $price->airport_code }}</td>
                        <td>{{ $price->parking_type }}</td>
                        <td>{{ $price->price }}</td>
                        <td>{{ $price->discount }}</td>
                        <td>{{ $price->transfer_time ?? '-' }}</td>
                        <td>{{ $price->from_date ?? '-' }}</td>
                        <td>{{ $price->to_date ?? '-' }}</td>
                        <td>{{ $price->is_available ? 'Yes' : 'No' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @elseif(isset($parkingPrices))
        <p>No parking prices found for the selected dates.</p>
    @endif
</body>

</html>
