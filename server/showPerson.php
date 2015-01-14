<!-- Person -->
<div class="panel panel-success">
   <div class="panel-heading"><?= $t->__('db.person') ?>:</div>
   <div class="panel-body">

        <table style="border-spacing: 5px; border-collapse: separate;">
          <tr>
            <td width="1%"><?= $t->__('db.person.name') ?>:</td>
            <td><?=$person_columns['name'] ?></td>
          </tr>
          <tr>
            <td><?= $t->__('db.person.city') ?>:</td>
            <td><?=$person_columns['city'] ?></td>
          </tr>
          <tr>
            <td><?= $t->__('db.person.phone1') ?>:</td>
            <td><?=$person_columns['phone1'] ?></td>
          </tr>
          <tr>
            <td><?= $t->__('db.person.phone2') ?>:</td>
            <td><?=$person_columns['phone2'] ?></td>
          </tr>
          <tr>
            <td><?= $t->__('db.person.email') ?>:</td>
            <td><?=$person_columns['email'] ?></td>
          </tr>
        </table>
       
   </div>
</div>