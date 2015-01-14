<!-- Book -->
<div class="panel panel-success">
   <div class="panel-heading"><?= $t->__('db.book') ?>:</div>
   <div class="panel-body">
       <table>
          <tr>
            <?php
                if ($book_columns['cover_url'] != '') {
                    $img_src_nocache = $fmw->escapeHtml($book_columns['cover_url']) . '?' . time();
                    echo "<td rowspan='3' width='150px'>";
                    echo "<img src='".$img_src_nocache."' width='130'/>";
                    echo "</td>";
                }
            ?>
            <td width="1px"><?= $t->__('db.book.title') ?>:</td>
            <td>(<?=$book_columns['code'] ?>) <?=$book_columns['title'] ?></td>
          </tr>

          <tr>
            <td><?= $t->__('db.book.author') ?>:</td>
            <td><?=$book_columns['author'] ?></td>
          </tr>

          <tr>
            <td><?= $t->__('db.book.coauthor') ?>:</td>
            <td><?=$book_columns['coauthor'] ?></td>
          </tr>
       </table>
   </div>
</div>