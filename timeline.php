<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>バレーボールチーム選択</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-image: url('images/背景.png'); /* 背景画像のパスを指定 */
      background-size: cover; /* 背景画像を全体に合わせる */
      background-repeat: no-repeat; /* 画像の繰り返しを防止 */
      background-position: center; /* 画像を中央に配置 */
      display: flex;
      justify-content: center; /* 横中央に配置 */
      align-items: center; /* 縦中央に配置 */
      height: 100vh; /* ビューポートの高さに合わせる */
    }
    .container {
      width: 80%;
      max-width: 600px;
      margin: 20px auto;
      background: rgba(255, 255, 255, 0.9); /* 半透明のホワイト背景 */
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    h1 {
      text-align: center;
      color: #333;
    }
    .form-group {
      margin-bottom: 20px;
    }
    .form-group label {
      display: block;
      margin-bottom: 5px;
    }
    .form-group select, .form-group input[type="submit"] {
      padding: 10px;
      font-size: 16px;
      width: 100%;
      border: 1px solid #ddd;
      border-radius: 4px;
    }
    .form-group select {
      background-color: #333; /* フォーム背景色を黒に設定 */
      color: #fff; /* テキスト色を白に設定 */
    }
    .form-group input[type="submit"] {
      background-color: #007bff;
      color: #fff;
      border: none;
      cursor: pointer;
    }
    .form-group input[type="submit"]:hover {
      background-color: #0056b3;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>チームの詳細を表示</h1>
    <form action="team_history.php" method="GET">
      <div class="form-group">
        <label for="team">チームを選択:</label>
        <select name="team" id="team" required>
          <option value="">-- 選択してください --</option>
          <?php
          // データベース接続設定
          $dbconn = pg_connect("host=localhost dbname=s2322029 user=s2322029 password=82tEN2QC")
              or die('Could not connect: ' . pg_last_error());

          // チームのリストを取得（genreがSV1WOMENまたはSV1MENのものに絞る）
          $query = "SELECT DISTINCT team_name FROM v_league WHERE genre IN ('SV1 WOMEN', 'SV1MEN') ORDER BY team_name;";
          $result = pg_query($query) or die('Query failed: ' . pg_last_error());

          // チームのリストをオプションとして表示
          while ($line = pg_fetch_assoc($result)) {
            $team_name = htmlspecialchars($line['team_name']);
            echo "<option value=\"$team_name\">$team_name</option>";
          }

          // データベース接続を閉じる
          pg_close($dbconn);
          ?>
        </select>
      </div>
      <input type="submit" value="表示">
    </form>
  </div>
</body>
</html>
