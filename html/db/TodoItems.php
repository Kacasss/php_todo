<?php
    /**
    * データベースにアクセスするクラス
    */
    class TodoItems extends Database {
        public function __construct(){
            parent::__construct();
        }

        /**
         * レコードを全件取得するメソッド（期限日の古いものから並びかえる）
         * todo_itemテーブルとusersテーブルを結合し、作成したレコードを返却する（論理削除済みのものは除く）
         * @return array 連想配列
         */
        public function selectAll() {
            $sql = "SELECT t.id, t.user_id, t.item_name, u.family_name, u.first_name, t.registration_date, t.expire_date, t.finished_date ";
            $sql .= "FROM todo_items as t JOIN users as u ON t.user_id = u.id ";
            $sql .= "WHERE u.is_deleted = :u_is_deleted AND t.is_deleted = :t_is_deleted ORDER BY expire_date";

            $stmt = $this->dbh->prepare($sql);
            $stmt->bindValue(":u_is_deleted", 0, PDO::PARAM_INT);
            $stmt->bindValue(":t_is_deleted", 0, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        /**
         * レコードを1件取得するメソッド
         * todo_itemテーブルとusersテーブルを結合し、作成したレコードを返却する（論理削除済みのものは除く
         * @param $id 文字列の数字
         * @return array 連想配列
         */
        public function selectTodoItemById($id) {
            $sql = "SELECT t.id, t.user_id, t.item_name, u.family_name, u.first_name, t.registration_date, t.expire_date, t.finished_date ";
            $sql .= "FROM todo_items as t JOIN users as u ON t.user_id = u.id ";
            $sql .= "WHERE u.is_deleted = :u_is_deleted AND t.is_deleted = :t_is_deleted AND t.id = :id ORDER BY expire_date";

            $stmt = $this->dbh->prepare($sql);
            $stmt->bindValue(":id", $id, PDO::PARAM_INT);
            $stmt->bindValue(":u_is_deleted", 0, PDO::PARAM_INT);
            $stmt->bindValue(":t_is_deleted", 0, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        /**
         * 検索したキーワードでレコードを取得するメソッド
         * @param array $todoItem
         * @return array 連想配列
         */
        public function searchTodoItemByKeyword($todoItem) {
            $sql = "SELECT t.id, t.user_id, t.item_name, u.family_name, u.first_name, t.registration_date, t.expire_date, t.finished_date ";
            $sql .= "FROM todo_items as t JOIN users as u ON t.user_id = u.id ";
            $sql .= "WHERE u.is_deleted = :u_is_deleted AND t.is_deleted = :t_is_deleted ";
            $sql .= "AND (t.item_name LIKE :item_name OR u.family_name LIKE :family_name OR u.first_name LIKE :first_name) ";
            $sql .= "ORDER BY expire_date";

            $stmt = $this->dbh->prepare($sql);
            $stmt->bindValue(":u_is_deleted", 0, PDO::PARAM_INT);
            $stmt->bindValue(":t_is_deleted", 0, PDO::PARAM_INT);
            $stmt->bindValue(":item_name", "%". $todoItem["item_name"] ."%", PDO::PARAM_STR);
            $stmt->bindValue(":family_name", "%". $todoItem["family_name"] ."%", PDO::PARAM_STR);
            $stmt->bindValue(":first_name", "%". $todoItem["first_name"] ."%", PDO::PARAM_STR);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }


        /**
         * レコードを1件追加するメソッド
         * @param array $todoItem
         * @return bool true | false
         */
        public function add($todoItem) {
            $sql = "INSERT INTO todo_items (user_id, item_name, registration_date, expire_date, finished_date) ";
            $sql .= "VALUES (:user_id, :item_name, :registration_date, :expire_date, :finished_date)";

            $stmt = $this->dbh->prepare($sql);
            $stmt->bindValue(":user_id", $todoItem["user_id"], PDO::PARAM_INT);
            $stmt->bindValue(":item_name", $todoItem["item_name"], PDO::PARAM_STR);
            $stmt->bindValue(":registration_date", $todoItem["registration_date"], PDO::PARAM_STR);
            $stmt->bindValue(":expire_date", $todoItem["expire_date"], PDO::PARAM_STR);
            $stmt->bindValue(":finished_date", $todoItem["finished_date"], PDO::PARAM_STR);

            return $stmt->execute();
        }


        /**
         * レコードを1件更新するメソッド
         * @param array $todoItem
         * @return bool true | false
         */
        public function update($todoItem) {
            $sql = "UPDATE todo_items SET user_id = :user_id, item_name = :item_name, expire_date = :expire_date, finished_date = :finished_date WHERE id = :id";

            $stmt = $this->dbh->prepare($sql);
            $stmt->bindValue(":id", $todoItem["id"], PDO::PARAM_INT);
            $stmt->bindValue(":user_id", $todoItem["user_id"], PDO::PARAM_INT);
            $stmt->bindValue(":item_name", $todoItem["item_name"], PDO::PARAM_STR);
            $stmt->bindValue(":expire_date", $todoItem["expire_date"], PDO::PARAM_STR);
            $stmt->bindValue(":finished_date", $todoItem["finished_date"], PDO::PARAM_STR);

            return $stmt->execute();
        }


        /**
         * レコードを1件削除するメソッド（論理削除）
         * @param string $id 文字列の数字
         * @return bool true | false
         */
        public function delete($id) {
            $sql = "UPDATE todo_items SET is_deleted = :is_deleted WHERE id = :id";


            $stmt = $this->dbh->prepare($sql);
            $stmt->bindValue(":is_deleted", 1, PDO::PARAM_INT);
            $stmt->bindValue(":id", $id, PDO::PARAM_INT);

            return $stmt->execute();
        }

        /**
         * 作業を完了するメソッド
         * @param array $todoItem
         * @return bool true | false
         */
        public function doneFinishedDateByID($todoItem) {
            $sql = "UPDATE todo_items SET finished_date = :finished_date WHERE id = :id ";
            $stmt = $this->dbh->prepare($sql);
            $stmt->bindValue(":id", $todoItem["id"], PDO::PARAM_INT);
            $stmt->bindValue(":finished_date", $todoItem["finished_date"], PDO::PARAM_STR);

            return $stmt->execute();
        }

    }
?>