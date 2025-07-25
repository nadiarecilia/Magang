<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Selamat Anda Diterima</title>
  <style>
    body {
      font-family: 'Arial', sans-serif;
      background-color: #f9f9f9;
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
      color: #4c4c9d;
    }
    .btn {
      display: inline-block;
      margin-top: 20px;
      background-color: #4c4c9d;
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
    <h2>Selamat, {{ $applicant->name }}!</h2>
    <p>Anda telah <strong>diterima</strong> untuk posisi <strong>{{ $applicant->jobPosting->title }}</strong> di <strong>Winnicode Garuda Teknologi</strong>.</p>

    <p>Tim kami akan segera menghubungi Anda untuk proses onboarding selanjutnya. Pastikan kontak Anda tetap aktif dan periksa email Anda secara berkala.</p>

    <p>Terima kasih telah mengikuti proses seleksi di perusahaan kami.</p>
    <p class="footer">Jika Anda memiliki pertanyaan, silakan hubungi HRD kami melalui email ini.</p>
  </div>
</body>
</html>