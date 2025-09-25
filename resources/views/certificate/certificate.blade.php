<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Certificate</title>

    <style>
        @import url("https://fonts.googleapis.com/css2?family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&display=swap");

        @page {
            size: A4;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: "Nunito Sans", "Times New Roman", serif;
            background: #fdfdfd;
            padding: 20px;
        }

        .certificate {
            width: 210mm;
            /* A4 width */
            height: 297mm;
            /* A4 height */
            padding: 20px 50px 50px 50px;
            box-sizing: border-box;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-between;
            background-image: url("{{ asset('certificate/certificate_background.png') }}");
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
        }

        .content_wrapper {
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-between;
        }

        .badges_wrapper {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
            justify-content: center;
            align-items: center;
            padding-bottom: 20px;
            width: 100%;
        }

        .badge {
            width: 100px;
            height: 80px;
            display: flex;
            padding: 5px;
            align-items: center;
            justify-content: center;
        }

        .badge img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .information_wrapper {
            width: 100%;
            display: flex;
            flex-direction: column;
            justify-content: start;
            align-items: center;
            gap: 24px;
            margin-top: 230px;
        }

        .certificate_title {
            text-align: center;
            font-size: 36px;
            line-height: normal;
            font-weight: 900;
            margin: 0;
        }

        .certificate_subtitle {
            text-align: center;
            font-size: 32px;
            line-height: normal;
            font-weight: 500;
            margin: 0;
        }

        .certificate_name {
            text-align: center;
            font-size: 32px;
            line-height: normal;
            font-weight: 900;
            margin: 0;
        }

        .certificate_description {
            text-align: center;
            font-size: 24px;
            line-height: normal;
            font-weight: 500;
            margin: 0;
        }

        .date_and_signature {
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
            height: 150px;
        }

        .date_and_signature hr {
            width: 100%;
            border: 2px solid gray;
        }

        .signature_badge {
            width: 120px;
            height: 120px;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            /* background-image: url("{{ asset('certificate/certificate_badge.png') }}"); */
            background-image: url("{{ asset('certificate/certificate_badge.png') }}");
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            padding: 5px;
        }

        .signature_badge p {
            text-align: center;
            font-size: 14px;
            line-height: normal;
            font-weight: 700;
            margin: 0;
            color: #bf9000;
            line-clamp: 1;
        }

        .date_of_issue {
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            overflow: hidden;
        }

        .signature {
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .signature_image {
            width: 150px;
            height: 100px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: -70px;
        }

        .signature_image img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .date_and_signature_label {
            text-align: center;
            font-size: 16px;
            line-height: normal;
            font-weight: 700;
            margin: 0;
            text-transform: uppercase;
        }

        .issue_date {
            text-align: center;
            font-size: 16px;
            line-height: normal;
            font-weight: 700;
            margin: 0;
        }
    </style>
</head>

<body>
    <div class="certificate">
        <div class="content_wrapper">

            <!-- Badges -->
            <div class="badges_wrapper">
                @foreach ($studentData['fitness_tests'] as $index => $test)
                    <div class="badge">
                        @if ($test['is_completed'])
                            <img src="{{ asset('' . ($index + 1) . '.png') }}"
                                alt="{{ $test['name'] }}" />
                        @else
                            <img src="{{ asset('certificate/cross.png') }}" alt="Not Completed" />
                        @endif
                    </div>
                @endforeach
            </div>

            <!-- Information -->
            <div class="information_wrapper">
                <p class="certificate_title">FitnessQ Certificate</p>
                <p class="certificate_subtitle">Proudly presented to</p>
                <p class="certificate_name">{{ $studentData['student']['name'] }}</p>
                <p class="certificate_description">
                    for having achieved {{ $studentData['summary']['overall_percentage'] }}%
                    in the FitnessQ assessment
                </p>
            </div>

            <!-- Footer -->
            <div class="date_and_signature">
                <!-- Date -->
                <div class="date_of_issue">
                    <p class="issue_date">{{ now()->format('d/m/Y') }}</p>
                    <hr />
                    <p class="date_and_signature_label">DATE</p>
                </div>

                <!-- Signature Badge -->
                <div class="signature_badge">
                    <p>Level {{ ceil($studentData['summary']['overall_percentage'] / 10) }}</p>
                    <p>******</p>
                    <p>{{ $studentData['summary']['overall_percentage'] }}%</p>
                </div>

                <!-- Signature -->
                <div class="signature">
                    <div class="signature_image">
                        <img src="{{ asset('certificate/signature.png') }}" alt="signature" />
                    </div>
                    <hr />
                    <p class="date_and_signature_label">Signature</p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
