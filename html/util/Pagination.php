<?php
    /**
     * ペジネーションクラス
     */
    class Pagination {
        // 分割する数
        const TODOS_MAX = 3;

        /**
         * DBで取得した連想配列を受け取り、
         * ペジネーションで分割した連想配列を返すメソッド
         * @param array $todos DBで取得した連想配列
         * @param string $page_num クエリで取得したページの数
         * @return array $$returnTodosArray 分割後の連想配列
         */
        public static function paginateTodoItems($todos, $page_num) {

            $returnTodosArray = [];

            // トータルデータ件数
            // （例）レコードが10個の場合、10が代入
            $todos_num = count($todos);

            // トータルページ数
            // ※ceilは小数点を切り上げる関数
            // （例）レコードが10個で、MAXが3の場合
            // 10/3は3.333（略）だが、切り上げの為4が代入される
            $max_page = (int) ceil($todos_num / self::TODOS_MAX);
                
            // $page_num はURLに渡された現在のページ数
            if ($page_num <= 0) {
                // ページが設定されてない、または0以下の場合は1を代入
                $now_page = 1; 
            } else if ($max_page <= $page_num) {
                // トータルページ数以上の場合は最大のページ数を代入
                // （例）レコードが10個の場合、4を代入
                $now_page = $max_page;
            } else {
                $now_page = (int) $page_num;
            }
            
            // 配列の何番目から取得すればよいか
            // （例）レコードが10個の場合、0, 3, 6, 9 のいずれかが代入される
            // （例）（1ページ目） (1 - 1) * 3 ... 0
            // （例）（2ページ目） (2 - 1) * 3 ... 3
            // （例）（3ページ目） (3 - 1) * 3 ... 6
            // （例）（4ページ目） (4 - 1) * 3 ... 9
            $start_array_num = ($now_page - 1) * self::TODOS_MAX;
        
            // array_sliceは、配列の何番目（$start_array_num）から何番目（self::TODOS_MAX）まで切り取る
            $todos = array_slice($todos, $start_array_num, self::TODOS_MAX, true);

            return $returnTodosArray = [
                "max_page" => $max_page,
                "now_page" => $now_page,
                "todos" => $todos
            ];
        }

    }