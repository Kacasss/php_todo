<?php
    /**
    * バリデーションに関するクラス
    */
    class Validation {

        /**
         * ユーザー名とパスワードが入力しているか確認するメソッド
         * @param string $user ユーザー名
         * @param string $pass パスワード
         * @return array $formErr
         */
        public static function validateFormByUserAndPass($user, $pass) : array {
            $formErr = [];

            if ($user == "") {
                $formErr["user"] = "ユーザー名を入力して下さい";
            }
        
            if ($pass == "") {
                $formErr["pass"] = "パスワードを入力して下さい";
            }
        
            return $formErr;
        }

        /**
         * フォームが入力しているか確認するメソッド
         * 配列が定義されていないか、未入力の場合、エラー内容を格納
         * @param array $inputTodoItem
         * @return array $formErr
         */
        public static function validateForm($inputTodoItem) : array {
            $formErr = [];

            if ( !isset($inputTodoItem["item_name"]) || $inputTodoItem["item_name"] == "") {
                $formErr["item_name"] = "項目名を入力して下さい";
            }
        
            if ( !isset($inputTodoItem["user_id"]) || $inputTodoItem["user_id"] == "") {
                $formErr["user_id"] = "ユーザーが選択されてません";
            }

            if ( !isset($inputTodoItem["expire_date"]) || $inputTodoItem["expire_date"] == "") {
                $formErr["expire_date"] = "日付が選択されてません";
            }
        
            return $formErr;
        }

        /**
         * フォームの文字数を確認し、100文字より小さいか確認するメソッド
         * @param string $str フォームで入力した文字列
         * @return bool true | false
         */
        public static function validateFormLength($str) {
            if (100 < mb_strlen($str)) {
                return true;
            }

            return false;
        }

        /**
         * 文字列の日付を受け取り、正しい日付か確認するメソッド
         * @param string $inputDate フォームで入力した文字列の日付（yyyy-mm-dd）
         * @return bool true | false
         */
        public static function validateDate($inputDate) {
            list($year, $month, $day) = explode('-', $inputDate);
    
            if(checkdate($month, $day, $year)) {
                return true;
            }
    
            return false;
        }

    }
?>