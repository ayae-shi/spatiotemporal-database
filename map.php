<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
  <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
  <title>V.LEAGUE情報サイト</title>
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin=""/>
  <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js" integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew==" crossorigin=""></script>
  <style type="text/css">
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
      max-width: 1000px; /* 最大幅を設定 */
      padding: 20px;
      text-align: center;
      background-color: rgba(255, 255, 255, 0.8); /* 背景に半透明のホワイトを追加してコンテンツを読みやすくする */
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    .search-form {
      margin-bottom: 20px;
      padding: 10px;
      background-color: #000000; /* フォームの背景色を黒に設定 */
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      color: #ffffff; /* フォーム内の文字色を白に設定 */
    }
    .search-form label {
      color: #ffffff; /* ラベルの文字色を白に設定 */
      font-size: 16px;
      margin-right: 10px;
    }
    .search-form select, .search-form input[type="text"] {
      padding: 10px;
      font-size: 16px;
      margin: 5px;
      border: 1px solid #ddd;
      border-radius: 4px;
      color: #ffffff; /* テキストボックス内の文字色を白に設定 */
      background-color: #333333; /* テキストボックスの背景色をダークグレーに設定 */
    }
    .search-form input[type="submit"] {
      padding: 10px 20px;
      font-size: 16px;
      color: #ffffff;
      background-color: #007bff;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }
    .search-form input[type="submit"]:hover {
      background-color: #0056b3;
    }
    .search-form .or {
      display: inline-block;
      margin: 0 10px;
      color: #ffffff; /* "OR"の文字色を白に設定 */
      font-size: 16px;
    }
    #map {
      height: 500px;
      border: 2px solid #ddd;
      border-radius: 8px;
    }
  </style>
</head>
<body>
  <?php
  // フォームからの入力を取得
  $team_name = isset($_POST['team_name']) ? $_POST['team_name'] : '';
  $area = isset($_POST['area']) ? $_POST['area'] : '';
  $genre = isset($_POST['genre']) ? $_POST['genre'] : '';

  // データベース接続設定
  $dbconn = pg_connect("host=localhost dbname=s2322029 user=s2322029 password=82tEN2QC")
      or die('Could not connect: ' . pg_last_error());

  // 中心座標を取得
  $query = "SELECT avg(lat) AS avglat, avg(lon) AS avglon FROM v_league 
            WHERE team_name LIKE '%" . pg_escape_string($team_name) . "%' 
            AND area LIKE '%" . pg_escape_string($area) . "%'
            AND genre LIKE '%" . pg_escape_string($genre) . "%';";
  $result = pg_query($query) or die('Query failed: ' . pg_last_error());
  $line = pg_fetch_array($result);
  $avglat = $line['avglat'];
  $avglon = $line['avglon'];

  // チーム情報を取得
  $query = "SELECT team_name, area, spotname, lat, lon, year_built, url FROM v_league 
            WHERE team_name LIKE '%" . pg_escape_string($team_name) . "%' 
            AND area LIKE '%" . pg_escape_string($area) . "%'
            AND genre LIKE '%" . pg_escape_string($genre) . "%';";
  $result = pg_query($query) or die('Query failed: ' . pg_last_error());

  // エリア名のリストを取得
  $area_query = "SELECT DISTINCT area FROM v_league ORDER BY area;";
  $area_result = pg_query($area_query) or die('Query failed: ' . pg_last_error());

  // ジャンルのリストを取得
  $genre_query = "SELECT DISTINCT genre FROM v_league ORDER BY genre;";
  $genre_result = pg_query($genre_query) or die('Query failed: ' . pg_last_error());
  ?>
  <div class="container">
    <div class="search-form">
      <form action="./map.php" method="POST">
        <label for="team_name">チーム名:</label>
        <input type="text" id="team_name" name="team_name" value="<?php echo htmlspecialchars($team_name); ?>" size="20">
        <span class="or">OR</span> <!-- "OR"の追加 -->
        <label for="area">エリア名:</label>
        <select id="area" name="area">
          <option value="">エリア選択</option>
          <?php while ($area_row = pg_fetch_array($area_result)) { ?>
            <option value="<?php echo htmlspecialchars($area_row['area']); ?>" <?php echo $area === $area_row['area'] ? 'selected' : ''; ?>>
              <?php echo htmlspecialchars($area_row['area']); ?>
            </option>
          <?php } ?>
        </select>
        <span class="or">OR</span>
        <label for="genre">ジャンル:</label>
        <select id="genre" name="genre">
          <option value="">ジャンル選択</option>
          <?php while ($genre_row = pg_fetch_array($genre_result)) { ?>
            <option value="<?php echo htmlspecialchars($genre_row['genre']); ?>" <?php echo $genre === $genre_row['genre'] ? 'selected' : ''; ?>>
              <?php echo htmlspecialchars($genre_row['genre']); ?>
            </option>
          <?php } ?>
        </select>
        <input type="submit" value="送信">
      </form>
    </div>
    <div id="map"></div>
  </div>
  <script type="text/javascript">
    var map = L.map('map', {
      center: [<?php echo $avglat; ?>, <?php echo $avglon; ?>],
      zoom: 5
    });
    var tileLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>',
    });
    tileLayer.addTo(map);
    <?php
    // チーム情報のマーカーを地図に追加
    while ($line = pg_fetch_array($result)) {
      echo "L.marker([" . $line['lat'] . ", " . $line['lon'] . "]).addTo(map)
        .bindPopup('<b>" . htmlspecialchars($line['team_name']) . "</b><br>エリア: " . htmlspecialchars($line['area']) . "<br>スポット名: " . htmlspecialchars($line['spotname']) . "<br>建設年: " . htmlspecialchars($line['year_built']) . "<br><a href=\"" . htmlspecialchars($line['url']) . "\" target=\"_blank\">公式サイト</a>');";
    }
    ?>
  </script>
</body>
</html>
