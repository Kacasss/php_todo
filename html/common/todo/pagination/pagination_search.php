<nav aria-label="Page navigation example">
    <ul class="pagination">

    <!-- << 現在のページが1ページ目の場合、クリックできないようにする -->
    <li class="page-item <?= $now_page === 1 ? "disabled" : ""; ?>">      
        <a class="page-link" href="./search.php?page_num=<?= $now_page - 1; ?>&search=<?= $search; ?>" aria-label="Previous">
            <span aria-hidden="true">&laquo;</span>
            <span class="sr-only">Previous</span>
        </a>
    </li>

    <?php for ($i = 1; $i <= $max_page; $i++) { ?>
        <?php if ($i == $now_page) : ?>
            <li class="page-item active">
                <a class="page-link" href="./search.php?page_num=<?= $i; ?>&search=<?= $search; ?>"><?= $now_page ?></a>
            </li>
        <?php else : ?>
            <li class="page-item">
                <a class="page-link" href="./search.php?page_num=<?= $i; ?>&search=<?= $search; ?>"><?= $i; ?></a>
            </li>
        <?php endif ?>

    <?php } ?>

    <!-- >> 現在のページが最後のページの場合、クリックできないようにする -->
    <li class="page-item <?= $now_page === $max_page ? "disabled" : ""; ?>">
        <a class="page-link" href="./search.php?page_num=<?= $now_page + 1; ?>&search=<?= $search; ?>" aria-label="Next">
            <span aria-hidden="true">&raquo;</span>
            <span class="sr-only">Next</span>
        </a>
    </li>

    </ul>
</nav>