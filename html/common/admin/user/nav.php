    <nav class="navbar navbar-expand-md navbar-dark bg-secondary">
        <span class="navbar-brand">ユーザー管理リスト</span>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    
                <li class="nav-item <?= $title === "ユーザー一覧" ? "active" : ""; ?>">
                    <a class="nav-link" href="./">ユーザー一覧</a>
                </li>
                <?php if ($title === "ユーザー一覧" || $title === "ユーザー登録") : ?> 
                    <li class="nav-item <?= $title === "ユーザー登録" ? "active" : ""; ?>">
                        <a class="nav-link" href="./register.php">ユーザー登録</a>
                    </li>
                <?php elseif ($title === "ユーザー更新") : ?> 
                    <li class="nav-item <?= $title === "ユーザー更新" ? "active" : ""; ?>">
                        <a class="nav-link" href="./edit.php">ユーザー更新</a>
                    </li>
                <?php elseif ($title === "ユーザー削除") : ?> 
                    <li class="nav-item <?= $title === "ユーザー削除" ? "active" : ""; ?>">
                        <a class="nav-link" href="./delete.php">ユーザー削除</a>
                    </li>
                <?php endif; ?>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?= $user["family_name"]; ?><?= $user["first_name"]; ?> さん
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="../login/admin/logout.php">ログアウト</a>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="../todo/">TODOリストへ</a>
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0" action="./search.php" method="get">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="search" value="">
                <button class="btn btn-outline-light my-2 my-sm-0" type="submit">検索</button>
            </form>
        </div>
    </nav>