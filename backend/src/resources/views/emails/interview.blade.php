<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Undangan Interview</title>
  <style>
    body {
      font-family: 'Arial', sans-serif;
      background-color: #f4f4f4;
      padding: 30px;
      color: #333;
    }
    .email-container {
      max-width: 600px;
      background-color: #ffffff;
      padding: 20px 30px;
      margin: auto;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.08);
    }
    h2 {
      color: #2196f3;
    }
    .btn {
      display: inline-block;
      margin-top: 20px;
      background-color: #2196f3;
      color: #ffffff;
      padding: 10px 20px;
      border-radius: 6px;
      text-decoration: none;
    }
    .footer {
      margin-top: 30px;
      font-size: 0.9rem;
      color: #777;
    }
  </style>
</head>
<body>
  <div class="email-container">
    <h2>Undangan Interview - {{ $application->jobPosting->title }}</h2>
    <p>Halo, <strong>{{ $application->name }}</strong>,</p>

    <p>Selamat! Anda terpilih untuk melanjutkan ke tahap interview untuk posisi <strong>{{ $application->jobPosting->title }}</strong>.</p>

    <p><strong>Berikut informasi interview Anda:</strong></p>
    <ul>
      <li><strong>Waktu:</strong> {{ \Carbon\Carbon::parse($schedule)->format('l, d M Y H:i') }}</li>
      <li><strong>Link Interview:</strong> <a href="{{ $link }}">{{ $link }}</a></li>
    </ul>

    <p>Pastikan Anda hadir tepat waktu dan mempersiapkan diri sebaik mungkin. Bila Anda memiliki kendala, silakan hubungi kami segera.</p>

    <p class="footer">Terima kasih atas ketertarikan Anda untuk bergabung bersama Winnicode Garuda Teknologi.</p>
  </div>
</body>
</html>