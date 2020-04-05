<div class="container">

   <div class="row py-3">
      <?php if (isset($data['session']['user']) && $data['session']['user'] === 'admin') { $is_admin = true; ?>
         <div class="col-2">
            <a class="btn btn-primary" href="<?php echo $data['server']['HTTP_ORIGIN'] . '/login/logout'; ?>" >Выйти</a>
         </div>
      <?php } else { $is_admin = false; ?>
         <div class="col-2">
            <a class="btn btn-primary" href="<?php echo $data['server']['HTTP_ORIGIN'] . 'login'; ?>" >Авторизоваться</a>
         </div>
      <?php } ?>

   </div>


   <div class="row">
      <div class="col-12 text-center">
         <h1 class="py-3">Список задач</h1>
      </div>

      <div class="col-12 py-3">
         <form action="<?php echo $data['server']['HTTP_ORIGIN'] . '/' ?>" method="GET">
            <div class="form-group row">
               <div class="col-sm-2">
                  <label for="Sort">Сортировать по</label>
               </div>
               <div class="col-sm-3">
                  <select class="form-control" id="Sort" name="column">
                     <option value="name" <?php if ( (isset($data['request']['column'])) && ($data['request']['column'] == 'name') ) echo 'selected'; ?> >Имени пользователя</option>
                     <option value="email" <?php if ( (isset($data['request']['column'])) && ($data['request']['column'] == 'email') ) echo 'selected'; ?> >E-mail</option>
                     <option value="status" <?php if ( (isset($data['request']['column'])) && ($data['request']['column'] == 'status') ) echo 'selected'; ?> >Статусу</option>
                  </select>
               </div>
               <div class="col-sm-2">
                  <select class="form-control" id="SortAD" name="sortAD">
                     <option value="asc" <?php if ( (isset($data['request']['sortAD'])) && ($data['request']['sortAD'] == 'asc') ) echo 'selected'; ?> >А -> Я</option>
                     <option value="desc" <?php if ( (isset($data['request']['sortAD'])) && ($data['request']['sortAD'] == 'desc') ) echo 'selected'; ?> >А <- Я</option>
                  </select>
               </div>
               <!--<select class="form-control" id="Sort" name="sort" onchange="location = window.location.href +  value">-->
               <div class="col-3">
                  <button type="submit" class="btn btn-primary">Сортировать</button>
               </div>
            </div>



         </form>
      </div>
      <div class="col-12 py-3">
         <table class="table table-hover">
            <thead>
            <tr>
               <th scope="col">Имя</th>
               <th scope="col">E-mail</th>
               <th scope="col">Текст задачи</th>
               <th scope="col">Статус</th>
               <?php if ($is_admin) { ?><th scope="col">Действие</th><?php } ?>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($data['get_job'] as $job) { ?>
                <form action="<?php echo $data['server']['HTTP_ORIGIN'] . '/index/edit'; ?>" method="post">
                  <tr>
                     <td><?php echo $job['username']; ?></td>
                     <td><?php echo $job['email']; ?></td>
                     <td><?php if ($is_admin) { ?>
                        <input type="text" class="form-control" id="editDescription" name="edit_description" value="<?php echo $job['description']; ?>">
                        <?php } else { ?>
                           <?php echo $job['description']; ?>
                        <?php } ?>
                     </td>
                     <td>
						   <?php if ($is_admin) { ?>
                        <select class="form-control" id="exampleFormControlSelect1" name="edit_status">
                           <option value="0" <?php if ($job['status'] == 0) echo 'selected'; ?>>Не выполнена</option>
                           <option value="1" <?php if ($job['status'] == 1) echo 'selected'; ?>>Выполнена</option>
                        </select>
				         <?php } else { ?>
                         <?php if ($job['status'] == 0) {
                            echo 'Не выполнена';
                            if ($job['updated']) echo ', отредактировано администратором';
                         } else {
                            echo 'Выполнена';
							       if ($job['updated']) echo ', отредактировано администратором';
                         } ?>
				         <?php } ?>
                     </td>
					      <?php if ($is_admin) { ?>
                     <td>
                        <input type="text" name="id" value="<?php echo $job['id']; ?>" hidden>
                        <button type="submit" class="btn btn-primary">Сохранить</button>
                     </td>
				         <?php } ?>
                  </tr>
                </form>
            <?php } ?>

            </tbody>
         </table>
      </div>

      <?php echo $data['pagination']; ?>

      <div class="col-12 text-center">
         <h2 class="py-3">Новая задача</h2>
      </div>

      <?php if (isset($data['error'])) { ?>
         <div class="alert alert-danger" role="alert">
            <?php echo $data['error']; ?>
         </div>
      <?php } ?>

	   <?php if (isset($data['success'])) { ?>
          <div class="alert alert-success" role="alert">
			  <?php echo $data['success']; ?>
          </div>
	   <?php } ?>
      <div class="col-12 py-3">
         <form action="<?php echo $data['server']['HTTP_ORIGIN'] . '/index/add'; ?>" method="post">
            <div class="form-group row">
               <div class="col-sm-2">
                  <label for="createName">Имя</label>
               </div>
               <div class="col-sm-3">
                  <input type="text" class="form-control" id="createName" name="create_name" placeholder="Имя">
               </div>
               <div class="col-sm-2">
                  <label for="createEmail">Email адрес</label>
               </div>
               <div class="col-sm-3">
                  <input type="email" class="form-control" id="createEmail" name="create_email" placeholder="E-mail">
               </div>
            </div>

            <div class="form-group">
               <label for="createTextJob">Текст задачи</label>
               <textarea class="form-control" id="createTextJob" name="create_text_job" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-success">Добавить задачу</button>
         </form>
      </div>

   </div>
</div>

<p>
   <pre>
   <?php //print_r($data) ?>
</pre>
</p>


