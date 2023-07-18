<?php
    /**
    * データベースにアクセスするスーパークラス
    */
    class Database {
        /** データベース名 @var string */
        const DB_NAME = "todo";

        /** データベースホスト名 @var string */
        const DB_HOST = "localhost";

        /** 文字コード @var string */
        const DB_CHARACTER_CODE = "utf8";

        /** ユーザー名 @var string */
        const DB_USER = "root";

        /** パスワード @var string */
        const DB_PASS = "";

        /** PDOインスタンスを代入する変数 @var pdo */
        protected $dbh;

        public function __construct(){
            /** データベース接続文字列の作成 */
            $dsn = "mysql:dbname=" . self::DB_NAME . ";host=" . self::DB_HOST . ";charset=" . self::DB_CHARACTER_CODE;
            
            $this->dbh = new PDO($dsn, self::DB_USER, self::DB_PASS);

            // PDOインスタンスのエラーモードを、例外をスローするように設定
            $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

    }
?>