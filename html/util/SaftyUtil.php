<?php
    /**
     * 安全対策ユーティリティクラス
     */
    class SaftyUtil {
        /**
         * XSS対策
         * POSTで送信されてきた連想配列の要素の値をサニタイズする（1次元配列のみ）
         * @param array $post POSTで取得した連想配列
         * @return array
         */
        public static function sanitize(array $post): array {
            foreach ($post as $key => $value) {
                $post[$key] = htmlspecialchars($value, ENT_QUOTES, "UTF-8");
            }
            return $post;
        }

        /**
         * CSRF対策 ワンタイムトークン
         * 乱数を使用し、ワンタイムトークンを生成するメソッド
         * @return string
         */
        public static function generateToken(): string {
            return bin2hex(openssl_random_pseudo_bytes(32));
        }

        /**
         * CSRF対策 トークンチェック
         * 第1引数の文字列と、第2引数の文字列が一致しているか確認するメソッド
         * @param string $sessionToken
         * @param string $formToken
         * @return bool 一致:true 不一致:false
         */
        public static function isValidToken($sessionToken, $formToken) {
            return $sessionToken === $formToken ? true : false;
        }

    }