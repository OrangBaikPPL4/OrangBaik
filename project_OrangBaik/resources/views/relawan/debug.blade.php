<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Debug Relawan</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .container { max-width: 1200px; margin: 0 auto; }
        .debug-info { background: #f5f5f5; padding: 15px; border-radius: 5px; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 8px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Debug Relawan View</h1>
        
        <div class="debug-info">
            <h2>Debug Information</h2>
            <p>Current User: {{ Auth::user()->name }} ({{ Auth::user()->email }})</p>
            <p>User Type: {{ Auth::user()->usertype }}</p>
            <p>Current Route: {{ request()->route()->getName() }}</p>
            
            @if(isset($relawans))
                <p>Relawans Variable: Defined (Count: {{ $relawans->count() }})</p>
                <pre>{{ print_r($relawans->toArray(), true) }}</pre>
            @else
                <p>Relawans Variable: Not defined</p>
            @endif
            
            @if(isset($error))
                <p>Error: {{ $error }}</p>
            @endif
        </div>
        
        <h2>Relawan Data</h2>
        @if(isset($relawans) && $relawans->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Peran</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($relawans as $relawan)
                    <tr>
                        <td>{{ $relawan->id }}</td>
                        <td>{{ $relawan->nama }}</td>
                        <td>{{ $relawan->email }}</td>
                        <td>{{ $relawan->peran }}</td>
                        <td>{{ $relawan->status }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>Tidak ada data relawan yang tersedia.</p>
        @endif
    </div>
</body>
</html>
