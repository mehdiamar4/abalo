<!DOCTYPE html>
<html>
<head>
    <title>Testdata</title>
</head>
<body>
<h1>Testdata</h1>

<table border="1" cellpadding="8">
    <tr>
        <th>ID</th>
        <th>Testname</th>
    </tr>

    @foreach ($testdata as $data)
        <tr>
            <td>{{ $data->id }}</td>
            <td>{{ $data->ab_testname }}</td>
        </tr>
    @endforeach
</table>
</body>
</html>
