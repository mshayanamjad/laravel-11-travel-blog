<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title>Reset Your Password</title>
  <style>
    html {
      overflow-x: hidden;
      width: 100%;
    }

    body {
      font-family: Arial, Helvetica, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f4f4f7;
      color: #333;
      overflow-x: hidden;
      width: 100%;
      box-sizing: border-box;
    }
    .email-wrapper {
      width: 100%;
      overflow-x: hidden;
      padding: 20px;
      background-color: #f4f4f7;
      box-sizing: border-box;
    }
    .email-container {
      max-width: 100%;
      margin: 0 auto;
      background-color: #ffffff;
      border-radius: 8px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      overflow: hidden;
    }
    .email-header h1 {
      margin: 0;
      font-size: 24px;
      color: #000;
      text-align: center;
    }
    .email-body {
      padding: 30px;
    }
    .email-body p {
      font-size: 16px;
      line-height: 1.6;
      margin: 0 0 20px;
    }
    .email-button {
      display: block;
      width: fit-content;
      margin: 20px auto;
      padding: 12px 24px;
      background-color: #007bff;
      color: #ffffff;
      text-decoration: none;
      font-size: 16px;
      font-weight: bold;
      border-radius: 5px;
      text-align: center;
    }
    .email-button:hover {
      background-color: #0056b3;
    }
    .email-footer {
      text-align: center;
      font-size: 14px;
      color: #666;
      padding: 20px;
      background-color: #f4f4f7;
    }
    .email-footer a {
      color: #007bff;
      text-decoration: none;
    }
    .email-footer a:hover {
      text-decoration: underline;
    }

    @media (max-width: 767px) {
      .email-container {
        max-width: 100%;
      }
    }
  </style>
</head>
<body>
  <div class="email-wrapper">
    <div class="email-container">
      <h1>Contact Form Submission</h1>
      <div class="email-body">
        <p><strong>Name:</strong> {{ $data['name'] }}</p>
        <p><strong>Email:</strong> {{ $data['email'] }}</p>
        <p><strong>Subject:</strong> {{ $data['subject'] }}</p>
        <p><strong>Message:</strong> {{ $data['message'] }}</p>
      </div>
    </div>
  </div>
</body>
</html>
