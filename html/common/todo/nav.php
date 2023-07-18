    <nav class="navbar navbar-expand-md navbar-dark bg-primary">
        <span class="navbar-brand">TODOリスト</span>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    
                <li class="nav-item <?= $title === "作業一覧" ? "active" : ""; ?>">
                    <a class="nav-link" href="./">作業一覧</a>
                </li>
                <?php if ($title === "作業一覧" || $title === "作業登録") : ?> 
                    <li class="nav-item <?= $title === "作業登録" ? "active" : ""; ?>">
                        <a class="nav-link" href="./entry.php">作業登録</a>
                    </li>
                <?php elseif ($title === "作業更新") : ?> 
                    <li class="nav-item <?= $title === "作業更新" ? "active" : ""; ?>">
                        <a class="nav-link" href="./entry.php">作業更新</a>
                    </li>
                <?php elseif ($title === "作業削除") : ?> 
                    <li class="nav-item <?= $title === "作業削除" ? "active" : ""; ?>">
                        <a class="nav-link" href="./entry.php">作業削除</a>
                    </li>
                <?php endif; ?>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?= $user["family_name"]; ?><?= $user["first_name"]; ?> さん
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="../login/todo/logout.php">ログアウト</a>
                    </div>
                </li>

                <?php if ($user["is_admin"] == 1) : ?> 
                    <li class="nav-item">
                        <a class="nav-link" href="../admin/">ユーザー管理画面へ</a>
                    </li>
                <?php endif; ?>
            </ul>
            <form class="form-inline my-2 my-lg-0" action="./search.php" method="get">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="search" value="">
                <button class="btn btn-outline-light my-2 my-sm-0" type="submit">検索</button>
            </form>
        </div>
    </nav>