<?php
    /**
    * ログインに関するクラス
    */
    class Users extends Database {

        public function __construct(){
            parent::__construct();
        }

        /**
         * レコードを全件取得するメソッド
         * @return array 連想配列
         */
        public function selectAll() {
            // パスワードは取得しない
            $sql = "SELECT id, user, family_name, first_name, is_admin, is_deleted FROM users";

            $stmt = $this->dbh->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        /**
         * ユーザー名を受け取り、一致したユーザーを返すメソッド
         * @param string $user
         * @return array ユーザーの連想配列
         */
        private function findUserByUserName(string $user): array {
            $sql = "SELECT id, pass, family_name, first_name, is_admin, is_deleted FROM users WHERE user = :user AND is_deleted = :is_deleted";
            $stmt = $this->dbh->prepare($sql);
            $stmt->bindValue(":user", $user, PDO::PARAM_STR);
            $stmt->bindValue(":is_deleted", 0, PDO::PARAM_INT);

            $stmt->execute();
            $rec = $stmt->fetch(PDO::FETCH_ASSOC);

            // falseが返却されたときは、空の配列を返却
            if (empty($rec)) {
                return [];
            }

            return $rec;
        }

        /**
         * メールアドレスとパスワードが一致するユーザーを取得するメソッド
         * @param string $user
         * @param string $pass
         * @return array ユーザーの連想配列（一致しないユーザーがなかったときは、空の配列）
         */
        public function getUser(string $user, string $pass): array {
            $rec = $this->findUserByUserName($user);

            // 空の配列が返却されたとき
            if (empty($rec)) {
                return [];
            }

            // パスワードの照合
            if (password_verify($pass, $rec["pass"])) {

                // 照合できたら、ユーザーの連想配列を返却（パスワードは除く）
                $rec = [
                    "id" => $rec["id"],
                    "family_name" => $rec["family_name"],
                    "first_name" => $rec["first_name"],
                    "is_admin" => $rec["is_admin"],
                    "is_deleted" => $rec["is_deleted"],
                ];
                
                return $rec;
            }

            // 照合できなかったときは、空の配列を返却
            return [];
        }

        /**
         * レコードを1件追加するメソッド
         * @param array $user
         * @return bool true | false
         */
        public function add($user) {
            $sql = "INSERT INTO users (user, pass, family_name, first_name, is_admin) ";
            $sql .= "VALUES (:user, :pass, :family_name, :first_name, :is_admin)";

            $stmt = $this->dbh->prepare($sql);
            $stmt->bindValue(":user", $user["user"], PDO::PARAM_STR);
            $stmt->bindValue(":pass", $user["pass"], PDO::PARAM_STR);
            $stmt->bindValue(":family_name", $user["family_name"], PDO::PARAM_STR);
            $stmt->bindValue(":first_name", $user["first_name"], PDO::PARAM_STR);
            $stmt->bindValue(":is_admin", $user["is_admin"], PDO::PARAM_STR);

            return $stmt->execute();
        }

        /**
         * レコードを1件取得するメソッド
         * @param $id 文字列の数字
         * @return array 連想配列
         */
        public function selectUserById($id) {
            $sql = "SELECT * FROM users WHERE id = :id AND is_deleted = :is_deleted";

            $stmt = $this->dbh->prepare($sql);
            $stmt->bindValue(":id", $id, PDO::PARAM_INT);
            $stmt->bindValue(":is_deleted", 0, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        /**
         * レコードを1件更新するメソッド
         * @param array $user
         * @return bool true | false
         */
        public function update($user) {
            $sql = "UPDATE users SET user = :user, pass = :pass, family_name = :family_name, first_name = :first_name, is_admin = :is_admin WHERE id = :id";

            $stmt = $this->dbh->prepare($sql);
            $stmt->bindValue(":user", $user["user"], PDO::PARAM_STR);
            $stmt->bindValue(":pass", $user["pass"], PDO::PARAM_STR);
            $stmt->bindValue(":family_name", $user["family_name"], PDO::PARAM_STR);
            $stmt->bindValue(":first_name", $user["first_name"], PDO::PARAM_STR);
            $stmt->bindValue(":is_admin", $user["is_admin"], PDO::PARAM_STR);
            $stmt->bindValue(":id", $user["id"], PDO::PARAM_INT);

            return $stmt->execute();
        }

        /**
         * レコードを1件削除するメソッド（論理削除）
         * @param string $id 文字列の数字
         * @return bool true | false
         */
        public function delete($id) {
            $sql = "UPDATE users SET is_deleted = :is_deleted WHERE id = :id";

            $stmt = $this->dbh->prepare($sql);
            $stmt->bindValue(":is_deleted", 1, PDO::PARAM_INT);
            $stmt->bindValue(":id", $id, PDO::PARAM_INT);

            return $stmt->execute();
        }
    }
?>