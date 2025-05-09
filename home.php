<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
    <title>V.LEAGUE情報サイト</title>
    <style type="text/css">
        body {
            font-family: 'Roboto', sans-serif;
            background-image: url('images/V.png'); /* 背景画像 */
            background-size: cover; /* 画像を全体にフィットさせる */
            background-position: center; /* 画像の位置を中央に設定 */
            color: #fff; /* 白色 */
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh; /* ビューポートの高さに合わせる */
        }
        .container {
            text-align: center;
            background-color: rgba(255, 255, 255, 0.8); /* 半透明の白色 */
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.2); /* 影を追加 */
            padding: 30px;
            max-width: 600px;
            width: 100%;
        }
        h1 {
            color: #000; /* 黒色 */
            font-size: 2.5em;
            margin-bottom: 20px;
            padding: 20px;
            background-color: #fff; /* 白背景 */
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.3); /* 影を追加 */
        }
        h3 {
            color: #000; /* 黒色 */
        }
        .option {
            display: block;
            margin: 15px auto;
            padding: 15px 25px;
            background-color: #5a6268; /* 青色 */
            color: #fff; /* 白色 */
            border-radius: 8px;
            text-decoration: none;
            font-size: 1.2em;
            transition: background-color 0.3s, transform 0.3s;
            border: 1px solid #5a6268; /* 青色のボーダー */
        }
        .option:hover {
            background-color: #6c757d; /* ホバー時のグレー */
            transform: translateY(-3px); /* ホバー時の浮き上がり効果 */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>V.LEAGUE情報サイト</h1>
        <a class="option" href="map.php">Vリーグのホームマップ</a>
        <h3>SV,Vリーグの各リーグの男女チームのホーム体育館を検索できます。</h3>
        <a class="option" href="timeline.php">V1リーグのチーム詳細</a>
        <h3>V1リーグに所属するチームの詳細情報を掲載しています。</h3>
    </div>
</body>
</html>
