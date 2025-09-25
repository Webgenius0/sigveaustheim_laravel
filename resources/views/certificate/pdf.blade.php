<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Student Fitness Report</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .section {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 8px;
            text-align: center;
        }

        .summary {
            background: #f9f9f9;
            padding: 10px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>Student Fitness Report</h2>
    </div>

    <div class="section">
        <h3>Student Details</h3>
        <p><strong>Name:</strong> {{ $data['student']['name'] }}</p>
        <p><strong>Gender:</strong> {{ $data['student']['gender'] }}</p>
        <p><strong>Age:</strong> {{ $data['student']['age'] }}</p>
        <p><strong>Class:</strong> {{ $data['student']['class'] }} - {{ $data['student']['section'] }}</p>
        <p><strong>Roll:</strong> {{ $data['student']['class_roll'] }}</p>
        @if ($data['student']['school'])
            <p><strong>School:</strong> {{ $data['student']['school']['school_name'] }}</p>
            <p><strong>City:</strong> {{ $data['student']['school']['city'] }}</p>
        @endif
    </div>

    <div class="section">
        <h3>Fitness Tests</h3>
        <table>
            <thead>
                <tr>
                    <th>Test</th>
                    <th>Unit</th>
                    <th>Attempts</th>
                    <th>Last Score</th>
                    <th>Comment</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data['fitness_tests'] as $test)
                    <tr>
                        <td>{{ $test['name'] }}</td>
                        <td>{{ $test['unit'] }}</td>
                        <td>{{ $test['attempts'] }}</td>
                        <td>{{ $test['last_score'] ?? '-' }}/{{ $test['out_of'] }}</td>
                        <td>{{ $test['comment'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="section summary">
        <h3>Summary</h3>
        <p><strong>Total Attempts:</strong> {{ $data['summary']['total_attempts'] }}</p>
        <p><strong>Unique Tests Taken:</strong> {{ $data['summary']['unique_tests_taken'] }}</p>
        <p><strong>Overall Percentage:</strong> {{ $data['summary']['overall_percentage'] }}%</p>
        <p><strong>Overall Comment:</strong> {{ $data['summary']['overall_comment'] }}</p>
    </div>
</body>

</html>
